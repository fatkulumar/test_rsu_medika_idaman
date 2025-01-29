<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JanjiTemu;
use App\Models\NomorAntrian;
use App\Models\Poli;
use App\Models\RekamMedis;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class JanjiTemuAdminController extends Controller
{
    public function index(Request $request)
    {
        $poli = Poli::all();
        $pasienLama = User::role('pasien')->get();
        $searchQuery = $request['search'] ?? '';
        $janjiTemu = JanjiTemu::with(['user.rekamMedis', 'dokter', 'poli'])
            ->when($searchQuery, function ($query) use ($searchQuery) {
                $query->whereHas('user', function ($subQuery) use ($searchQuery) {
                    $subQuery->where('name', 'like', '%' . $searchQuery . '%');
                });
            })
            ->where('status_penanganan', 'menunggu')
            ->paginate(10);
        return Inertia::render('Admin/JanjiTemu', [
            'janjiTemu' => $janjiTemu,
            'polis' => $poli,
            'users' => $pasienLama,
        ]);
    }

    function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:diperiksa,menunggu,selesai',
                'janji_temu_id' => 'required|string|max:36',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $janjiTemu = JanjiTemu::find($request->post('janji_temu_id'));
            $janjiTemu->status_penanganan = $request->post('status');
            $janjiTemu->save();

            $status = $request->post('status');

                if ($status == 'diperiksa') {

                    $record = RekamMedis::orderBy('created_at', 'desc')->first();
                    if ($record) {
                        $nomorRekam = $record->nomor_rekam_medis;
                        $nomorRekam + 1;
                    }else{
                        $tanggalDanWaktu = Carbon::now()->format('ymd');
                        $nomorRekam = $tanggalDanWaktu.'0001';
                    }

                    $statusRawat = 'rawat jalan';

                    RekamMedis::updateOrCreate([
                        'janji_temu_id' => $janjiTemu->id
                    ],
                    [
                        'user_id' => $janjiTemu->user_id,
                        'janji_temu_id' => $janjiTemu->id,
                        'nomor_antrian' => $janjiTemu->nomor_antrian,
                        'status_rawat' => $statusRawat,
                        'nomor_rekam_medis' => $nomorRekam,
                    ]);

                }else if ($status == "selesai") {
                    $statusRawat = 'pulang';

                    $record = RekamMedis::orderBy('created_at', 'desc')->first();
                    if ($record) {
                        $nomorRekam = $record->nomor_rekam_medis;
                        $nomorRekam + 1;
                    }else{
                        $tanggalDanWaktu = Carbon::now()->format('ymd');
                        $nomorRekam = $tanggalDanWaktu.'0001';
                    }

                    RekamMedis::updateOrCreate([
                        'janji_temu_id' => $janjiTemu->id
                    ],
                    [
                        'user_id' => $janjiTemu->user_id,
                        'janji_temu_id' => $janjiTemu->id,
                        'nomor_antrian' => $janjiTemu->nomor_antrian,
                        'status_rawat' => $statusRawat,
                        'nomor_rekam_medis' => $nomorRekam,
                    ]);

                }else if ($status == "menunggu") {
                    if (RekamMedis::where('janji_temu_id', $janjiTemu->id)->exists()) {
                        $rekam = RekamMedis::where('janji_temu_id', $janjiTemu->id)->first();
                        $rekam->delete();
                    }
                }

            return redirect()->back()->with('success', 'Berhasil Mengubah Status Penangan');
        } catch (\Exception $th) {
            $error['message'] = $th->getMessage();
            $error['line'] = $th->getLine();
            $error['file'] = $th->getFile();
            Log::channel('daily')->info("message: {$error['message']}, line: {$error['line']}, file: {$error['file']}");
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function diperiksa(Request $request)
    {
        $searchQuery = $request['search'] ?? '';
        $diperiksa = JanjiTemu::with(['user.rekamMedis', 'dokter', 'poli'])
            ->when($searchQuery, function ($query) use ($searchQuery) {
                $query->whereHas('user', function ($subQuery) use ($searchQuery) {
                    $subQuery->where('name', 'like', '%' . $searchQuery . '%');
                });
            })
            ->where('status_penanganan', 'diperiksa')
            ->paginate(10);
        return Inertia::render('Admin/Diperiksa', [
            'diperiksa' => $diperiksa,
        ]);
    }

    public function selesaiDiperiksa(Request $request)
    {
        $searchQuery = $request['search'] ?? '';
        $diperiksa = JanjiTemu::with(['user.rekamMedis', 'dokter', 'poli'])
            ->when($searchQuery, function ($query) use ($searchQuery) {
                $query->whereHas('user', function ($subQuery) use ($searchQuery) {
                    $subQuery->where('name', 'like', '%' . $searchQuery . '%');
                });
            })
            ->where('status_penanganan', 'selesai')
            ->paginate(10);
        return Inertia::render('Admin/SelesaiDiperiksa', [
            'diperiksa' => $diperiksa,
        ]);
    }

    function delete($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $janjiTemu = JanjiTemu::find($id);
                $janjiTemu->delete();

                RekamMedis::where('janji_temu_id', $janjiTemu->id)->delete();
                if ($janjiTemu->delete()) {
                    return redirect()->back()->with('success', 'Selesai Diperiksa');
                }else{
                    return redirect()->back()->with('error', 'Gagal');
                }
            });
        } catch (\Exception $th) {
            $error['message'] = $th->getMessage();
            $error['line'] = $th->getLine();
            $error['file'] = $th->getFile();
            Log::channel('daily')->info("message: {$error['message']}, line: {$error['line']}, file: {$error['file']}");
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    function daftar(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                "poli_id" => "required|string|max:36",
                "user_id" => "required|string|max:36",
                "status_pasien" => "required|in:baru,lama",
                "status_penanganan" => "required|in:menunggu,diperiksa,selesai",
                "status_rawat" => "required|string|in:menginap,pulang,boleh pulang,rawat jalan",
                "tanggal_kunjungan" => 'required|date'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors());
            }
            $time = Carbon::now();
            $waktu = $time->format('H:i');
            if ($waktu == "00:00") {
                NomorAntrian::where('id', 1)->update(['nomor' => 1]);
            }

            $nomorAntrian = NomorAntrian::find(1);
            $nomorAntri = $nomorAntrian->nomor+1;

            if (RekamMedis::where('user_id', $request->post('user_id'))->exists()) {
                $statusPasien = 'lama';
            }else{
                $statusPasien = 'baru';
            }

            $janjiTemu = JanjiTemu::create([
                'poli_id' => $request->post('poli_id'),
                'user_id' => $request->post('user_id'),
                'status_pasien' => $statusPasien,
                'status_penanganan' => $request->post('status_penanganan'),
                'nomor_antrian' => $nomorAntri,
                'tanggal_kunjungan' => $request->post('tanggal_kunjungan'),
            ]);

            $status = $request->post('status_penanganan');

                if ($status == 'diperiksa') {

                    // jika sudah memiliki account maka get nomor rekam medis
                    if (RekamMedis::where('user_id', $request->post('user_id'))->exists()) {
                        $getNomorRekam = RekamMedis::where('user_id', $request->post('user_id'))->first();
                        $nomorRekam = $getNomorRekam->nomor_rekam_medis;
                    }else{
                        if (RekamMedis::orderBy('created_at', 'DESC')->exists()) {
                            $rekam = RekamMedis::orderBy('created_at', 'DESC')->first();
                            $nomorRekam = $rekam->nomor_rekam_medis+1;
                        }else{
                            $tanggalDanWaktu = Carbon::now()->format('ymd');
                            $nomorRekam = $tanggalDanWaktu.'0001';
                        }
                    }

                    $statusRawat = 'rawat jalan';

                    RekamMedis::updateOrCreate([
                        'janji_temu_id' => $janjiTemu->id
                    ],
                    [
                        'user_id' => $request->post('user_id'),
                        'janji_temu_id' => $janjiTemu->id,
                        'nomor_antrian' => $janjiTemu->nomor_antrian,
                        'status_rawat' => $statusRawat,
                        'nomor_rekam_medis' => $nomorRekam,
                    ]);
                }else if ($status == "selesai") {
                    $statusRawat = 'pulang';
                    // jika sudah memiliki account maka get nomor rekam medis
                    if (RekamMedis::where('user_id', $request->post('user_id'))->exists()) {
                        $getNomorRekam = RekamMedis::where('user_id', $request->post('user_id'))->first();
                        $nomorRekam = $getNomorRekam->nomor_rekam_medis;
                    }else{
                        if (RekamMedis::orderBy('created_at', 'DESC')->exists()) {
                            $rekam = RekamMedis::orderBy('created_at', 'DESC')->first();
                            $nomorRekam = $rekam->nomor_rekam_medis+1;
                        }else{
                            $tanggalDanWaktu = Carbon::now()->format('ymd');
                            $nomorRekam = $tanggalDanWaktu.'0001';
                        }
                    }

                    RekamMedis::updateOrCreate([
                        'janji_temu_id' => $janjiTemu->id
                    ],
                    [
                        'user_id' => $request->post('user_id'),
                        'janji_temu_id' => $janjiTemu->id,
                        'nomor_antrian' => $janjiTemu->nomor_antrian,
                        'status_rawat' => $statusRawat,
                        'nomor_rekam_medis' => $nomorRekam,
                    ]);

                }else if ($status == "menunggu") {
                    if (RekamMedis::where('janji_temu_id', $janjiTemu->id)->exists()) {
                        $rekam = RekamMedis::where('janji_temu_id', $janjiTemu->id)->first();
                        $rekam->delete();
                    }
                }

            if ($janjiTemu) {
                return redirect()->back()->with('success', 'Berhasil Daftar');
            }else{
                return redirect()->back()->with('error', 'Gagal Daftar');
            }

        } catch (\Exception $th) {
            $error['message'] = $th->getMessage();
            $error['line'] = $th->getLine();
            $error['file'] = $th->getFile();
            Log::channel('daily')->info("message: {$error['message']}, line: {$error['line']}, file: {$error['file']}");
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}

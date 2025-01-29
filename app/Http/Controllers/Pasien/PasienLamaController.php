<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\JanjiTemu;
use App\Models\NomorAntrian;
use App\Models\Poli;
use App\Models\RekamMedis;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class PasienLamaController extends Controller
{
    function index()
    {
        $poli = Poli::all();
        $pasienLama = User::role('pasien')->get();
        return Inertia::render('Pegawai/PasienLama', [
            'polis' => $poli,
            'users' => $pasienLama,
        ]);
    }

    function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'poli_id' => 'required|string|max:36',
                'user_id' => 'required|string|max:36',
                'status_penanganan' => 'required|string|in:menunggu,diperiksa,selesai',
                'tanggal_kunjungan' => 'required|date:'
            ]);


            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors());
            }

            $time = Carbon::now();
            $waktu = $time->format('H:i');
            if ($waktu == "00:00") {
                NomorAntrian::where('id', 1)->update(['nomor' => 1]);
            }

            $nomorAntrian = NomorAntrian::first('nomor');
            if ($nomorAntrian) {
                $nomorAntrian = (int)$nomorAntrian->nomor+1;
            }else{
                $nomorAntrian = 1;
            }

            if (RekamMedis::where('user_id', $request->post('user_id'))->exists()) {
                $statusPasien = 'lama';
            }else{
                $statusPasien = 'baru';
            }

            $data = [
                'poli_id' => $request->post('poli_id'),
                'user_id' => $request->post('user_id'),
                'status_pasien' => $statusPasien,
                'status_penanganan' => $request->post('status_penanganan'),
                'nomor_antrian' => $nomorAntrian,
                'tanggal_kunjungan' => $request->post('tanggal_kunjungan'),
            ];
            $poli = Poli::all();
            $pasienLama = User::role('pasien')->get();
            return Inertia::render('Pegawai/Pendaftaran', [
                'data' => $data,
                'polis' => $poli,
                'users' => $pasienLama,
            ]);
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
                'poli_id' => 'required|string|max:36',
                'user_id' => 'required|string|max:36',
                'nomor_antrian' => 'required|integer',
                'status_pasien' => 'required|string|in:lama,baru',
                'status_penanganan' => 'required|string|in:menunggu,diperiksa,selesai',
                'tanggal_kunjungan' => 'required|date',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors());
            }

            $janjiTemu = JanjiTemu::create([
                    'user_id' =>$request->post('user_id'),
                    'poli_id' =>$request->post('poli_id'),
                    'tanggal_kunjungan' => $request->post('tanggal_kunjungan'),
                    'nomor_antrian' => $request->post('nomor_antrian'),
                    'status_pasien' => $request->post('status_pasien'),
                    'status_penanganan' => $request->post('status_penanganan'),
                    'tanggal_kunjungan' => $request->post('tanggal_kunjungan'),
            ]);

            if ($janjiTemu) {
                $antrian = NomorAntrian::first();
                $antrian->nomor = $request->post('nomor_antrian');
                $antrian->save();
                return redirect()->route('dashboard')->with('success', 'Berhasil Daftar');
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

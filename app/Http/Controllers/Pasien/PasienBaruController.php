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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class PasienBaruController extends Controller
{
    function index()
    {
        $poli = Poli::all();
        $pasienLama = User::role('pasien')->get();
        return Inertia::render('Pegawai/PasienBaru', [
            'polis' => $poli,
            'users' => $pasienLama,
        ]);
    }

    function daftarPasienBaru(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'poli_id' => 'required|string|max:36',
                'user_id' => 'required|string|max:36',
                'tanggal_kunjungan' => 'required|date',
                'status_penanganan' => 'required|string|in:menunggu,diperiksa,selesai',

                'keluhan' => 'nullable|string',
                'diagnosa' => 'nullable|string',
                'tindakan' => 'nullable|string',
                'obat' => 'nullable|string',
                'keterangan' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors());
            }

            $time = Carbon::now();
            $waktu = $time->format('H:i');
            if ($waktu == "09:13") {
                NomorAntrian::where('id', 1)->update(['nomor' => 1]);
            }

            $nomorAntrian = NomorAntrian::first('nomor');
            $nomorAntrian = (int)$nomorAntrian->nomor+1;

            if (RekamMedis::where('user_id', $request->post('user_id'))->exists()) {
                $statusPasien = 'lama';
            }else{
                $statusPasien = 'baru';
            }

            $janjiTemu = JanjiTemu::create([
                    'user_id' =>$request->post('user_id'),
                    'poli_id' =>$request->post('poli_id'),
                    'tanggal_kunjungan' => $request->post('tanggal_kunjungan'),
                    'nomor_antrian' => $nomorAntrian,
                    'status_pasien' => $statusPasien,
                    'status_penanganan' => $request->post('status_penanganan'),
                    'tanggal_kunjungan' => $request->post('tanggal_kunjungan'),
            ]);

            $record = RekamMedis::orderBy('created_at', 'desc')->first();
            if ($record) {
                $nomorRekam = $record->nomor_rekam_medis;
                $nomorRekam + 1;
            }else{
                $tanggalDanWaktu = Carbon::now()->format('ymd');
                $nomorRekam = $tanggalDanWaktu.'0001';
            }
            // return $request;
            $tanggalDanWaktu = Carbon::now()->format('ymd');
            $rekamMedis = RekamMedis::create([
                'user_id' => $janjiTemu->user_id,
                'janji_temu_id' => $janjiTemu->id,
                'status_rawat' => 'rawat jalan',
                'nomor_antrian' => $nomorAntrian,
                'nomor_rekam_medis' => $nomorRekam,

                'keluhan' => $request->post('keluhan'),
                'diagnosa' => $request->post('diagnosa'),
                'tindakan' => $request->post('tindakan'),
                'obat' => $request->post('obat'),
                'keterangan' => $request->post('keterangan'),
            ]);

            if ($janjiTemu && $rekamMedis) {
                $antrian = NomorAntrian::first();
                $antrian->nomor = $nomorAntrian;
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

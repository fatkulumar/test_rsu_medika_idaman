<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JanjiTemu;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class JanjiTemuAdminController extends Controller
{
    public function index()
    {
        $janjiTemu = JanjiTemu::with(['user', 'dokter', 'poli'])
            ->where('status_penanganan', 'menunggu')
            ->paginate(10);
        // return $janjiTemu;
        return Inertia::render('Admin/JanjiTemu', [
            'janjiTemu' => $janjiTemu,
        ]);
    }

    function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:diperiksa,menunggu',
                'janji_temu_id' => 'required|string|max:36',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }
            $janjiTemu = JanjiTemu::find($request->post('janji_temu_id'));
            $janjiTemu->status_penanganan = $request->post('status');
            $janjiTemu->save();

            if ($janjiTemu->save()) {

                $status = $request->post('status') == 'diperiksa' ? 'menginap' : 'pulang';
                if ($status == 'menginap') {
                    RekamMedis::updateOrCreate([
                        'janji_temu_id' => $janjiTemu->id
                    ],
                        [
                            'janji_temu_id' => $janjiTemu->id,
                            'nomor_antrian' => $janjiTemu->nomor_antrian,
                            'status_rawat' => $status,
                        ]);
                }else if ($status == 'pulang') {
                    RekamMedis::where('janji_temu_id', $janjiTemu->id)->delete();
                }
            }
            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $th) {
            $error['message'] = $th->getMessage();
            $error['line'] = $th->getLine();
            $error['file'] = $th->getFile();
            Log::channel('daily')->info("message: {$error['message']}, line: {$error['line']}, file: {$error['file']}");
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    public function diperiksa()
    {
        $diperiksa = JanjiTemu::with(['user', 'dokter', 'poli'])
            ->where('status_penanganan', 'diperiksa')
            ->paginate(10);
        // return $janjiTemu;
        return Inertia::render('Admin/Diperiksa', [
            'diperiksa' => $diperiksa,
        ]);
    }

}

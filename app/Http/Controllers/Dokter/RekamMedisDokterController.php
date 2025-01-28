<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class RekamMedisDokterController extends Controller
{
    function index()
    {
        $rekamMedis = RekamMedis::with(['janjiTemu.user', 'janjiTemu.dokter', 'janjiTemu.poli', 'janjiTemu.user.profile'])
        ->orderBy('status_rawat', 'ASC')
        ->where('status_rawat', '!=', 'pulang')
        ->paginate(10);
        // return $rekamMedis;
        return Inertia::render('Dokter/RekamMedis', [
            'rekamMedis' => $rekamMedis,
        ]);
    }

    function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|string|max:36',
                'diagnosa' => 'required|string',
                'keluhan' => 'required|string',
                'obat' => 'required|string',
                'tindakan' => 'required|string',
                'status_rawat' => 'required|in:menginap,boleh pulang',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $rekamMedis = RekamMedis::find($request->post('id'));
            $rekamMedis->diagnosa = $request->post('diagnosa');
            $rekamMedis->keluhan = $request->post('keluhan');
            $rekamMedis->obat = $request->post('obat');
            $rekamMedis->tindakan = $request->post('tindakan');
            $rekamMedis->status_rawat = $request->post('status_rawat');
            $rekamMedis->save();

            return redirect()->back()->with('success', 'Berhasil');
        } catch (\Exception $th) {
            $error['message'] = $th->getMessage();
            $error['line'] = $th->getLine();
            $error['file'] = $th->getFile();
            Log::channel('daily')->info("message: {$error['message']}, line: {$error['line']}, file: {$error['file']}");
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
}

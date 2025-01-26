<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class RekamMedisAdminController extends Controller
{
    function index()
    {
        $rekamMedis = RekamMedis::with(['janjiTemu.user', 'janjiTemu.dokter', 'janjiTemu.poli'])
        ->orderBy('status_rawat', 'ASC')
        ->paginate(10);
        // return $rekamMedis;
        return Inertia::render('Admin/RekamMedis', [
            'rekamMedis' => $rekamMedis,
        ]);
    }

    function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required|in:menginap,pulang,boleh pulang',
                'rekam_medis_id' => 'required|string|max:36',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $rekamMedis = RekamMedis::find($request->post('rekam_medis_id'));
            $rekamMedis->status_rawat = $request->post('status');
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

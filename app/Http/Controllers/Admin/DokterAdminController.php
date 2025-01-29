<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class DokterAdminController extends Controller
{
    function index(Request $request)
    {
        $polis = Poli::all();
        $searchQuery = $request['search'] ?? '';
        $dokters = User::with(['roles', 'dokter.poli'])
        ->whereHas('roles', function ($query) {
            $query->where('name', 'dokter');
        })
        ->when($searchQuery, function ($query) use ($searchQuery) {
            $query->where('name', 'like', '%' . $searchQuery . '%');
        })
        ->paginate(10);
        return Inertia::render('Admin/Dokter', [
            'dokters' => $dokters,
            'polis' => $polis,
        ]);
    }

    function delete(Request $request, $id)
    {
        try {
            $user = User::where('id', $id)->delete();
        } catch (\Exception $th) {
            $error['message'] = $th->getMessage();
            $error['line'] = $th->getLine();
            $error['file'] = $th->getFile();
            Log::channel('daily')->info("message: {$error['message']}, line: {$error['line']}, file: {$error['file']}");
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    function dokterToPoli(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'poli_id' => 'required|string|max:36|exists:App\Models\Poli,id|unique:App\Models\Dokter,poli_id',
                'user_id' => 'required|string|max:36',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $dokter = Dokter::updateOrCreate([
                'user_id' => $request->post('user_id'),
            ], [
                'poli_id' => $request->post('poli_id'),
            ]);

            if ($dokter) {
                return redirect()->back()->with('success', 'Dokter berhasil ditambahkan ke poli');
            } else {
                return redirect()->back()->with('error', 'Dokter gagal ditambahkan ke poli');
            }
        } catch (\Exception $th) {
            $error['message'] = $th->getMessage();
            $error['line'] = $th->getLine();
            $error['file'] = $th->getFile();
            Log::channel('daily')->info("message: {$error['message']}, line: {$error['line']}, file: {$error['file']}");
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    function polis(Request $request)
    {
        try {
            $searchQuery = $request['search'] ?? '';
            $polis = Poli::when($searchQuery, function ($query) use ($searchQuery) {
                $query->where('name', 'like', '%' . $searchQuery . '%');
            })
            ->paginate(10);

            if ($polis) {
                return Inertia::render('Admin/Poli', [
                    'polis' => $polis,
                ]);
            }
        } catch (\Exception $th) {
            $error['message'] = $th->getMessage();
            $error['line'] = $th->getLine();
            $error['file'] = $th->getFile();
            Log::channel('daily')->info("message: {$error['message']}, line: {$error['line']}, file: {$error['file']}");
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

    function tambahPoli(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:225',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors());
            }

            $poli = Poli::updateOrCreate([
                'id' => $request->post('id'),
            ], [
                'name' => $request->post('name'),
            ]);
            if ($poli) {
                return redirect()->back()->with('success', 'Poli berhasil ditambahkan ke poli');
            } else {
                return redirect()->back()->with('error', 'Poli gagal ditambahkan ke poli');
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

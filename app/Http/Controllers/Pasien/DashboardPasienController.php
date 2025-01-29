<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardPasienController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $data = User::with([
            'roles',
            'janjiTemu' => function ($query) {
                $query->orderBy('tanggal_kunjungan', 'DESC');
            },
            'janjiTemu.poli',
            'janjiTemu.dokter',
            'rekamMedis'
        ])
        ->where('id', Auth::id()) // Bisa pakai Auth::id() untuk lebih singkat
        ->get();
        return Inertia::render('Pasien/Dashboard', [
            'data' => $data,
        ]);
    }
}

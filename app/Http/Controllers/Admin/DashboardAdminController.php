<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\JanjiTemu;
use App\Models\Poli;
use App\Models\RekamMedis;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardAdminController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = User::count();
        $poli = Poli::count();
        $dokter = Dokter::count();
        $menginap = RekamMedis::where('status_rawat', 'menginap')->count();
        $pulang = RekamMedis::where('status_rawat', 'pulang')->count();
        $daftar = JanjiTemu::count();
        $data = [
            'user' => $user,
            'poli' => $poli,
            'dokter' => $dokter,
            'menginap' => $menginap,
            'pulang' => $pulang,
            'daftar' => $daftar,
        ];

        return Inertia::render('Admin/Dashboard', [
            'dashboard' => $data,
        ]);
    }
}

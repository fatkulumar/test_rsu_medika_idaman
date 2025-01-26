<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Poli;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardDokterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $auth = Auth::user();
        $profile = Dokter::where('user_id', $auth->id)->first();
        return $profile;
        $poli = Poli::count();
        $dokter = Dokter::count();
        $menginap = RekamMedis::where('status_rawat', '!=' , 'pulang')->count();
        $data = [
            'poli' => $poli,
            'dokter' => $dokter,
            'menginap' => $menginap,
        ];
        return Inertia::render('Dokter/Dashboard', [
            'dashboard' => $data,
        ]);
    }
}

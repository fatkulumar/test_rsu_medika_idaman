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
        $countMenginap = 0;
        $countPulang = 0;
        $countBolehPulang = 0;
        $menginap = RekamMedis::join('janji_temus', 'rekam_medis.janji_temu_id', '=', 'janji_temus.id')
        ->join('polis', 'polis.id', '=', 'janji_temus.poli_id')
        ->join('dokters', 'dokters.poli_id', '=', 'polis.id')
        ->where('status_rawat', '!=' , 'pulang')
        ->select('janji_temus.*', 'polis.*', 'rekam_medis.*', 'dokters.user_id as dokter_id')
        ->get();
        foreach($menginap as $item) {
            if ($item->dokter_id == $auth->id) {
                $countMenginap++;
            }
        }

        $pulang = RekamMedis::join('janji_temus', 'rekam_medis.janji_temu_id', '=', 'janji_temus.id')
        ->join('polis', 'polis.id', '=', 'janji_temus.poli_id')
        ->join('dokters', 'dokters.poli_id', '=', 'polis.id')
        ->where('status_rawat', 'pulang')
        ->select('janji_temus.*', 'polis.*', 'rekam_medis.*', 'dokters.user_id as dokter_id')
        ->get();
        foreach($pulang as $item) {
            if ($item->user_id == $auth->id) {
                $countPulang++;
            }
        }

        $bolehPulang = RekamMedis::join('janji_temus', 'rekam_medis.janji_temu_id', '=', 'janji_temus.id')
        ->join('polis', 'polis.id', '=', 'janji_temus.poli_id')
        ->join('dokters', 'dokters.poli_id', '=', 'polis.id')
        ->where('status_rawat', 'boleh pulang')
        ->select('janji_temus.*', 'polis.*', 'rekam_medis.*', 'dokters.user_id as dokter_id')
        ->get();
        foreach($bolehPulang as $item) {
            if ($item->user_id == $auth->id) {
                $countBolehPulang++;
            }
        }

        $data = [
            'pulang' => $countPulang,
            'bolehPulang' => $countBolehPulang,
            'menginap' => $countMenginap,
        ];
        return Inertia::render('Dokter/Dashboard', [
            'dashboard' => $data,
        ]);
    }
}

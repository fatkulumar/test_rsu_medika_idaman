<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PasienBaruController extends Controller
{
    function index()
    {
        return Inertia::render('Pasien/PasienBaru');
    }
}

<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/pasien/lama', [App\Http\Controllers\Pasien\PasienLamaController::class, 'index'])->name('lama');
Route::get('/pasien/baru', [App\Http\Controllers\Pasien\PasienBaruController::class, 'index'])->name('baru');

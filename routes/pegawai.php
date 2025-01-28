<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/lama', [App\Http\Controllers\Pasien\PasienLamaController::class, 'index'])->name('lama');
Route::post('/lama', [App\Http\Controllers\Pasien\PasienLamaController::class, 'store']);
Route::post('/daftar', [App\Http\Controllers\Pasien\PasienLamaController::class, 'daftar']);
Route::get('/baru', [App\Http\Controllers\Pasien\PasienBaruController::class, 'index'])->name('baru');
Route::post('/daftar-pasien-baru', [App\Http\Controllers\Pasien\PasienBaruController::class, 'daftarPasienBaru']);

<?php

use Illuminate\Support\Facades\Route;
Route::get('/rekam-medis', [App\Http\Controllers\Dokter\RekamMedisDokterController::class, 'index'])->name('rekam-medis');
Route::post('/rekam-medis', [App\Http\Controllers\Dokter\RekamMedisDokterController::class, 'store']);

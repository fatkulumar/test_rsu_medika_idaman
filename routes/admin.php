<?php

use Illuminate\Support\Facades\Route;

Route::get('/janji-temu', [App\Http\Controllers\Admin\JanjiTemuAdminController::class, 'index'])->name('janji-temu');
Route::post('/janji-temu', [App\Http\Controllers\Admin\JanjiTemuAdminController::class, 'store']);
Route::get('/diperiksa', [App\Http\Controllers\Admin\JanjiTemuAdminController::class, 'diperiksa'])->name('diperiksa');
Route::get('/selesai-diperiksa', [App\Http\Controllers\Admin\JanjiTemuAdminController::class, 'selesaiDiperiksa'])->name('selesai-diperiksa');
Route::delete('/janji-temu/{id}', [App\Http\Controllers\Admin\JanjiTemuAdminController::class, 'delete']);
Route::post('/daftar', [App\Http\Controllers\Admin\JanjiTemuAdminController::class, 'daftar']);

Route::get('/rekam-medis', [App\Http\Controllers\Admin\RekamMedisAdminController::class, 'index'])->name('rekam-medis');
Route::post('/rekam-medis', [App\Http\Controllers\Admin\RekamMedisAdminController::class, 'store']);
Route::delete('/rekam-medis/{id}', [App\Http\Controllers\Admin\RekamMedisAdminController::class, 'delete']);

Route::get('/users', [App\Http\Controllers\Admin\UserAdminController::class, 'index'])->name('users');
Route::post('/register', [App\Http\Controllers\Admin\UserAdminController::class, 'store'])->name('register');

Route::get('/dokters', [App\Http\Controllers\Admin\DokterAdminController::class, 'index'])->name('dokter');
Route::delete('/dokter/{id}', [App\Http\Controllers\Admin\DokterAdminController::class, 'delete']);
Route::post('/dokter-to-poli', [App\Http\Controllers\Admin\DokterAdminController::class, 'dokterToPoli']);

Route::get('/polis', [App\Http\Controllers\Admin\DokterAdminController::class, 'polis'])->name('poli');
Route::post('/polis', [App\Http\Controllers\Admin\DokterAdminController::class, 'tambahPoli']);

<?php

use Illuminate\Support\Facades\Route;

Route::get('/janji-temu', [App\Http\Controllers\Admin\JanjiTemuAdminController::class, 'index'])->name('janji-temu');
Route::post('/janji-temu', [App\Http\Controllers\Admin\JanjiTemuAdminController::class, 'store']);

Route::get('/diperiksa', [App\Http\Controllers\Admin\JanjiTemuAdminController::class, 'diperiksa'])->name('diperiksa');

Route::get('/rekam-medis', [App\Http\Controllers\Admin\RekamMedisAdminController::class, 'index'])->name('rekam-medis');
Route::post('/rekam-medis', [App\Http\Controllers\Admin\RekamMedisAdminController::class, 'store']);

Route::get('/users', [App\Http\Controllers\Admin\UserAdminController::class, 'index'])->name('users');

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/pasien/dashboard', App\Http\Controllers\Pasien\DashboardPasienController::class)->middleware(['auth', 'verified', 'role:pasien'])->name('pasien.dashboard');
Route::get('/pegawai/dashboard', App\Http\Controllers\Pegawai\DashboardPegawaiController::class)->middleware(['auth', 'verified', 'role:pegawai'])->name('dashboard');
Route::get('/admin/dashboard', App\Http\Controllers\Admin\DashboardAdminController::class)->middleware(['auth', 'verified', 'role:admin'])->name('admin.dashboard');
Route::get('/dokter/dashboard', App\Http\Controllers\Dokter\DashboardDokterController::class)->middleware(['auth', 'verified', 'role:dokter'])->name('dokter.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

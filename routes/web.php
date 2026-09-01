<?php

use App\Http\Controllers\AbsensiController;
use Illuminate\Support\Facades\Route;

// ==========================================
// 1. ROUTE PUBLIK (Bisa Diakses Siapa Saja)
// ==========================================
Route::get('/', [AbsensiController::class, 'index'])->name('absensi.index');
Route::post('/absensi', [AbsensiController::class, 'store'])->name('absensi.store');
Route::post('/register', [AbsensiController::class, 'registerStore'])->name('absensi.register');

// Form & Proses Login Admin (Harus di luar middleware)
Route::get('/admin/login', [AbsensiController::class, 'loginForm'])->name('admin.login.form');
Route::post('/admin/login', [AbsensiController::class, 'loginProcess'])->name('admin.login.process');
Route::post('/admin/logout', [AbsensiController::class, 'logout'])->name('admin.logout');


// ==========================================
// 2. ROUTE TERKUNCI (Wajib Password Admin)
// ==========================================
Route::middleware(['admin.password'])->group(function () {
    Route::get('/admin', [AbsensiController::class, 'admin'])->name('absensi.admin');
    Route::get('/admin/export', [AbsensiController::class, 'export'])->name('absensi.export');
    
    Route::get('/admin/anggota', [AbsensiController::class, 'anggota'])->name('absensi.admin.anggota');
    Route::get('/admin/anggota/export', [AbsensiController::class, 'exportAnggota'])->name('absensi.admin.anggota.export');

    // ROUTE UPDATE & DELETE ANGGOTA
    Route::put('/admin/anggota/{id}', [AbsensiController::class, 'updateAnggota'])->name('absensi.admin.anggota.update');
    Route::delete('/admin/anggota/{id}', [AbsensiController::class, 'destroyAnggota'])->name('absensi.admin.anggota.destroy');

    // ROUTE TAMBAH, UPDATE & DELETE ABSENSI MANUAL ADMIN
    Route::post('/admin/absensi/store-manual', [AbsensiController::class, 'storeManual'])->name('absensi.admin.store_manual');
    Route::put('/admin/absensi/{id}', [AbsensiController::class, 'updateAbsensi'])->name('absensi.admin.update');
    Route::delete('/admin/absensi/{id}', [AbsensiController::class, 'destroyAbsensi'])->name('absensi.admin.destroy');

    // ROUTE GANTI USERNAME & PASSWORD ADMIN
    Route::post('/admin/change-password', [AbsensiController::class, 'updatePassword'])->name('admin.change_password');
});
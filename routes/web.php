<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\AuthController;

// 1. Akses utama (root) langsung diarahkan ke Login
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. Rute Publik (Bisa diakses tanpa login)
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login/validate', [AuthController::class, 'validateLogin'])->name('login.validate');

// 3. Rute Terproteksi (Hanya bisa diakses jika sudah login)
Route::middleware(['auth.custom'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [PenyewaanController::class, 'index'])->name('dashboard');

    // ---------------- MOBIL ----------------
    Route::get('/mobil',              [MobilController::class, 'index'])->name('mobil.index');
    Route::get('/mobil/add',          [MobilController::class, 'create'])->name('mobil.create');
    Route::post('/mobil/store',       [MobilController::class, 'store'])->name('mobil.store');
    Route::get('/mobil/edit/{id}',    [MobilController::class, 'edit'])->name('mobil.edit');
    Route::post('/mobil/update/{id}', [MobilController::class, 'update'])->name('mobil.update');
    Route::post('/mobil/delete/{id}', [MobilController::class, 'delete'])->name('mobil.delete');

    // ---------------- PELANGGAN ----------------
    Route::get('/pelanggan',              [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/pelanggan/add',          [PelangganController::class, 'create'])->name('pelanggan.create'); // Ini rute yang tadi hilang
    Route::post('/pelanggan/store',       [PelangganController::class, 'store'])->name('pelanggan.store');
    Route::get('/pelanggan/edit/{id}',    [PelangganController::class, 'edit'])->name('pelanggan.edit');
    Route::post('/pelanggan/update/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
    Route::post('/pelanggan/delete/{id}', [PelangganController::class, 'delete'])->name('pelanggan.delete');

    // ---------------- PENYEWAAN ----------------
    Route::get('/penyewaan',               [PenyewaanController::class, 'index'])->name('penyewaan.index');
    Route::get('/penyewaan/add',           [PenyewaanController::class, 'create'])->name('penyewaan.create'); 
    Route::post('/penyewaan/store',        [PenyewaanController::class, 'store'])->name('penyewaan.store');
    Route::post('/penyewaan/kembali/{id}', [PenyewaanController::class, 'kembali'])->name('penyewaan.kembali');
    Route::post('/penyewaan/delete/{id}',  [PenyewaanController::class, 'delete'])->name('penyewaan.delete');

    // ---------------- PEMBAYARAN ----------------
    Route::get('/pembayaran/{id_sewa}', [PembayaranController::class, 'form'])->name('pembayaran.form');
    Route::post('/pembayaran/{id_sewa}/proses', [PembayaranController::class, 'prosesPembayaran'])->name('pembayaran.proses');
    Route::post('/pembayaran/verifikasi/{id_pembayaran}/{status}', [PembayaranController::class, 'verifikasi'])->name('pembayaran.verifikasi');
});
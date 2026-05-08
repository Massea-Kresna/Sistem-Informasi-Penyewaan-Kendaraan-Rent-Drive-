<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenyewaanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;

// ===== Root: arahkan ke dashboard atau login =====
Route::get('/', function () {
    if (session()->has('admin_id'))     return redirect()->route('admin.dashboard');
    if (session()->has('pelanggan_id')) return redirect()->route('pelanggan.dashboard');
    return redirect()->route('login');
})->name('home');

// ===== AUTH PELANGGAN =====
Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login'])->name('login.submit');
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// ===== AUTH ADMIN =====
Route::get('/admin/login',   [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login',  [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// ===== AREA PELANGGAN (perlu login) =====
Route::middleware('pelanggan.auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('pelanggan.dashboard');

    // Profil
    Route::get('/profil',  [AuthController::class, 'showProfil'])->name('pelanggan.profil');
    Route::post('/profil', [AuthController::class, 'updateProfil'])->name('pelanggan.profil.update');

    // Booking flow
    Route::get('/sewa/mobil',         [BookingController::class, 'browseMobil'])->name('pelanggan.mobil');
    Route::get('/sewa/pilih/{id}',    [BookingController::class, 'pilihMobil'])->name('pelanggan.pilih');
    Route::post('/sewa/konfirmasi',   [BookingController::class, 'konfirmasi'])->name('pelanggan.konfirmasi');
    Route::post('/sewa/simpan',       [BookingController::class, 'simpan'])->name('pelanggan.simpan');
    Route::get('/sewa/riwayat',       [BookingController::class, 'riwayat'])->name('pelanggan.riwayat');

    // Payment flow
    Route::get('/sewa/{id}/bayar',  [PaymentController::class, 'showPayment'])->name('pelanggan.bayar');
    Route::post('/sewa/{id}/proses', [PaymentController::class, 'proses'])->name('pelanggan.proses');
    Route::get('/sewa/{id}/gagal',  [PaymentController::class, 'gagal'])->name('pelanggan.gagal');
    Route::post('/sewa/{id}/batal', [PaymentController::class, 'batal'])->name('pelanggan.batal');
    Route::get('/sewa/{id}/bukti',  [PaymentController::class, 'bukti'])->name('pelanggan.bukti');
});

// ===== AREA ADMIN (perlu login admin) =====
Route::middleware('admin.auth')->group(function () {
    Route::get('/admin', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');

    // Mobil
    Route::get('/admin/mobil',              [MobilController::class, 'index'])->name('mobil.index');
    Route::get('/admin/mobil/add',          [MobilController::class, 'create'])->name('mobil.create');
    Route::post('/admin/mobil/store',       [MobilController::class, 'store'])->name('mobil.store');
    Route::get('/admin/mobil/edit/{id}',    [MobilController::class, 'edit'])->name('mobil.edit');
    Route::post('/admin/mobil/update/{id}', [MobilController::class, 'update'])->name('mobil.update');
    Route::post('/admin/mobil/delete/{id}', [MobilController::class, 'delete'])->name('mobil.delete');

    // Pelanggan
    Route::get('/admin/pelanggan',              [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::get('/admin/pelanggan/add',          [PelangganController::class, 'create'])->name('pelanggan.create');
    Route::post('/admin/pelanggan/store',       [PelangganController::class, 'store'])->name('pelanggan.store');
    Route::get('/admin/pelanggan/edit/{id}',    [PelangganController::class, 'edit'])->name('pelanggan.edit');
    Route::post('/admin/pelanggan/update/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
    Route::post('/admin/pelanggan/delete/{id}', [PelangganController::class, 'delete'])->name('pelanggan.delete');

    // Penyewaan
    Route::get('/admin/penyewaan',                [PenyewaanController::class, 'index'])->name('penyewaan.index');
    Route::get('/admin/penyewaan/detail/{id}',    [PenyewaanController::class, 'detail'])->name('penyewaan.detail');
    Route::get('/admin/penyewaan/add',            [PenyewaanController::class, 'create'])->name('penyewaan.create');
    Route::post('/admin/penyewaan/store',         [PenyewaanController::class, 'store'])->name('penyewaan.store');
    Route::post('/admin/penyewaan/kembali/{id}',  [PenyewaanController::class, 'kembali'])->name('penyewaan.kembali');
    Route::post('/admin/penyewaan/delete/{id}',   [PenyewaanController::class, 'delete'])->name('penyewaan.delete');
});

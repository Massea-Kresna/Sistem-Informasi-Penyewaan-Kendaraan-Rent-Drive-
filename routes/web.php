<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PenyewaanController;

Route::get('/', function () {
    return view('penyewaan.index');
});

// Mobil Routes
Route::get('/mobil', [MobilController::class, 'index'])->name('mobil.index');
Route::get('/mobil/add', [MobilController::class, 'create'])->name('mobil.create');
Route::post('/mobil/store', [MobilController::class, 'store'])->name('mobil.store');
Route::get('/mobil/edit/{id}', [MobilController::class, 'edit'])->name('mobil.edit');
Route::post('/mobil/update/{id}', [MobilController::class, 'update'])->name('mobil.update');
Route::post('/mobil/delete/{id}', [MobilController::class, 'delete'])->name('mobil.delete');

// Pelanggan Routes
Route::get('/pelanggan', [PelangganController::class, 'index'])->name('pelanggan.index');
Route::get('/pelanggan/add', [PelangganController::class, 'create'])->name('pelanggan.create');
Route::post('/pelanggan/store', [PelangganController::class, 'store'])->name('pelanggan.store');
Route::get('/pelanggan/edit/{id}', [PelangganController::class, 'edit'])->name('pelanggan.edit');
Route::post('/pelanggan/update/{id}', [PelangganController::class, 'update'])->name('pelanggan.update');
Route::post('/pelanggan/delete/{id}', [PelangganController::class, 'delete'])->name('pelanggan.delete');

// Penyewaan Routes
Route::get('/penyewaan', [PenyewaanController::class, 'index'])->name('penyewaan.index');
Route::get('/penyewaan/add', [PenyewaanController::class, 'add'])->name('penyewaan.add');
Route::post('/penyewaan/store', [PenyewaanController::class, 'store'])->name('penyewaan.store');
Route::post('/penyewaan/kembali/{id}', [PenyewaanController::class, 'kembali'])->name('penyewaan.kembali');
Route::post('/penyewaan/delete/{id}', [PenyewaanController::class, 'delete'])->name('penyewaan.delete');

@extends('layout')
@section('content')
<div class="p-4 bg-light rounded mb-4">
    <h3>Selamat Datang, {{ session('admin_nama') }} 👋</h3>
    <p class="text-muted mb-0">Panel administrasi Rent Drive — kelola mobil, pelanggan, dan penyewaan.</p>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h6>Total Mobil</h6>
                <h3 class="mb-0">{{ $stats['total_mobil'] }}</h3>
                <small>{{ $stats['mobil_tersedia'] }} tersedia · {{ $stats['mobil_disewa'] }} disewa</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6>Total Pelanggan</h6>
                <h3 class="mb-0">{{ $stats['total_pelanggan'] }}</h3>
                <small>terdaftar di sistem</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h6>Penyewaan Aktif</h6>
                <h3 class="mb-0">{{ $stats['sewa_aktif'] }}</h3>
                <small>{{ $stats['sewa_pending'] }} menunggu pembayaran</small>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <h6>Total Pendapatan</h6>
                <h3 class="mb-0">Rp {{ number_format($stats['pendapatan']) }}</h3>
                <small>dari pembayaran berhasil</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <a href="{{ route('mobil.index') }}" class="btn btn-outline-primary w-100 py-3 mb-2">
            🚗 Kelola Mobil
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('pelanggan.index') }}" class="btn btn-outline-success w-100 py-3 mb-2">
            👥 Kelola Pelanggan
        </a>
    </div>
    <div class="col-md-4">
        <a href="{{ route('penyewaan.index') }}" class="btn btn-outline-info w-100 py-3 mb-2">
            📋 Kelola Penyewaan
        </a>
    </div>
</div>
@endsection

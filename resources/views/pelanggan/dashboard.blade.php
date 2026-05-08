@extends('pelanggan.layout')
@section('title', 'Dashboard')

@section('content')
<div class="p-4 bg-light rounded mb-4">
    <h3>Selamat datang, {{ session('pelanggan_nama') }}! 👋</h3>
    <p class="text-muted mb-0">Temukan dan sewa mobil impian Anda dengan mudah dan cepat.</p>
</div>

<div class="row mb-4">
    <div class="col-md-6">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6 class="card-title">Mobil Tersedia</h6>
                <h2 class="mb-0">{{ $stats['mobil_tersedia'] }}</h2>
                <small>unit siap disewa</small>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h6 class="card-title">Total Mobil</h6>
                <h2 class="mb-0">{{ $stats['total_mobil'] }}</h2>
                <small>unit dalam armada</small>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body text-center py-5">
        <h5>Siap menyewa mobil?</h5>
        <p class="text-muted">Lihat daftar mobil yang tersedia dan pilih yang sesuai dengan kebutuhan Anda.</p>
        <a href="{{ route('pelanggan.mobil') }}" class="btn btn-primary btn-lg">
            Lihat Daftar Mobil →
        </a>
    </div>
</div>
@endsection

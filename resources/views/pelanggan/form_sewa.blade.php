@extends('pelanggan.layout')
@section('title', 'Input Tanggal Sewa')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('pelanggan.mobil') }}">Daftar Mobil</a></li>
        <li class="breadcrumb-item active">Form Penyewaan</li>
    </ol>
</nav>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
    </div>
@endif

<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h5>Mobil Dipilih</h5>
                <hr>
                <p class="mb-1"><strong>{{ $mobil->nama_mobil }}</strong></p>
                <p class="text-muted mb-1">Merek: {{ $mobil->merek }}</p>
                <p class="text-muted mb-1">Plat: {{ $mobil->plat_nomor }}</p>
                <h4 class="text-primary mt-3">Rp {{ number_format($mobil->harga_sewa) }}<small class="text-muted">/hari</small></h4>
            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <h5>Pilih Tanggal Sewa</h5>
                <hr>
                <form method="POST" action="{{ route('pelanggan.konfirmasi') }}">
                    @csrf
                    <input type="hidden" name="id_mobil" value="{{ $mobil->id_mobil }}">

                    <div class="mb-3">
                        <label class="form-label">Tanggal Mulai Sewa</label>
                        <input type="date" name="tanggal_sewa" class="form-control"
                               min="{{ date('Y-m-d') }}"
                               value="{{ old('tanggal_sewa', date('Y-m-d')) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Selesai Sewa</label>
                        <input type="date" name="tanggal_kembali" class="form-control"
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+1 day'))) }}" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('pelanggan.mobil') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Lanjut ke Konfirmasi →</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

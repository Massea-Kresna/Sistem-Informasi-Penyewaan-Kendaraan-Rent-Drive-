@extends('layout')
@section('content')
<h4>Request Stok & Input Tanggal Sewa</h4>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card shadow-sm"><div class="card-body">
    <form method="POST" action="{{ route('penyewaan.store') }}">
        @csrf
        <div class="mb-3">
            <label>Pilih Mobil</label>
            <select name="id_mobil" class="form-select" required>
                <option value="">-- Pilih Mobil (Tersedia) --</option>
                @foreach($mobils as $m)
                    <option value="{{ $m->id_mobil }}">
                        {{ $m->nama_mobil }} - {{ $m->plat_nomor }} (Rp {{ number_format($m->harga_sewa) }}/hari)
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label>Tanggal Mulai Sewa</label>
            <input type="date" name="tanggal_sewa" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>
        <div class="mb-3">
            <label>Durasi Sewa (Hari)</label>
            <input type="number" name="durasi_hari" class="form-control" min="1" required>
        </div>
        <button type="submit" class="btn btn-primary">Konfirmasi Pesanan</button>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">Batal</a>
    </form>
</div></div>
@endsection
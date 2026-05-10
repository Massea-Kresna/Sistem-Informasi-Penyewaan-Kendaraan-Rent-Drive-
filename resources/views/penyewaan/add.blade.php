@extends('layout')
@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card mt-2">
    <div class="card-body">
        <h5 class="card-title fw-bolder mb-3">Tambah Penyewaan</h5>
        <form method="post" action="{{ route('penyewaan.store') }}">
            @csrf
            <div class="mb-3">
                <label for="id_pelanggan" class="form-label">Pelanggan</label>
                <select class="form-select" id="id_pelanggan" name="id_pelanggan" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($pelanggans as $p)
                        <option value="{{ $p->id_pelanggan }}">{{ $p->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="id_mobil" class="form-label">Mobil (tersedia)</label>
                <select class="form-select" id="id_mobil" name="id_mobil" required>
                    <option value="">-- Pilih Mobil --</option>
                    @foreach($mobils as $m)
                        <option value="{{ $m->id_mobil }}">
                            {{ $m->nama_mobil }} ({{ $m->plat_nomor }}) - Rp {{ number_format($m->harga_sewa) }}/hari
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="tanggal_sewa" class="form-label">Tanggal Sewa</label>
                    <input type="date" class="form-control" id="tanggal_sewa" name="tanggal_sewa"
                           value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                    <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali"
                           value="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Metode Pembayaran</label>
                <select class="form-select" name="metode_pembayaran" required>
                    <option value="transfer">Transfer Bank</option>
                    <option value="cash">Cash (Tunai)</option>
                </select>
            </div>
            <div class="text-center">
                <a href="{{ route('penyewaan.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

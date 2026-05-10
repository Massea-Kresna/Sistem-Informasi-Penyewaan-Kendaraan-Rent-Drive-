@extends('layout')
@section('content')
<h4>Tambah Mobil</h4>
@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
    </div>
@endif
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('mobil.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Nama Mobil</label>
                <input type="text" name="nama_mobil" class="form-control" value="{{ old('nama_mobil') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Merek</label>
                <input type="text" name="merek" class="form-control" value="{{ old('merek') }}" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Plat Nomor</label>
                <input type="text" name="plat_nomor" class="form-control" value="{{ old('plat_nomor') }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label>Tahun Pembuatan</label>
                <input type="number" name="tahun_pembuatan" class="form-control"
                       value="{{ old('tahun_pembuatan', date('Y')) }}" min="1900" max="{{ date('Y') + 1 }}" required>
            </div>
            <div class="col-md-4 mb-3">
                <label>Warna</label>
                <input type="text" name="warna" class="form-control" value="{{ old('warna') }}" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Kapasitas Penumpang</label>
                <input type="number" name="kapasitas_penumpang" class="form-control"
                       value="{{ old('kapasitas_penumpang', 4) }}" min="1" max="50" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Harga Sewa / Hari (Rp)</label>
                <input type="number" name="harga_sewa" class="form-control" value="{{ old('harga_sewa') }}" required>
            </div>
        </div>
        <div class="mb-3">
            <label>Foto Mobil <small class="text-muted">(opsional, JPG/PNG max 2MB)</small></label>
            <input type="file" name="foto_mobil" class="form-control" accept="image/jpeg,image/png">
        </div>
        <div class="mb-3">
            <label>Deskripsi <small class="text-muted">(opsional)</small></label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('mobil.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div></div>
@endsection

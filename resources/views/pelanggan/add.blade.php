@extends('layout')
@section('content')
<h4>Tambah Pelanggan</h4>

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
    </div>
@endif

<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('pelanggan.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-7 mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
            </div>
            <div class="col-md-5 mb-3">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control"
                       max="{{ date('Y-m-d') }}" value="{{ old('tanggal_lahir') }}" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>No KTP</label>
                <input type="text" name="no_ktp" class="form-control" value="{{ old('no_ktp') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>No HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
            </div>
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
        </div>
        <div class="mb-3">
            <label>Foto KTP <small class="text-muted">(opsional, JPG/PNG max 2MB)</small></label>
            <input type="file" name="foto_ktp" class="form-control" accept="image/jpeg,image/png">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div></div>
@endsection

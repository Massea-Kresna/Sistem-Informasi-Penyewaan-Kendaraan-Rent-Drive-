@extends('layout')
@section('content')
<h4>Ubah Data Pelanggan</h4>

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
    </div>
@endif

<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('pelanggan.update', $data->id_pelanggan) }}">
        @csrf
        <div class="row">
            <div class="col-md-7 mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="{{ $data->nama }}" required>
            </div>
            <div class="col-md-5 mb-3">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control"
                       max="{{ date('Y-m-d') }}" value="{{ $data->tanggal_lahir }}" required>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $data->email }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Password <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                <input type="password" name="password" class="form-control">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>No KTP</label>
                <input type="text" name="no_ktp" class="form-control" value="{{ $data->no_ktp }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>No HP</label>
                <input type="text" name="no_hp" class="form-control" value="{{ $data->no_hp }}" required>
            </div>
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" rows="2" required>{{ $data->alamat }}</textarea>
        </div>
        <div class="mb-3">
            <label>URL Foto KTP <small class="text-muted">(opsional)</small></label>
            <input type="url" name="foto_ktp" class="form-control" value="{{ $data->foto_ktp }}"
                   placeholder="https://example.com/ktp.jpg">
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div></div>
@endsection

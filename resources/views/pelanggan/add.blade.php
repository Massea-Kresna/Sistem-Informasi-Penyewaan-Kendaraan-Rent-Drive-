@extends('layout')
@section('content')
<h4>Tambah Pelanggan</h4>

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $e)
            <div>{{ $e }}</div>
        @endforeach
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('pelanggan.store') }}">
            @csrf
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>No KTP</label>
                <input type="text" name="no_ktp" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>No HP</label>
                <input type="text" name="no_hp" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection

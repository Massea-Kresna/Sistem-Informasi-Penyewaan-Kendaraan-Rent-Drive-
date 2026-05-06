@extends('layout')
@section('content')
<h4>Tambah Mobil</h4>
@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach
    </div>
@endif
<div class="card"><div class="card-body">
    <form method="POST" action="{{ route('mobil.store') }}">
        @csrf
        <div class="mb-3">
            <label>Nama Mobil</label>
            <input type="text" name="nama_mobil" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Merek</label>
            <input type="text" name="merek" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Plat Nomor</label>
            <input type="text" name="plat_nomor" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Harga Sewa / Hari (Rp)</label>
            <input type="number" name="harga_sewa" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('mobil.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div></div>
@endsection
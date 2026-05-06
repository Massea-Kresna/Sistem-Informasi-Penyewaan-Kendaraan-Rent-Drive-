@extends('layout')

@section('content')
<h4>Ubah Data Mobil</h4>

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $e)
            <div>{{ $e }}</div>
        @endforeach
    </div>
@endif

<div class="card">
    <div class="card-body">
        <!-- PERUBAHAN 1: Action diarahkan ke route update dengan membawa ID mobil -->
        <form method="POST" action="{{ route('mobil.update', $data->id_mobil) }}">
            @csrf
            
            <div class="mb-3">
                <label>Nama Mobil</label>
                <!-- PERUBAHAN 2: Menambahkan value agar data lama muncul -->
                <input type="text" name="nama_mobil" class="form-control" value="{{ $data->nama_mobil }}" required>
            </div>

            <div class="mb-3">
                <label>Merek</label>
                <input type="text" name="merek" class="form-control" value="{{ $data->merek }}" required>
            </div>

            <div class="mb-3">
                <label>Plat Nomor</label>
                <input type="text" name="plat_nomor" class="form-control" value="{{ $data->plat_nomor }}" required>
            </div>

            <div class="mb-3">
                <label>Harga Sewa / Hari (Rp)</label>
                <input type="number" name="harga_sewa" class="form-control" value="{{ $data->harga_sewa }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('mobil.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
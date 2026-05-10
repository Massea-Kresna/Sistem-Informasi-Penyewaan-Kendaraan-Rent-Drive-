@extends('layout')
@section('content')
<h4>Data Pelanggan</h4>
<a href="{{ route('pelanggan.create') }}" class="btn btn-success mb-3">+ Tambah Pelanggan</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-hover">
    <thead class="table-primary">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No KTP</th>
            <th>No HP</th>
            <th>Tgl Lahir</th>
            <th>Alamat</th>
            <th>Opsi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($datas as $i => $d)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{ $d->email }}</td>
            <td>{{ $d->no_ktp }}</td>
            <td>{{ $d->no_hp }}</td>
            <td>{{ $d->tanggal_lahir }}</td>
            <td>{{ Str::limit($d->alamat, 30) }}</td>
            <td>
                <form method="POST"
                      action="{{ route('pelanggan.delete', $d->id_pelanggan) }}"
                      style="display:inline">
                    @csrf
                    <button onclick="return confirm('Hapus permanen data pelanggan ini beserta seluruh riwayat sewa-nya?')"
                            class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection

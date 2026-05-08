@extends('layout')
@section('content')
<h4>Data Mobil</h4>
<a href="{{ route('mobil.create') }}" class="btn btn-success mb-3">+ Tambah Mobil</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-hover">
    <thead class="table-primary">
        <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Nama Mobil</th>
            <th>Merek</th>
            <th>Tahun</th>
            <th>Warna</th>
            <th>Plat</th>
            <th>Kapasitas</th>
            <th>Harga/Hari</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($datas as $i => $d)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>
                @if($d->foto_mobil)
                    <img src="{{ asset('storage/' . $d->foto_mobil) }}" alt=""
                         style="width:60px; height:40px; object-fit:cover;"
                         onerror="this.style.display='none'">
                @else
                    <span class="text-muted">-</span>
                @endif
            </td>
            <td>{{ $d->nama_mobil }}</td>
            <td>{{ $d->merek }}</td>
            <td>{{ $d->tahun_pembuatan }}</td>
            <td>{{ $d->warna }}</td>
            <td>{{ $d->plat_nomor }}</td>
            <td>{{ $d->kapasitas_penumpang }}</td>
            <td>Rp {{ number_format($d->harga_sewa) }}</td>
            <td>
                <span class="badge bg-{{ $d->status=='tersedia' ? 'success' : 'danger' }}">
                    {{ $d->status }}
                </span>
            </td>
            <td>
                <a href="{{ route('mobil.edit', $d->id_mobil) }}" class="btn btn-warning btn-sm">Ubah</a>
                <form method="POST" action="{{ route('mobil.delete', $d->id_mobil) }}" style="display:inline">
                    @csrf
                    <button onclick="return confirm('Hapus?')" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection

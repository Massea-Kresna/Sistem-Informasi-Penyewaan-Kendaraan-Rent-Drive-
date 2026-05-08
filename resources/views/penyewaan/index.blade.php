@extends('layout')
@section('content')
<h4>Data Penyewaan</h4>
<a href="{{ route('penyewaan.create') }}" class="btn btn-success mb-3">+ Tambah Penyewaan</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-hover">
    <thead class="table-primary">
        <tr>
            <th>No</th>
            <th>Pelanggan</th>
            <th>Mobil</th>
            <th>Plat</th>
            <th>Tgl Sewa</th>
            <th>Tgl Kembali</th>
            <th>Durasi</th>
            <th>Status</th>
            <th>Metode Bayar</th>
            <th>Total</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @forelse($datas as $i => $d)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $d->nama_pelanggan }}</td>
            <td>{{ $d->nama_mobil }}</td>
            <td>{{ $d->plat_nomor }}</td>
            <td>{{ $d->tanggal_sewa }}</td>
            <td>{{ $d->tanggal_kembali ?? '-' }}</td>
            <td>{{ $d->durasi_hari ?? '-' }} hari</td>
            <td>
                @php
                    $badge = [
                        'pending'    => 'warning text-dark',
                        'dibayar'    => 'info',
                        'selesai'    => 'secondary',
                        'dibatalkan' => 'danger',
                    ][$d->status] ?? 'light';
                @endphp
                <span class="badge bg-{{ $badge }}">{{ $d->status }}</span>
            </td>
            <td>
                @if($d->metode_pembayaran)
                    <span class="badge bg-light text-dark">{{ ucfirst($d->metode_pembayaran) }}</span>
                @else - @endif
            </td>
            <td>{{ $d->total_biaya ? 'Rp ' . number_format($d->total_biaya) : '-' }}</td>
            <td>
                <a href="{{ route('penyewaan.detail', $d->id_sewa) }}" class="btn btn-info btn-sm">Detail</a>
                @if($d->status == 'dibayar')
                    <form method="POST" action="{{ route('penyewaan.kembali', $d->id_sewa) }}" style="display:inline">
                        @csrf
                        <button onclick="return confirm('Kembalikan mobil ini?')" class="btn btn-primary btn-sm">Kembalikan</button>
                    </form>
                @endif
                <form method="POST" action="{{ route('penyewaan.delete', $d->id_sewa) }}" style="display:inline">
                    @csrf
                    <button onclick="return confirm('Hapus permanen data ini?')" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="11" class="text-center text-muted">Belum ada data penyewaan</td></tr>
    @endforelse
    </tbody>
</table>
@endsection

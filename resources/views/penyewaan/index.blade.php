@extends('layout')
@section('content')
<h4>Dashboard Penyewaan</h4>
<a href="{{ route('penyewaan.create') }}" class="btn btn-success mb-3">+ Sewa Mobil Baru</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>No ID</th><th>Mobil</th><th>Tgl Sewa</th><th>Tgl Kembali</th>
                <th>Total Biaya</th><th>Status</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($datas as $d)
            <tr>
                <td>#{{ $d->id_sewa }}</td>
                <td>{{ $d->nama_mobil }} <br> <small class="text-muted">{{ $d->plat_nomor }}</small></td>
                <td>{{ $d->tanggal_sewa }}</td>
                <td>{{ $d->tanggal_kembali }}</td>
                <td>Rp {{ number_format($d->total_biaya) }}</td>
                <td>
                    @php
                        $badgeColor = match($d->status) {
                            'Pending' => 'secondary',
                            'Berhasil Dibayar' => 'success',
                            'Dibatalkan' => 'danger',
                            default => 'warning'
                        };
                    @endphp
                    <span class="badge bg-{{ $badgeColor }}">{{ $d->status }}</span>
                </td>
                <td>
                    @if($d->status == 'Pending')
                        <a href="{{ route('pembayaran.form', $d->id_sewa) }}" class="btn btn-primary btn-sm">Bayar</a>
                    @elseif($d->status == 'Menunggu Verifikasi')
                        <form method="POST" action="{{ route('pembayaran.verifikasi', ['id_pembayaran' => $d->id_pembayaran, 'status' => 1]) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-success btn-sm">Valid</button>
                        </form>
                        <form method="POST" action="{{ route('pembayaran.verifikasi', ['id_pembayaran' => $d->id_pembayaran, 'status' => 0]) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-danger btn-sm">Tolak</button>
                        </form>
                    @elseif($d->status == 'Berhasil Dibayar')
                        <button class="btn btn-info btn-sm text-white" onclick="alert('Bukti sewa berhasil dicetak/dikirim!')">Cetak Bukti</button>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
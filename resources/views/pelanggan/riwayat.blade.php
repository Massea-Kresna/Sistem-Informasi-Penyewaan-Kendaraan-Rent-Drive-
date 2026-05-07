@extends('pelanggan.layout')
@section('title', 'Riwayat Sewa')

@section('content')
<h4 class="mb-3">Riwayat Penyewaan</h4>

@if(count($datas) === 0)
    <div class="alert alert-info">
        Anda belum memiliki riwayat penyewaan.
        <a href="{{ route('pelanggan.mobil') }}">Mulai sewa sekarang →</a>
    </div>
@else
<table class="table table-hover">
    <thead class="table-primary">
        <tr>
            <th>No</th>
            <th>Mobil</th>
            <th>Tgl Sewa</th>
            <th>Tgl Kembali</th>
            <th>Total</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    @foreach($datas as $i => $d)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>
                <strong>{{ $d->nama_mobil }}</strong><br>
                <small class="text-muted">{{ $d->merek }} - {{ $d->plat_nomor }}</small>
            </td>
            <td>{{ $d->tanggal_sewa }}</td>
            <td>{{ $d->tanggal_kembali ?? '-' }}</td>
            <td>Rp {{ number_format($d->total_biaya) }}</td>
            <td>
                @php
                    $badge = [
                        'pending'    => 'warning text-dark',
                        'dibayar'    => 'success',
                        'selesai'    => 'secondary',
                        'dibatalkan' => 'danger',
                    ][$d->status] ?? 'light';
                @endphp
                <span class="badge bg-{{ $badge }}">{{ $d->status }}</span>
            </td>
            <td>
                @if($d->status === 'pending')
                    <a href="{{ route('pelanggan.bayar', $d->id_sewa) }}" class="btn btn-primary btn-sm">Bayar</a>
                @elseif($d->status === 'dibayar' || $d->status === 'selesai')
                    <a href="{{ route('pelanggan.bukti', $d->id_sewa) }}" class="btn btn-info btn-sm">Lihat Bukti</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endif
@endsection

@extends('pelanggan.layout')
@section('title', 'Riwayat Perjalanan')

@section('content')
<style>
    .page-header { padding: 2rem 3rem; background: var(--white); border-bottom: 1px solid var(--line); }
    .page-title { font-size: 1.5rem; font-weight: 300; color: var(--ink); }
    
    .table-wrapper { padding: 3rem; max-width: 1200px; margin: 0 auto; }
    .data-table { width: 100%; border-collapse: collapse; background: var(--white); border: 1px solid var(--line); }
    .data-table th { background: var(--bg); padding: 1rem 1.5rem; font-size: 10.5px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; color: var(--ink-muted); text-align: center; border-bottom: 1px solid var(--line); }
    .data-table td { padding: 1rem 1.5rem; font-size: 13.5px; color: var(--ink); border-bottom: 1px solid var(--line); vertical-align: middle; text-align: center; }
    
    .data-primary { font-weight: 600; color: var(--blue-deep); display: block; margin-bottom: 2px; }
    .data-secondary { font-size: 12px; color: var(--ink-muted); display: block; }
    
    .badge-status { display: inline-block; padding: 5px 12px; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border-radius: 99px; }
    .bg-pending { background: var(--amber-soft); color: var(--amber); }
    .bg-dibayar { background: var(--blue-soft); color: var(--blue-accent); }
    .bg-selesai { background: var(--green-soft); color: var(--green); }
    .bg-dibatalkan { background: var(--red-soft); color: var(--red); }

    .btn-act { padding: 8px 14px; font-size: 11px; font-weight: 600; font-family: 'Sora'; text-transform: uppercase; text-decoration: none; display: inline-block; transition: 0.2s; }
    .btn-pay { background: var(--blue-deep); color: var(--white); border: 1px solid var(--blue-deep); }
    .btn-pay:hover { background: var(--blue-mid); color: var(--white); }
    .btn-view { background: transparent; color: var(--ink-muted); border: 1px solid var(--line); }
    .btn-view:hover { border-color: var(--blue-accent); color: var(--blue-accent); background: var(--bg); }
</style>

<div class="page-header">
    <h2 class="page-title">Riwayat <strong>Perjalanan Anda</strong></h2>
</div>

<div class="table-wrapper">
    @if(count($datas) === 0)
        <div style="text-align: center; padding: 4rem; background: var(--white); border: 1px solid var(--line); color: var(--ink-muted);">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🧾</div>
            Anda belum memiliki riwayat reservasi.<br>
            <a href="{{ route('pelanggan.mobil') }}" style="color: var(--blue-accent); font-weight: 600; display: inline-block; margin-top: 10px; text-decoration: none;">Eksplorasi Katalog →</a>
        </div>
    @else
        <table class="data-table">
            <thead>
                <tr>
                    <th>Ref ID</th>
                    <th>Armada</th>
                    <th>Jadwal Sewa</th>
                    <th>Total Tagihan</th>
                    <th>Status</th>
                    <th>Tindakan</th>
                </tr>
            </thead>
            <tbody>
            @foreach($datas as $d)
                <tr>
                    <td style="font-family: monospace;">#{{ str_pad($d->id_sewa, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <span class="data-primary">{{ $d->nama_mobil }}</span>
                        <span class="data-secondary">{{ $d->plat_nomor }}</span>
                    </td>
                    <td>
                        <span class="data-secondary">{{ date('d M Y', strtotime($d->tanggal_sewa)) }}</span>
                        <span class="data-secondary">s/d {{ $d->tanggal_kembali ? date('d M Y', strtotime($d->tanggal_kembali)) : '-' }}</span>
                    </td>
                    <td>
                        <span class="data-primary" style="color: var(--ink);">Rp {{ number_format($d->total_biaya, 0, ',', '.') }}</span>
                    </td>
                    <td>
                        @php
                            $st = strtolower($d->status);
                            $bg = 'bg-pending';
                            if(in_array($st, ['dibayar', 'aktif'])) $bg = 'bg-dibayar';
                            if($st == 'selesai') $bg = 'bg-selesai';
                            if(in_array($st, ['batal', 'dibatalkan'])) $bg = 'bg-dibatalkan';
                        @endphp
                        <span class="badge-status {{ $bg }}">{{ $d->status }}</span>
                    </td>
                    <td>
                        @if($st === 'pending')
                            <a href="{{ route('pelanggan.bayar', $d->id_sewa) }}" class="btn-act btn-pay">Bayar Sekarang</a>
                        @elseif($st === 'dibayar' || $st === 'selesai')
                            <a href="{{ route('pelanggan.bukti', $d->id_sewa) }}" class="btn-act btn-view">Lihat Kuitansi</a>
                        @else
                            <span style="color: var(--ink-muted); font-size: 11px;">-</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
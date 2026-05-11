@extends('layout')

@section('content')
<style>
    .page-header { padding: 2rem 3rem; background: var(--white); border-bottom: 1px solid var(--line); display: flex; justify-content: space-between; align-items: center; }
    .page-title { font-size: 1.4rem; font-weight: 300; color: var(--ink); }
    .btn-back { background: transparent; border: 1px solid var(--line); padding: 8px 16px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em; color: var(--ink-muted); text-decoration: none; }

    .content-wrapper { padding: 3rem; max-width: 1200px; margin: 0 auto; }
    .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem; }
    @media (max-width: 900px) { .detail-grid { grid-template-columns: 1fr; } }

    .info-card { background: var(--white); border: 1px solid var(--line); padding: 2rem; }
    .card-label { font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.15em; color: var(--blue-deep); margin-bottom: 1.5rem; display: block; border-bottom: 1px solid var(--line); padding-bottom: 8px; }
    
    .data-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed var(--line); font-size: 13px; }
    .data-row:last-child { border-bottom: none; }
    .label-text { color: var(--ink-muted); }
    .value-text { font-weight: 500; text-align: right; }

    .badge-status { padding: 4px 10px; font-size: 10px; font-weight: 600; text-transform: uppercase; border-radius: 99px; }
    .bg-warning { background: var(--amber-soft); color: var(--amber); }
    .bg-info { background: var(--blue-soft); color: var(--blue-accent); }
    .bg-secondary { background: var(--bg); color: var(--ink-muted); }
    .bg-danger { background: var(--red-soft); color: var(--red); }

    .table-pay { width: 100%; border-collapse: collapse; margin-top: 1rem; font-size: 12.5px; }
    .table-pay th { background: var(--bg); padding: 12px; text-align: left; color: var(--ink-muted); text-transform: uppercase; font-size: 10px; letter-spacing: 0.1em; border-bottom: 1px solid var(--line); }
    .table-pay td { padding: 12px; border-bottom: 1px solid var(--line); }
</style>

<div class="page-header">
    <h2 class="page-title">Detail Penyewaan <strong>#{{ str_pad($sewa->id_sewa, 6, '0', STR_PAD_LEFT) }}</strong></h2>
    <a href="{{ route('penyewaan.index') }}" class="btn-back">← Kembali</a>
</div>

<div class="content-wrapper">
    <div class="detail-grid">
        <div class="info-card">
            <span class="card-label">Informasi Pelanggan</span>
            <div class="data-row"><span class="label-text">Nama</span><span class="value-text">{{ $sewa->nama_pelanggan }}</span></div>
            <div class="data-row"><span class="label-text">Email</span><span class="value-text">{{ $sewa->email }}</span></div>
            <div class="data-row"><span class="label-text">No KTP</span><span class="value-text">{{ $sewa->no_ktp }}</span></div>
            <div class="data-row"><span class="label-text">No HP</span><span class="value-text">{{ $sewa->no_hp }}</span></div>
        </div>

        <div class="info-card">
            <span class="card-label">Spesifikasi Armada</span>
            <div class="data-row"><span class="label-text">Mobil</span><span class="value-text">{{ $sewa->nama_mobil }}</span></div>
            <div class="data-row"><span class="label-text">Plat Nomor</span><span class="value-text" style="font-family: monospace;">{{ $sewa->plat_nomor }}</span></div>
            <div class="data-row"><span class="label-text">Warna / Tahun</span><span class="value-text">{{ $sewa->warna }} / {{ $sewa->tahun_pembuatan }}</span></div>
            <div class="data-row"><span class="label-text">Tarif / Hari</span><span class="value-text">Rp {{ number_format($sewa->harga_sewa) }}</span></div>
        </div>
    </div>

    <div class="info-card" style="margin-bottom: 2rem;">
        <span class="card-label">Rincian Reservasi</span>
        <div class="detail-grid" style="gap: 4rem; margin-bottom: 0;">
            <div>
                <div class="data-row"><span class="label-text">Status Sewa</span>
                    <span>
                        @php $b = ['pending'=>'warning','dibayar'=>'info','selesai'=>'secondary','dibatalkan'=>'danger'][$sewa->status] ?? 'light'; @endphp
                        <span class="badge-status bg-{{ $b }}">{{ $sewa->status }}</span>
                    </span>
                </div>
                <div class="data-row"><span class="label-text">Tanggal Sewa</span><span class="value-text">{{ date('d M Y', strtotime($sewa->tanggal_sewa)) }}</span></div>
                <div class="data-row"><span class="label-text">Tanggal Kembali</span><span class="value-text">{{ $sewa->tanggal_kembali ? date('d M Y', strtotime($sewa->tanggal_kembali)) : '-' }}</span></div>
            </div>
            <div>
                <div class="data-row"><span class="label-text">Durasi</span><span class="value-text">{{ $sewa->durasi_hari }} Hari</span></div>
                <div class="data-row"><span class="label-text">Total Biaya</span><span class="value-text" style="color: var(--blue-deep); font-weight: 600;">Rp {{ number_format($sewa->total_biaya) }}</span></div>
                <div class="data-row"><span class="label-text">Dibuat Pada</span><span class="value-text">{{ date('d/m/Y H:i', strtotime($sewa->created_at)) }}</span></div>
            </div>
        </div>
    </div>

    <div class="info-card">
        <span class="card-label">Riwayat Transaksi Pembayaran</span>
        @if(count($pembayaran) === 0)
            <p style="text-align: center; color: var(--ink-muted); font-size: 13px; padding: 1rem;">Belum ada record pembayaran.</p>
        @else
            <table class="table-pay">
                <thead>
                    <tr>
                        <th>ID Bayar</th>
                        <th>Tanggal</th>
                        <th>Metode</th>
                        <th>Nominal</th>
                        <th>Status</th>
                        <th>Bukti</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($pembayaran as $p)
                    <tr>
                        <td style="font-family: monospace;">#PAY-{{ $p->id_pembayaran }}</td>
                        <td>{{ date('d/m/Y', strtotime($p->tanggal_bayar)) }}</td>
                        <td>{{ ucfirst($p->metode_pembayaran) }}</td>
                        <td style="font-weight: 600;">Rp {{ number_format($p->jumlah_bayar) }}</td>
                        <td>
                            @php $ps = ['berhasil'=>'success','gagal'=>'danger','pending'=>'warning'][$p->status_pembayaran] ?? 'light'; @endphp
                            <span class="badge-status bg-{{ $ps }}">{{ $p->status_pembayaran }}</span>
                        </td>
                        <td>
                            @if($p->bukti_transfer)
                                <a href="{{ asset('storage/' . $p->bukti_transfer) }}" target="_blank" style="color: var(--blue-accent); text-decoration: none;">Lihat ↗</a>
                            @else - @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
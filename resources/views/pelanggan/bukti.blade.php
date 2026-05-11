@extends('pelanggan.layout')
@section('title', 'Kuitansi & Bukti Sewa')

@section('content')
<style>
    /* Styling khusus untuk layar (tampilan web) */
    .invoice-container { padding: 3rem 1.5rem; max-width: 850px; margin: 0 auto; }
    
    .invoice-card { 
        background: var(--white); 
        border: 1px solid var(--line); 
        border-top: 4px solid var(--green); /* Aksen hijau tanda sukses */
        padding: 3.5rem; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
    }

    /* Header Invoice */
    .invoice-header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid var(--line); padding-bottom: 2rem; margin-bottom: 2.5rem; }
    .brand-title { display: flex; align-items: center; gap: 10px; font-size: 1.4rem; font-weight: 600; color: var(--blue-deep); letter-spacing: 0.05em; text-transform: uppercase; }
    .brand-mark { width: 32px; height: 32px; background: var(--blue-deep); display: flex; align-items: center; justify-content: center; color: var(--white); }
    
    .invoice-meta { text-align: right; }
    .invoice-meta h1 { font-size: 1.8rem; font-weight: 300; color: var(--ink); margin-bottom: 5px; }
    .invoice-meta p { font-size: 13px; color: var(--ink-muted); margin: 0; }

    /* Grid Layout */
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-bottom: 2.5rem; }
    @media (max-width: 768px) { .grid-2 { grid-template-columns: 1fr; gap: 2rem; } }

    .section-title { font-size: 11px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase; color: var(--ink-muted); margin-bottom: 1.25rem; border-bottom: 1px dashed var(--line); padding-bottom: 8px; }

    .data-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 13px; line-height: 1.5; }
    .data-label { color: var(--ink-muted); font-weight: 400; }
    .data-value { color: var(--ink); font-weight: 500; text-align: right; max-width: 65%; word-wrap: break-word; }
    .data-value.mono { font-family: monospace; letter-spacing: 0.5px; }

    /* Badge & Alert */
    .badge-status { padding: 4px 12px; font-size: 10px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; border-radius: 99px; display: inline-block; }
    .bg-success { background: var(--green-soft); color: var(--green); }
    .bg-secondary { background: var(--bg); color: var(--ink-muted); }

    /* Kotak Total */
    .total-box { 
        background: var(--green-soft); border: 1px solid rgba(22, 163, 74, 0.2); 
        padding: 1.5rem 2rem; display: flex; justify-content: space-between; align-items: center; 
        margin-top: 1rem; 
    }
    .total-box span { font-size: 12px; font-weight: 600; color: var(--green); text-transform: uppercase; letter-spacing: 0.1em; }
    .total-box strong { font-size: 2rem; font-weight: 600; color: var(--green); }

    .info-alert { text-align: center; font-size: 11.5px; color: var(--ink-muted); margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--line); font-style: italic; }

    /* Tombol Aksi */
    .btn-group { display: flex; justify-content: space-between; margin-top: 2rem; align-items: center; }
    .btn-action { 
        padding: 12px 24px; font-family: 'Sora'; font-size: 12px; font-weight: 500; 
        letter-spacing: 0.05em; text-transform: uppercase; text-decoration: none; 
        cursor: pointer; transition: 0.2s; border: 1px solid var(--line); 
    }
    .btn-back { background: transparent; color: var(--ink); }
    .btn-back:hover { background: var(--bg); }
    .btn-print { background: var(--blue-deep); color: var(--white); border: none; display: flex; align-items: center; gap: 8px; }
    .btn-print:hover { background: var(--blue-mid); }

    /* ─── STYLING UNTUK KERTAS CETAK (PRINT) ─── */
    @media print {
        body { background: var(--white) !important; color: #000; }
        .navbar, .btn-group { display: none !important; }
        .invoice-container { padding: 0; max-width: 100%; margin: 0; }
        .invoice-card { border: none !important; box-shadow: none !important; padding: 0 !important; }
        .total-box { border: 1px solid #000; background: transparent; }
        .total-box span, .total-box strong { color: #000; }
        .bg-success, .bg-secondary { background: transparent; border: 1px solid #000; color: #000; }
    }
</style>

<div class="invoice-container">
    <div class="invoice-card">
        
        <div class="invoice-header">
            <div class="brand-title">
                <div class="brand-mark">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h11a2 2 0 012 2v3"/><rect x="9" y="11" width="14" height="10" rx="2"/></svg>
                </div>
                Rent Drive
            </div>
            <div class="invoice-meta">
                <h1>Bukti Sewa</h1>
                <p>No. Ref: <strong style="color: var(--ink); font-family: monospace;">RD-{{ str_pad($sewa->id_sewa, 6, '0', STR_PAD_LEFT) }}</strong></p>
                <p>Dicetak: {{ date('d M Y, H:i') }}</p>
            </div>
        </div>

        <div class="grid-2">
            <div>
                <h3 class="section-title">Ditagihkan Kepada</h3>
                <div class="data-row"><span class="data-label">Nama Lengkap</span><span class="data-value">{{ $sewa->nama_pelanggan }}</span></div>
                <div class="data-row"><span class="data-label">Email Valid</span><span class="data-value">{{ $sewa->email }}</span></div>
                <div class="data-row"><span class="data-label">Kontak (HP)</span><span class="data-value">{{ $sewa->no_hp }}</span></div>
                <div class="data-row"><span class="data-label">Alamat Penagihan</span><span class="data-value">{{ $sewa->alamat }}</span></div>
            </div>
            
            <div>
                <h3 class="section-title">Informasi Reservasi</h3>
                <div class="data-row">
                    <span class="data-label">Status Sewa</span>
                    <span class="data-value">
                        @if($sewa->status === 'dibayar')
                            <span class="badge-status bg-success">Berhasil Dibayar</span>
                        @elseif($sewa->status === 'selesai')
                            <span class="badge-status bg-secondary">Selesai</span>
                        @endif
                    </span>
                </div>
                <div class="data-row"><span class="data-label">Tanggal Mulai</span><span class="data-value">{{ date('d M Y', strtotime($sewa->tanggal_sewa)) }}</span></div>
                <div class="data-row"><span class="data-label">Tanggal Selesai</span><span class="data-value">{{ date('d M Y', strtotime($sewa->tanggal_kembali)) }}</span></div>
                <div class="data-row"><span class="data-label">Durasi Terhitung</span><span class="data-value">{{ $sewa->durasi_hari }} Hari</span></div>
                @if($sewa->catatan)
                    <div class="data-row"><span class="data-label">Catatan Spesial</span><span class="data-value" style="font-style: italic;">"{{ $sewa->catatan }}"</span></div>
                @endif
            </div>
        </div>

        <div class="grid-2">
            <div>
                <h3 class="section-title">Spesifikasi Armada</h3>
                <div class="data-row"><span class="data-label">Mobil Terpilih</span><span class="data-value">{{ $sewa->nama_mobil }}</span></div>
                <div class="data-row"><span class="data-label">Merek & Tahun</span><span class="data-value">{{ $sewa->merek }} / {{ $sewa->tahun_pembuatan }}</span></div>
                <div class="data-row"><span class="data-label">Plat Nomor</span><span class="data-value mono">{{ $sewa->plat_nomor }}</span></div>
                <div class="data-row"><span class="data-label">Warna Kendaraan</span><span class="data-value">{{ $sewa->warna }}</span></div>
                <div class="data-row"><span class="data-label">Tarif Sewa Dasar</span><span class="data-value">Rp {{ number_format($sewa->harga_sewa, 0, ',', '.') }} / hari</span></div>
            </div>

            <div>
                <h3 class="section-title">Catatan Pembayaran</h3>
                @if($pembayaran)
                    <div class="data-row"><span class="data-label">ID Transaksi</span><span class="data-value mono">PAY-{{ str_pad($pembayaran->id_pembayaran, 6, '0', STR_PAD_LEFT) }}</span></div>
                    <div class="data-row"><span class="data-label">Metode Bayar</span><span class="data-value">{{ ucfirst($pembayaran->metode_pembayaran) }}</span></div>
                    <div class="data-row"><span class="data-label">Tanggal Lunas</span><span class="data-value">{{ date('d M Y H:i', strtotime($pembayaran->tanggal_bayar)) }}</span></div>
                    <div class="data-row">
                        <span class="data-label">Status Bayar</span>
                        <span class="data-value"><span class="badge-status bg-success">{{ ucfirst($pembayaran->status_pembayaran) }}</span></span>
                    </div>
                    @if($pembayaran->bukti_transfer)
                        <div class="data-row" style="align-items: center; margin-top: 10px;">
                            <span class="data-label">Lampiran Bukti</span>
                            <span class="data-value">
                                <a href="{{ asset('storage/' . $pembayaran->bukti_transfer) }}" target="_blank" style="color: var(--blue-accent); text-decoration: none; font-size: 12px;">Lihat Berkas ↗</a>
                            </span>
                        </div>
                    @endif
                @else
                    <div style="font-size: 12px; color: var(--ink-muted); font-style: italic;">Informasi pembayaran tidak tersedia atau belum dilunasi.</div>
                @endif
            </div>
        </div>

        <div class="total-box">
            <span>Total Pelunasan</span>
            <strong>Rp {{ number_format($sewa->total_biaya, 0, ',', '.') }}</strong>
        </div>

        <div class="info-alert">
            Dokumen ini diterbitkan secara otomatis oleh sistem Rent-Drive dan merupakan konfirmasi resmi reservasi. Mohon cetak atau simpan dokumen ini sebagai bukti saat melakukan pengambilan unit kendaraan.
        </div>

    </div>

    <div class="btn-group">
        <a href="{{ route('pelanggan.riwayat') }}" class="btn-action btn-back">← Kembali ke Riwayat</a>
        <button onclick="window.print()" class="btn-action btn-print">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Cetak Dokumen
        </button>
    </div>
</div>
@endsection
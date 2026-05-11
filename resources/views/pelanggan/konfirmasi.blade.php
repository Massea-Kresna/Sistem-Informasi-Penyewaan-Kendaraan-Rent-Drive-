@extends('pelanggan.layout')
@section('title', 'Konfirmasi Pesanan')

@section('content')
<style>
    .page-header { padding: 2rem 3rem; background: var(--white); border-bottom: 1px solid var(--line); }
    .page-title { font-size: 1.5rem; font-weight: 300; color: var(--ink); }
    
    .confirm-wrapper { padding: 3rem; max-width: 800px; margin: 0 auto; }
    .confirm-card { background: var(--white); border: 1px solid var(--line); padding: 3rem; }
    
    .section-label { font-size: 11px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase; color: var(--blue-deep); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--line); }

    .data-row { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px dashed var(--line); font-size: 13.5px; }
    .data-row:last-child { border-bottom: none; }
    .data-label { color: var(--ink-muted); font-weight: 400; }
    .data-value { color: var(--ink); font-weight: 500; text-align: right; }
    
    .total-row { display: flex; justify-content: space-between; align-items: center; background: var(--bg); padding: 1.5rem; border: 1px solid var(--line); margin-top: 1.5rem; }
    .total-label { font-size: 14px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; color: var(--ink); }
    .total-value { font-size: 1.5rem; font-weight: 600; color: var(--blue-deep); }

    .form-actions { display: flex; gap: 1rem; margin-top: 2.5rem; align-items: center; justify-content: space-between; }
    .btn-submit { background: var(--blue-deep); color: var(--white); padding: 14px 24px; font-family: 'Sora'; font-size: 12px; font-weight: 500; letter-spacing: 0.1em; text-transform: uppercase; border: none; cursor: pointer; transition: 0.2s; }
    .btn-submit:hover { background: var(--blue-mid); }
    .btn-cancel { color: var(--ink-muted); font-size: 12px; font-weight: 500; text-transform: uppercase; text-decoration: none; letter-spacing: 0.05em; transition: 0.2s; border: 1px solid var(--line); padding: 13px 20px; }
    .btn-cancel:hover { color: var(--ink); background: var(--bg); }
</style>

<div class="page-header">
    <h2 class="page-title">Konfirmasi <strong>Reservasi</strong></h2>
</div>

<div class="confirm-wrapper">
    <div class="confirm-card">
        <h3 class="section-label">Ringkasan Pesanan Anda</h3>
        
        <div class="data-row">
            <span class="data-label">Armada Terpilih</span>
            <span class="data-value">{{ $mobil->nama_mobil }} ({{ $mobil->merek }} {{ $mobil->tahun_pembuatan }})</span>
        </div>
        <div class="data-row">
            <span class="data-label">Warna / Plat Nomor</span>
            <span class="data-value">{{ $mobil->warna }} / <span style="font-family: monospace;">{{ $mobil->plat_nomor }}</span></span>
        </div>
        <div class="data-row">
            <span class="data-label">Kapasitas Maksimal</span>
            <span class="data-value">{{ $mobil->kapasitas_penumpang }} Penumpang</span>
        </div>
        <div class="data-row">
            <span class="data-label">Tarif Dasar</span>
            <span class="data-value">Rp {{ number_format($mobil->harga_sewa, 0, ',', '.') }} / Hari</span>
        </div>
        <div class="data-row" style="margin-top: 1rem;">
            <span class="data-label">Periode Sewa</span>
            <span class="data-value">{{ date('d M Y', strtotime($tanggal_sewa)) }} — {{ date('d M Y', strtotime($tanggal_kembali)) }}</span>
        </div>
        <div class="data-row">
            <span class="data-label">Total Durasi</span>
            <span class="data-value">{{ $durasi }} Hari</span>
        </div>
        @if($catatan)
        <div class="data-row">
            <span class="data-label">Catatan Tambahan</span>
            <span class="data-value" style="color: var(--ink-muted); font-style: italic; max-width: 60%;">"{{ $catatan }}"</span>
        </div>
        @endif

        <div class="total-row">
            <span class="total-label">Estimasi Total Biaya</span>
            <span class="total-value">Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>

        <form method="POST" action="{{ route('pelanggan.simpan') }}">
            @csrf
            <input type="hidden" name="id_mobil"        value="{{ $mobil->id_mobil }}">
            <input type="hidden" name="tanggal_sewa"    value="{{ $tanggal_sewa }}">
            <input type="hidden" name="tanggal_kembali" value="{{ $tanggal_kembali }}">
            <input type="hidden" name="durasi_hari"     value="{{ $durasi }}">
            <input type="hidden" name="total_biaya"     value="{{ $total }}">
            <input type="hidden" name="catatan"         value="{{ $catatan }}">

            <div class="form-actions">
                <a href="{{ route('pelanggan.pilih', $mobil->id_mobil) }}" class="btn-cancel">← Ubah Data</a>
                <button type="submit" class="btn-submit">Simpan & Lanjut Bayar →</button>
            </div>
        </form>
    </div>
</div>
@endsection
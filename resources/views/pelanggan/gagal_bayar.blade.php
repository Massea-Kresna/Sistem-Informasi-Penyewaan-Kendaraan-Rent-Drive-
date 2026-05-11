@extends('pelanggan.layout')
@section('title', 'Transaksi Gagal')

@section('content')
<style>
    .fail-wrapper {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    
    .fail-card {
        background: var(--white);
        border: 1px solid var(--line);
        border-top: 4px solid var(--red);
        padding: 4rem 3rem;
        max-width: 500px;
        width: 100%;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0,0,0,0.03);
    }

    .fail-icon {
        width: 70px; height: 70px;
        background: var(--red-soft);
        color: var(--red);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1.5rem;
    }
    
    .fail-title { font-size: 1.5rem; font-weight: 600; color: var(--ink); margin-bottom: 0.5rem; }
    .fail-desc { font-size: 13.5px; color: var(--ink-muted); line-height: 1.6; margin-bottom: 2rem; }

    .fail-summary {
        background: var(--bg);
        border: 1px solid var(--line);
        padding: 1.5rem;
        margin-bottom: 2rem;
        text-align: left;
    }
    .summary-text { font-size: 13px; color: var(--ink); margin-bottom: 5px; }
    .summary-total { font-size: 1.25rem; font-weight: 600; color: var(--red); margin-top: 10px; border-top: 1px dashed var(--line); padding-top: 10px; }

    .btn-grid { display: grid; gap: 12px; }
    .btn-action {
        padding: 14px; font-family: 'Sora'; font-size: 12px; font-weight: 500; letter-spacing: 0.1em;
        text-transform: uppercase; border: none; cursor: pointer; transition: 0.2s; text-decoration: none; text-align: center;
    }
    .btn-retry { background: var(--blue-deep); color: var(--white); }
    .btn-retry:hover { background: var(--blue-mid); }
    .btn-cancel { background: transparent; color: var(--ink-muted); border: 1px solid var(--line); }
    .btn-cancel:hover { background: var(--red-soft); color: var(--red); border-color: var(--red); }
</style>

<div class="fail-wrapper">
    <div class="fail-card">
        <div class="fail-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="32" height="32">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
        </div>
        
        <h2 class="fail-title">Pembayaran Ditolak</h2>
        <p class="fail-desc">
            Sistem kami tidak dapat memvalidasi pembayaran Anda untuk referensi pesanan <strong>#{{ str_pad($sewa->id_sewa, 6, '0', STR_PAD_LEFT) }}</strong>.
        </p>

        <div class="fail-summary">
            <div class="summary-text"><strong>Armada:</strong> {{ $sewa->nama_mobil }}</div>
            <div class="summary-text" style="font-family: monospace;"><strong>Plat:</strong> {{ $sewa->plat_nomor }}</div>
            <div class="summary-total">Total: Rp {{ number_format($sewa->total_biaya, 0, ',', '.') }}</div>
        </div>

        <div class="btn-grid">
            <a href="{{ route('pelanggan.bayar', $sewa->id_sewa) }}" class="btn-action btn-retry">Coba Bayar Kembali</a>
            
            <form method="POST" action="{{ route('pelanggan.batal', $sewa->id_sewa) }}">
                @csrf
                <button class="btn-action btn-cancel" style="width: 100%;" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini secara permanen?')">Batalkan Reservasi</button>
            </form>
        </div>
    </div>
</div>
@endsection
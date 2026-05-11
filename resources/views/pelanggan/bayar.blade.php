@extends('pelanggan.layout')
@section('title', 'Pembayaran')

@section('content')
<style>
    .page-header { padding: 2rem 3rem; background: var(--white); border-bottom: 1px solid var(--line); }
    .page-title { font-size: 1.5rem; font-weight: 300; color: var(--ink); }
    
    .pay-wrapper { padding: 3rem; max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 400px 1fr; gap: 2rem; }
    @media (max-width: 850px) { .pay-wrapper { grid-template-columns: 1fr; } }

    .panel { background: var(--white); border: 1px solid var(--line); padding: 2rem; height: fit-content; }
    .section-label { font-size: 11px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase; color: var(--blue-deep); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--line); }

    .data-row { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px dashed var(--line); font-size: 13px; }
    .data-row:last-child { border-bottom: none; }
    .data-label { color: var(--ink-muted); }
    .data-value { font-weight: 500; text-align: right; }
    
    .total-box { background: var(--blue-deep); color: var(--white); padding: 1.5rem; margin-top: 1rem; text-align: center; }
    .total-box span { display: block; font-size: 10px; text-transform: uppercase; letter-spacing: 0.1em; opacity: 0.8; margin-bottom: 5px; }
    .total-box strong { font-size: 1.8rem; font-weight: 400; }

    /* Custom Radio Box */
    .radio-option { display: block; position: relative; margin-bottom: 1rem; cursor: pointer; }
    .radio-option input { position: absolute; opacity: 0; }
    .radio-card { border: 1px solid var(--line); padding: 1rem 1.25rem; transition: 0.2s; background: var(--white); }
    .radio-option input:checked + .radio-card { border-color: var(--blue-accent); background: var(--blue-soft); }
    .radio-title { display: block; font-weight: 600; font-size: 14px; color: var(--ink); margin-bottom: 4px; }
    .radio-desc { display: block; font-size: 12px; color: var(--ink-muted); }

    /* File Input */
    .field label { display: block; font-size: 11px; font-weight: 500; letter-spacing: 0.1em; text-transform: uppercase; color: var(--ink-muted); margin-bottom: 8px; }
    .field input[type="file"] { width: 100%; background: var(--bg); border: 1px solid var(--line); padding: 9px 12px; font-family: 'Sora'; font-size: 13px; outline: none; }
    
    .sim-alert { background: var(--bg); border-left: 3px solid var(--ink-muted); padding: 1rem; margin: 2rem 0 1rem; font-size: 12.5px; color: var(--ink); }
    
    .btn-grid { display: grid; gap: 10px; margin-top: 1.5rem; }
    .btn-action { padding: 14px; font-family: 'Sora'; font-size: 12px; font-weight: 500; letter-spacing: 0.1em; text-transform: uppercase; border: none; cursor: pointer; transition: 0.2s; text-align: center; text-decoration: none; }
    .btn-success { background: var(--blue-deep); color: var(--white); }
    .btn-success:hover { background: var(--blue-mid); }
    .btn-danger { background: transparent; color: var(--red); border: 1px solid var(--red); }
    .btn-danger:hover { background: var(--red-soft); }

    .cancel-link { display: block; text-align: center; margin-top: 2rem; color: var(--red); font-size: 12px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.05em; text-decoration: none; border: none; background: none; cursor: pointer; width: 100%; }
    .cancel-link:hover { text-decoration: underline; }

    .alert-error { background: var(--red-soft); border-left: 3px solid var(--red); padding: 1rem; margin-bottom: 2rem; font-size: 13px; color: #7f1d1d; }
</style>

<div class="page-header">
    <h2 class="page-title">Selesaikan <strong>Pembayaran</strong></h2>
</div>

<div class="pay-wrapper">
    <div>
        <div class="panel">
            <h3 class="section-label">Detail Tagihan</h3>
            <div class="data-row"><span class="data-label">ID Reservasi</span><span class="data-value" style="font-family: monospace;">#{{ str_pad($sewa->id_sewa, 6, '0', STR_PAD_LEFT) }}</span></div>
            <div class="data-row"><span class="data-label">Armada</span><span class="data-value">{{ $sewa->nama_mobil }}</span></div>
            <div class="data-row"><span class="data-label">Plat Nomor</span><span class="data-value" style="font-family: monospace;">{{ $sewa->plat_nomor }}</span></div>
            <div class="data-row"><span class="data-label">Periode Sewa</span><span class="data-value">{{ date('d/m/y', strtotime($sewa->tanggal_sewa)) }} - {{ date('d/m/y', strtotime($sewa->tanggal_kembali)) }}</span></div>
            <div class="data-row"><span class="data-label">Durasi</span><span class="data-value">{{ $sewa->durasi_hari }} Hari</span></div>
            
            <div class="total-box">
                <span>Total Kewajiban</span>
                <strong>Rp {{ number_format($sewa->total_biaya, 0, ',', '.') }}</strong>
            </div>
        </div>

        <form method="POST" action="{{ route('pelanggan.batal', $sewa->id_sewa) }}">
            @csrf
            <button class="cancel-link" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">Batalkan Pesanan Ini</button>
        </form>
    </div>

    <div>
        <div class="panel">
            <h3 class="section-label">Instruksi Pembayaran</h3>
            
            @if($errors->any())
                <div class="alert-error">
                    <ul style="margin: 0; padding-left: 1.2rem;">
                        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('pelanggan.proses', $sewa->id_sewa) }}" enctype="multipart/form-data">
                @csrf
                
                <label class="radio-option">
                    <input type="radio" name="metode_pembayaran" value="transfer" {{ old('metode_pembayaran', 'transfer') === 'transfer' ? 'checked' : '' }}>
                    <div class="radio-card">
                        <span class="radio-title">Transfer Bank Instan</span>
                        <span class="radio-desc">BCA 1234567890 a.n. Rent Drive</span>
                    </div>
                </label>
                
                <label class="radio-option">
                    <input type="radio" name="metode_pembayaran" value="cash" {{ old('metode_pembayaran') === 'cash' ? 'checked' : '' }}>
                    <div class="radio-card">
                        <span class="radio-title">Bayar Tunai (Cash)</span>
                        <span class="radio-desc">Pelunasan dilakukan di kantor saat pengambilan kunci mobil.</span>
                    </div>
                </label>

                <div class="field" style="margin-top: 1.5rem;">
                    <label>Bukti Transfer <span style="text-transform:none; font-weight:400;">(Opsional, JPG/PNG maks 2MB)</span></label>
                    <input type="file" name="bukti_transfer" accept="image/jpeg,image/png">
                    <span style="display:block; font-size:11px; color:var(--ink-muted); margin-top:6px;">Wajib dilampirkan jika Anda memilih metode Transfer Bank.</span>
                </div>

                <div class="sim-alert">
                    <strong>Mode Pengujian / Simulasi Sistem</strong><br>
                    Tekan tombol di bawah untuk menyimulasikan hasil dari proses pembayaran.
                </div>

                <div class="btn-grid">
                    <button type="submit" name="hasil" value="sukses" class="btn-action btn-success">Validasi & Nyatakan Berhasil</button>
                    <button type="submit" name="hasil" value="gagal" class="btn-action btn-danger">Simulasikan Pembayaran Gagal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
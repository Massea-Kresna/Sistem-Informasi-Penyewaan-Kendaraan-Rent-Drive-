@extends('pelanggan.layout')
@section('title', 'Form Reservasi')

@section('content')
<style>
    .page-header { padding: 2rem 3rem; background: var(--white); border-bottom: 1px solid var(--line); }
    .page-title { font-size: 1.5rem; font-weight: 300; color: var(--ink); }
    
    .reservation-wrapper { padding: 3rem; max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: 350px 1fr; gap: 2.5rem; }
    @media (max-width: 850px) { .reservation-wrapper { grid-template-columns: 1fr; } }

    .panel-card { background: var(--white); border: 1px solid var(--line); padding: 2rem; height: fit-content; }
    .panel-title { font-size: 11px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase; color: var(--blue-deep); margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--line); }

    /* Summary Mobil */
    .summary-img { width: 100%; height: 180px; object-fit: cover; background: var(--bg); border: 1px solid var(--line); margin-bottom: 1.5rem; }
    .summary-name { font-size: 1.25rem; font-weight: 600; color: var(--ink); margin-bottom: 4px; }
    .summary-spec { font-size: 13px; color: var(--ink-muted); margin-bottom: 1rem; line-height: 1.6; }
    .summary-price { font-size: 1.5rem; font-weight: 600; color: var(--blue-accent); margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px dashed var(--line); }
    .summary-price small { font-size: 12px; font-weight: 400; color: var(--ink-muted); }

    /* Form Styles */
    .field { margin-bottom: 1.5rem; }
    .field label { display: block; font-size: 11px; font-weight: 500; letter-spacing: 0.1em; text-transform: uppercase; color: var(--ink-muted); margin-bottom: 8px; }
    .field input, .field textarea { width: 100%; background: var(--bg); border: 1px solid var(--line); padding: 12px 16px; font-family: 'Sora', sans-serif; font-size: 14px; color: var(--ink); outline: none; transition: border 0.2s; }
    .field input:focus, .field textarea:focus { border-color: var(--blue-accent); background: var(--white); }

    .form-actions { display: flex; gap: 1rem; margin-top: 2.5rem; align-items: center; justify-content: space-between; }
    .btn-submit { background: var(--blue-deep); color: var(--white); padding: 14px 24px; font-family: 'Sora'; font-size: 12px; font-weight: 500; letter-spacing: 0.1em; text-transform: uppercase; border: none; cursor: pointer; transition: 0.2s; }
    .btn-submit:hover { background: var(--blue-mid); }
    .btn-cancel { color: var(--ink-muted); font-size: 12px; font-weight: 500; text-transform: uppercase; text-decoration: none; letter-spacing: 0.05em; transition: 0.2s; }
    .btn-cancel:hover { color: var(--ink); }

    .alert-error { background: var(--red-soft); border-left: 3px solid var(--red); padding: 1rem 1.5rem; margin-bottom: 2rem; font-size: 13px; color: #7f1d1d; }
</style>

<div class="page-header">
    <h2 class="page-title">Formulir <strong>Reservasi</strong></h2>
</div>

<div class="reservation-wrapper">
    <div class="panel-card">
        <h3 class="panel-title">Ringkasan Armada</h3>
        @if($mobil->foto_mobil)
            <img src="{{ asset('storage/' . $mobil->foto_mobil) }}" class="summary-img" alt="Foto Mobil">
        @endif
        <div class="summary-name">{{ $mobil->nama_mobil }}</div>
        <div class="summary-spec">
            {{ $mobil->merek }} • {{ $mobil->tahun_pembuatan }} • {{ $mobil->warna }}<br>
            Plat Nomor: <span style="font-family: monospace;">{{ $mobil->plat_nomor }}</span><br>
            Kapasitas: {{ $mobil->kapasitas_penumpang }} Penumpang
        </div>
        <div class="summary-price">
            Rp {{ number_format($mobil->harga_sewa, 0, ',', '.') }}<small>/hari</small>
        </div>
    </div>

    <div class="panel-card">
        <h3 class="panel-title">Tentukan Jadwal Sewa</h3>
        
        @if($errors->any())
            <div class="alert-error">
                <ul style="margin: 0; padding-left: 1.2rem;">
                    @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('pelanggan.konfirmasi') }}">
            @csrf
            <input type="hidden" name="id_mobil" value="{{ $mobil->id_mobil }}">

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div class="field" style="margin: 0;">
                    <label>Tanggal Pengambilan</label>
                    <input type="date" name="tanggal_sewa" min="{{ date('Y-m-d') }}" value="{{ old('tanggal_sewa', date('Y-m-d')) }}" required>
                </div>
                <div class="field" style="margin: 0;">
                    <label>Rencana Kembali</label>
                    <input type="date" name="tanggal_kembali" min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+1 day'))) }}" required>
                </div>
            </div>

            <div class="field">
                <label>Catatan Perjalanan <span style="text-transform:none; font-weight:400; color:var(--ink-muted);">(Opsional)</span></label>
                <textarea name="catatan" rows="3" placeholder="Contoh: Permintaan khusus, titik penjemputan...">{{ old('catatan') }}</textarea>
            </div>

            <div class="form-actions">
                <a href="{{ route('pelanggan.mobil') }}" class="btn-cancel">← Batalkan</a>
                <button type="submit" class="btn-submit">Lanjut ke Konfirmasi →</button>
            </div>
        </form>
    </div>
</div>
@endsection
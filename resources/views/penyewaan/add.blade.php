@extends('layout')

@section('content')
<style>
    .page-header { padding: 2rem 3rem; background: var(--white); border-bottom: 1px solid var(--line); text-align: center; }
    .page-title { font-size: 1.5rem; font-weight: 300; color: var(--ink); }
    .page-title strong { font-weight: 600; }

    .form-wrapper { padding: 3rem; max-width: 900px; margin: 0 auto; }
    .form-card { background: var(--white); border: 1px solid var(--line); padding: 3rem; text-align: center; }
    
    .form-section-title {
        font-size: 11px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase;
        color: var(--blue-deep); margin-bottom: 2rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--line);
    }

    .css-grid { display: grid; gap: 2rem 1.5rem; margin-bottom: 2.5rem; }
    .grid-2 { grid-template-columns: repeat(2, 1fr); }

    .field label {
        display: block; font-size: 11px; font-weight: 500; letter-spacing: 0.1em;
        text-transform: uppercase; color: var(--ink-muted); margin-bottom: 10px;
    }
    .field input, .field select {
        width: 100%; background: var(--bg); border: 1px solid var(--line);
        padding: 12px 16px; font-family: 'Sora', sans-serif; font-size: 14px;
        color: var(--ink); text-align: center; /* Isi Input Tengah */
        outline: none; transition: all 0.2s;
    }
    .field input:focus, .field select:focus { border-color: var(--blue-accent); background: var(--white); }

    .form-actions { display: flex; gap: 1rem; margin-top: 2rem; justify-content: center; }
    .btn-submit {
        background: var(--ink); color: var(--white); padding: 12px 30px;
        font-family: 'Sora'; font-size: 12px; font-weight: 500;
        letter-spacing: 0.1em; text-transform: uppercase; border: none; cursor: pointer;
    }
    .btn-cancel {
        background: transparent; color: var(--ink); padding: 12px 30px; border: 1px solid var(--line);
        font-size: 12px; font-weight: 500; letter-spacing: 0.1em; text-transform: uppercase;
        text-decoration: none;
    }
</style>

<div class="page-header">
    <h2 class="page-title">Tambah <strong>Penyewaan</strong></h2>
</div>

<div class="form-wrapper">
    <div class="form-card">
        <form method="post" action="{{ route('penyewaan.store') }}">
            @csrf
            <div class="form-section-title">Pihak & Armada</div>
            <div class="css-grid grid-2">
                <div class="field">
                    <label>Pelanggan</label>
                    <select name="id_pelanggan" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($pelanggans as $p)
                            <option value="{{ $p->id_pelanggan }}">{{ $p->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Mobil (Tersedia)</label>
                    <select name="id_mobil" required>
                        <option value="">-- Pilih Mobil --</option>
                        @foreach($mobils as $m)
                            <option value="{{ $m->id_mobil }}">{{ $m->nama_mobil }} ({{ $m->plat_nomor }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-section-title">Jadwal & Pembayaran</div>
            <div class="css-grid grid-2">
                <div class="field">
                    <label>Tanggal Sewa</label>
                    <input type="date" name="tanggal_sewa" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="field">
                    <label>Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" value="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                </div>
                <div class="field" style="grid-column: span 2;">
                    <label>Metode Pembayaran</label>
                    <select name="metode_pembayaran" required>
                        <option value="transfer">Transfer Bank</option>
                        <option value="cash">Cash (Tunai)</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('penyewaan.index') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</div>
@endsection
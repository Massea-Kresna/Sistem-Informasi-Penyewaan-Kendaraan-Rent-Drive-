@extends('layout')

@section('content')
<style>
    .page-header {
        padding: 2rem 3rem; background: var(--white); border-bottom: 1px solid var(--line);
    }
    .page-title { font-size: 1.5rem; font-weight: 300; color: var(--ink); }
    .page-title strong { font-weight: 600; }

    .form-wrapper { padding: 3rem; max-width: 900px; }
    .form-card { background: var(--white); border: 1px solid var(--line); padding: 3rem; }
    
    .form-section-title {
        font-size: 12px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase;
        color: var(--blue-deep); margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--line);
    }

    .css-grid { display: grid; gap: 2rem 1.5rem; margin-bottom: 2rem; }
    .grid-2 { grid-template-columns: repeat(2, 1fr); }
    .grid-3 { grid-template-columns: repeat(3, 1fr); }
    
    @media (max-width: 768px) {
        .grid-2, .grid-3 { grid-template-columns: 1fr; }
    }

    .field label {
        display: block; font-size: 11px; font-weight: 500; letter-spacing: 0.1em;
        text-transform: uppercase; color: var(--ink-muted); margin-bottom: 8px;
    }
    .field input, .field textarea {
        width: 100%; background: var(--bg); border: 1px solid var(--line);
        padding: 12px 16px; font-family: 'Sora', sans-serif; font-size: 14px;
        color: var(--ink); transition: border 0.2s, background 0.2s; outline: none;
    }
    .field input:focus, .field textarea:focus { border-color: var(--blue-accent); background: var(--white); }
    .field .help-text { display: block; font-size: 11px; color: var(--ink-muted); margin-top: 6px; }

    .form-actions { display: flex; gap: 1rem; margin-top: 3rem; }
    .btn-submit {
        background: var(--ink); color: var(--white); padding: 12px 28px;
        font-family: 'Sora', sans-serif; font-size: 12.5px; font-weight: 500;
        letter-spacing: 0.05em; text-transform: uppercase; border: none; cursor: pointer; transition: 0.2s;
    }
    .btn-submit:hover { background: #000; }
    .btn-cancel {
        background: transparent; color: var(--ink); padding: 12px 28px; border: 1px solid var(--line);
        font-size: 12.5px; font-weight: 500; letter-spacing: 0.05em; text-transform: uppercase;
        text-decoration: none; display: flex; align-items: center; transition: 0.2s;
    }
    .btn-cancel:hover { background: var(--bg); }

    /* Alert untuk Error Form */
    .form-errors { background: var(--red-soft); border-left: 3px solid var(--red); padding: 1rem 1.5rem; margin-bottom: 2rem; font-size: 13px; color: #7f1d1d; }
    .form-errors ul { margin: 0; padding-left: 1.5rem; }
</style>

<div class="page-header">
    <h2 class="page-title">Tambah <strong>Armada Baru</strong></h2>
</div>

<div class="form-wrapper">
    @if($errors->any())
        <div class="form-errors">
            <ul>
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <form method="POST" action="{{ route('mobil.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-section-title">Informasi Dasar</div>
            <div class="css-grid grid-2">
                <div class="field">
                    <label>Nama Mobil</label>
                    <input type="text" name="nama_mobil" value="{{ old('nama_mobil') }}" required placeholder="Contoh: Avanza Veloz">
                </div>
                <div class="field">
                    <label>Merek</label>
                    <input type="text" name="merek" value="{{ old('merek') }}" required placeholder="Contoh: Toyota">
                </div>
            </div>

            <div class="form-section-title">Spesifikasi Kendaraan</div>
            <div class="css-grid grid-3">
                <div class="field">
                    <label>Plat Nomor</label>
                    <input type="text" name="plat_nomor" value="{{ old('plat_nomor') }}" required placeholder="B 1234 CD">
                </div>
                <div class="field">
                    <label>Tahun Pembuatan</label>
                    <input type="number" name="tahun_pembuatan" value="{{ old('tahun_pembuatan', date('Y')) }}" min="1900" max="{{ date('Y') + 1 }}" required>
                </div>
                <div class="field">
                    <label>Warna</label>
                    <input type="text" name="warna" value="{{ old('warna') }}" required placeholder="Hitam">
                </div>
            </div>

            <div class="form-section-title">Detail Sewa</div>
            <div class="css-grid grid-2">
                <div class="field">
                    <label>Kapasitas Penumpang</label>
                    <input type="number" name="kapasitas_penumpang" value="{{ old('kapasitas_penumpang', 4) }}" min="1" max="50" required>
                </div>
                <div class="field">
                    <label>Harga Sewa / Hari (Rp)</label>
                    <input type="number" name="harga_sewa" value="{{ old('harga_sewa') }}" required placeholder="300000">
                </div>
            </div>

            <div class="field" style="margin-bottom: 2rem;">
                <label>Foto Mobil</label>
                <input type="file" name="foto_mobil" accept="image/jpeg,image/png" style="padding: 9px 12px;">
                <span class="help-text">Format JPG/PNG, maksimal ukuran 2MB (Opsional)</span>
            </div>

            <div class="field">
                <label>Deskripsi Tambahan</label>
                <textarea name="deskripsi" rows="3" placeholder="Tuliskan keterangan detail kondisi atau fasilitas mobil...">{{ old('deskripsi') }}</textarea>
                <span class="help-text">Opsional. Jelaskan fitur tambahan seperti kelengkapan audio, dll.</span>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Simpan Data Mobil</button>
                <a href="{{ route('mobil.index') }}" class="btn-cancel">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
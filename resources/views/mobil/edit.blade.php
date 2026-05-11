@extends('layout')

@section('content')
<style>
    /* Styling ini sama persis dengan add.blade.php untuk konsistensi */
    .page-header { padding: 2rem 3rem; background: var(--white); border-bottom: 1px solid var(--line); }
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
    
    @media (max-width: 768px) { .grid-2, .grid-3 { grid-template-columns: 1fr; } }

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
    .btn-submit { background: var(--blue-deep); color: var(--white); padding: 12px 28px; font-family: 'Sora'; font-size: 12.5px; font-weight: 500; letter-spacing: 0.05em; text-transform: uppercase; border: none; cursor: pointer; transition: 0.2s; }
    .btn-submit:hover { background: var(--blue-mid); }
    .btn-cancel { background: transparent; color: var(--ink); padding: 12px 28px; border: 1px solid var(--line); font-size: 12.5px; font-weight: 500; letter-spacing: 0.05em; text-transform: uppercase; text-decoration: none; display: flex; align-items: center; transition: 0.2s; }
    .btn-cancel:hover { background: var(--bg); }

    .form-errors { background: var(--red-soft); border-left: 3px solid var(--red); padding: 1rem 1.5rem; margin-bottom: 2rem; font-size: 13px; color: #7f1d1d; }
    .form-errors ul { margin: 0; padding-left: 1.5rem; }

    /* Area Preview Foto */
    .photo-preview { display: flex; gap: 1.5rem; align-items: flex-start; margin-top: 10px; }
    .photo-preview img { width: 120px; height: 80px; object-fit: cover; border: 1px solid var(--line); background: var(--bg); }
    .photo-preview .info { font-size: 12px; color: var(--ink-muted); }
</style>

<div class="page-header">
    <h2 class="page-title">Pembaruan <strong>Data Armada</strong></h2>
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
        <form method="POST" action="{{ route('mobil.update', $data->id_mobil) }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-section-title">Informasi Dasar</div>
            <div class="css-grid grid-2">
                <div class="field">
                    <label>Nama Mobil</label>
                    <input type="text" name="nama_mobil" value="{{ $data->nama_mobil }}" required>
                </div>
                <div class="field">
                    <label>Merek</label>
                    <input type="text" name="merek" value="{{ $data->merek }}" required>
                </div>
            </div>

            <div class="form-section-title">Spesifikasi Kendaraan</div>
            <div class="css-grid grid-3">
                <div class="field">
                    <label>Plat Nomor</label>
                    <input type="text" name="plat_nomor" value="{{ $data->plat_nomor }}" required>
                </div>
                <div class="field">
                    <label>Tahun Pembuatan</label>
                    <input type="number" name="tahun_pembuatan" value="{{ $data->tahun_pembuatan }}" min="1900" max="{{ date('Y') + 1 }}" required>
                </div>
                <div class="field">
                    <label>Warna</label>
                    <input type="text" name="warna" value="{{ $data->warna }}" required>
                </div>
            </div>

            <div class="form-section-title">Detail Sewa</div>
            <div class="css-grid grid-2">
                <div class="field">
                    <label>Kapasitas Penumpang</label>
                    <input type="number" name="kapasitas_penumpang" value="{{ $data->kapasitas_penumpang }}" min="1" max="50" required>
                </div>
                <div class="field">
                    <label>Harga Sewa / Hari (Rp)</label>
                    <input type="number" name="harga_sewa" value="{{ $data->harga_sewa }}" required>
                </div>
            </div>

            <div class="field" style="margin-bottom: 2rem;">
                <label>Pembaruan Foto Mobil</label>
                <input type="file" name="foto_mobil" accept="image/jpeg,image/png" style="padding: 9px 12px;">
                <span class="help-text">Kosongkan kolom ini jika Anda tidak ingin mengganti foto.</span>
                
                @if($data->foto_mobil)
                    <div class="photo-preview">
                        <img src="{{ asset('storage/' . $data->foto_mobil) }}" alt="Foto saat ini">
                        <div class="info">Visual armada saat ini.<br>Sistem akan menimpanya jika file baru diunggah.</div>
                    </div>
                @endif
            </div>

            <div class="field">
                <label>Deskripsi Tambahan</label>
                <textarea name="deskripsi" rows="3">{{ $data->deskripsi }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Terapkan Perubahan</button>
                <a href="{{ route('mobil.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
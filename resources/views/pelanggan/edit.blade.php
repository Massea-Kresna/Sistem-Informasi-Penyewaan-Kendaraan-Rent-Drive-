@extends('layout')

@section('content')
<style>
    .page-header { padding: 2rem 3rem; background: var(--white); border-bottom: 1px solid var(--line); }
    .page-title { font-size: 1.5rem; font-weight: 300; color: var(--ink); }
    .page-title strong { font-weight: 600; }

    .form-wrapper { padding: 3rem; max-width: 900px; }
    .form-card { background: var(--white); border: 1px solid var(--line); padding: 3rem; }
    
    .form-section-title {
        font-size: 12px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase;
        color: var(--blue-deep); margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--line);
    }

    .css-grid { display: grid; gap: 2rem 1.5rem; margin-bottom: 2.5rem; }
    .grid-2 { grid-template-columns: repeat(2, 1fr); }
    
    @media (max-width: 768px) { .grid-2 { grid-template-columns: 1fr; } }

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
        background: var(--blue-deep); color: var(--white); padding: 12px 28px;
        font-family: 'Sora', sans-serif; font-size: 12.5px; font-weight: 500;
        letter-spacing: 0.05em; text-transform: uppercase; border: none; cursor: pointer; transition: 0.2s;
    }
    .btn-submit:hover { background: var(--blue-mid); }
    .btn-cancel {
        background: transparent; color: var(--ink); padding: 12px 28px; border: 1px solid var(--line);
        font-size: 12.5px; font-weight: 500; letter-spacing: 0.05em; text-transform: uppercase;
        text-decoration: none; display: flex; align-items: center; transition: 0.2s;
    }
    .btn-cancel:hover { background: var(--bg); }

    .form-errors { background: var(--red-soft); border-left: 3px solid var(--red); padding: 1rem 1.5rem; margin-bottom: 2rem; font-size: 13px; color: #7f1d1d; }
    .form-errors ul { margin: 0; padding-left: 1.5rem; }

    .photo-preview { display: flex; gap: 1.5rem; align-items: center; margin-top: 10px; }
    .photo-preview img { width: 100px; height: 65px; object-fit: cover; border: 1px solid var(--line); }
</style>

<div class="page-header">
    <h2 class="page-title">Pembaruan <strong>Entitas Pelanggan</strong></h2>
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
        <form method="POST" action="{{ route('pelanggan.update', $data->id_pelanggan) }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-section-title">Kredensial Akun</div>
            <div class="css-grid grid-2">
                <div class="field">
                    <label>Alamat Email</label>
                    <input type="email" name="email" value="{{ $data->email }}" required>
                </div>
                <div class="field">
                    <label>Kata Sandi Baru</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak diubah">
                    <span class="help-text">Minimal 8 karakter jika ingin mengganti sandi.</span>
                </div>
            </div>

            <div class="form-section-title">Data Personil</div>
            <div class="css-grid grid-2">
                <div class="field">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ $data->nama }}" required>
                </div>
                <div class="field">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" max="{{ date('Y-m-d') }}" value="{{ $data->tanggal_lahir }}" required>
                </div>
                <div class="field">
                    <label>Nomor Induk Kependudukan (KTP)</label>
                    <input type="text" name="no_ktp" value="{{ $data->no_ktp }}" required>
                </div>
                <div class="field">
                    <label>Nomor Telepon / WhatsApp</label>
                    <input type="text" name="no_hp" value="{{ $data->no_hp }}" required>
                </div>
            </div>

            <div class="form-section-title">Domisili & Berkas</div>
            <div class="field" style="margin-bottom: 1.5rem;">
                <label>Alamat Lengkap</label>
                <textarea name="alamat" rows="2" required>{{ $data->alamat }}</textarea>
            </div>
            
            <div class="field">
                <label>Perbarui Foto KTP</label>
                <input type="file" name="foto_ktp" accept="image/jpeg,image/png" style="padding: 9px 12px;">
                
                @if($data->foto_ktp)
                    <div class="photo-preview">
                        <img src="{{ asset('storage/' . $data->foto_ktp) }}" alt="KTP saat ini">
                        <span class="help-text">Visual KTP tersimpan. Unggah file baru untuk menimpa.</span>
                    </div>
                @endif
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Terapkan Perubahan</button>
                <a href="{{ route('pelanggan.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
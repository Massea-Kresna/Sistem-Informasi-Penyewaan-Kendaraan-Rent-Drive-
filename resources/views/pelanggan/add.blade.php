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

    .form-errors { background: var(--red-soft); border-left: 3px solid var(--red); padding: 1rem 1.5rem; margin-bottom: 2rem; font-size: 13px; color: #7f1d1d; }
    .form-errors ul { margin: 0; padding-left: 1.5rem; }
</style>

<div class="page-header">
    <h2 class="page-title">Registrasi <strong>Pelanggan Baru</strong></h2>
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
        <form method="POST" action="{{ route('pelanggan.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-section-title">Kredensial Akun</div>
            <div class="css-grid grid-2">
                <div class="field">
                    <label>Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com">
                </div>
                <div class="field">
                    <label>Kata Sandi</label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter">
                </div>
            </div>

            <div class="form-section-title">Data Personil</div>
            <div class="css-grid grid-2">
                <div class="field">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Sesuai KTP">
                </div>
                <div class="field">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" max="{{ date('Y-m-d') }}" value="{{ old('tanggal_lahir') }}" required>
                </div>
                <div class="field">
                    <label>Nomor Induk Kependudukan (KTP)</label>
                    <input type="text" name="no_ktp" value="{{ old('no_ktp') }}" required placeholder="16 Digit NIK">
                </div>
                <div class="field">
                    <label>Nomor Telepon / WhatsApp</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" required placeholder="08xxxxxxxxxx">
                </div>
            </div>

            <div class="form-section-title">Domisili & Berkas</div>
            <div class="field" style="margin-bottom: 1.5rem;">
                <label>Alamat Lengkap</label>
                <textarea name="alamat" rows="2" required placeholder="Tuliskan jalan, RT/RW, kelurahan, dan kota...">{{ old('alamat') }}</textarea>
            </div>
            <div class="field">
                <label>Unggah Foto KTP</label>
                <input type="file" name="foto_ktp" accept="image/jpeg,image/png" style="padding: 9px 12px;">
                <span class="help-text">Format JPG/PNG, maksimal ukuran 2MB (Opsional namun disarankan untuk verifikasi).</span>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Daftarkan Pelanggan</button>
                <a href="{{ route('pelanggan.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
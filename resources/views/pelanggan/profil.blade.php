@extends('pelanggan.layout')
@section('title', 'Profil Saya')

@section('content')
<style>
    .page-header { padding: 2rem 3rem; background: var(--white); border-bottom: 1px solid var(--line); }
    .page-title { font-size: 1.5rem; font-weight: 300; color: var(--ink); }
    .page-title strong { font-weight: 600; }
    
    .form-wrapper { padding: 3rem; max-width: 900px; margin: 0 auto; }
    .form-card { background: var(--white); border: 1px solid var(--line); padding: 3rem; }
    
    .form-section-title { font-size: 11px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase; color: var(--blue-deep); margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 1px solid var(--line); }

    .css-grid { display: grid; gap: 1.5rem; margin-bottom: 2.5rem; }
    .grid-2 { grid-template-columns: repeat(2, 1fr); }
    @media (max-width: 768px) { .grid-2 { grid-template-columns: 1fr; } }

    .field label { display: block; font-size: 11px; font-weight: 500; letter-spacing: 0.1em; text-transform: uppercase; color: var(--ink-muted); margin-bottom: 8px; }
    .field input, .field textarea { width: 100%; background: var(--bg); border: 1px solid var(--line); padding: 12px 16px; font-family: 'Sora', sans-serif; font-size: 14px; color: var(--ink); outline: none; transition: border 0.2s, background 0.2s; }
    .field input:focus, .field textarea:focus { border-color: var(--blue-accent); background: var(--white); }
    .field input[readonly] { color: var(--ink-muted); cursor: not-allowed; }
    
    .help-text { display: block; font-size: 11px; color: var(--ink-muted); margin-top: 6px; }

    .form-actions { display: flex; gap: 1rem; margin-top: 3rem; justify-content: flex-end; border-top: 1px solid var(--line); padding-top: 2rem; }
    .btn-submit { background: var(--ink); color: var(--white); padding: 12px 28px; font-family: 'Sora'; font-size: 12.5px; font-weight: 500; letter-spacing: 0.05em; text-transform: uppercase; border: none; cursor: pointer; transition: 0.2s; }
    .btn-submit:hover { background: var(--blue-deep); }
    .btn-cancel { background: transparent; color: var(--ink); padding: 12px 28px; border: 1px solid var(--line); font-size: 12.5px; font-weight: 500; letter-spacing: 0.05em; text-transform: uppercase; text-decoration: none; display: flex; align-items: center; transition: 0.2s; }
    .btn-cancel:hover { background: var(--bg); }
    
    .alert-error { background: var(--red-soft); border-left: 3px solid var(--red); padding: 1rem 1.5rem; margin-bottom: 2rem; font-size: 13px; color: #7f1d1d; }
</style>

<div class="page-header">
    <h2 class="page-title">Profil <strong>Saya</strong></h2>
</div>

<div class="form-wrapper">
    @if($errors->any())
        <div class="alert-error">
            <ul style="margin: 0; padding-left: 1.2rem;">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <form method="POST" action="{{ route('pelanggan.profil.update') }}" enctype="multipart/form-data">
            @csrf

            <div class="form-section-title">Kredensial Login</div>
            <div class="css-grid grid-2">
                <div class="field">
                    <label>Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="field">
                    <label>Tanggal Bergabung</label>
                    <input type="text" value="{{ date('d F Y', strtotime($user->created_at)) }}" readonly>
                </div>
            </div>

            <div class="form-section-title">Informasi Pribadi</div>
            <div class="css-grid grid-2">
                <div class="field">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required>
                </div>
                <div class="field">
                    <label>Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" max="{{ date('Y-m-d') }}" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" required>
                </div>
                <div class="field">
                    <label>Nomor Induk Kependudukan (KTP)</label>
                    <input type="text" name="no_ktp" value="{{ old('no_ktp', $user->no_ktp) }}" required>
                </div>
                <div class="field">
                    <label>Nomor Telepon (HP)</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" required>
                </div>
            </div>

            <div class="field" style="margin-bottom: 1.5rem;">
                <label>Alamat Domisili</label>
                <textarea name="alamat" rows="2" required>{{ old('alamat', $user->alamat) }}</textarea>
            </div>

            <div class="field" style="margin-bottom: 2.5rem;">
                <label>Pembaruan Dokumen KTP</label>
                <input type="file" name="foto_ktp" accept="image/jpeg,image/png" style="padding: 9px 12px;">
                <span class="help-text">Unggah file JPG/PNG baru jika ingin menimpa KTP lama. Maksimal 2MB.</span>
                
                @if($user->foto_ktp)
                    <div style="margin-top: 15px; border: 1px dashed var(--line); padding: 10px; display: inline-block; background: var(--bg);">
                        <span style="display: block; font-size: 10px; color: var(--ink-muted); margin-bottom: 5px; text-transform: uppercase; letter-spacing: 1px;">KTP Saat Ini</span>
                        <img src="{{ asset('storage/' . $user->foto_ktp) }}" alt="KTP" style="max-height:80px; border: 1px solid var(--line);" onerror="this.style.display='none'">
                    </div>
                @endif
            </div>

            <div class="form-section-title">Pemeliharaan Keamanan (Opsional)</div>
            <div class="css-grid grid-2">
                <div class="field">
                    <label>Kata Sandi Baru</label>
                    <input type="password" name="password" placeholder="Biarkan kosong jika tidak diubah">
                </div>
                <div class="field">
                    <label>Konfirmasi Sandi Baru</label>
                    <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru">
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('pelanggan.dashboard') }}" class="btn-cancel">Batal</a>
                <button type="submit" class="btn-submit">Simpan Pembaruan Data</button>
            </div>
        </form>
    </div>
</div>
@endsection
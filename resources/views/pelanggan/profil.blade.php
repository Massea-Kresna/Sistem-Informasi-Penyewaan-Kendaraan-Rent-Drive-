@extends('pelanggan.layout')
@section('title', 'Profil Saya')

@section('content')
<h4 class="mb-3">Profil Saya</h4>
<p class="text-muted">Perbarui data diri Anda di sini.</p>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('pelanggan.profil.update') }}">
            @csrf

            <h6 class="text-muted mb-3">Akun</h6>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Bergabung</label>
                    <input type="text" class="form-control" value="{{ $user->created_at }}" readonly>
                </div>
            </div>

            <hr>
            <h6 class="text-muted mb-3">Data Diri</h6>
            <div class="row">
                <div class="col-md-7 mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control"
                           value="{{ old('nama', $user->nama) }}" required>
                </div>
                <div class="col-md-5 mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control"
                           max="{{ date('Y-m-d') }}"
                           value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">No KTP</label>
                    <input type="text" name="no_ktp" class="form-control"
                           value="{{ old('no_ktp', $user->no_ktp) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">No HP</label>
                    <input type="text" name="no_hp" class="form-control"
                           value="{{ old('no_hp', $user->no_hp) }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat', $user->alamat) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">URL Foto KTP <small class="text-muted">(opsional)</small></label>
                <input type="url" name="foto_ktp" class="form-control"
                       placeholder="https://example.com/ktp.jpg"
                       value="{{ old('foto_ktp', $user->foto_ktp) }}">
                @if($user->foto_ktp)
                    <div class="mt-2">
                        <img src="{{ $user->foto_ktp }}" alt="KTP" style="max-height:100px;"
                             onerror="this.style.display='none'">
                    </div>
                @endif
            </div>

            <hr>
            <h6 class="text-muted mb-3">Ubah Password <small>(opsional)</small></h6>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="Kosongkan jika tidak diubah">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('pelanggan.dashboard') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

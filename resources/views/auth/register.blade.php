<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - Rent Drive</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container" style="max-width:600px; margin-top:40px; margin-bottom:40px;">
    <div class="text-center mb-4">
        <h2>🚗 Rent Drive</h2>
        <p class="text-muted">Daftar Akun Pelanggan</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('register.submit') }}" enctype="multipart/form-data">
                @csrf

                <h6 class="text-muted mb-3">Akun</h6>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                               value="{{ old('email') }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                </div>

                <hr>
                <h6 class="text-muted mb-3">Data Diri</h6>
                <div class="row">
                    <div class="col-md-7 mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control"
                               value="{{ old('nama') }}" required>
                    </div>
                    <div class="col-md-5 mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="form-control"
                               max="{{ date('Y-m-d') }}"
                               value="{{ old('tanggal_lahir') }}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No KTP</label>
                        <input type="text" name="no_ktp" class="form-control"
                               value="{{ old('no_ktp') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text" name="no_hp" class="form-control"
                               value="{{ old('no_hp') }}" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2" required>{{ old('alamat') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Foto KTP <small class="text-muted">(opsional, JPG/PNG max 2MB)</small></label>
                    <input type="file" name="foto_ktp" class="form-control" accept="image/jpeg,image/png">
                </div>

                <button type="submit" class="btn btn-primary w-100">Daftar</button>
            </form>
        </div>
    </div>
    <p class="text-center mt-3">
        Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
    </p>
</div>
</body>
</html>

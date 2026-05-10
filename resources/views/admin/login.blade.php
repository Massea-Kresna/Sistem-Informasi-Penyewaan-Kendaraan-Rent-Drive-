<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin - Rent Drive</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark">
<div class="container" style="max-width:420px; margin-top:80px;">
    <div class="text-center mb-4 text-white">
        <h2>🔧 Rent Drive</h2>
        <p class="text-light">Panel Administrator</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <h5 class="card-title mb-3">Login Admin</h5>
            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control"
                           value="{{ old('username') }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-dark w-100">Masuk</button>
            </form>
            <hr>
            <small class="text-muted">
                Default: <code>admin</code> / <code>admin123</code>
            </small>
        </div>
    </div>
    <p class="text-center mt-3">
        <a href="{{ route('login') }}" class="text-light">← Kembali ke halaman pelanggan</a>
    </p>
</div>
</body>
</html>

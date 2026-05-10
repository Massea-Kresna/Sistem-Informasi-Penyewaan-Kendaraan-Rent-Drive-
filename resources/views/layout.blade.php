<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rental Mobil - Kel04</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">🚗 Rental Mobil</a>
        <div class="collapse navbar-collapse">
            
            <ul class="navbar-nav me-auto">
                @if(Session::has('pelanggan_id'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('mobil.index') }}">Data Mobil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pelanggan.index') }}">Data Pelanggan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Penyewaan / Dashboard</a>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav ms-auto">
                @if(Session::has('pelanggan_id'))
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm mt-1">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-light btn-sm mt-1" href="{{ route('login') }}">Login</a>
                    </li>
                @endif
            </ul>
            
        </div>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
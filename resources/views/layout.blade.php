<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Rent Drive</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --bg-color: #f4f6f8;
            --surface: #ffffff;
            --border: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --accent-blue: #1e3a8a; /* Navy Blue */
            --accent-blue-light: #eff6ff;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            letter-spacing: -0.01em;
        }
        
        /* Navbar Eksklusif */
        .navbar-custom {
            background-color: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 0.75rem 0;
        }
        .navbar-brand {
            font-weight: 600;
            color: var(--text-main) !important;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .brand-dot {
            width: 8px;
            height: 8px;
            background-color: var(--accent-blue);
            display: inline-block;
        }
        .nav-link {
            color: var(--text-muted) !important;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            margin: 0 0.25rem;
            border-radius: 4px;
            transition: all 0.2s;
        }
        .nav-link:hover, .nav-link.active {
            background-color: var(--accent-blue-light);
            color: var(--accent-blue) !important;
        }
        
        /* Tombol Keluar Minimalis */
        .btn-logout {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-main);
            border: 1px solid var(--border);
            background: transparent;
            padding: 0.4rem 1rem;
            border-radius: 0; /* Ujung kotak tegas */
            transition: all 0.2s ease;
        }
        .btn-logout:hover {
            border-color: var(--text-main);
            background-color: var(--text-main);
            color: var(--surface);
        }

        /* Container Konten */
        .content-wrapper {
            background-color: var(--surface);
            border: 1px solid var(--border);
            padding: 2rem;
            min-height: 70vh;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        /* Custom Alerts */
        .alert {
            border-radius: 0;
            border: 1px solid;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .alert-success { 
            background-color: var(--accent-blue-light); 
            border-color: #bfdbfe; 
            color: var(--accent-blue); 
        }
        .alert-danger { 
            background-color: #fef2f2; 
            border-color: #fecaca; 
            color: #991b1b; 
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
        <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
            <span class="brand-dot"></span> RENTDRIVE
        </a>
        <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-5 me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('mobil.index') }}">Katalog Mobil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('pelanggan.index') }}">Pelanggan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('penyewaan.index') }}">Transaksi</a>
                </li>
            </ul>
            @if(session()->has('admin_id'))
                <div class="d-flex align-items-center gap-4">
                    <span style="font-size: 0.9rem; color: var(--text-muted);">
                        Admin: <strong style="color: var(--text-main);">{{ session('admin_nama') }}</strong>
                    </span>
                    <form method="POST" action="{{ route('admin.logout') }}" class="m-0">
                        @csrf
                        <button class="btn btn-logout">Keluar</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</nav>

<div class="container">
    <div class="content-wrapper">
        @if(session('success'))
            <div class="alert alert-success px-3 py-2 mb-4">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger px-3 py-2 mb-4">{{ session('error') }}</div>
        @endif
        
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — Rent-Drive</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue-deep:   #0f2d5e;
            --blue-mid:    #1a4080;
            --blue-accent: #2563eb;
            --blue-soft:   #eff6ff;
            --ink:         #0d1b2a;
            --ink-muted:   #5a6e85;
            --line:        #dde3ed;
            --bg:          #f0f4fa;
            --white:       #ffffff;
            --green:       #16a34a;
            --green-soft:  #f0fdf4;
            --amber:       #d97706;
            --amber-soft:  #fffbeb;
            --red:         #dc2626;
            --red-soft:    #fef2f2;
        }

        html, body { height: 100%; }

        body {
            font-family: 'Sora', sans-serif;
            font-weight: 400;
            background: var(--bg);
            color: var(--ink);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ─── NAVBAR ─── */
        .navbar {
            background: var(--white);
            border-bottom: 1px solid var(--line);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .navbar-inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            height: 60px;
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        /* brand */
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 9px;
            text-decoration: none;
            flex-shrink: 0;
        }
        .brand-mark {
            width: 26px; height: 26px;
            background: var(--blue-deep);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .brand-mark svg { width: 13px; height: 13px; color: #fff; }
        .brand-name {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--ink);
        }

        /* divider */
        .nav-divider {
            width: 1px;
            height: 20px;
            background: var(--line);
            flex-shrink: 0;
        }

        /* nav links */
        .nav-links {
            display: flex;
            align-items: center;
            gap: 2px;
            flex: 1;
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 6px 13px;
            font-size: 12.5px;
            font-weight: 400;
            color: var(--ink-muted);
            text-decoration: none;
            letter-spacing: 0.02em;
            transition: color 0.15s, background 0.15s;
            white-space: nowrap;
            position: relative;
        }
        .nav-link svg { width: 14px; height: 14px; flex-shrink: 0; opacity: 0.7; }
        .nav-link:hover { color: var(--ink); background: var(--bg); }
        .nav-link.active {
            color: var(--blue-deep);
            font-weight: 500;
        }
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -1px; left: 13px; right: 13px;
            height: 2px;
            background: var(--blue-deep);
        }
        /* badge on nav link */
        .nav-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 18px;
            height: 16px;
            padding: 0 5px;
            background: var(--blue-accent);
            color: #fff;
            font-size: 9px;
            font-weight: 600;
            letter-spacing: 0;
            border-radius: 99px;
        }

        /* right side */
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            margin-left: auto;
            flex-shrink: 0;
        }
        .admin-chip {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .admin-avatar {
            width: 28px; height: 28px;
            background: var(--blue-soft);
            border: 1px solid rgba(37,99,235,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 600;
            color: var(--blue-deep);
            letter-spacing: 0.04em;
            flex-shrink: 0;
        }
        .admin-info { line-height: 1.3; }
        .admin-label {
            font-size: 9px;
            font-weight: 500;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--ink-muted);
            display: block;
        }
        .admin-name {
            font-size: 12.5px;
            font-weight: 600;
            color: var(--ink);
            display: block;
        }
        .btn-logout {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 7px 16px;
            background: transparent;
            border: 1px solid var(--line);
            font-family: 'Sora', sans-serif;
            font-size: 11.5px;
            font-weight: 500;
            letter-spacing: 0.08em;
            color: var(--ink-muted);
            cursor: pointer;
            transition: border-color 0.2s, color 0.2s, background 0.2s;
            white-space: nowrap;
        }
        .btn-logout svg { width: 13px; height: 13px; }
        .btn-logout:hover {
            border-color: var(--red);
            color: var(--red);
            background: var(--red-soft);
        }

        /* mobile toggle */
        .nav-toggle {
            display: none;
            background: none;
            border: 1px solid var(--line);
            padding: 6px 9px;
            cursor: pointer;
            margin-left: auto;
            color: var(--ink-muted);
        }
        .nav-toggle svg { width: 18px; height: 18px; display: block; }
        .nav-toggle .icon-close { display: none; }

        @media (max-width: 820px) {
            .nav-links, .nav-divider { display: none; }
            .navbar-right { display: none; }
            .nav-toggle { display: flex; }

            .nav-links.open {
                display: flex;
                flex-direction: column;
                align-items: stretch;
                position: absolute;
                top: 60px; left: 0; right: 0;
                background: var(--white);
                border-bottom: 1px solid var(--line);
                padding: 0.75rem 1rem;
                gap: 2px;
                z-index: 99;
            }
            .nav-links.open + .navbar-right {
                display: flex;
                position: absolute;
                top: auto;
                flex-direction: column;
                align-items: stretch;
                left: 0; right: 0;
            }
            .nav-link.active::after { display: none; }
            .nav-link.active { background: var(--blue-soft); }

            /* show logout in mobile drawer */
            .mobile-user-row {
                display: flex !important;
            }
        }

        .mobile-user-row {
            display: none;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            border-top: 1px solid var(--line);
            background: var(--white);
        }

        /* ─── PAGE CONTENT ─── */
        .page-body {
            flex: 1;
            max-width: 1400px;
            width: 100%;
            margin: 0 auto;
            padding: 0;
        }

        /* ─── FLASH ALERTS ─── */
        .flash-zone {
            max-width: 1400px;
            margin: 0 auto;
            padding: 1rem 2rem 0;
        }
        .flash {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 400;
            border-left: 3px solid;
            margin-bottom: 1px;
        }
        .flash svg { width: 15px; height: 15px; flex-shrink: 0; margin-top: 1px; }
        .flash-success { background: var(--green-soft); border-color: var(--green); color: #14532d; }
        .flash-error   { background: var(--red-soft);   border-color: var(--red);   color: #7f1d1d; }
        .flash-close {
            margin-left: auto;
            background: none;
            border: none;
            cursor: pointer;
            color: inherit;
            opacity: 0.5;
            padding: 0;
            line-height: 1;
            font-size: 16px;
        }
        .flash-close:hover { opacity: 1; }
    </style>
</head>
<body>

    <!-- ═══ NAVBAR ═══ -->
    <nav class="navbar" role="navigation" aria-label="Navigasi utama">
        <div class="navbar-inner">

            <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
                <span class="brand-name">Rent-Drive</span>
            </a>

            <div class="nav-divider"></div>

            <div class="nav-links" id="navLinks">
                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('mobil.index') }}"
                   class="nav-link {{ request()->routeIs('mobil.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h11a2 2 0 012 2v3"/><rect x="9" y="11" width="14" height="10" rx="2"/><circle cx="12" cy="21" r="1"/><circle cx="20" cy="21" r="1"/></svg>
                    Katalog Mobil
                </a>
                <a href="{{ route('pelanggan.index') }}"
                   class="nav-link {{ request()->routeIs('pelanggan.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                    Pelanggan
                </a>
                <a href="{{ route('penyewaan.index') }}"
                   class="nav-link {{ request()->routeIs('penyewaan.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Transaksi
                    @if(isset($sewa_pending) && $sewa_pending > 0)
                        <span class="nav-badge">{{ $sewa_pending }}</span>
                    @endif
                </a>
            </div>

            @if(session()->has('admin_id'))
            <div class="navbar-right">
                <div class="admin-chip">
                    <div class="admin-avatar">
                        {{ strtoupper(substr(session('admin_nama', 'A'), 0, 2)) }}
                    </div>
                    <div class="admin-info">
                        <span class="admin-label">Admin</span>
                        <span class="admin-name">{{ session('admin_nama') }}</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        Keluar
                    </button>
                </form>
            </div>
            @endif

            <!-- mobile toggle -->
            <button class="nav-toggle" id="navToggle" aria-label="Buka menu" aria-expanded="false">
                <svg class="icon-menu" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                <svg class="icon-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>

        </div>

        <!-- mobile user row -->
        @if(session()->has('admin_id'))
        <div class="mobile-user-row" id="mobileUserRow" style="display:none;">
            <div class="admin-chip">
                <div class="admin-avatar">{{ strtoupper(substr(session('admin_nama', 'A'), 0, 2)) }}</div>
                <div class="admin-info">
                    <span class="admin-label">Admin</span>
                    <span class="admin-name">{{ session('admin_nama') }}</span>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Keluar
                </button>
            </form>
        </div>
        @endif
    </nav>

    <!-- ═══ FLASH MESSAGES ═══ -->
    <div class="flash-zone">
        @if(session('success'))
        <div class="flash flash-success" role="alert" id="flash-s">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
            <button class="flash-close" onclick="this.parentElement.remove()" aria-label="Tutup">&times;</button>
        </div>
        @endif
        @if(session('error'))
        <div class="flash flash-error" role="alert" id="flash-e">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
            <button class="flash-close" onclick="this.parentElement.remove()" aria-label="Tutup">&times;</button>
        </div>
        @endif
    </div>

    <!-- ═══ PAGE CONTENT ═══ -->
    <main class="page-body">
        @yield('content')
    </main>

    <script>
        /* ── mobile nav toggle ── */
        const toggle   = document.getElementById('navToggle');
        const navLinks = document.getElementById('navLinks');
        const userRow  = document.getElementById('mobileUserRow');
        const iconMenu = toggle?.querySelector('.icon-menu');
        const iconClose= toggle?.querySelector('.icon-close');

        toggle?.addEventListener('click', () => {
            const open = navLinks.classList.toggle('open');
            toggle.setAttribute('aria-expanded', open);
            if (iconMenu)  iconMenu.style.display  = open ? 'none' : '';
            if (iconClose) iconClose.style.display = open ? ''     : 'none';
            if (userRow)   userRow.style.display   = open ? 'flex' : 'none';
        });

        /* ── auto-dismiss flash after 5s ── */
        ['flash-s', 'flash-e'].forEach(id => {
            const el = document.getElementById(id);
            if (el) setTimeout(() => el.style.transition = 'opacity 0.4s', 100),
                    setTimeout(() => { el.style.opacity = '0'; setTimeout(() => el.remove(), 400); }, 5000);
        });
    </script>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin — Rent Drive</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue-deep:   #0f2d5e;
            --blue-mid:    #1a4080;
            --blue-accent: #2563eb;
            --blue-soft:   #dbeafe;
            --ink:         #0d1b2a;
            --ink-muted:   #5a6e85;
            --line:        #dde3ed;
            --bg:          #f7f9fc;
        }

        html, body { height: 100%; }

        body {
            font-family: 'Sora', sans-serif;
            font-weight: 400;
            background: var(--bg);
            color: var(--ink);
            display: flex;
            min-height: 100vh;
        }

        /* ─── LEFT PANEL ─── */
        .panel-left {
            display: none;
            width: 44%;
            flex-shrink: 0;
            background: var(--ink); /* Dibedakan sedikit lebih gelap untuk Admin */
            position: relative;
            overflow: hidden;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem 3.5rem;
        }

        @media (min-width: 960px) { .panel-left { display: flex; } }

        .panel-left::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255,255,255,0.06) 1.7px, transparent 1.5px);
            background-size: 28px 28px;
            pointer-events: none;
        }

        .panel-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            position: relative;
            z-index: 1;
        }
        .panel-logo-name {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.9);
        }

        .panel-body { position: relative; z-index: 1; }
        .panel-heading {
            font-size: clamp(2rem, 3.2vw, 2.8rem);
            font-weight: 300;
            line-height: 1.2;
            color: #fff;
            margin-bottom: 1.25rem;
        }
        .panel-heading strong {
            font-weight: 600;
            display: block;
            color: var(--blue-accent);
        }
        .panel-desc {
            font-size: 14px;
            line-height: 1.75;
            color: rgba(255,255,255,0.45);
            max-width: 300px;
        }

        .panel-footer {
            font-size: 11px;
            letter-spacing: 0.12em;
            color: rgba(255,255,255,0.25);
            text-transform: uppercase;
            position: relative;
            z-index: 1;
        }

        /* ─── RIGHT PANEL ─── */
        .panel-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2.5rem 2rem;
            background: #fff;
        }

        .form-shell { width: 100%; max-width: 380px; }

        .mobile-logo { display: flex; align-items: center; gap: 10px; margin-bottom: 2.5rem; }
        @media (min-width: 960px) { .mobile-logo { display: none; } }
        .mobile-logo-mark {
            width: 26px; height: 26px;
            background: var(--ink);
            display: flex; align-items: center; justify-content: center;
        }
        .mobile-logo-mark svg { width: 13px; height: 13px; color: #fff; }
        .mobile-logo-name {
            font-size: 13px; font-weight: 600; letter-spacing: 0.18em;
            text-transform: uppercase; color: var(--ink);
        }

        .form-heading { font-size: 1.6rem; font-weight: 600; color: var(--ink); margin-bottom: 6px; }
        .form-sub { font-size: 13.5px; color: var(--ink-muted); margin-bottom: 2.5rem; }

        /* ─── ALERT ─── */
        .alert { padding: 12px 16px; font-size: 13px; margin-bottom: 1.5rem; border-left: 3px solid; }
        .alert-success { background: #eff6ff; border-color: var(--blue-accent); color: var(--blue-mid); }
        .alert-error   { background: #fef2f2; border-color: #ef4444; color: #7f1d1d; }
        .alert ul { padding-left: 1rem; }
        .alert li { margin-top: 2px; }

        /* ─── FORM ELEMENTS ─── */
        .field { margin-bottom: 1.75rem; }
        .field label {
            display: block; font-size: 11px; font-weight: 500;
            letter-spacing: 0.16em; text-transform: uppercase;
            color: var(--ink-muted); margin-bottom: 8px;
        }
        .field input {
            display: block; width: 100%; background: transparent;
            border: none; border-bottom: 1.5px solid var(--line);
            padding: 10px 0; font-family: 'Sora', sans-serif;
            font-size: 14.5px; font-weight: 400; color: var(--ink);
            outline: none; transition: border-color 0.2s;
        }
        .field input::placeholder { color: #b0bcc9; }
        .field input:focus { border-bottom-color: var(--blue-accent); }

        /* ─── PASSWORD WRAPPER ─── */
        .password-wrap { position: relative; }
        .toggle-pw {
            position: absolute; right: 0; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; color: var(--ink-muted);
            padding: 4px; display: flex; transition: color 0.2s;
        }
        .toggle-pw:hover { color: var(--blue-accent); }
        .toggle-pw svg { width: 17px; height: 17px; }

        /* ─── SUBMIT ─── */
        .btn-submit {
            width: 100%; background: var(--ink); color: #fff;
            border: none; padding: 14px 0; font-family: 'Sora', sans-serif;
            font-size: 13px; font-weight: 500; letter-spacing: 0.12em;
            text-transform: uppercase; cursor: pointer; margin-top: 0.5rem;
            transition: background 0.2s, transform 0.1s;
        }
        .btn-submit:hover { background: #000; }
        .btn-submit:active { transform: scale(0.99); }

        /* ─── FOOTER LINK ─── */
        .form-footer {
            margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--line);
            font-size: 13px; color: var(--ink-muted); text-align: center;
        }
        .form-footer a {
            color: var(--blue-accent); text-decoration: none; font-weight: 500; transition: color 0.2s;
        }
        .form-footer a:hover { color: var(--blue-deep); text-decoration: underline; }
    </style>
</head>
<body>

    <aside class="panel-left">
        <div class="panel-logo">
            <span class="panel-logo-name">Admin Rent-Drive</span>
        </div>

        <div class="panel-body">
            <h1 class="panel-heading">
                Pusat
                <strong>Administrasi</strong>
            </h1>
            <p class="panel-desc">
                Kelola armada kendaraan, pantau transaksi pelanggan, dan operasional pelanggan
            </p>
        </div>

        <span class="panel-footer">Admin Rent-Drive &copy; {{ date('Y') }}</span>
    </aside>

    <main class="panel-right">
        <div class="form-shell">

            <div class="mobile-logo">
                <div class="mobile-logo-mark">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h11a2 2 0 012 2v3"/><rect x="9" y="11" width="14" height="10" rx="2"/></svg>
                </div>
                <span class="mobile-logo-name">Rent Drive Admin</span>
            </div>

            <h2 class="form-heading">Otentikasi</h2>
            <p class="form-sub">Masuk dengan kredensial administrator Anda</p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="field">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Masukkan username" required autofocus>
                </div>

                <div class="field">
                    <label for="password">Kata Sandi</label>
                    <div class="password-wrap">
                        <input type="password" id="password" name="password" placeholder="••••••••" required style="padding-right: 2rem;">
                        <button type="button" class="toggle-pw" id="togglePw" aria-label="Tampilkan kata sandi">
                            <svg id="iconEye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg id="iconEyeOff" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Akses Panel</button>
            </form>

            <div class="form-footer">
                Bukan administrator?
                <a href="{{ route('login') }}">Kembali ke portal pelanggan</a>
            </div>

        </div>
    </main>

    <script>
        const toggle = document.getElementById('togglePw');
        const pwInput = document.getElementById('password');
        const iconEye = document.getElementById('iconEye');
        const iconOff = document.getElementById('iconEyeOff');

        toggle.addEventListener('click', () => {
            const isHidden = pwInput.type === 'password';
            pwInput.type = isHidden ? 'text' : 'password';
            iconEye.style.display = isHidden ? 'none' : '';
            iconOff.style.display = isHidden ? '' : 'none';
        });
    </script>

</body>
</html>
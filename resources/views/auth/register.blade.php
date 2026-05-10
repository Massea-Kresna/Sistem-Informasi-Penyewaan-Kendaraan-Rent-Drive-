<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar — Rent Drive</title>

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
            --blue-soft:   #eff6ff;
            --ink:         #0d1b2a;
            --ink-muted:   #5a6e85;
            --line:        #dde3ed;
            --bg:          #f0f4fa;
        }

        html { height: 100%; }

        body {
            font-family: 'Sora', sans-serif;
            font-weight: 400;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 2.5rem 1rem 3rem;
        }

        /* ─── TOP BAR ─── */
        .topbar {
            width: 100%;
            max-width: 680px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }
        .topbar-logo {
            display: flex;
            align-items: center;
            gap: 9px;
            text-decoration: none;
        }
        .topbar-mark {
            width: 28px; height: 28px;
            background: var(--blue-deep);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .topbar-mark svg { width: 13px; height: 13px; color: #fff; }
        .topbar-name {
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: var(--ink);
        }
        .topbar-link {
            font-size: 12.5px;
            color: var(--ink-muted);
            text-decoration: none;
            transition: color 0.2s;
        }
        .topbar-link span { color: var(--blue-accent); font-weight: 500; }
        .topbar-link:hover span { text-decoration: underline; }

        /* ─── CARD ─── */
        .card {
            width: 100%;
            max-width: 680px;
            background: #fff;
            border: 1px solid var(--line);
        }

        .card-header {
            padding: 2rem 2.5rem 1.75rem;
            border-bottom: 1px solid var(--line);
        }
        .card-header h1 {
            font-size: 1.45rem;
            font-weight: 600;
            color: var(--ink);
            margin-bottom: 4px;
        }
        .card-header p {
            font-size: 13.5px;
            color: var(--ink-muted);
        }

        .card-body { padding: 0 2.5rem 2.5rem; }

        /* ─── ALERT ─── */
        .alert {
            padding: 12px 16px;
            font-size: 13px;
            border-left: 3px solid;
            margin: 1.5rem 0 0;
        }
        .alert-error { background: #fef2f2; border-color: #ef4444; color: #7f1d1d; }
        .alert ul { padding-left: 1rem; }
        .alert li { margin-top: 2px; }

        /* ─── SECTION DIVIDER ─── */
        .section-head {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 1.75rem 0 1.25rem;
        }
        .section-num {
            width: 22px; height: 22px;
            background: var(--blue-deep);
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .section-title {
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--ink-muted);
        }
        .section-line {
            flex: 1;
            height: 1px;
            background: var(--line);
        }

        /* ─── FIELDS ─── */
        .field-group {
            display: grid;
            gap: 0 1.75rem;
        }
        .field-group.cols-2 { grid-template-columns: 1fr 1fr; }
        @media (max-width: 560px) { .field-group.cols-2 { grid-template-columns: 1fr; } }

        .field { margin-bottom: 1.5rem; }

        .field label {
            display: block;
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--ink-muted);
            margin-bottom: 7px;
        }
        .field label .optional {
            font-weight: 400;
            letter-spacing: 0;
            text-transform: none;
            color: #a0aec0;
            font-size: 11px;
            margin-left: 4px;
        }

        .field input,
        .field select,
        .field textarea {
            display: block;
            width: 100%;
            background: transparent;
            border: none;
            border-bottom: 1.5px solid var(--line);
            padding: 9px 0;
            font-family: 'Sora', sans-serif;
            font-size: 14px;
            font-weight: 400;
            color: var(--ink);
            outline: none;
            transition: border-color 0.2s;
            -webkit-appearance: none;
            appearance: none;
            resize: none;
        }
        .field input::placeholder,
        .field textarea::placeholder { color: #b0bcc9; }
        .field input:focus,
        .field select:focus,
        .field textarea:focus { border-bottom-color: var(--blue-accent); }

        /* select arrow */
        .select-wrap { position: relative; }
        .select-wrap::after {
            content: '';
            position: absolute;
            right: 4px;
            top: 50%;
            transform: translateY(-50%);
            width: 0; height: 0;
            border-left: 4px solid transparent;
            border-right: 4px solid transparent;
            border-top: 5px solid var(--ink-muted);
            pointer-events: none;
        }

        /* file input */
        .file-input-wrap { position: relative; }
        .file-input-label {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 0;
            border-bottom: 1.5px solid var(--line);
            cursor: pointer;
            transition: border-color 0.2s;
        }
        .file-input-label:focus-within { border-bottom-color: var(--blue-accent); }
        .file-input-label svg { width: 16px; height: 16px; color: var(--ink-muted); flex-shrink: 0; }
        .file-input-label .file-text { font-size: 14px; color: #b0bcc9; }
        .file-input-label .file-text.has-file { color: var(--ink); }
        .file-input-label input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            padding: 0;
            border: none;
        }

        /* password wrapper */
        .pw-wrap { position: relative; }
        .toggle-pw {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--ink-muted);
            padding: 4px;
            display: flex;
            transition: color 0.2s;
        }
        .toggle-pw:hover { color: var(--blue-accent); }
        .toggle-pw svg { width: 16px; height: 16px; }

        /* ─── PASSWORD STRENGTH ─── */
        .pw-strength { margin-top: 6px; display: flex; gap: 4px; }
        .pw-bar {
            flex: 1; height: 2px;
            background: var(--line);
            transition: background 0.3s;
        }
        .pw-bar.active-weak   { background: #ef4444; }
        .pw-bar.active-fair   { background: #f59e0b; }
        .pw-bar.active-good   { background: #3b82f6; }
        .pw-bar.active-strong { background: #22c55e; }

        /* ─── SUBMIT ─── */
        .form-actions {
            margin-top: 0.5rem;
            padding-top: 2rem;
            border-top: 1px solid var(--line);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .form-note { font-size: 12.5px; color: var(--ink-muted); line-height: 1.6; }

        .btn-submit {
            background: var(--blue-deep);
            color: #fff;
            border: none;
            padding: 13px 36px;
            font-family: 'Sora', sans-serif;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            cursor: pointer;
            white-space: nowrap;
            transition: background 0.2s, transform 0.1s;
        }
        .btn-submit:hover { background: var(--blue-mid); }
        .btn-submit:active { transform: scale(0.99); }
    </style>
</head>
<body>

    <!-- TOP BAR -->
    <div class="topbar">
        <a href="{{ url('/') }}" class="topbar-logo">
            <span class="topbar-name">Rent-Drive</span>
        </a>
        <a href="{{ route('login') }}" class="topbar-link">
            Sudah punya akun? <span>Masuk</span>
        </a>
    </div>

    <!-- CARD -->
    <div class="card">

        <div class="card-header">
            <h1>Buat Akun Baru</h1>
            <p>Lengkapi data di bawah untuk mendaftar sebagai pelanggan Rent-Drive</p>
        </div>

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}" enctype="multipart/form-data">
                @csrf

                <!-- ── SECTION 1: Akun ── -->
                <div class="section-head">
                    <span class="section-num">1</span>
                    <span class="section-title">Informasi Akun</span>
                    <span class="section-line"></span>
                </div>

                <div class="field">
                    <label for="email">Alamat Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@email.com"
                        required
                        autofocus
                    >
                </div>

                <div class="field-group cols-2">
                    <div class="field">
                        <label for="password">Kata Sandi</label>
                        <div class="pw-wrap">
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Min. 8 karakter"
                                required
                                style="padding-right: 2rem;"
                                id="pwField"
                            >
                            <button type="button" class="toggle-pw" data-target="password" aria-label="Tampilkan kata sandi">
                                <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="icon-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                        <div class="pw-strength">
                            <div class="pw-bar" id="bar1"></div>
                            <div class="pw-bar" id="bar2"></div>
                            <div class="pw-bar" id="bar3"></div>
                            <div class="pw-bar" id="bar4"></div>
                        </div>
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Konfirmasi Sandi</label>
                        <div class="pw-wrap">
                            <input
                                type="password"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Ulangi kata sandi"
                                required
                                style="padding-right: 2rem;"
                            >
                            <button type="button" class="toggle-pw" data-target="password_confirmation" aria-label="Tampilkan konfirmasi sandi">
                                <svg class="icon-eye" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="icon-off" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="display:none"><path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ── SECTION 2: Data Diri ── -->
                <div class="section-head">
                    <span class="section-num">2</span>
                    <span class="section-title">Data Diri</span>
                    <span class="section-line"></span>
                </div>

                <div class="field-group cols-2">
                    <div class="field">
                        <label for="nama">Nama Lengkap</label>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            value="{{ old('nama') }}"
                            placeholder="Sesuai KTP"
                            required
                        >
                    </div>
                    <div class="field">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input
                            type="date"
                            id="tanggal_lahir"
                            name="tanggal_lahir"
                            value="{{ old('tanggal_lahir') }}"
                            max="{{ date('Y-m-d') }}"
                            required
                        >
                    </div>
                </div>

                <div class="field-group cols-2">
                    <div class="field">
                        <label for="no_ktp">Nomor KTP</label>
                        <input
                            type="text"
                            id="no_ktp"
                            name="no_ktp"
                            value="{{ old('no_ktp') }}"
                            placeholder="NIK"
                            maxlength="16"
                            required
                        >
                    </div>
                    <div class="field">
                        <label for="no_hp">Nomor HP</label>
                        <input
                            type="tel"
                            id="no_hp"
                            name="no_hp"
                            value="{{ old('no_hp') }}"
                            placeholder="08xxxxxxxxxx"
                            required
                        >
                    </div>
                </div>

                <div class="field">
                    <label for="alamat">Alamat Domisili</label>
                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="2"
                        placeholder="Jl. Nama Jalan, No. x, Kota"
                        required
                    >{{ old('alamat') }}</textarea>
                </div>

                <div class="field">
                    <label>
                        Foto KTP
                        <span class="optional">— opsional, maks. 2 MB</span>
                    </label>
                    <div class="file-input-wrap">
                        <label class="file-input-label" id="fileLabel">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                            <span class="file-text" id="fileText">Pilih file gambar…</span>
                            <input
                                type="file"
                                name="foto_ktp"
                                accept="image/jpeg,image/png"
                                id="fileInput"
                            >
                        </label>
                    </div>
                </div>

                <!-- ── ACTIONS ── -->
                <div class="form-actions">
                    <p class="form-note">
                        Dengan mendaftar, Anda menyetujui<br>syarat &amp; ketentuan layanan kami.
                    </p>
                    <button type="submit" class="btn-submit">Buat Akun</button>
                </div>

            </form>
        </div>
    </div>

    <script>
        /* toggle password visibility */
        document.querySelectorAll('.toggle-pw').forEach(btn => {
            btn.addEventListener('click', () => {
                const input = document.getElementById(btn.dataset.target);
                const isHidden = input.type === 'password';
                input.type = isHidden ? 'text' : 'password';
                btn.querySelector('.icon-eye').style.display = isHidden ? 'none' : '';
                btn.querySelector('.icon-off').style.display = isHidden ? '' : 'none';
            });
        });

        /* password strength meter */
        const pwInput = document.getElementById('password');
        const bars = [
            document.getElementById('bar1'),
            document.getElementById('bar2'),
            document.getElementById('bar3'),
            document.getElementById('bar4'),
        ];
        const classes = ['active-weak', 'active-fair', 'active-good', 'active-strong'];

        function getStrength(val) {
            let score = 0;
            if (val.length >= 8)  score++;
            if (/[A-Z]/.test(val)) score++;
            if (/[0-9]/.test(val)) score++;
            if (/[^A-Za-z0-9]/.test(val)) score++;
            return score;
        }

        pwInput.addEventListener('input', () => {
            const s = getStrength(pwInput.value);
            bars.forEach((bar, i) => {
                bar.className = 'pw-bar';
                if (i < s) bar.classList.add(classes[s - 1]);
            });
        });

        /* file input label */
        const fileInput = document.getElementById('fileInput');
        const fileText  = document.getElementById('fileText');
        fileInput.addEventListener('change', () => {
            if (fileInput.files.length) {
                fileText.textContent = fileInput.files[0].name;
                fileText.classList.add('has-file');
            } else {
                fileText.textContent = 'Pilih file gambar…';
                fileText.classList.remove('has-file');
            }
        });
    </script>

</body>
</html>
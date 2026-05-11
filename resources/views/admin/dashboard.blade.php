@extends('layout')

@section('content')

<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
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

    .dash {
        font-family: 'Sora', sans-serif;
        color: var(--ink);
        background: var(--bg);
        min-height: 100vh;
        padding: 2rem 2.5rem 3rem;
    }

    /* ── TOP BAR ── */
    .dash-topbar {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 2.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .dash-greeting-tag {
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: var(--blue-accent);
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .dash-greeting-tag::before {
        content: '';
        display: inline-block;
        width: 24px; height: 1.5px;
        background: var(--blue-accent);
    }
    .dash-title {
        font-size: 1.7rem;
        font-weight: 600;
        color: var(--ink);
        line-height: 1.2;
    }
    .dash-title span { font-weight: 300; color: var(--ink-muted); }

    .dash-meta {
        text-align: right;
    }
    .dash-date {
        font-size: 12px;
        color: var(--ink-muted);
        margin-bottom: 4px;
    }
    .dash-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 500;
        color: var(--green);
        letter-spacing: 0.08em;
    }
    .status-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
        background: var(--green);
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(22,163,74,0.4); }
        50%       { box-shadow: 0 0 0 5px rgba(22,163,74,0); }
    }

    /* ── STAT CARDS ── */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1px;
        background: var(--line);
        border: 1px solid var(--line);
        margin-bottom: 2rem;
    }
    @media (max-width: 900px) { .stat-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 520px) { .stat-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: var(--white);
        padding: 1.75rem 1.75rem 1.5rem;
        position: relative;
        overflow: hidden;
        transition: background 0.2s;
    }
    .stat-card:hover { background: #fafcff; }

    .stat-card::before {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 2px;
        background: transparent;
        transition: background 0.25s;
    }
    .stat-card:hover::before { background: var(--blue-accent); }

    .stat-icon-wrap {
        width: 36px; height: 36px;
        border: 1px solid var(--line);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.25rem;
    }
    .stat-icon-wrap svg { width: 17px; height: 17px; }
    .stat-icon-wrap.blue   { border-color: rgba(37,99,235,0.25); color: var(--blue-accent); background: var(--blue-soft); }
    .stat-icon-wrap.green  { border-color: rgba(22,163,74,0.25); color: var(--green);        background: var(--green-soft); }
    .stat-icon-wrap.amber  { border-color: rgba(217,119,6,0.25);  color: var(--amber);        background: var(--amber-soft); }
    .stat-icon-wrap.purple { border-color: rgba(124,58,237,0.25); color: #7c3aed;             background: #f5f3ff; }

    .stat-label {
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--ink-muted);
        margin-bottom: 0.5rem;
    }
    .stat-value {
        font-size: 2rem;
        font-weight: 600;
        color: var(--ink);
        line-height: 1;
        margin-bottom: 0.6rem;
        letter-spacing: -0.02em;
    }
    .stat-value.count-up { opacity: 0; transform: translateY(8px); transition: opacity 0.5s, transform 0.5s; }
    .stat-value.count-up.visible { opacity: 1; transform: none; }

    .stat-sub {
        font-size: 12px;
        color: #8b9eb3;
        line-height: 1.5;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .badge-green  { display: inline-block; padding: 1px 7px; background: var(--green-soft);  color: var(--green); font-size: 10px; font-weight: 600; letter-spacing: 0.06em; }
    .badge-amber  { display: inline-block; padding: 1px 7px; background: var(--amber-soft);  color: var(--amber); font-size: 10px; font-weight: 600; letter-spacing: 0.06em; }
    .badge-red    { display: inline-block; padding: 1px 7px; background: var(--red-soft);    color: var(--red);   font-size: 10px; font-weight: 600; letter-spacing: 0.06em; }
    .badge-blue   { display: inline-block; padding: 1px 7px; background: var(--blue-soft);   color: var(--blue-accent); font-size: 10px; font-weight: 600; letter-spacing: 0.06em; }

    /* ── MAIN CONTENT GRID ── */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 1.5rem;
        align-items: start;
    }
    @media (max-width: 1024px) { .content-grid { grid-template-columns: 1fr; } }

    /* ── PANEL GENERIC ── */
    .panel {
        background: var(--white);
        border: 1px solid var(--line);
    }
    .panel-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--line);
    }
    .panel-title {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--ink);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .panel-title::before {
        content: '';
        width: 3px; height: 14px;
        background: var(--blue-deep);
        display: inline-block;
    }
    .panel-link {
        font-size: 11px;
        font-weight: 500;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--blue-accent);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: color 0.2s;
    }
    .panel-link:hover { color: var(--blue-deep); }
    .panel-link svg { width: 12px; height: 12px; }

    /* ── TABLE ── */
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th {
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: var(--ink-muted);
        padding: 10px 1.5rem;
        text-align: left;
        border-bottom: 1px solid var(--line);
        background: #fafbfd;
        white-space: nowrap;
    }
    .data-table td {
        padding: 13px 1.5rem;
        font-size: 13px;
        border-bottom: 1px solid var(--line);
        vertical-align: middle;
        color: var(--ink);
    }
    .data-table tr:last-child td { border-bottom: none; }
    .data-table tbody tr { transition: background 0.15s; }
    .data-table tbody tr:hover { background: #fafcff; }

    .td-name { font-weight: 500; }
    .td-muted { color: var(--ink-muted); font-size: 12px; }

    .status-pill {
        display: inline-block;
        padding: 3px 10px;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }
    .pill-green  { background: var(--green-soft);  color: var(--green); }
    .pill-amber  { background: var(--amber-soft);  color: var(--amber); }
    .pill-red    { background: var(--red-soft);    color: var(--red); }
    .pill-blue   { background: var(--blue-soft);   color: var(--blue-accent); }
    .pill-gray   { background: #f1f5f9; color: #64748b; }

    /* ── EMPTY STATE ── */
    .empty-state {
        padding: 3rem 1.5rem;
        text-align: center;
    }
    .empty-state svg { width: 36px; height: 36px; color: #c7d2de; margin: 0 auto 1rem; }
    .empty-state p { font-size: 13px; color: var(--ink-muted); }

    /* ── ACTION PANEL (right) ── */
    .action-panel { display: flex; flex-direction: column; gap: 1.5rem; }

    .nav-card { background: var(--white); border: 1px solid var(--line); overflow: hidden; }
    .nav-card-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--line);
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--ink-muted);
    }
    .nav-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--line);
        text-decoration: none;
        color: var(--ink);
        font-size: 13.5px;
        font-weight: 400;
        transition: background 0.15s, padding-left 0.2s;
        position: relative;
    }
    .nav-item:last-child { border-bottom: none; }
    .nav-item:hover { background: var(--blue-soft); padding-left: 1.5rem; color: var(--blue-deep); }
    .nav-item:hover .nav-item-icon { border-color: rgba(37,99,235,0.3); background: rgba(37,99,235,0.08); color: var(--blue-accent); }
    .nav-item:hover .nav-arrow { opacity: 1; transform: translateX(0); }
    .nav-item-icon {
        width: 34px; height: 34px;
        border: 1px solid var(--line);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.2s;
    }
    .nav-item-icon svg { width: 15px; height: 15px; }
    .nav-item-body { flex: 1; }
    .nav-item-label { font-weight: 500; display: block; }
    .nav-item-sub   { font-size: 11px; color: var(--ink-muted); display: block; margin-top: 1px; }
    .nav-arrow {
        opacity: 0;
        transform: translateX(-4px);
        transition: all 0.2s;
        color: var(--blue-accent);
    }
    .nav-arrow svg { width: 14px; height: 14px; }

    /* ── ACTIVITY FEED ── */
    .activity-list { padding: 0 1.25rem; }
    .activity-item {
        display: flex;
        gap: 12px;
        padding: 12px 0;
        border-bottom: 1px solid var(--line);
        font-size: 12.5px;
    }
    .activity-item:last-child { border-bottom: none; }
    .activity-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
        margin-top: 5px;
    }
    .activity-dot.blue   { background: var(--blue-accent); }
    .activity-dot.green  { background: var(--green); }
    .activity-dot.amber  { background: var(--amber); }
    .activity-dot.red    { background: var(--red); }
    .activity-text { color: var(--ink); line-height: 1.5; }
    .activity-time { font-size: 11px; color: #a0aec0; margin-top: 2px; }

    /* ── DONUT MINI CHART ── */
    .mini-chart-wrap {
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }
    .donut-svg { flex-shrink: 0; }
    .donut-legend { flex: 1; }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        margin-bottom: 8px;
        color: var(--ink);
    }
    .legend-item:last-child { margin-bottom: 0; }
    .legend-dot { width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0; }
    .legend-val { margin-left: auto; font-weight: 600; font-size: 12px; }

    /* ── ANIMATIONS ── */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .stat-card   { animation: fadeSlideUp 0.5s both; }
    .stat-card:nth-child(1) { animation-delay: 0.05s; }
    .stat-card:nth-child(2) { animation-delay: 0.12s; }
    .stat-card:nth-child(3) { animation-delay: 0.19s; }
    .stat-card:nth-child(4) { animation-delay: 0.26s; }
    .panel       { animation: fadeSlideUp 0.5s 0.3s both; }
    .action-panel{ animation: fadeSlideUp 0.5s 0.35s both; }
</style>

<div class="dash">

    {{-- ── TOP BAR ── --}}
    <div class="dash-topbar">
        <div>
            <p class="dash-greeting-tag">Panel Admin</p>
            <h1 class="dash-title">
                Halo, <span>{{ session('admin_nama') }}</span>
            </h1>
        </div>
        <div class="dash-meta">
            <p class="dash-date" id="live-date">—</p>
            <span class="dash-status">
                <span class="status-dot"></span>
                Sistem Aktif
            </span>
        </div>
    </div>

    {{-- ── STAT CARDS ── --}}
    <div class="stat-grid">

        <div class="stat-card">
            <div class="stat-icon-wrap blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h11a2 2 0 012 2v3"/><rect x="9" y="11" width="14" height="10" rx="2"/><circle cx="12" cy="21" r="1"/><circle cx="20" cy="21" r="1"/></svg>
            </div>
            <div class="stat-label">Total Armada</div>
            <div class="stat-value" data-target="{{ $stats['total_mobil'] }}">0</div>
            <div class="stat-sub">
                <span class="badge-green">{{ $stats['mobil_tersedia'] }} tersedia</span>
                <span class="badge-amber">{{ $stats['mobil_disewa'] }} disewa</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrap green">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
            </div>
            <div class="stat-label">Total Pelanggan</div>
            <div class="stat-value" data-target="{{ $stats['total_pelanggan'] }}">0</div>
            <div class="stat-sub">
                <span class="badge-blue">Akun terdaftar</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrap amber">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div class="stat-label">Penyewaan Aktif</div>
            <div class="stat-value" data-target="{{ $stats['sewa_aktif'] }}">0</div>
            <div class="stat-sub">
                <span class="badge-amber">{{ $stats['sewa_pending'] }} menunggu bayar</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-wrap purple">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
            </div>
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-value" id="revenue-val" style="font-size: 1.4rem;">
                Rp {{ number_format($stats['pendapatan'], 0, ',', '.') }}
            </div>
            <div class="stat-sub">
                <span class="badge-green">Pembayaran berhasil</span>
            </div>
        </div>

    </div>

    {{-- ── MAIN GRID ── --}}
    <div class="content-grid">

        {{-- LEFT: Tabel penyewaan terkini --}}
        <div>
            <div class="panel">
                <div class="panel-header">
                    <span class="panel-title">Penyewaan Terkini</span>
                    <a href="{{ route('penyewaan.index') }}" class="panel-link">
                        Lihat Semua
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                </div>

                @if(isset($penyewaan_terbaru) && $penyewaan_terbaru->count() > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Pelanggan</th>
                            <th>Kendaraan</th>
                            <th>Mulai</th>
                            <th>Selesai</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($penyewaan_terbaru as $item)
                        <tr>
                            <td>
                                <div class="td-name">{{ $item->pelanggan->nama ?? '—' }}</div>
                                <div class="td-muted">{{ $item->pelanggan->no_hp ?? '' }}</div>
                            </td>
                            <td>
                                <div class="td-name">{{ $item->mobil->nama ?? '—' }}</div>
                                <div class="td-muted">{{ $item->mobil->plat_nomor ?? '' }}</div>
                            </td>
                            <td class="td-muted">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</td>
                            <td class="td-muted">{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
                            <td>
                                @php
                                    $status = strtolower($item->status ?? '');
                                    $pillClass = match(true) {
                                        str_contains($status, 'aktif')    => 'pill-green',
                                        str_contains($status, 'pending')  => 'pill-amber',
                                        str_contains($status, 'selesai')  => 'pill-blue',
                                        str_contains($status, 'batal')    => 'pill-red',
                                        default                           => 'pill-gray',
                                    };
                                @endphp
                                <span class="status-pill {{ $pillClass }}">{{ $item->status }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="empty-state">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                    <p>Belum ada data penyewaan.</p>
                </div>
                @endif
            </div>

            {{-- Mini chart armada --}}
            <div class="panel" style="margin-top: 1.5rem;">
                <div class="panel-header">
                    <span class="panel-title">Komposisi Armada</span>
                </div>
                <div class="mini-chart-wrap">
                    <svg class="donut-svg" width="80" height="80" viewBox="0 0 80 80">
                        @php
                            $total    = max(1, $stats['total_mobil']);
                            $tersedia = $stats['mobil_tersedia'];
                            $disewa   = $stats['mobil_disewa'];
                            $lain     = $total - $tersedia - $disewa;
                            $r = 30; $cx = 40; $cy = 40;
                            $circ = 2 * M_PI * $r;
                            $pct1 = ($tersedia / $total);
                            $pct2 = ($disewa   / $total);
                            $pct3 = max(0, ($lain / $total));
                            $d1 = $pct1 * $circ;
                            $d2 = $pct2 * $circ;
                            $d3 = $pct3 * $circ;
                            $gap = 1.5;
                            $off0 = 0;
                            $off1 = $circ - $d1 + $gap;
                            $off2 = $circ - $d2 + $gap;
                            $off3 = $circ - $d3 + $gap;
                            $rot1 = -90;
                            $rot2 = -90 + ($pct1 * 360) + 2;
                            $rot3 = $rot2 + ($pct2 * 360) + 2;
                        @endphp
                        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="none" stroke="#e8edf4" stroke-width="10"/>
                        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="none" stroke="#16a34a" stroke-width="10"
                            stroke-dasharray="{{ $d1 }} {{ $circ }}"
                            stroke-dashoffset="{{ $circ * 0.25 }}"
                            transform="rotate({{ $rot1 }} {{ $cx }} {{ $cy }})"/>
                        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="none" stroke="#d97706" stroke-width="10"
                            stroke-dasharray="{{ $d2 }} {{ $circ }}"
                            stroke-dashoffset="{{ $circ * 0.25 }}"
                            transform="rotate({{ $rot2 }} {{ $cx }} {{ $cy }})"/>
                        @if($pct3 > 0)
                        <circle cx="{{ $cx }}" cy="{{ $cy }}" r="{{ $r }}" fill="none" stroke="#e2e8f0" stroke-width="10"
                            stroke-dasharray="{{ $d3 }} {{ $circ }}"
                            stroke-dashoffset="{{ $circ * 0.25 }}"
                            transform="rotate({{ $rot3 }} {{ $cx }} {{ $cy }})"/>
                        @endif
                        <text x="{{ $cx }}" y="{{ $cy - 4 }}" text-anchor="middle" font-family="Sora,sans-serif" font-size="14" font-weight="600" fill="#0d1b2a">{{ $total }}</text>
                        <text x="{{ $cx }}" y="{{ $cy + 12 }}" text-anchor="middle" font-family="Sora,sans-serif" font-size="8" fill="#5a6e85">UNIT</text>
                    </svg>
                    <div class="donut-legend">
                        <div class="legend-item">
                            <span class="legend-dot" style="background:#16a34a;"></span>
                            Tersedia
                            <span class="legend-val">{{ $stats['mobil_tersedia'] }}</span>
                        </div>
                        <div class="legend-item">
                            <span class="legend-dot" style="background:#d97706;"></span>
                            Disewa
                            <span class="legend-val">{{ $stats['mobil_disewa'] }}</span>
                        </div>
                        @if($lain > 0)
                        <div class="legend-item">
                            <span class="legend-dot" style="background:#cbd5e1;"></span>
                            Tidak Aktif
                            <span class="legend-val">{{ $lain }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Navigasi + aktivitas --}}
        <div class="action-panel">

            {{-- Menu navigasi --}}
            <div class="nav-card">
                <div class="nav-card-header">Menu Utama</div>

                <a href="{{ route('mobil.index') }}" class="nav-item">
                    <div class="nav-item-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h11a2 2 0 012 2v3"/><rect x="9" y="11" width="14" height="10" rx="2"/><circle cx="12" cy="21" r="1"/><circle cx="20" cy="21" r="1"/></svg>
                    </div>
                    <div class="nav-item-body">
                        <span class="nav-item-label">Data Mobil</span>
                        <span class="nav-item-sub">Kelola armada kendaraan</span>
                    </div>
                    <span class="nav-arrow"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg></span>
                </a>

                <a href="{{ route('pelanggan.index') }}" class="nav-item">
                    <div class="nav-item-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                    </div>
                    <div class="nav-item-body">
                        <span class="nav-item-label">Manajemen Pelanggan</span>
                        <span class="nav-item-sub">Data & verifikasi akun</span>
                    </div>
                    <span class="nav-arrow"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg></span>
                </a>

                <a href="{{ route('penyewaan.index') }}" class="nav-item">
                    <div class="nav-item-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <div class="nav-item-body">
                        <span class="nav-item-label">Pantau Penyewaan</span>
                        <span class="nav-item-sub">Transaksi & status sewa</span>
                    </div>
                    <span class="nav-arrow"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg></span>
                </a>
            </div>

            <!-- {{-- Aktivitas terkini --}}
            <div class="nav-card">
                <div class="nav-card-header">Aktivitas Terkini</div>
                <div class="activity-list">
                    @if(isset($penyewaan_terbaru) && $penyewaan_terbaru->count() > 0)
                        @foreach($penyewaan_terbaru->take(5) as $item)
                        @php
                            $dotColor = match(true) {
                                str_contains(strtolower($item->status ?? ''), 'aktif')   => 'green',
                                str_contains(strtolower($item->status ?? ''), 'pending') => 'amber',
                                str_contains(strtolower($item->status ?? ''), 'batal')   => 'red',
                                default => 'blue',
                            };
                        @endphp
                        <div class="activity-item">
                            <span class="activity-dot {{ $dotColor }}"></span>
                            <div>
                                <div class="activity-text">
                                    <strong>{{ $item->pelanggan->nama ?? 'Pelanggan' }}</strong>
                                    menyewa {{ $item->mobil->nama ?? 'kendaraan' }}
                                </div>
                                <div class="activity-time">
                                    {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                    &nbsp;·&nbsp;
                                    <span class="status-pill {{ match(true) { str_contains(strtolower($item->status ?? ''), 'aktif') => 'pill-green', str_contains(strtolower($item->status ?? ''), 'pending') => 'pill-amber', str_contains(strtolower($item->status ?? ''), 'batal') => 'pill-red', default => 'pill-blue' } }}" style="font-size:9px; padding:1px 6px;">
                                        {{ $item->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="activity-item">
                            <span class="activity-dot blue"></span>
                            <div>
                                <div class="activity-text">Belum ada aktivitas terkini.</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div> -->

        </div>
    </div>
</div>

<script>
    /* live date */
    (function() {
        const el = document.getElementById('live-date');
        const days = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        function update() {
            const d = new Date();
            el.textContent = `${days[d.getDay()]}, ${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
        }
        update();
    })();

    /* animated count-up for stat values */
    (function() {
        const targets = document.querySelectorAll('.stat-value[data-target]');
        const easeOut = t => 1 - Math.pow(1 - t, 3);
        const duration = 900;

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                const end = parseInt(el.dataset.target, 10);
                const start = performance.now();
                (function tick(now) {
                    const pct = Math.min((now - start) / duration, 1);
                    el.textContent = Math.round(easeOut(pct) * end);
                    if (pct < 1) requestAnimationFrame(tick);
                    else el.textContent = end;
                })(start);
                observer.unobserve(el);
            });
        }, { threshold: 0.3 });

        targets.forEach(el => observer.observe(el));
    })();
</script>

@endsection
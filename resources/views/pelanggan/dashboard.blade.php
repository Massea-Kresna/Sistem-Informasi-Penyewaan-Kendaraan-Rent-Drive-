@extends('pelanggan.layout')
@section('title', 'Dashboard Pelanggan')

@section('content')
<style>
    /* ─── VARIABEL TEMA SORA MINIMALIS ─── */
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
    }

    .user-dashboard {
        font-family: 'Sora', sans-serif;
        color: var(--ink);
        max-width: 1040px;
        margin: 0 auto;
        padding: 2rem 1.5rem;
    }

    /* ─── ANIMASI MUNCUL ─── */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-up { animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }

    /* ─── BANNER SELAMAT DATANG ─── */
    .welcome-banner {
        background: var(--white);
        border: 1px solid var(--line);
        border-left: 4px solid var(--blue-accent);
        padding: 2.5rem 3rem;
        margin-bottom: 2.5rem;
        position: relative;
        overflow: hidden;
    }
    .welcome-banner::after {
        content: ''; position: absolute; top: 0; right: 0; width: 150px; height: 100%;
        background: linear-gradient(90deg, transparent, var(--blue-soft)); opacity: 0.5;
    }
    .welcome-banner h3 {
        font-size: 1.65rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--ink); letter-spacing: -0.02em;
    }
    .welcome-banner p { font-size: 14px; color: var(--ink-muted); margin: 0; line-height: 1.6; }

    /* ─── STATISTIK GRID ─── */
    .stat-grid {
        display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;
    }
    .stat-card {
        background: var(--white); border: 1px solid var(--line); padding: 2.5rem;
        display: flex; flex-direction: column; justify-content: space-between;
        transition: transform 0.3s ease, border-color 0.3s ease, box-shadow 0.3s ease;
        position: relative; cursor: default;
    }
    /* Interaktivitas Hover pada Kartu */
    .stat-card:hover {
        transform: translateY(-4px);
        border-color: var(--blue-accent);
        box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.05);
    }
    
    .stat-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem; }
    .stat-label { font-size: 11px; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase; color: var(--ink-muted); }
    .stat-icon { width: 40px; height: 40px; background: var(--blue-soft); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--blue-accent); transition: transform 0.3s ease; }
    .stat-card:hover .stat-icon { transform: scale(1.1) rotate(5deg); }
    
    .stat-value { font-size: 3.5rem; font-weight: 300; color: var(--blue-deep); margin-bottom: 0.5rem; line-height: 1; display: flex; align-items: baseline; gap: 8px; }
    .stat-value span { font-size: 1rem; font-weight: 500; color: var(--ink-muted); letter-spacing: 0; }
    .stat-desc { font-size: 12.5px; color: var(--ink-muted); }

    /* ─── CALL TO ACTION (CTA) ─── */
    .cta-card {
        background: var(--blue-deep); border: 1px solid var(--blue-deep); padding: 3.5rem 2rem;
        text-align: center; color: var(--white); position: relative; overflow: hidden;
    }
    /* Pola background halus */
    .cta-card::before {
        content: ''; position: absolute; inset: 0; opacity: 0.1;
        background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;
    }
    .cta-content { position: relative; z-index: 1; }
    .cta-card h5 { font-size: 1.5rem; font-weight: 500; margin-bottom: 1rem; color: var(--white); }
    .cta-card p { font-size: 14px; color: rgba(255,255,255,0.7); margin-bottom: 2.5rem; max-width: 500px; margin-left: auto; margin-right: auto; line-height: 1.6; }
    
    /* Tombol Interaktif */
    .btn-primary-custom {
        display: inline-flex; align-items: center; justify-content: center; gap: 12px;
        background: var(--blue-accent); color: #fff; border: none; padding: 15px 36px;
        font-family: 'Sora', sans-serif; font-size: 13px; font-weight: 500; letter-spacing: 0.1em;
        text-transform: uppercase; text-decoration: none; transition: all 0.3s ease;
    }
    .btn-primary-custom:hover { background: #fff; color: var(--blue-accent); transform: translateY(-2px); box-shadow: 0 4px 15px rgba(37,99,235,0.3); }
    .btn-primary-custom:active { transform: translateY(0); }
    .btn-primary-custom svg { width: 16px; height: 16px; transition: transform 0.3s ease; }
    .btn-primary-custom:hover svg { transform: translateX(5px); }
</style>

<div class="user-dashboard">
    <div class="welcome-banner animate-up">
        <h3>Selamat datang, {{ session('pelanggan_nama') }}! 👋</h3>
        <p>Temukan dan sewa mobil impian Anda dengan mudah dan cepat</p>
    </div>

    <div class="stat-grid">
        <div class="stat-card animate-up delay-1">
            <div class="stat-header">
                <div class="stat-label">Armada Tersedia</div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20"><path d="M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h11a2 2 0 012 2v3"/><rect x="9" y="11" width="14" height="10" rx="2"/><circle cx="12" cy="21" r="1"/><circle cx="20" cy="21" r="1"/></svg>
                </div>
            </div>
            <div class="stat-value"><div class="counter" data-target="{{ $stats['mobil_tersedia'] }}">0</div><span>Unit</span></div>
            <div class="stat-desc">Kendaraan siap diluncurkan hari ini</div>
        </div>
        
        <div class="stat-card animate-up delay-2">
            <div class="stat-header">
                <div class="stat-label">Kapasitas Sistem</div>
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
            </div>
            <div class="stat-value"><div class="counter" data-target="{{ $stats['total_mobil'] }}">0</div><span>Unit</span></div>
            <div class="stat-desc">Total armada terdaftar di Rent-Drive</div>
        </div>
    </div>

    <div class="cta-card animate-up delay-3">
        <div class="cta-content">
            <h5>Siap memulai perjalanan Anda?</h5>
            <p>Lihat daftar mobil yang tersedia dan pilih yang sesuai dengan kebutuhan Anda</p>
            
            <a href="{{ route('pelanggan.mobil') }}" class="btn-primary-custom">
                Lihat Katalog Armada
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // Animasi Number Counter
        const counters = document.querySelectorAll('.counter');
        const speed = 200; // Semakin kecil semakin cepat

        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-target');
                const count = +counter.innerText;
                
                // Menentukan besaran langkah peningkatan
                const inc = target / speed;

                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 15);
                } else {
                    counter.innerText = target;
                }
            };

            // Sedikit delay agar animasi sinkron dengan fade-up
            setTimeout(updateCount, 400);
        });
    });
</script>
@endsection
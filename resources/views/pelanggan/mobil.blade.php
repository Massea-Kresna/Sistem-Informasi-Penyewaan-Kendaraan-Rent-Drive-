@extends('pelanggan.layout')
@section('title', 'Katalog Armada')

@section('content')
<style>
    .page-header { padding: 2rem 3rem; background: var(--white); border-bottom: 1px solid var(--line); }
    .page-title { font-size: 1.5rem; font-weight: 300; color: var(--ink); margin-bottom: 5px; }
    .page-title strong { font-weight: 600; }
    .page-desc { font-size: 13px; color: var(--ink-muted); }

    .catalog-wrapper { padding: 3rem; max-width: 1200px; margin: 0 auto; }
    .car-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 2rem; }

    .car-card {
        background: var(--white); border: 1px solid var(--line);
        display: flex; flex-direction: column; transition: transform 0.3s, box-shadow 0.3s;
    }
    .car-card:hover { transform: translateY(-4px); box-shadow: 0 10px 20px rgba(0,0,0,0.03); border-color: var(--blue-accent); }
    .car-card.disabled { opacity: 0.6; filter: grayscale(0.8); pointer-events: none; }

    .car-img-wrap { height: 200px; background: var(--bg); border-bottom: 1px solid var(--line); position: relative; }
    .car-img { width: 100%; height: 100%; object-fit: cover; }
    .car-badge {
        position: absolute; top: 15px; right: 15px; padding: 4px 10px; font-size: 9px;
        font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em;
    }
    .badge-available { background: var(--green-soft); color: var(--green); }
    .badge-unavailable { background: var(--red-soft); color: var(--red); }

    .car-info { padding: 1.5rem; flex: 1; display: flex; flex-direction: column; }
    .car-name { font-size: 1.2rem; font-weight: 600; color: var(--ink); margin-bottom: 4px; }
    .car-specs { font-size: 12px; color: var(--ink-muted); margin-bottom: 1rem; }
    
    .car-details { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 1rem; font-size: 12px; }
    .detail-item { background: var(--bg); padding: 8px; border: 1px solid var(--line); text-align: center; }
    .detail-item span { display: block; font-size: 9px; text-transform: uppercase; color: var(--ink-muted); letter-spacing: 0.05em; margin-bottom: 2px; }

    /* Gaya Baru untuk Deskripsi Tambahan */
    .car-desc {
        font-size: 11.5px;
        color: var(--ink-muted);
        line-height: 1.6;
        margin-bottom: 1.5rem;
        /* Membatasi teks maksimal 3 baris */
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .car-price { font-size: 1.25rem; font-weight: 600; color: var(--blue-deep); margin-bottom: 1.5rem; margin-top: auto; }
    .car-price small { font-size: 12px; font-weight: 400; color: var(--ink-muted); }

    .btn-rent {
        background: var(--ink); color: var(--white); text-align: center; padding: 12px;
        font-size: 11px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase;
        text-decoration: none; transition: background 0.2s; border: none; width: 100%;
    }
    .btn-rent:hover { background: var(--blue-deep); color: var(--white); }
    .btn-disabled { background: var(--line); color: var(--ink-muted); cursor: not-allowed; }
</style>

<div class="page-header">
    <h2 class="page-title">Katalog <strong>Armada</strong></h2>
    <p class="page-desc">Pilih unit kendaraan yang tersedia untuk perjalanan Anda selanjutnya.</p>
</div>

<div class="catalog-wrapper">
    @if(count($mobils) === 0)
        <div style="text-align: center; padding: 4rem; color: var(--ink-muted); border: 1px dashed var(--line);">
            Belum ada armada yang terdaftar di sistem.
        </div>
    @endif

    <div class="car-grid">
        @foreach($mobils as $m)
            @php $isAvailable = $m->status === 'tersedia'; @endphp
            <div class="car-card {{ !$isAvailable ? 'disabled' : '' }}">
                <div class="car-img-wrap">
                    @if($m->foto_mobil)
                        <img src="{{ asset('storage/' . $m->foto_mobil) }}" class="car-img" alt="{{ $m->nama_mobil }}" onerror="this.style.display='none'">
                    @else
                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size: 3rem; color: var(--line);">🚗</div>
                    @endif
                    <span class="car-badge {{ $isAvailable ? 'badge-available' : 'badge-unavailable' }}">
                        {{ $isAvailable ? 'Tersedia' : 'Disewa' }}
                    </span>
                </div>
                
                <div class="car-info">
                    <div class="car-name">{{ $m->nama_mobil }}</div>
                    <div class="car-specs">{{ $m->merek }} • {{ $m->tahun_pembuatan }} • {{ $m->warna }}</div>
                    
                    <div class="car-details">
                        <div class="detail-item"><span>Plat Nomor</span>{{ $m->plat_nomor }}</div>
                        <div class="detail-item"><span>Kapasitas</span>{{ $m->kapasitas_penumpang }} Orang</div>
                    </div>
                    
                    @if($m->deskripsi)
                        <div class="car-desc" title="{{ $m->deskripsi }}">
                            {{ $m->deskripsi }}
                        </div>
                    @else
                        <div class="car-desc" style="font-style: italic; color: #cbd5e1;">
                            Tidak ada deskripsi tambahan untuk armada ini.
                        </div>
                    @endif
                    
                    <div class="car-price">Rp {{ number_format($m->harga_sewa, 0, ',', '.') }}<small>/hari</small></div>
                    
                    @if($isAvailable)
                        <a href="{{ route('pelanggan.pilih', $m->id_mobil) }}" class="btn-rent">Pilih & Reservasi</a>
                    @else
                        <button class="btn-rent btn-disabled" disabled>Tidak Tersedia</button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
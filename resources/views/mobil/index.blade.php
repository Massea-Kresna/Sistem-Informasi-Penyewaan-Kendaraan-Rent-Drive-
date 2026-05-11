@extends('layout')

@section('content')
<style>
    .page-header {
        display: flex; justify-content: space-between; align-items: center;
        padding: 2rem 3rem; background: var(--white); border-bottom: 1px solid var(--line);
    }
    .page-title { font-size: 1.5rem; font-weight: 300; color: var(--ink); }
    .page-title strong { font-weight: 600; }
    
    .btn-add {
        background: var(--ink); color: var(--white); padding: 10px 20px;
        font-size: 13px; font-weight: 500; letter-spacing: 0.05em; text-transform: uppercase;
        text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
        transition: background 0.2s;
    }
    .btn-add:hover { background: #000; color: var(--white); }

    .table-wrapper { padding: 2rem 3rem; }
    .data-table {
        width: 100%; border-collapse: collapse; background: var(--white);
        border: 1px solid var(--line); box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    .data-table th {
        background: var(--bg); padding: 1rem 1.5rem; font-size: 10.5px;
        font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em;
        color: var(--ink-muted); text-align: center; border-bottom: 1px solid var(--line);
    }
    .data-table td {
        padding: 1rem 1.5rem; font-size: 13.5px; color: var(--ink);
        border-bottom: 1px solid var(--line); vertical-align: middle;
        text-align: center;
    }
    
    .car-img { width: 125px; height: 75px; object-fit: cover; border: 2.5px solid var(--line); background: var(--bg);}
    .price-text { font-weight: 600; color: var(--blue-deep); }
    
    .status-badge {
        display: inline-block; padding: 5px 12px; font-size: 10.5px; font-weight: 600;
        text-transform: uppercase; letter-spacing: 0.05em; border-radius: 99px;
    }
    .status-tersedia { background: var(--green-soft); color: var(--green); }
    .status-disewa { background: var(--red-soft); color: var(--red); }
    
    .action-group { display: flex; gap: 8px; justify-content: center}
    .btn-act {
        padding: 6px 12px; font-size: 11px; font-weight: 500; font-family: 'Sora';
        text-transform: uppercase; text-decoration: none; cursor: pointer;
        background: transparent; border: 1px solid var(--line); color: var(--ink-muted);
        transition: all 0.2s;
    }
    .btn-act.edit:hover { border-color: var(--amber); color: var(--amber); background: var(--amber-soft); }
    .btn-act.delete:hover { border-color: var(--red); color: var(--red); background: var(--red-soft); }
</style>

<div class="page-header">
    <h2 class="page-title">Katalog <strong>Armada</strong></h2>
    <a href="{{ route('mobil.create') }}" class="btn-add">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Mobil
    </a>
</div>

<div class="table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Informasi Mobil</th>
                <th>Spesifikasi</th>
                <th>Plat & Harga</th>
                <th>Status</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($datas as $i => $d)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>
                    @if($d->foto_mobil)
                        <img src="{{ asset('storage/' . $d->foto_mobil) }}" alt="Foto" class="car-img" onerror="this.style.display='none'">
                    @else
                        <span class="text-muted" style="font-size: 11px; color: var(--ink-muted);">Tidak ada</span>
                    @endif
                </td>
                <td>
                    <strong>{{ $d->nama_mobil }}</strong><br>
                    <span style="font-size: 12px; color: var(--ink-muted);">{{ $d->merek }}</span>
                </td>
                <td>
                    <span style="font-size: 12px; color: var(--ink-muted);">Thn:</span> {{ $d->tahun_pembuatan }} <br>
                    <span style="font-size: 12px; color: var(--ink-muted);">Warna:</span> {{ $d->warna }} <br>
                    <span style="font-size: 12px; color: var(--ink-muted);">Seat:</span> {{ $d->kapasitas_penumpang }} Orang
                </td>
                <td>
                    <span style="font-size: 12px; background: var(--bg); padding: 2px 6px; border: 1px solid var(--line); font-family: monospace;">{{ $d->plat_nomor }}</span><br>
                    <span class="price-text" style="display: block; margin-top: 6px;">Rp {{ number_format($d->harga_sewa, 0, ',', '.') }}/hari</span>
                </td>
                <td>
                    <span class="status-badge {{ strtolower($d->status) == 'tersedia' ? 'status-tersedia' : 'status-disewa' }}">
                        {{ $d->status }}
                    </span>
                </td>
                <td>
                    <div class="action-group">
                        <a href="{{ route('mobil.edit', $d->id_mobil) }}" class="btn-act edit">Ubah</a>
                        <form method="POST" action="{{ route('mobil.delete', $d->id_mobil) }}" style="display:inline">
                            @csrf
                            <button onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" class="btn-act delete">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
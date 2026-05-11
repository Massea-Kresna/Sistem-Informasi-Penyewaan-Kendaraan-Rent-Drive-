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
        color: var(--ink-muted); text-align: center; /* Rata Tengah */
        border-bottom: 1px solid var(--line);
    }
    .data-table td {
        padding: 1rem 1.5rem; font-size: 13.5px; color: var(--ink);
        border-bottom: 1px solid var(--line); vertical-align: middle; 
        text-align: center; /* Rata Tengah */
    }
    
    .data-primary { font-weight: 600; color: var(--blue-deep); display: block; margin-bottom: 2px; }
    .data-secondary { font-size: 12px; color: var(--ink-muted); display: block; }
    .mono-text { font-family: monospace; font-size: 12px; background: var(--bg); padding: 2px 6px; border: 1px solid var(--line); }

    .badge-status {
        display: inline-block; padding: 5px 12px; font-size: 10px; font-weight: 600;
        text-transform: uppercase; letter-spacing: 0.05em; border-radius: 99px;
    }
    .status-pending { background: var(--amber-soft); color: var(--amber); }
    .status-dibayar { background: var(--blue-soft); color: var(--blue-accent); }
    .status-selesai { background: var(--green-soft); color: var(--green); }
    .status-dibatalkan { background: var(--red-soft); color: var(--red); }

    .action-group { display: flex; gap: 6px; justify-content: center; } /* Pusatkan Tombol */
    .btn-act {
        padding: 6px 10px; font-size: 11px; font-weight: 500; font-family: 'Sora';
        text-transform: uppercase; text-decoration: none; cursor: pointer;
        background: transparent; border: 1px solid var(--line); color: var(--ink-muted);
        transition: all 0.2s;
    }
    .btn-act.detail:hover { border-color: var(--blue-accent); color: var(--blue-accent); background: var(--blue-soft); }
    .btn-act.finish:hover { border-color: var(--blue-deep); color: var(--blue-deep); background: var(--bg); }
    .btn-act.delete:hover { border-color: var(--red); color: var(--red); background: var(--red-soft); }
</style>

<div class="page-header">
    <h2 class="page-title">Data <strong>Penyewaan</strong></h2>
    <a href="{{ route('penyewaan.create') }}" class="btn-add">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Penyewaan
    </a>
</div>

<div class="table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Pelanggan</th>
                <th>Armada</th>
                <th>Jadwal & Durasi</th>
                <th>Total Biaya</th>
                <th>Status</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($datas as $i => $d)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>
                    <span class="data-primary">{{ $d->nama_pelanggan }}</span>
                    <span class="data-secondary">Metode: {{ ucfirst($d->metode_pembayaran ?? '-') }}</span>
                </td>
                <td>
                    <span class="data-primary">{{ $d->nama_mobil }}</span>
                    <span class="mono-text">{{ $d->plat_nomor }}</span>
                </td>
                <td>
                    <span class="data-secondary">{{ date('d M Y', strtotime($d->tanggal_sewa)) }} — {{ $d->tanggal_kembali ? date('d M Y', strtotime($d->tanggal_kembali)) : '-' }}</span>
                    <span class="data-secondary" style="font-weight: 600;">{{ $d->durasi_hari ?? '-' }} Hari</span>
                </td>
                <td>
                    <span class="data-primary" style="color: var(--ink);">Rp {{ number_format($d->total_biaya, 0, ',', '.') }}</span>
                </td>
                <td>
                    <span class="badge-status status-{{ $d->status }}">
                        {{ $d->status }}
                    </span>
                </td>
                <td>
                    <div class="action-group">
                        <a href="{{ route('penyewaan.detail', $d->id_sewa) }}" class="btn-act detail">Detail</a>
                        @if($d->status == 'dibayar')
                        <form method="POST" action="{{ route('penyewaan.kembali', $d->id_sewa) }}" style="display:inline">
                            @csrf
                            <button onclick="return confirm('Selesaikan sewa ini?')" class="btn-act finish">Selesai</button>
                        </form>
                        @endif
                        <form method="POST" action="{{ route('penyewaan.delete', $d->id_sewa) }}" style="display:inline">
                            @csrf
                            <button onclick="return confirm('Hapus permanen data ini?')" class="btn-act delete">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" style="padding: 3rem; color: var(--ink-muted);">Belum ada data penyewaan</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
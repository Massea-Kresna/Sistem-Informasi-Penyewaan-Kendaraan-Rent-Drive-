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
        border-bottom: 1px solid var(--line); vertical-align: middle; text-align: center; /* Rata Tengah Global */
    }
    
    .action-group { display: flex; gap: 8px; justify-content: center; }
    .btn-act {
        padding: 6px 12px; font-size: 11px; font-weight: 500; font-family: 'Sora';
        text-transform: uppercase; text-decoration: none; cursor: pointer;
        background: transparent; border: 1px solid var(--line); color: var(--ink-muted);
        transition: all 0.2s;
    }
    .btn-act.delete:hover { border-color: var(--red); color: var(--red); background: var(--red-soft); }
    .btn-act.edit:hover { border-color: var(--amber); color: var(--amber); background: var(--amber-soft); }

    .data-primary { font-weight: 600; color: var(--blue-deep); display: block; margin-bottom: 4px; }
    .data-secondary { font-size: 12px; color: var(--ink-muted); }
    .mono-text { font-family: monospace; font-size: 12.5px; background: var(--bg); padding: 2px 6px; border: 1px solid var(--line); }
</style>

<div class="page-header">
    <h2 class="page-title">Manajemen <strong>Pelanggan</strong></h2>
    <a href="{{ route('pelanggan.create') }}" class="btn-add">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
        Tambah Pelanggan
    </a>
</div>

<div class="table-wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Profil Akun</th>
                <th>Kontak Pribadi</th>
                <th>Data Kependudukan</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($datas as $i => $d)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>
                    <span class="data-primary">{{ $d->nama }}</span>
                    <span class="data-secondary">{{ $d->email }}</span>
                </td>
                <td>
                    <span style="display:block; margin-bottom: 4px;">{{ $d->no_hp }}</span>
                    <span class="data-secondary">{{ Str::limit($d->alamat, 40) }}</span>
                </td>
                <td>
                    <span class="mono-text" style="display:block; margin-bottom: 4px; width: max-content; margin-left: auto; margin-right: auto;">NIK: {{ $d->no_ktp }}</span>
                    <span class="data-secondary">Lahir: {{ date('d M Y', strtotime($d->tanggal_lahir)) }}</span>
                </td>
                <td>
                    <div class="action-group">
                        <a href="{{ route('pelanggan.edit', $d->id_pelanggan) }}" class="btn-act edit">Ubah</a>
                        <form method="POST" action="{{ route('pelanggan.delete', $d->id_pelanggan) }}" style="display:inline">
                            @csrf
                            <button onclick="return confirm('Hapus permanen data pelanggan ini beserta seluruh riwayat sewa-nya?')" class="btn-act delete">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
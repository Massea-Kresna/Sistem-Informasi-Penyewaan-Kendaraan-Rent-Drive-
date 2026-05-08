@extends('layout')
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('penyewaan.index') }}">Data Penyewaan</a></li>
        <li class="breadcrumb-item active">Detail #{{ $sewa->id_sewa }}</li>
    </ol>
</nav>

<h4>Detail Penyewaan #{{ str_pad($sewa->id_sewa, 6, '0', STR_PAD_LEFT) }}</h4>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header bg-primary text-white"><strong>Data Pelanggan</strong></div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><th width="35%">Nama</th><td>{{ $sewa->nama_pelanggan }}</td></tr>
                    <tr><th>Email</th><td>{{ $sewa->email }}</td></tr>
                    <tr><th>No KTP</th><td>{{ $sewa->no_ktp }}</td></tr>
                    <tr><th>No HP</th><td>{{ $sewa->no_hp }}</td></tr>
                    <tr><th>Alamat</th><td>{{ $sewa->alamat }}</td></tr>
                    @if($sewa->foto_ktp)
                        <tr><th>Foto KTP</th>
                            <td>
                                <a href="{{ asset('storage/' . $sewa->foto_ktp) }}" target="_blank">Lihat KTP →</a>
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $sewa->foto_ktp) }}" alt="KTP"
                                         style="max-height:100px;">
                                </div>
                            </td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header bg-info text-white"><strong>Data Mobil</strong></div>
            <div class="card-body">
                @if($sewa->foto_mobil)
                    <img src="{{ asset('storage/' . $sewa->foto_mobil) }}" class="img-fluid rounded mb-2"
                         style="max-height:160px; object-fit:cover; width:100%;">
                @endif
                <table class="table table-sm mb-0">
                    <tr><th width="35%">Mobil</th><td>{{ $sewa->nama_mobil }}</td></tr>
                    <tr><th>Merek</th><td>{{ $sewa->merek }}</td></tr>
                    <tr><th>Tahun</th><td>{{ $sewa->tahun_pembuatan }}</td></tr>
                    <tr><th>Warna</th><td>{{ $sewa->warna }}</td></tr>
                    <tr><th>Plat</th><td>{{ $sewa->plat_nomor }}</td></tr>
                    <tr><th>Kapasitas</th><td>{{ $sewa->kapasitas_penumpang }} penumpang</td></tr>
                    <tr><th>Harga / Hari</th><td>Rp {{ number_format($sewa->harga_sewa) }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-success text-white"><strong>Detail Sewa</strong></div>
    <div class="card-body">
        <table class="table table-sm mb-0">
            <tr><th width="20%">Status Sewa</th>
                <td>
                    @php
                        $badge = ['pending'=>'warning','dibayar'=>'info','selesai'=>'secondary','dibatalkan'=>'danger'][$sewa->status] ?? 'light';
                    @endphp
                    <span class="badge bg-{{ $badge }}">{{ $sewa->status }}</span>
                </td>
            </tr>
            <tr><th>Tanggal Sewa</th><td>{{ $sewa->tanggal_sewa }}</td></tr>
            <tr><th>Tanggal Kembali</th><td>{{ $sewa->tanggal_kembali ?? '-' }}</td></tr>
            <tr><th>Durasi</th><td>{{ $sewa->durasi_hari }} hari</td></tr>
            <tr><th>Total Biaya</th>
                <td><strong>Rp {{ number_format($sewa->total_biaya) }}</strong></td></tr>
            @if($sewa->catatan)
                <tr><th>Catatan</th><td>{{ $sewa->catatan }}</td></tr>
            @endif
            <tr><th>Dibuat</th><td>{{ $sewa->created_at }}</td></tr>
        </table>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header bg-warning"><strong>Riwayat Pembayaran</strong></div>
    <div class="card-body">
        @if(count($pembayaran) === 0)
            <p class="text-muted mb-0">Belum ada pembayaran.</p>
        @else
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Tgl Bayar</th>
                        <th>Metode</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Bukti Transfer</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($pembayaran as $p)
                    <tr>
                        <td>PAY-{{ str_pad($p->id_pembayaran, 6, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ $p->tanggal_bayar }}</td>
                        <td>{{ ucfirst($p->metode_pembayaran) }}</td>
                        <td>Rp {{ number_format($p->jumlah_bayar) }}</td>
                        <td>
                            @php
                                $b = ['berhasil'=>'success','gagal'=>'danger','pending'=>'warning'][$p->status_pembayaran] ?? 'light';
                            @endphp
                            <span class="badge bg-{{ $b }}">{{ ucfirst($p->status_pembayaran) }}</span>
                        </td>
                        <td>
                            @if($p->bukti_transfer)
                                <a href="{{ asset('storage/' . $p->bukti_transfer) }}" target="_blank"
                                   class="btn btn-sm btn-outline-primary">
                                    🔗 Lihat Bukti
                                </a>
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $p->bukti_transfer) }}" alt="Bukti"
                                         style="max-width:120px; max-height:80px; object-fit:cover;"
                                         onerror="this.style.display='none'">
                                </div>
                            @else
                                <span class="text-muted">- (cash / belum diunggah)</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

<a href="{{ route('penyewaan.index') }}" class="btn btn-secondary">← Kembali</a>
@endsection

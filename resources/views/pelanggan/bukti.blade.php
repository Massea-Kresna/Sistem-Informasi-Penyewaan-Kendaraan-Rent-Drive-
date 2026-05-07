@extends('pelanggan.layout')
@section('title', 'Bukti Penyewaan')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-success">
            <div class="card-header bg-success text-white text-center py-3">
                <h4 class="mb-0">✓ Bukti Penyewaan</h4>
                <small>Notifikasi: Pesanan Anda berhasil dikonfirmasi</small>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <h2>🚗 Rent Drive</h2>
                    <p class="text-muted mb-0">Invoice / Bukti Sewa</p>
                </div>

                <table class="table">
                    <tr>
                        <th width="40%">No. Invoice</th>
                        <td>RD-{{ str_pad($sewa->id_sewa, 6, '0', STR_PAD_LEFT) }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($sewa->status === 'dibayar')
                                <span class="badge bg-success">Berhasil Dibayar</span>
                            @elseif($sewa->status === 'selesai')
                                <span class="badge bg-secondary">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    <tr><th colspan="2" class="bg-light">Detail Pelanggan</th></tr>
                    <tr><th>Nama</th><td>{{ $sewa->nama_pelanggan }}</td></tr>
                    <tr><th>No HP</th><td>{{ $sewa->no_hp }}</td></tr>
                    <tr><th>Alamat</th><td>{{ $sewa->alamat }}</td></tr>

                    <tr><th colspan="2" class="bg-light">Detail Mobil</th></tr>
                    <tr><th>Mobil</th><td>{{ $sewa->nama_mobil }} ({{ $sewa->merek }})</td></tr>
                    <tr><th>Plat Nomor</th><td>{{ $sewa->plat_nomor }}</td></tr>

                    <tr><th colspan="2" class="bg-light">Detail Sewa</th></tr>
                    <tr><th>Tanggal Mulai</th><td>{{ $sewa->tanggal_sewa }}</td></tr>
                    <tr><th>Tanggal Selesai</th><td>{{ $sewa->tanggal_kembali }}</td></tr>
                    <tr><th>Harga / Hari</th><td>Rp {{ number_format($sewa->harga_sewa) }}</td></tr>

                    <tr class="table-success">
                        <th><h5 class="mb-0">Total Pembayaran</h5></th>
                        <td><h5 class="mb-0 text-success">Rp {{ number_format($sewa->total_biaya) }}</h5></td>
                    </tr>
                </table>

                <div class="alert alert-info text-center mt-4 mb-0">
                    <small>Bukti ini sah sebagai konfirmasi penyewaan. Simpan untuk keperluan pengembalian mobil.</small>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('pelanggan.riwayat') }}" class="btn btn-outline-secondary">← Riwayat Sewa</a>
                    <button onclick="window.print()" class="btn btn-primary">🖨 Cetak Bukti</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

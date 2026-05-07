@extends('pelanggan.layout')
@section('title', 'Konfirmasi Pesanan')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('pelanggan.mobil') }}">Daftar Mobil</a></li>
        <li class="breadcrumb-item"><a href="{{ route('pelanggan.pilih', $mobil->id_mobil) }}">Form Penyewaan</a></li>
        <li class="breadcrumb-item active">Konfirmasi</li>
    </ol>
</nav>

<h4 class="mb-3">Konfirmasi Pesanan</h4>
<p class="text-muted">Periksa detail pesanan Anda. Setelah dikonfirmasi, pesanan akan disimpan dan menunggu pembayaran.</p>

<div class="card">
    <div class="card-body">
        <h5 class="mb-3">Ringkasan Pesanan</h5>

        <table class="table">
            <tr><th width="35%">Mobil</th>
                <td>{{ $mobil->nama_mobil }} ({{ $mobil->merek }})</td></tr>
            <tr><th>Plat Nomor</th>          <td>{{ $mobil->plat_nomor }}</td></tr>
            <tr><th>Harga per Hari</th>      <td>Rp {{ number_format($mobil->harga_sewa) }}</td></tr>
            <tr><th>Tanggal Sewa</th>        <td>{{ $tanggal_sewa }}</td></tr>
            <tr><th>Tanggal Kembali</th>     <td>{{ $tanggal_kembali }}</td></tr>
            <tr><th>Durasi</th>              <td>{{ $hari }} hari</td></tr>
            <tr class="table-primary">
                <th><h5 class="mb-0">Total Biaya</h5></th>
                <td><h5 class="mb-0 text-primary">Rp {{ number_format($total) }}</h5></td>
            </tr>
        </table>

        <form method="POST" action="{{ route('pelanggan.simpan') }}">
            @csrf
            <input type="hidden" name="id_mobil"        value="{{ $mobil->id_mobil }}">
            <input type="hidden" name="tanggal_sewa"    value="{{ $tanggal_sewa }}">
            <input type="hidden" name="tanggal_kembali" value="{{ $tanggal_kembali }}">
            <input type="hidden" name="total_biaya"     value="{{ $total }}">

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('pelanggan.pilih', $mobil->id_mobil) }}" class="btn btn-secondary">← Ubah Tanggal</a>
                <button type="submit" class="btn btn-success btn-lg">
                    Konfirmasi & Lanjut ke Pembayaran →
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

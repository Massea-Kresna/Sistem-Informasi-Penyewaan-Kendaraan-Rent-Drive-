@extends('pelanggan.layout')
@section('title', 'Pembayaran')

@section('content')
<h4 class="mb-3">Pembayaran Mobil</h4>
<p class="text-muted">Selesaikan pembayaran untuk mengkonfirmasi pesanan Anda.</p>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-body">
                <h5>Detail Pesanan</h5>
                <hr>
                <table class="table table-sm">
                    <tr><th>ID Sewa</th><td>#{{ $sewa->id_sewa }}</td></tr>
                    <tr><th>Mobil</th><td>{{ $sewa->nama_mobil }}</td></tr>
                    <tr><th>Plat</th><td>{{ $sewa->plat_nomor }}</td></tr>
                    <tr><th>Tgl Sewa</th><td>{{ $sewa->tanggal_sewa }}</td></tr>
                    <tr><th>Tgl Kembali</th><td>{{ $sewa->tanggal_kembali }}</td></tr>
                    <tr class="table-primary">
                        <th>Total Bayar</th>
                        <td><strong>Rp {{ number_format($sewa->total_biaya) }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5>Metode Pembayaran</h5>
                <hr>
                <div class="alert alert-info">
                    <strong>📌 Mode Simulasi</strong><br>
                    <small>Pilih hasil pembayaran untuk demo alur sistem.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Pilih Metode</label>
                    <select class="form-select" disabled>
                        <option>Transfer Bank BCA</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Rekening Tujuan</label>
                    <input type="text" class="form-control" value="1234567890 a.n. Rent Drive" readonly>
                </div>

                <form method="POST" action="{{ route('pelanggan.proses', $sewa->id_sewa) }}">
                    @csrf
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" name="hasil" value="sukses" class="btn btn-success btn-lg">
                            ✓ Simulasi Pembayaran Berhasil
                        </button>
                        <button type="submit" name="hasil" value="gagal" class="btn btn-outline-danger">
                            ✗ Simulasi Pembayaran Gagal
                        </button>
                    </div>
                </form>

                <hr>
                <form method="POST" action="{{ route('pelanggan.batal', $sewa->id_sewa) }}">
                    @csrf
                    <button onclick="return confirm('Batalkan pesanan ini?')" class="btn btn-link text-danger">
                        Batalkan Pesanan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

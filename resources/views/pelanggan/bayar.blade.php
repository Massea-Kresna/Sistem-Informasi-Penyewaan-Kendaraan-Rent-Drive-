@extends('pelanggan.layout')
@section('title', 'Pembayaran')

@section('content')
<h4 class="mb-3">Pembayaran</h4>
<p class="text-muted">Selesaikan pembayaran untuk mengonfirmasi pesanan Anda.</p>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<form method="POST" action="{{ route('pelanggan.proses', $sewa->id_sewa) }}">
    @csrf
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
                        <tr><th>Durasi</th><td>{{ $sewa->durasi_hari }} hari</td></tr>
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

                    <div class="mb-3">
                        <label class="form-label">Pilih Metode</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="metode_pembayaran"
                                   id="m_transfer" value="transfer"
                                   {{ old('metode_pembayaran', 'transfer') === 'transfer' ? 'checked' : '' }}>
                            <label class="form-check-label" for="m_transfer">
                                <strong>Transfer Bank</strong>
                                <br><small class="text-muted">BCA 1234567890 a.n. Rent Drive</small>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="metode_pembayaran"
                                   id="m_cash" value="cash"
                                   {{ old('metode_pembayaran') === 'cash' ? 'checked' : '' }}>
                            <label class="form-check-label" for="m_cash">
                                <strong>Cash (Tunai)</strong>
                                <br><small class="text-muted">Bayar di kantor saat pickup mobil</small>
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL Bukti Transfer <small class="text-muted">(opsional)</small></label>
                        <input type="url" name="bukti_transfer" class="form-control"
                               placeholder="https://example.com/bukti.jpg"
                               value="{{ old('bukti_transfer') }}">
                        <small class="text-muted">Untuk metode transfer, sertakan link foto bukti.</small>
                    </div>

                    <div class="alert alert-info">
                        <strong>📌 Mode Simulasi</strong><br>
                        <small>Pilih hasil pembayaran untuk simulasi alur sistem.</small>
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" name="hasil" value="sukses" class="btn btn-success btn-lg">
                            ✓ Simulasi Pembayaran Berhasil
                        </button>
                        <button type="submit" name="hasil" value="gagal" class="btn btn-outline-danger">
                            ✗ Simulasi Pembayaran Gagal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="text-center mt-3">
    <form method="POST" action="{{ route('pelanggan.batal', $sewa->id_sewa) }}" class="d-inline">
        @csrf
        <button onclick="return confirm('Batalkan pesanan ini?')" class="btn btn-link text-danger">
            Batalkan Pesanan
        </button>
    </form>
</div>
@endsection

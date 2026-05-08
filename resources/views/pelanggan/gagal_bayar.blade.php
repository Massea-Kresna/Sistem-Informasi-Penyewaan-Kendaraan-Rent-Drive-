@extends('pelanggan.layout')
@section('title', 'Pembayaran Gagal')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card border-danger">
            <div class="card-body text-center py-5">
                <div style="font-size:60px">⚠️</div>
                <h4 class="text-danger mt-3">Pembayaran Gagal</h4>
                <p class="text-muted">Mohon maaf, pembayaran untuk pesanan #{{ $sewa->id_sewa }} tidak berhasil diproses.</p>

                <hr>
                <p class="mb-1"><strong>{{ $sewa->nama_mobil }}</strong> ({{ $sewa->plat_nomor }})</p>
                <p>Total: <strong>Rp {{ number_format($sewa->total_biaya) }}</strong></p>
                <hr>

                <p class="text-muted">Silakan coba kembali atau batalkan pesanan.</p>

                <div class="d-grid gap-2 mt-4">
                    <a href="{{ route('pelanggan.bayar', $sewa->id_sewa) }}" class="btn btn-primary btn-lg">
                        🔄 Coba Bayar Lagi
                    </a>
                    <form method="POST" action="{{ route('pelanggan.batal', $sewa->id_sewa) }}">
                        @csrf
                        <button onclick="return confirm('Yakin batalkan pesanan ini?')"
                                class="btn btn-outline-danger w-100">
                            ✗ Batalkan Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

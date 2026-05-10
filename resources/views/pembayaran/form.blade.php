@extends('layout')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h4 class="text-center mb-4">Proses Pembayaran</h4>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="alert alert-info">
                    <strong>Total Tagihan:</strong> Rp {{ number_format($sewa->total_biaya) }}
                </div>
                
                <form method="POST" action="{{ route('pembayaran.proses', $sewa->id_sewa) }}">
                    @csrf
                    <div class="mb-3">
                        <label>Masukkan Nominal Bayar (Rp)</label>
                        <input type="number" name="jumlah_bayar" class="form-control" value="{{ $sewa->total_biaya }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Metode Pembayaran</label>
                        <select name="metode_pembayaran" class="form-select">
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="E-Wallet">E-Wallet</option>
                            <option value="Cash">Cash</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Bayar Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
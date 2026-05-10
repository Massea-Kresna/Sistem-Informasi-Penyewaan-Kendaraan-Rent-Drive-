@extends('pelanggan.layout')
@section('title', 'Daftar Mobil')

@section('content')
<h4 class="mb-3">Daftar Mobil</h4>
<p class="text-muted">Pilih mobil yang tersedia untuk disewa.</p>

@if(count($mobils) === 0)
    <div class="alert alert-info">Belum ada mobil yang terdaftar di sistem.</div>
@endif

<div class="row">
    @foreach($mobils as $m)
        <div class="col-md-4 mb-4">
            <div class="card h-100 {{ $m->status !== 'tersedia' ? 'opacity-75' : '' }}">
                @if($m->foto_mobil)
                    <img src="{{ asset('storage/' . $m->foto_mobil) }}" class="card-img-top" alt="{{ $m->nama_mobil }}"
                         style="height:180px; object-fit:cover;"
                         onerror="this.style.display='none'">
                @else
                    <div class="bg-light text-center py-5 border-bottom">
                        <span style="font-size:50px;">🚗</span>
                    </div>
                @endif

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title mb-0">{{ $m->nama_mobil }}</h5>
                        @if($m->status === 'tersedia')
                            <span class="badge bg-success">Tersedia</span>
                        @else
                            <span class="badge bg-danger">Tidak Tersedia</span>
                        @endif
                    </div>
                    <p class="text-muted small mb-2">
                        {{ $m->merek }} • {{ $m->tahun_pembuatan }} • {{ $m->warna }}
                    </p>
                    <p class="mb-1"><small><strong>Plat:</strong> {{ $m->plat_nomor }}</small></p>
                    <p class="mb-2"><small>👥 {{ $m->kapasitas_penumpang }} penumpang</small></p>
                    @if($m->deskripsi)
                        <p class="text-muted small mb-2">{{ Str::limit($m->deskripsi, 80) }}</p>
                    @endif
                    <h5 class="text-primary mt-3 mb-0">Rp {{ number_format($m->harga_sewa) }}<small class="text-muted">/hari</small></h5>
                </div>
                <div class="card-footer bg-white border-0">
                    @if($m->status === 'tersedia')
                        <a href="{{ route('pelanggan.pilih', $m->id_mobil) }}" class="btn btn-primary w-100">
                            Pilih & Sewa
                        </a>
                    @else
                        <button class="btn btn-secondary w-100" disabled>Sedang Disewa</button>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection

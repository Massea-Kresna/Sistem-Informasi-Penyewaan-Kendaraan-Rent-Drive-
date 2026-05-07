<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    private function getOwnedSewa($id)
    {
        $sewa = DB::table('penyewaan as p')
            ->join('mobil as m', 'p.id_mobil', '=', 'm.id_mobil')
            ->join('pelanggan as pl', 'p.id_pelanggan', '=', 'pl.id_pelanggan')
            ->where('p.id_sewa', $id)
            ->where('p.id_pelanggan', session('pelanggan_id'))
            ->select(
                'p.*',
                'm.nama_mobil', 'm.merek', 'm.plat_nomor', 'm.harga_sewa',
                'pl.nama as nama_pelanggan', 'pl.no_hp', 'pl.alamat'
            )->first();
        return $sewa;
    }

    // Pembayaran Mobil - tampilkan form pembayaran
    public function showPayment($id)
    {
        $sewa = $this->getOwnedSewa($id);
        if (!$sewa) {
            return redirect()->route('pelanggan.riwayat')
                ->with('error', 'Data penyewaan tidak ditemukan.');
        }
        if ($sewa->status !== 'pending') {
            return redirect()->route('pelanggan.bukti', $id);
        }
        return view('pelanggan.bayar', compact('sewa'));
    }

    // Proses Pembayaran - simulasi sukses/gagal
    public function proses(Request $request, $id)
    {
        $sewa = $this->getOwnedSewa($id);
        if (!$sewa || $sewa->status !== 'pending') {
            return redirect()->route('pelanggan.riwayat');
        }

        $hasil = $request->input('hasil');

        if ($hasil === 'sukses') {
            // Verifikasi Pembayaran
            // Update Status Penyewaan = Berhasil Dibayar
            DB::update(
                "UPDATE penyewaan SET status='dibayar' WHERE id_sewa=:id",
                ['id' => $id]
            );
            // Update Status Mobil = Disewa
            DB::update(
                "UPDATE mobil SET status='disewa' WHERE id_mobil=:id",
                ['id' => $sewa->id_mobil]
            );
            // Kirim Notifikasi & Bukti Sewa → Tampilkan Bukti
            return redirect()->route('pelanggan.bukti', $id)
                ->with('success', 'Pembayaran berhasil! Mobil telah dikonfirmasi disewa.');
        }

        // Pembayaran gagal → Tampilkan Gagal Bayar (retry / cancel)
        return redirect()->route('pelanggan.gagal', $id);
    }

    // Tampilkan Gagal Bayar
    public function gagal($id)
    {
        $sewa = $this->getOwnedSewa($id);
        if (!$sewa || $sewa->status !== 'pending') {
            return redirect()->route('pelanggan.riwayat');
        }
        return view('pelanggan.gagal_bayar', compact('sewa'));
    }

    // Batalkan Pesanan
    public function batal($id)
    {
        $sewa = $this->getOwnedSewa($id);
        if (!$sewa || $sewa->status !== 'pending') {
            return redirect()->route('pelanggan.riwayat')
                ->with('error', 'Pesanan tidak dapat dibatalkan.');
        }
        // Update Status Penyewaan = Dibatalkan
        DB::update(
            "UPDATE penyewaan SET status='dibatalkan' WHERE id_sewa=:id",
            ['id' => $id]
        );
        return redirect()->route('pelanggan.riwayat')
            ->with('success', 'Pesanan telah dibatalkan.');
    }

    // Tampilkan Bukti Penyewaan
    public function bukti($id)
    {
        $sewa = $this->getOwnedSewa($id);
        if (!$sewa) {
            return redirect()->route('pelanggan.riwayat')
                ->with('error', 'Bukti tidak ditemukan.');
        }
        if ($sewa->status === 'pending') {
            return redirect()->route('pelanggan.bayar', $id);
        }
        if ($sewa->status === 'dibatalkan') {
            return redirect()->route('pelanggan.riwayat')
                ->with('error', 'Pesanan ini telah dibatalkan.');
        }
        return view('pelanggan.bukti', compact('sewa'));
    }
}

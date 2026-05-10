<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller {
    public function form($id_sewa) {
        $sewa = DB::table('penyewaan')->where('id_sewa', $id_sewa)->first();
        return view('pembayaran.form', compact('sewa'));
    }

    public function prosesPembayaran(Request $request, $id_sewa) {
        // Proses Pembayaran 
        // Upload bukti transfer logic disini...
        
        DB::table('pembayaran')->insert([
            'id_sewa' => $id_sewa,
            'jumlah_bayar' => $request->jumlah_bayar,
            'tanggal_bayar' => date('Y-m-d'),
            'status_pembayaran' => 'Menunggu Verifikasi',
            'created_at' => date('Y-m-d')
        ]);
        
        return redirect()->route('dashboard')->with('success', 'Pembayaran sedang diverifikasi');
    }

    // Fungsi ini dipicu oleh Admin/Sistem untuk verifikasi
    public function verifikasi($id_pembayaran, $status_valid) {
        $pembayaran = DB::table('pembayaran')->where('id_pembayaran', $id_pembayaran)->first();
        $id_sewa = $pembayaran->id_sewa;
        $id_mobil = DB::table('penyewaan')->where('id_sewa', $id_sewa)->value('id_mobil');

        if ($status_valid) {
            // Update Status Penyewaan = Berhasil Dibayar [cite: 37]
            DB::table('penyewaan')->where('id_sewa', $id_sewa)->update(['status' => 'Berhasil Dibayar']);
            // Update Status Mobil = Disewa [cite: 38]
            DB::table('mobil')->where('id_mobil', $id_mobil)->update(['status' => 'disewa']);
            // Kirim Notifikasi & Bukti Sewa [cite: 30]
        } else {
            // Tampilkan Gagal Bayar [cite: 29] & Batalkan Pesanan [cite: 34]
            DB::table('penyewaan')->where('id_sewa', $id_sewa)->update(['status' => 'Dibatalkan']); // Update Status Penyewaan = Dibatalkan [cite: 40]
        }
        return redirect()->back();
    }
}
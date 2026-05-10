<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    // Lihat Daftar Mobil — tampilkan semua dengan status tersedia/tidak
    public function browseMobil()
    {
        $mobils = DB::select('SELECT * FROM mobil ORDER BY status ASC, nama_mobil ASC');
        return view('pelanggan.mobil', compact('mobils'));
    }

    // Pilih Mobil → Cek Status → tampilkan form tanggal
    public function pilihMobil($id)
    {
        $mobil = DB::table('mobil')->where('id_mobil', $id)->first();

        if (!$mobil) {
            return redirect()->route('pelanggan.mobil')
                ->with('error', 'Mobil tidak ditemukan.');
        }

        // Cek Status Mobil — Mobil tersedia?
        if ($mobil->status !== 'tersedia') {
            return redirect()->route('pelanggan.mobil')
                ->with('error', 'Mobil "' . $mobil->nama_mobil . '" sedang tidak tersedia.');
        }

        return view('pelanggan.form_sewa', compact('mobil'));
    }

    // Konfirmasi Pesanan — preview sebelum simpan
    public function konfirmasi(Request $request)
    {
        $request->validate([
            'id_mobil'        => 'required|integer',
            'tanggal_sewa'    => 'required|date|after_or_equal:today',
            'tanggal_kembali' => 'required|date|after:tanggal_sewa',
            'catatan'         => 'nullable|max:500',
        ]);

        $mobil = DB::table('mobil')->where('id_mobil', $request->id_mobil)->first();
        if (!$mobil || $mobil->status !== 'tersedia') {
            return redirect()->route('pelanggan.mobil')
                ->with('error', 'Mobil sudah tidak tersedia.');
        }

        $tglSewa    = new \DateTime($request->tanggal_sewa);
        $tglKembali = new \DateTime($request->tanggal_kembali);
        $durasi     = max($tglSewa->diff($tglKembali)->days, 1);
        $total      = $durasi * $mobil->harga_sewa;

        return view('pelanggan.konfirmasi', [
            'mobil'           => $mobil,
            'tanggal_sewa'    => $request->tanggal_sewa,
            'tanggal_kembali' => $request->tanggal_kembali,
            'durasi'          => $durasi,
            'total'           => $total,
            'catatan'         => $request->catatan,
        ]);
    }

    // Simpan Data Sementara — Insert Data Penyewaan (status: Pending)
    public function simpan(Request $request)
    {
        $request->validate([
            'id_mobil'        => 'required|integer',
            'tanggal_sewa'    => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_sewa',
            'total_biaya'     => 'required|numeric|min:1',
            'durasi_hari'     => 'required|integer|min:1',
            'catatan'         => 'nullable|max:500',
        ]);

        $mobil = DB::table('mobil')->where('id_mobil', $request->id_mobil)->first();
        if (!$mobil || $mobil->status !== 'tersedia') {
            return redirect()->route('pelanggan.mobil')
                ->with('error', 'Mobil sudah tidak tersedia.');
        }

        $idSewa = DB::table('penyewaan')->insertGetId([
            'id_mobil'        => $request->id_mobil,
            'id_pelanggan'    => session('pelanggan_id'),
            'tanggal_sewa'    => $request->tanggal_sewa,
            'tanggal_kembali' => $request->tanggal_kembali,
            'total_biaya'     => $request->total_biaya,
            'durasi_hari'     => $request->durasi_hari,
            'catatan'         => $request->catatan,
            'status'          => 'pending',
            'created_at'      => now(),
        ], 'id_sewa');

        return redirect()->route('pelanggan.bayar', $idSewa);
    }

    // Riwayat Sewa - semua booking pelanggan ini
    public function riwayat()
    {
        $datas = DB::select('
            SELECT p.*, m.nama_mobil, m.plat_nomor, m.merek
            FROM penyewaan p
            JOIN mobil m ON p.id_mobil = m.id_mobil
            WHERE p.id_pelanggan = :id
            ORDER BY p.id_sewa DESC
        ', ['id' => session('pelanggan_id')]);

        return view('pelanggan.riwayat', compact('datas'));
    }
}

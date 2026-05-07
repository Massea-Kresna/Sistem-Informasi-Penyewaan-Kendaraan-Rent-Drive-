<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenyewaanController extends Controller {

    public function index() {
        $datas = DB::select('
            SELECT p.*, m.nama_mobil, m.plat_nomor, pl.nama AS nama_pelanggan
            FROM penyewaan p
            JOIN mobil m ON p.id_mobil = m.id_mobil
            JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
        ');
        return view('penyewaan.index')->with('datas', $datas);
    }

    public function create() {
        $mobils     = DB::select("SELECT * FROM mobil WHERE status='tersedia'");
        $pelanggans = DB::select('SELECT * FROM pelanggan');
        return view('penyewaan.add', compact('mobils', 'pelanggans'));
    }

    public function store(Request $request) {
        $request->validate([
            'id_mobil'      => 'required',
            'id_pelanggan'  => 'required',
            'tanggal_sewa'  => 'required|date',
        ]);
        // Admin langsung membuat penyewaan dengan status 'dibayar' (rental aktif)
        DB::insert(
            "INSERT INTO penyewaan(id_mobil, id_pelanggan, tanggal_sewa, status)
             VALUES (:id_mobil, :id_pelanggan, :tanggal_sewa, 'dibayar')",
            [
                'id_mobil'     => $request->id_mobil,
                'id_pelanggan' => $request->id_pelanggan,
                'tanggal_sewa' => $request->tanggal_sewa,
            ]
        );
        DB::update(
            "UPDATE mobil SET status='disewa' WHERE id_mobil=:id",
            ['id' => $request->id_mobil]
        );
        return redirect()->route('penyewaan.index')
                         ->with('success', 'Penyewaan berhasil dibuat');
    }

    // Kembalikan mobil
    public function kembali($id) {
        $sewa = DB::table('penyewaan')->where('id_sewa', $id)->first();
        $mobil = DB::table('mobil')->where('id_mobil', $sewa->id_mobil)->first();

        $tgl_sewa   = new \DateTime($sewa->tanggal_sewa);
        $tgl_kembali = new \DateTime(date('Y-m-d'));
        $selisih    = $tgl_sewa->diff($tgl_kembali)->days;
        $selisih    = max($selisih, 1); // minimal 1 hari
        $total      = $selisih * $mobil->harga_sewa;

        DB::update(
            "UPDATE penyewaan
             SET tanggal_kembali=:tgl, status='selesai', total_biaya=:total
             WHERE id_sewa=:id",
            [
                'tgl'   => date('Y-m-d'),
                'total' => $total,
                'id'    => $id,
            ]
        );
        DB::update(
            "UPDATE mobil SET status='tersedia' WHERE id_mobil=:id",
            ['id' => $sewa->id_mobil]
        );
        return redirect()->route('penyewaan.index')
                         ->with('success', "Mobil berhasil dikembalikan. Total: Rp " . number_format($total));
    }

    public function delete($id) {
        $sewa = DB::table('penyewaan')->where('id_sewa', $id)->first();
        DB::update(
            "UPDATE mobil SET status='tersedia' WHERE id_mobil=:id",
            ['id' => $sewa->id_mobil]
        );
        DB::delete('DELETE FROM penyewaan WHERE id_sewa=:id', ['id' => $id]);
        return redirect()->route('penyewaan.index')
                         ->with('success', 'Data penyewaan berhasil dihapus');
    }
}

<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenyewaanController extends Controller {

    public function index() {
        $datas = DB::select('
            SELECT p.*, m.nama_mobil, m.plat_nomor, pl.nama AS nama_pelanggan,
                   pb.metode_pembayaran, pb.status_pembayaran
            FROM penyewaan p
            JOIN mobil m ON p.id_mobil = m.id_mobil
            JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
            LEFT JOIN pembayaran pb ON pb.id_sewa = p.id_sewa
            ORDER BY p.id_sewa DESC
        ');
        return view('penyewaan.index')->with('datas', $datas);
    }

    public function detail($id) {
        $sewa = DB::table('penyewaan as p')
            ->join('mobil as m', 'p.id_mobil', '=', 'm.id_mobil')
            ->join('pelanggan as pl', 'p.id_pelanggan', '=', 'pl.id_pelanggan')
            ->where('p.id_sewa', $id)
            ->select(
                'p.*',
                'm.nama_mobil', 'm.merek', 'm.plat_nomor', 'm.tahun_pembuatan',
                'm.warna', 'm.kapasitas_penumpang', 'm.harga_sewa', 'm.foto_mobil',
                'pl.nama as nama_pelanggan', 'pl.email', 'pl.no_hp', 'pl.no_ktp',
                'pl.alamat', 'pl.foto_ktp'
            )->first();

        if (!$sewa) {
            return redirect()->route('penyewaan.index')
                ->with('error', 'Data penyewaan tidak ditemukan.');
        }

        $pembayaran = DB::table('pembayaran')
            ->where('id_sewa', $id)
            ->orderByDesc('id_pembayaran')
            ->get();

        return view('penyewaan.detail', compact('sewa', 'pembayaran'));
    }

    public function create() {
        $mobils     = DB::select("SELECT * FROM mobil WHERE status='tersedia'");
        $pelanggans = DB::select('SELECT * FROM pelanggan');
        return view('penyewaan.add', compact('mobils', 'pelanggans'));
    }

    public function store(Request $request) {
        $request->validate([
            'id_mobil'        => 'required',
            'id_pelanggan'    => 'required',
            'tanggal_sewa'    => 'required|date',
            'tanggal_kembali' => 'required|date|after:tanggal_sewa',
            'metode_pembayaran' => 'required|in:transfer,cash',
        ]);

        $mobil = DB::table('mobil')->where('id_mobil', $request->id_mobil)->first();
        $tglSewa    = new \DateTime($request->tanggal_sewa);
        $tglKembali = new \DateTime($request->tanggal_kembali);
        $durasi     = max($tglSewa->diff($tglKembali)->days, 1);
        $total      = $durasi * $mobil->harga_sewa;

        $idSewa = DB::table('penyewaan')->insertGetId([
            'id_mobil'        => $request->id_mobil,
            'id_pelanggan'    => $request->id_pelanggan,
            'tanggal_sewa'    => $request->tanggal_sewa,
            'tanggal_kembali' => $request->tanggal_kembali,
            'durasi_hari'     => $durasi,
            'total_biaya'     => $total,
            'status'          => 'dibayar',
            'created_at'      => now(),
        ], 'id_sewa');

        // Admin langsung input pembayaran berhasil
        DB::table('pembayaran')->insert([
            'id_sewa'           => $idSewa,
            'jumlah_bayar'      => $total,
            'metode_pembayaran' => $request->metode_pembayaran,
            'tanggal_bayar'     => date('Y-m-d'),
            'status_pembayaran' => 'berhasil',
            'created_at'        => now(),
        ]);

        DB::update("UPDATE mobil SET status='disewa' WHERE id_mobil=:id", ['id' => $request->id_mobil]);

        return redirect()->route('penyewaan.index')
                         ->with('success', 'Penyewaan berhasil dibuat');
    }

    public function kembali($id) {
        $sewa = DB::table('penyewaan')->where('id_sewa', $id)->first();

        DB::update(
            "UPDATE penyewaan SET status='selesai' WHERE id_sewa=:id",
            ['id' => $id]
        );
        DB::update(
            "UPDATE mobil SET status='tersedia' WHERE id_mobil=:id",
            ['id' => $sewa->id_mobil]
        );
        return redirect()->route('penyewaan.index')
                         ->with('success', "Mobil berhasil dikembalikan.");
    }

    public function delete($id) {
        $sewa = DB::table('penyewaan')->where('id_sewa', $id)->first();
        if ($sewa && $sewa->status === 'dibayar') {
            DB::update(
                "UPDATE mobil SET status='tersedia' WHERE id_mobil=:id",
                ['id' => $sewa->id_mobil]
            );
        }
        DB::delete('DELETE FROM pembayaran WHERE id_sewa=:id', ['id' => $id]);
        DB::delete('DELETE FROM penyewaan WHERE id_sewa=:id', ['id' => $id]);
        return redirect()->route('penyewaan.index')
                         ->with('success', 'Data penyewaan berhasil dihapus');
    }
}

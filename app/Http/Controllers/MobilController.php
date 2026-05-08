<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MobilController extends Controller {

    public function index() {
        $datas = DB::select('SELECT * FROM mobil');
        return view('mobil.index')->with('datas', $datas);
    }

    public function create() {
        return view('mobil.add');
    }

    public function store(Request $request) {
        $request->validate([
            'nama_mobil'          => 'required|max:100',
            'merek'               => 'required|max:100',
            'plat_nomor'          => 'required|max:20|unique:mobil,plat_nomor',
            'harga_sewa'          => 'required|numeric|min:0',
            'tahun_pembuatan'     => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'warna'               => 'required|max:50',
            'kapasitas_penumpang' => 'required|integer|min:1|max:50',
            'foto_mobil'          => 'nullable|url|max:500',
            'deskripsi'           => 'nullable|max:1000',
        ]);

        DB::table('mobil')->insert([
            'nama_mobil'          => $request->nama_mobil,
            'merek'               => $request->merek,
            'plat_nomor'          => $request->plat_nomor,
            'harga_sewa'          => $request->harga_sewa,
            'tahun_pembuatan'     => $request->tahun_pembuatan,
            'warna'               => $request->warna,
            'kapasitas_penumpang' => $request->kapasitas_penumpang,
            'foto_mobil'          => $request->foto_mobil,
            'deskripsi'           => $request->deskripsi,
            'status'              => 'tersedia',
        ]);

        return redirect()->route('mobil.index')
                         ->with('success', 'Data mobil berhasil ditambahkan');
    }

    public function edit($id) {
        $data = DB::table('mobil')->where('id_mobil', $id)->first();
        return view('mobil.edit')->with('data', $data);
    }

    public function update($id, Request $request) {
        $request->validate([
            'nama_mobil'          => 'required|max:100',
            'merek'               => 'required|max:100',
            'plat_nomor'          => 'required|max:20|unique:mobil,plat_nomor,' . $id . ',id_mobil',
            'harga_sewa'          => 'required|numeric|min:0',
            'tahun_pembuatan'     => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'warna'               => 'required|max:50',
            'kapasitas_penumpang' => 'required|integer|min:1|max:50',
            'foto_mobil'          => 'nullable|url|max:500',
            'deskripsi'           => 'nullable|max:1000',
        ]);

        DB::table('mobil')->where('id_mobil', $id)->update([
            'nama_mobil'          => $request->nama_mobil,
            'merek'               => $request->merek,
            'plat_nomor'          => $request->plat_nomor,
            'harga_sewa'          => $request->harga_sewa,
            'tahun_pembuatan'     => $request->tahun_pembuatan,
            'warna'               => $request->warna,
            'kapasitas_penumpang' => $request->kapasitas_penumpang,
            'foto_mobil'          => $request->foto_mobil,
            'deskripsi'           => $request->deskripsi,
        ]);

        return redirect()->route('mobil.index')
                         ->with('success', 'Data mobil berhasil diubah');
    }

    public function delete($id) {
        // Hard delete cascade — hapus semua data terkait di database
        $sewaIds = DB::table('penyewaan')->where('id_mobil', $id)->pluck('id_sewa');
        if ($sewaIds->isNotEmpty()) {
            DB::table('pembayaran')->whereIn('id_sewa', $sewaIds)->delete();
            DB::table('penyewaan')->whereIn('id_sewa', $sewaIds)->delete();
        }
        DB::table('mobil')->where('id_mobil', $id)->delete();

        return redirect()->route('mobil.index')
                         ->with('success', 'Data mobil dan semua data terkait berhasil dihapus permanen.');
    }
}

<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MobilController extends Controller {

    // READ
    public function index() {
        $datas = DB::select('SELECT * FROM mobil');
        return view('mobil.index')->with('datas', $datas);
    }

    // CREATE - form
    public function create() {
        return view('mobil.add');
    }

    // CREATE - simpan
    public function store(Request $request) {
        $request->validate([
            'nama_mobil'  => 'required',
            'merek'       => 'required',
            'plat_nomor'  => 'required',
            'harga_sewa'  => 'required|numeric',
        ]);
        DB::insert(
            'INSERT INTO mobil(nama_mobil, merek, plat_nomor, harga_sewa)
             VALUES (:nama_mobil, :merek, :plat_nomor, :harga_sewa)',
            [
                'nama_mobil' => $request->nama_mobil,
                'merek'      => $request->merek,
                'plat_nomor' => $request->plat_nomor,
                'harga_sewa' => $request->harga_sewa,
            ]
        );
        return redirect()->route('mobil.index')
                         ->with('success', 'Data mobil berhasil ditambahkan');
    }

    // UPDATE - form
    public function edit($id) {
        $data = DB::table('mobil')->where('id_mobil', $id)->first();
        return view('mobil.edit')->with('data', $data);
    }

    // UPDATE - simpan
    public function update($id, Request $request) {
        $request->validate([
            'nama_mobil' => 'required',
            'merek'      => 'required',
            'plat_nomor' => 'required',
            'harga_sewa' => 'required|numeric',
        ]);
        DB::update(
            'UPDATE mobil SET nama_mobil=:nama_mobil, merek=:merek,
             plat_nomor=:plat_nomor, harga_sewa=:harga_sewa
             WHERE id_mobil=:id',
            [
                'id'         => $id,
                'nama_mobil' => $request->nama_mobil,
                'merek'      => $request->merek,
                'plat_nomor' => $request->plat_nomor,
                'harga_sewa' => $request->harga_sewa,
            ]
        );
        return redirect()->route('mobil.index')
                         ->with('success', 'Data mobil berhasil diubah');
    }

    // DELETE
    public function delete($id) {
        DB::delete('DELETE FROM mobil WHERE id_mobil=:id', ['id' => $id]);
        return redirect()->route('mobil.index')
                         ->with('success', 'Data mobil berhasil dihapus');
    }
}

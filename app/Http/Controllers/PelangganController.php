<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller {

    public function index() {
        $datas = DB::select('SELECT * FROM pelanggan');
        return view('pelanggan.index')->with('datas', $datas);
    }

    public function create() {
        return view('pelanggan.add');
    }

    public function store(Request $request) {
        $request->validate([
            'nama'   => 'required',
            'no_ktp' => 'required',
            'no_hp'  => 'required',
            'alamat' => 'required',
        ]);
        DB::insert(
            'INSERT INTO pelanggan(nama, no_ktp, no_hp, alamat)
             VALUES (:nama, :no_ktp, :no_hp, :alamat)',
            [
                'nama'   => $request->nama,
                'no_ktp' => $request->no_ktp,
                'no_hp'  => $request->no_hp,
                'alamat' => $request->alamat,
            ]
        );
        return redirect()->route('pelanggan.index')
                         ->with('success', 'Data pelanggan berhasil ditambahkan');
    }

    public function edit($id) {
        $data = DB::table('pelanggan')->where('id_pelanggan', $id)->first();
        return view('pelanggan.edit')->with('data', $data);
    }

    public function update($id, Request $request) {
        $request->validate([
            'nama'   => 'required',
            'no_ktp' => 'required',
            'no_hp'  => 'required',
            'alamat' => 'required',
        ]);
        DB::update(
            'UPDATE pelanggan SET nama=:nama, no_ktp=:no_ktp,
             no_hp=:no_hp, alamat=:alamat
             WHERE id_pelanggan=:id',
            [
                'id'     => $id,
                'nama'   => $request->nama,
                'no_ktp' => $request->no_ktp,
                'no_hp'  => $request->no_hp,
                'alamat' => $request->alamat,
            ]
        );
        return redirect()->route('pelanggan.index')
                         ->with('success', 'Data pelanggan berhasil diubah');
    }

    public function delete($id) {
        DB::delete('DELETE FROM pelanggan WHERE id_pelanggan=:id', ['id' => $id]);
        return redirect()->route('pelanggan.index')
                         ->with('success', 'Data pelanggan berhasil dihapus');
    }
}

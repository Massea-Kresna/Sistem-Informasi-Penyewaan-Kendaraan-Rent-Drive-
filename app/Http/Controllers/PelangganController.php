<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PelangganController extends Controller {

    public function index() {
        $datas = DB::select('SELECT * FROM pelanggan ORDER BY id_pelanggan DESC');
        return view('pelanggan.index')->with('datas', $datas);
    }

    public function create() {
        return view('pelanggan.add');
    }

    public function edit($id)
    {
        // Ambil data pelanggan berdasarkan id_pelanggan
        // Sesuaikan nama Model/Tabel dengan yang kamu pakai (misal pakai DB query builder):
        $data = DB::table('pelanggan')->where('id_pelanggan', $id)->first();
        
        if (!$data) {
            return redirect()->route('pelanggan.index')->with('error', 'Data tidak ditemukan!');
        }

        return view('pelanggan.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi input
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'tanggal_lahir' => 'required|date',
            'no_ktp' => 'required',
            'no_hp' => 'required',
            'alamat' => 'required',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png|max:2048',
        ]);

        // 2. Ambil data pelanggan saat ini untuk mengecek foto lama
        $pelanggan = DB::table('pelanggan')->where('id_pelanggan', $id)->first();

        // 3. Siapkan array data yang akan diupdate
        $updateData = [
            'nama' => $request->nama,
            'email' => $request->email,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ];

        // 4. Jika kolom password diisi, enkripsi dan masukkan ke array update
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        // 5. Jika ada file foto_ktp baru yang diunggah
        if ($request->hasFile('foto_ktp')) {
            // Hapus foto lama jika ada
            if ($pelanggan->foto_ktp && Storage::disk('public')->exists($pelanggan->foto_ktp)) {
                Storage::disk('public')->delete($pelanggan->foto_ktp);
            }
            // Simpan foto baru
            $updateData['foto_ktp'] = $request->file('foto_ktp')->store('foto_ktp', 'public');
        }

        // 6. Eksekusi update ke database
        DB::table('pelanggan')->where('id_pelanggan', $id)->update($updateData);

        // 7. Kembalikan ke halaman daftar dengan pesan sukses
        return redirect()->route('pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    public function store(Request $request) {
        $request->validate([
            'nama'          => 'required|max:150',
            'email'         => 'required|email|max:150|unique:pelanggan,email',
            'password'      => 'required|min:6',
            'no_ktp'        => 'required|max:30|unique:pelanggan,no_ktp',
            'no_hp'         => 'required|max:20',
            'alamat'        => 'required|max:255',
            'tanggal_lahir' => 'required|date|before:today',
            'foto_ktp'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto_ktp')) {
            $fotoPath = $request->file('foto_ktp')->store('foto_ktp', 'public');
        }

        DB::table('pelanggan')->insert([
            'nama'          => $request->nama,
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'no_ktp'        => $request->no_ktp,
            'no_hp'         => $request->no_hp,
            'alamat'        => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'foto_ktp'      => $fotoPath,
            'created_at'    => now(),
        ]);

        return redirect()->route('pelanggan.index')
                         ->with('success', 'Data pelanggan berhasil ditambahkan');
    }

    public function delete($id) {
        // Hard delete cascade — hapus pembayaran & penyewaan terkait, lalu pelanggan
        $fotoKtp = DB::table('pelanggan')->where('id_pelanggan', $id)->value('foto_ktp');

        $sewaIds = DB::table('penyewaan')->where('id_pelanggan', $id)->pluck('id_sewa');
        if ($sewaIds->isNotEmpty()) {
            // Set mobil yang sedang disewa jadi tersedia kembali
            $mobilIds = DB::table('penyewaan')
                ->whereIn('id_sewa', $sewaIds)
                ->where('status', 'dibayar')
                ->pluck('id_mobil');
            if ($mobilIds->isNotEmpty()) {
                DB::table('mobil')->whereIn('id_mobil', $mobilIds)->update(['status' => 'tersedia']);
            }
            // Hapus file bukti transfer terkait
            $buktis = DB::table('pembayaran')->whereIn('id_sewa', $sewaIds)->pluck('bukti_transfer');
            foreach ($buktis as $b) if ($b) Storage::disk('public')->delete($b);

            DB::table('pembayaran')->whereIn('id_sewa', $sewaIds)->delete();
            DB::table('penyewaan')->whereIn('id_sewa', $sewaIds)->delete();
        }
        DB::table('pelanggan')->where('id_pelanggan', $id)->delete();

        if ($fotoKtp) Storage::disk('public')->delete($fotoKtp);

        return redirect()->route('pelanggan.index')
                         ->with('success', 'Data pelanggan dan semua data terkait berhasil dihapus permanen.');
    }
}

<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller {
    public function login() {
        return view('auth.login');
    }

    public function validateLogin(Request $request) { // Validasi Login 
        $pelanggan = DB::table('pelanggan')
            ->where('email', $request->email)
            ->whereNull('deleted_at')
            ->first();

        // Cek Username & Password [cite: 31]
        if ($pelanggan && Hash::check($request->password, $pelanggan->password)) {
            Session::put('pelanggan_id', $pelanggan->id_pelanggan);
            return redirect()->route('dashboard'); // Tampilkan Dashboard 
        }
        return redirect()->back()->with('error', 'Login Gagal!'); // Tampilkan Pesan Error [cite: 13]
    }

    public function logout() { // Logout [cite: 21]
        Session::forget('pelanggan_id'); // Hapus Session [cite: 41]
        return redirect()->route('login');
    }
}
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('pelanggan_id')) {
            return redirect()->route('pelanggan.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = DB::table('pelanggan')
            ->where('username', $request->username)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'username' => 'Username atau password salah.',
            ])->withInput($request->only('username'));
        }

        session([
            'pelanggan_id'   => $user->id_pelanggan,
            'pelanggan_nama' => $user->nama,
        ]);

        return redirect()->route('pelanggan.dashboard');
    }

    public function showRegister()
    {
        if (session()->has('pelanggan_id')) {
            return redirect()->route('pelanggan.dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|min:4|max:50|unique:pelanggan,username',
            'password' => 'required|min:6|confirmed',
            'nama'     => 'required|max:150',
            'no_ktp'   => 'required|max:30|unique:pelanggan,no_ktp',
            'no_hp'    => 'required|max:20',
            'alamat'   => 'required|max:255',
        ]);

        DB::insert(
            'INSERT INTO pelanggan(username, password, nama, no_ktp, no_hp, alamat)
             VALUES (:username, :password, :nama, :no_ktp, :no_hp, :alamat)',
            [
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'nama'     => $request->nama,
                'no_ktp'   => $request->no_ktp,
                'no_hp'    => $request->no_hp,
                'alamat'   => $request->alamat,
            ]
        );

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function dashboard()
    {
        $stats = [
            'mobil_tersedia' => DB::table('mobil')->where('status', 'tersedia')->count(),
            'total_mobil'    => DB::table('mobil')->count(),
        ];
        return view('pelanggan.dashboard', compact('stats'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['pelanggan_id', 'pelanggan_nama']);
        return redirect()->route('login')
            ->with('success', 'Anda berhasil logout.');
    }
}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('admin_id')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = DB::table('admin')->where('username', $request->username)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withErrors([
                'username' => 'Username atau password admin salah.',
            ])->withInput($request->only('username'));
        }

        session([
            'admin_id'   => $admin->id_admin,
            'admin_nama' => $admin->nama,
        ]);

        return redirect()->route('admin.dashboard');
    }

    public function dashboard()
    {
        $stats = [
            'total_mobil'      => DB::table('mobil')->count(),
            'mobil_tersedia'   => DB::table('mobil')->where('status', 'tersedia')->count(),
            'mobil_disewa'     => DB::table('mobil')->where('status', 'disewa')->count(),
            'total_pelanggan'  => DB::table('pelanggan')->count(),
            'sewa_aktif'       => DB::table('penyewaan')->where('status', 'dibayar')->count(),
            'sewa_pending'     => DB::table('penyewaan')->where('status', 'pending')->count(),
            'pendapatan'       => DB::table('pembayaran')->where('status_pembayaran', 'berhasil')->sum('jumlah_bayar'),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['admin_id', 'admin_nama']);
        return redirect()->route('admin.login')
            ->with('success', 'Anda berhasil logout.');
    }
}

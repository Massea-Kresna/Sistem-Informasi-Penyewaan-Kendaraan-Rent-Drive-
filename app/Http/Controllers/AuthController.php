<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = DB::table('pelanggan')
            ->where('email', $request->email)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->withInput($request->only('email'));
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
            'email'         => 'required|email|max:150|unique:pelanggan,email',
            'password'      => 'required|min:6|confirmed',
            'nama'          => 'required|max:150',
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
            'email'         => $request->email,
            'password'      => Hash::make($request->password),
            'nama'          => $request->nama,
            'no_ktp'        => $request->no_ktp,
            'no_hp'         => $request->no_hp,
            'alamat'        => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'foto_ktp'      => $fotoPath,
            'created_at'    => now(),
        ]);

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

    // Tampilkan profil pelanggan
    public function showProfil()
    {
        $user = DB::table('pelanggan')
            ->where('id_pelanggan', session('pelanggan_id'))
            ->first();
        return view('pelanggan.profil', compact('user'));
    }

    // Update profil pelanggan
    public function updateProfil(Request $request)
    {
        $id = session('pelanggan_id');

        $request->validate([
            'nama'          => 'required|max:150',
            'email'         => 'required|email|max:150|unique:pelanggan,email,' . $id . ',id_pelanggan',
            'no_ktp'        => 'required|max:30|unique:pelanggan,no_ktp,' . $id . ',id_pelanggan',
            'no_hp'         => 'required|max:20',
            'alamat'        => 'required|max:255',
            'tanggal_lahir' => 'required|date|before:today',
            'foto_ktp'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password'      => 'nullable|min:6|confirmed',
        ]);

        $data = [
            'nama'          => $request->nama,
            'email'         => $request->email,
            'no_ktp'        => $request->no_ktp,
            'no_hp'         => $request->no_hp,
            'alamat'        => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        if ($request->hasFile('foto_ktp')) {
            $old = DB::table('pelanggan')->where('id_pelanggan', $id)->value('foto_ktp');
            if ($old) Storage::disk('public')->delete($old);
            $data['foto_ktp'] = $request->file('foto_ktp')->store('foto_ktp', 'public');
        }

        DB::table('pelanggan')->where('id_pelanggan', $id)->update($data);
        session(['pelanggan_nama' => $request->nama]);

        return redirect()->route('pelanggan.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}

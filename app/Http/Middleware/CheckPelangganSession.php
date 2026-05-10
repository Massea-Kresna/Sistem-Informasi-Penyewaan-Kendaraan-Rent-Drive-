<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckPelangganSession
{
    public function handle(Request $request, Closure $next)
    {
        // Jika session pelanggan_id tidak ada, tendang kembali ke login
        if (!Session::has('pelanggan_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PelangganAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('pelanggan_id')) {
            return redirect()->route('login')
                ->withErrors(['username' => 'Silakan login terlebih dahulu.']);
        }
        return $next($request);
    }
}

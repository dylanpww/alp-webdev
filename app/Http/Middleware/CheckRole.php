<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles  <-- Kita menangkap daftar role di sini
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user login
        if (!Auth::check()) {
            return redirect('/login');
        }

        // 2. Ambil role user saat ini
        $userRole = Auth::user()->role; // Pastikan nama kolom di DB adalah 'role'

        // 3. Cek apakah role user ada di dalam daftar yang diizinkan
        // Logika: Jika role user ada di dalam array $roles, silakan lewat.
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // 4. Jika tidak cocok, tolak akses
        abort(403, 'Unauthorized action.');
    }
}
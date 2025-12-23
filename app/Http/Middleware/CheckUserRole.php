<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login
        if (!session()->has('user_id')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        // Ambil role dari session
        $role = session()->get('role');

        // Jika role adalah 'user', hanya bisa akses rute tertentu
        if ($role === 'user') {
            $allowedRoutes = [
                'customer-order.index',
                'customer-order.store',
                'home',
                'logout',
            ];

            $currentRouteName = $request->route()->getName();

            // Jika rute bukan yang diizinkan, redirect ke customer-order
            if (!in_array($currentRouteName, $allowedRoutes)) {
                return redirect('/customer-order')->with('error', 'Anda tidak memiliki akses ke halaman ini');
            }
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = DB::table('users')
            ->where('Username', $validated['username'])
            ->first();
        
        if (!$user) {
            Log::info('User not found', ['username' => $validated['username']]);
            return back()->with('error', 'User tidak ditemukan');
        }

        if (!Hash::check($validated['password'], $user->Password)) {
            Log::info('Password incorrect', ['username' => $validated['username']]);
            return back()->with('error', 'Password salah');
        }

        $request->session()->regenerate();
        
        // Set session data menggunakan IdUser (primary key tabel users)
        $request->session()->put('user_id', $user->IdUser);
        $request->session()->put('username', $user->Username);
        $request->session()->put('role', $user->Role ?? 'staff');
        
        Log::info('Login successful', [
            'user_id' => $user->IdUser,
            'username' => $user->Username,
            'role' => $user->Role ?? 'staff',
            'session_id' => session()->getId()
        ]);

        // Redirect berdasarkan role
        if ($user->Role === 'user') {
            return redirect('/customer-order')->with('success', 'Login berhasil!');
        } else {
            return redirect('/dashboard')->with('success', 'Login berhasil!');
        }
    }

    public function logout(\Illuminate\Http\Request $request)
    {
        Log::info('User logout', ['user_id' => session('user_id')]);
        
        $request->session()->flush();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'Logout berhasil!');
    }
}

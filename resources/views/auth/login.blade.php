@extends('layouts.app')

@section('title', 'Masuk')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        padding: 20px;
    }

    .login-container {
        width: 100%;
        max-width: 700px;
    }

    .login-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        overflow: hidden;
        animation: slideUp 0.5s ease;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 50px 150px;
        text-align: center;
        color: white;
    }

    .login-header h1 {
        font-size: 2.8rem;
        font-weight: 800;
        margin-bottom: 15px;
        letter-spacing: -0.5px;
    }

    .login-header p {
        opacity: 0.9;
        font-size: 1.1rem;
        font-weight: 300;
    }

    .login-body {
        padding: 50px 150px;
    }

    .form-group {
        margin-bottom: 35px;
        margin-left: 0;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 14px;
        font-size: 1rem;
        text-align: left;
    }

    .form-control {
        width: 100%;
        padding: 16px 18px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 1.05rem;
        transition: all 0.3s ease;
        background: white;
    }

    .form-control:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .form-control::placeholder {
        color: #9ca3af;
    }

    .form-check {
        display: flex;
        align-items: center;
        margin-bottom: 35px;
        margin-left: 0;
        justify-content: flex-start;
    }

    .form-check-input {
        width: 20px;
        height: 20px;
        margin-right: 12px;
        cursor: pointer;
        accent-color: #667eea;
        flex-shrink: 0;
    }

    .form-check-label {
        font-size: 1rem;
        color: #6b7280;
        cursor: pointer;
        user-select: none;
        text-align: left;
        margin: 0;
    }

    .btn-login {
        width: 100%;
        padding: 18px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .login-footer {
        padding: 0 150px 50px;
        text-align: center;
    }

    .login-footer p {
        color: #6b7280;
        font-size: 1rem;
        margin-bottom: 0;
    }

    .login-footer a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }

    .login-footer a:hover {
        color: #764ba2;
    }

    .alert {
        border-radius: 12px;
        border: none;
        margin-bottom: 24px;
        padding: 16px 18px;
        font-size: 0.95rem;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
    }

    .is-invalid {
        border-color: #dc2626 !important;
    }

    small[style*="color: #dc2626"] {
        display: block;
        margin-top: 8px;
        font-size: 0.85rem;
    }

    @media (max-width: 900px) {
        .login-header {
            padding: 50px 100px;
        }

        .login-body {
            padding: 50px 100px;
        }

        .login-footer


@section('content')
<div class="login-container">
    <div class="login-card">
        {{-- HEADER --}}
        <div class="login-header">
            <h1>🔐 Masuk</h1>
            <p>Sistem Penyewaan Alat Berat</p>
        </div>

        {{-- BODY --}}
        <div class="login-body">
            @if (session('error'))
                <div class="alert alert-danger">
                    ✗ {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    ✓ {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                {{-- USERNAME --}}
                <div class="form-group">
                    <label for="username" class="form-label">
                        👤 Nama Pengguna
                    </label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           class="form-control @error('username') is-invalid @enderror"
                           placeholder="Masukkan username"
                           value="{{ old('username') }}" 
                           required 
                           autofocus>
                    @error('username')
                        <small style="color: #dc2626;">{{ $message }}</small>
                    @enderror
                </div>

                {{-- PASSWORD --}}
                <div class="form-group">
                    <label for="password" class="form-label">
                        🔑 Kata Sandi
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Masukkan kata sandi"
                           required>
                    @error('password')
                        <small style="color: #dc2626;">{{ $message }}</small>
                    @enderror
                </div>

                {{-- REMEMBER ME --}}
                <div class="form-check">
                    <input type="checkbox" 
                           id="remember" 
                           name="remember" 
                           class="form-check-input"
                           {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="form-check-label">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                {{-- LOGIN BUTTON --}}
                <button type="submit" class="btn-login">
                    Masuk ke Akun →a
                </button>
            </form>
        </div>

        {{-- FOOTER --}}
        <div class="login-footer">
            <p>Belum punya akun? 
                <a href="{{ route('register') }}">Daftar di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection

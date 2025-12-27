@extends('layouts.app')

@section('title', 'Daftar')

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
        padding: 40px 20px;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .register-container {
        width: 100%;
        max-width: 520px;
        margin: 0 auto;
    }

    .register-card {
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

    .register-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 40px 30px;
        text-align: center;
        color: white;
    }

    .register-header h1 {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .register-header p {
        opacity: 0.9;
        font-size: 0.95rem;
        font-weight: 300;
    }

    .register-body {
        padding: 40px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px;
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        font-size: 0.95rem;
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

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    @media (max-width: 480px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }

    .btn-register {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        margin-top: 8px;
    }

    .btn-register:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
    }

    .btn-register:active {
        transform: translateY(0);
    }

    .register-footer {
        padding: 20px 40px 40px;
        text-align: center;
    }

    .register-footer p {
        color: #6b7280;
        font-size: 0.9rem;
        margin-bottom: 0;
    }

    .register-footer a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s;
    }

    .register-footer a:hover {
        color: #764ba2;
    }

    .alert {
        border-radius: 10px;
        border: none;
        margin-bottom: 24px;
        padding: 14px 16px;
        font-size: 0.9rem;
    }

    .alert-danger {
        background: #fee2e2;
        color: #991b1b;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
    }

    .form-text {
        font-size: 0.8rem;
        color: #9ca3af;
        margin-top: 4px;
    }

    @media (max-width: 480px) {
        .register-card {
            border-radius: 16px;
        }

        .register-header {
            padding: 30px 20px;
        }

        .register-header h1 {
            font-size: 1.5rem;
        }

        .register-body {
            padding: 30px 20px;
        }

        .register-footer {
            padding: 15px 20px 30px;
        }
    }
</style>
@endpush

@section('content')
<div class="register-container">
    <div class="register-card">
        {{-- HEADER --}}
        <div class="register-header">
            <h1>📝 Daftar</h1>
            <p>Buat akun baru untuk mulai menyewa</p>
        </div>

        {{-- BODY --}}
        <div class="register-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    ✗ Terjadi kesalahan saat mendaftar:
                    <ul style="margin: 8px 0 0 20px; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li style="margin-top: 4px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}">
                @csrf

                {{-- USERNAME --}}
                <div class="form-group">
                    <label for="username" class="form-label">👤 Nama Pengguna</label>
                    <input type="text" 
                           id="username" 
                           name="username" 
                           class="form-control @error('username') is-invalid @enderror"
                           placeholder="pilih username unik"
                           value="{{ old('username') }}" 
                           required>
                    <div class="form-text">Min 3 karakter, hanya huruf dan angka</div>
                    @error('username')
                        <small style="color: #dc2626;">{{ $message }}</small>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div class="form-group">
                    <label for="email" class="form-label">📧 Email</label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="nama@example.com"
                           value="{{ old('email') }}" 
                           required>
                    @error('email')
                        <small style="color: #dc2626;">{{ $message }}</small>
                    @enderror
                </div>

                {{-- PASSWORD & CONFIRM --}}
                <div class="form-row">
                    <div class="form-group">
                        <label for="password" class="form-label">🔑 Kata Sandi</label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Min 6 karakter"
                               required>
                        @error('password')
                            <small style="color: #dc2626;">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">🔑 Konfirmasi</label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="form-control"
                               placeholder="Ulangi kata sandi"
                               required>
                    </div>
                </div>

                {{-- NO TELEPON --}}
                <div class="form-group">
                    <label for="NoTelepon" class="form-label">📱 Nomor Telepon</label>
                    <input type="tel" 
                           id="NoTelepon" 
                           name="NoTelepon" 
                           class="form-control @error('NoTelepon') is-invalid @enderror"
                           placeholder="08XX-XXXX-XXXX"
                           value="{{ old('NoTelepon') }}" 
                           required>
                    @error('NoTelepon')
                        <small style="color: #dc2626;">{{ $message }}</small>
                    @enderror
                </div>

                {{-- ALAMAT --}}
                <div class="form-group">
                    <label for="Alamat" class="form-label">🏠 Alamat</label>
                    <textarea id="Alamat" 
                              name="Alamat" 
                              class="form-control @error('Alamat') is-invalid @enderror"
                              placeholder="Jalan, nomor, kelurahan..."
                              rows="2"
                              required>{{ old('Alamat') }}</textarea>
                    @error('Alamat')
                        <small style="color: #dc2626;">{{ $message }}</small>
                    @enderror
                </div>

                {{-- KOTA --}}
                <div class="form-group">
                    <label for="Kota" class="form-label">🌍 Kota</label>
                    <input type="text" 
                           id="Kota" 
                           name="Kota" 
                           class="form-control @error('Kota') is-invalid @enderror"
                           placeholder="Palembang"
                           value="{{ old('Kota') }}" 
                           required>
                    @error('Kota')
                        <small style="color: #dc2626;">{{ $message }}</small>
                    @enderror
                </div>

                {{-- SUBMIT BUTTON --}}
                <button type="submit" class="btn-register">
                    Buat Akun Saya →
                </button>
            </form>
        </div>

        {{-- FOOTER --}}
        <div class="register-footer">
            <p>Sudah punya akun? 
                <a href="{{ route('login') }}">Masuk di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection

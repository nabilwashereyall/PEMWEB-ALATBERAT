@extends('layouts.app')

@section('title', 'Register - Penyewaan Akomodasi')

@section('content')
<div class="container-fluid" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); min-height: 100vh; display: flex; align-items: center;">
    <div class="row w-100">
        <div class="col-md-6 mx-auto">
            <div class="card" style="border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); border: none;">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-building" style="font-size: 3rem; color: #667eea;"></i>
                        <h2 class="mt-3" style="color: #1f2937; font-weight: 700;">Penyewaan Akomodasi</h2>
                        <p class="text-muted">Buat akun baru</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Username -->
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                   id="username" name="username" value="{{ old('username') }}" 
                                   placeholder="Masukkan username" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" 
                                   placeholder="Masukkan email" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" 
                                   placeholder="Masukkan password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" 
                                   placeholder="Konfirmasi password" required>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary w-100 py-2" 
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; font-weight: 600; border-radius: 8px;">
                            <i class="fas fa-user-plus me-2"></i>Daftar
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted">Sudah punya akun? <a href="{{ route('login') }}" style="color: #667eea; text-decoration: none; font-weight: 600;">Login disini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

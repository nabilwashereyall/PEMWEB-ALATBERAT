@extends('layouts.app')
@section('title', 'Tambah Customer')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3">Tambah Customer Baru</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('customer.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('customer.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="NamaCustomer" class="form-label">Nama Customer <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('NamaCustomer') is-invalid @enderror" 
                           id="NamaCustomer" name="NamaCustomer" value="{{ old('NamaCustomer') }}" required>
                    @error('NamaCustomer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="Email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('Email') is-invalid @enderror" 
                           id="Email" name="Email" value="{{ old('Email') }}">
                    @error('Email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="NoTelepon" class="form-label">No. Telepon</label>
                    <input type="text" class="form-control @error('NoTelepon') is-invalid @enderror" 
                           id="NoTelepon" name="NoTelepon" value="{{ old('NoTelepon') }}">
                    @error('NoTelepon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="Alamat" class="form-label">Alamat</label>
                    <textarea class="form-control @error('Alamat') is-invalid @enderror" 
                              id="Alamat" name="Alamat" rows="3">{{ old('Alamat') }}</textarea>
                    @error('Alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="Kota" class="form-label">Kota</label>
                    <input type="text" class="form-control @error('Kota') is-invalid @enderror" 
                           id="Kota" name="Kota" value="{{ old('Kota') }}">
                    @error('Kota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                    <a href="{{ route('customer.index') }}" class="btn btn-light">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Tambah Bank')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3">Tambah Bank Baru</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('bank.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('bank.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="Account" class="form-label">Account <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('Account') is-invalid @enderror" 
                           id="Account" name="Account" value="{{ old('Account') }}" placeholder="Misal: BCA-001" required>
                    @error('Account')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text text-muted">ID akun yang unik (tidak boleh duplikat)</small>
                </div>

                <div class="mb-3">
                    <label for="NamaBank" class="form-label">Nama Bank <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('NamaBank') is-invalid @enderror" 
                           id="NamaBank" name="NamaBank" value="{{ old('NamaBank') }}" required>
                    @error('NamaBank')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="NomorRekening" class="form-label">No. Rekening</label>
                    <input type="text" class="form-control @error('NomorRekening') is-invalid @enderror" 
                           id="NomorRekening" name="NomorRekening" value="{{ old('NomorRekening') }}">
                    @error('NomorRekening')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                    <a href="{{ route('bank.index') }}" class="btn btn-light">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

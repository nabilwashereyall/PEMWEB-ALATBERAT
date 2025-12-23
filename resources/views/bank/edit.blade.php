@extends('layouts.app')
@section('title', 'Edit Bank')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3">Edit Bank</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('bank.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('bank.update', $bank->Account) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="Account" class="form-label">Account</label>
                    <input type="text" class="form-control" id="Account" name="Account" value="{{ $bank->Account }}" disabled>
                    <small class="form-text text-muted">ID akun tidak dapat diubah</small>
                </div>

                <div class="mb-3">
                    <label for="NamaBank" class="form-label">Nama Bank <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('NamaBank') is-invalid @enderror" 
                           id="NamaBank" name="NamaBank" value="{{ old('NamaBank', $bank->NamaBank) }}" required>
                    @error('NamaBank')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="NomorRekening" class="form-label">No. Rekening</label>
                    <input type="text" class="form-control @error('NomorRekening') is-invalid @enderror" 
                           id="NomorRekening" name="NomorRekening" value="{{ old('NomorRekening', $bank->NomorRekening) }}">
                    @error('NomorRekening')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Simpan Perubahan
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

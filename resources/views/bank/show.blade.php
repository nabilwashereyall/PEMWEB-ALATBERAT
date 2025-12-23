@extends('layouts.app')
@section('title', 'Detail Bank')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3">Detail Bank</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('bank.index') }}" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('bank.edit', $bank->Account) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0">{{ $bank->NamaBank }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Account:</label>
                    <p><span class="badge bg-info">{{ $bank->Account }}</span></p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Bank:</label>
                    <p>{{ $bank->NamaBank }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">No. Rekening:</label>
                    <p>{{ $bank->NomorRekening ?? '-' }}</p>
                </div>
            </div>

            <hr>
            <div class="row text-muted small">
                <div class="col-md-6">
                    <p><strong>Dibuat:</strong> {{ \Carbon\Carbon::parse($bank->CreatedAt)->format('d F Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Diupdate:</strong> {{ \Carbon\Carbon::parse($bank->UpdatedAt)->format('d F Y H:i') }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light">
            <form action="{{ route('bank.destroy', $bank->Account) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                    <i class="bi bi-trash"></i> Hapus Bank
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

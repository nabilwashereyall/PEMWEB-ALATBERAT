@extends('layouts.app')
@section('title', 'Detail Alat Berat')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3">Detail Alat Berat</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('alat-berat.index') }}" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('alat-berat.edit', $alatBerat->IdAlatBerat) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0">{{ $alatBerat->NamaAlatBerat }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">ID Alat Berat:</label>
                    <p>{{ $alatBerat->IdAlatBerat }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Alat Berat:</label>
                    <p>{{ $alatBerat->NamaAlatBerat }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Tipe:</label>
                    <p>
                        @if ($alatBerat->Tipe)
                            <span class="badge bg-secondary">{{ $alatBerat->Tipe }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Kondisi:</label>
                    <p>
                        @if ($alatBerat->Kondisi == 'Baik')
                            <span class="badge bg-success">{{ $alatBerat->Kondisi }}</span>
                        @elseif ($alatBerat->Kondisi == 'Rusak Ringan')
                            <span class="badge bg-warning">{{ $alatBerat->Kondisi }}</span>
                        @elseif ($alatBerat->Kondisi == 'Rusak Berat')
                            <span class="badge bg-danger">{{ $alatBerat->Kondisi }}</span>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Harga Sewa:</label>
                    <p><strong class="text-primary">Rp {{ number_format($alatBerat->HargaSewa, 0, ',', '.') }}</strong></p>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-3">
                    <label class="form-label fw-bold">Spesifikasi:</label>
                    <p>{{ $alatBerat->Spesifikasi ?? '-' }}</p>
                </div>
            </div>

            <hr>
            <div class="row text-muted small">
                <div class="col-md-6">
                    <p><strong>Dibuat:</strong> {{ \Carbon\Carbon::parse($alatBerat->CreatedAt)->format('d F Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Diupdate:</strong> {{ \Carbon\Carbon::parse($alatBerat->UpdatedAt)->format('d F Y H:i') }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light">
            <form action="{{ route('alat-berat.destroy', $alatBerat->IdAlatBerat) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                    <i class="bi bi-trash"></i> Hapus Alat Berat
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

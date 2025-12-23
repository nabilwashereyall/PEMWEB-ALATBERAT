@extends('layouts.app')
@section('title', 'Detail Staff')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3">Detail Staff</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('staff.index') }}" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('staff.edit', $staff->IdStaff) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0">{{ $staff->NamaStaff }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">ID Staff:</label>
                    <p>{{ $staff->IdStaff }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Staff:</label>
                    <p>{{ $staff->NamaStaff }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email:</label>
                    <p>{{ $staff->Email }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">No. Telepon:</label>
                    <p>{{ $staff->NoTelepon ?? '-' }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-3">
                    <label class="form-label fw-bold">Alamat:</label>
                    <p>{{ $staff->Alamat ?? '-' }}</p>
                </div>
            </div>

            <hr>
            <div class="row text-muted small">
                <div class="col-md-6">
                    <p><strong>Dibuat:</strong> {{ \Carbon\Carbon::parse($staff->CreatedAt)->format('d F Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Diupdate:</strong> {{ \Carbon\Carbon::parse($staff->UpdatedAt)->format('d F Y H:i') }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light">
            <form action="{{ route('staff.destroy', $staff->IdStaff) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                    <i class="bi bi-trash"></i> Hapus Staff
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

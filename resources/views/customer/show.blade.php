@extends('layouts.app')

@section('title', 'Detail Customer')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3">Detail Customer</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('customer.index') }}" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('customer.edit', $customer->IdCustomer) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-light">
            <h5 class="mb-0">{{ $customer->NamaCustomer }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">ID Customer:</label>
                    <p>{{ $customer->IdCustomer }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama Customer:</label>
                    <p>{{ $customer->NamaCustomer }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email:</label>
                    <p>{{ $customer->Email ?? '-' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">No. Telepon:</label>
                    <p>{{ $customer->NoTelepon ?? '-' }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Kota:</label>
                    <p>{{ $customer->Kota ?? '-' }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-3">
                    <label class="form-label fw-bold">Alamat:</label>
                    <p>{{ $customer->Alamat ?? '-' }}</p>
                </div>
            </div>

            <hr>

            <div class="row text-muted small">
                <div class="col-md-6">
                    <p><strong>Dibuat:</strong> {{ \Carbon\Carbon::parse($customer->CreatedAt)->format('d F Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Diupdate:</strong> {{ \Carbon\Carbon::parse($customer->UpdatedAt)->format('d F Y H:i') }}</p>
                </div>
            </div>
        </div>
        <div class="card-footer bg-light">
            <form action="{{ route('customer.destroy', $customer->IdCustomer) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus customer ini?')">
                    <i class="bi bi-trash"></i> Hapus Customer
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

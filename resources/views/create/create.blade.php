@extends('layouts.app')

@section('title', 'Buat Invoice')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Buat Invoice Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('invoice.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="NoInvoice" class="form-label">No Invoice</label>
                        <input type="text" class="form-control @error('NoInvoice') is-invalid @enderror" 
                               id="NoInvoice" name="NoInvoice" value="{{ old('NoInvoice') }}" 
                               placeholder="Masukkan nomor invoice" required>
                        @error('NoInvoice')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="IdCustomer" class="form-label">Customer</label>
                        <select class="form-select @error('IdCustomer') is-invalid @enderror" 
                                id="IdCustomer" name="IdCustomer" required>
                            <option value="">Pilih Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->IdCustomer }}" {{ old('IdCustomer') == $customer->IdCustomer ? 'selected' : '' }}>
                                    {{ $customer->NamaCustomer }}
                                </option>
                            @endforeach
                        </select>
                        @error('IdCustomer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="Tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control @error('Tanggal') is-invalid @enderror" 
                               id="Tanggal" name="Tanggal" value="{{ old('Tanggal', now()->format('Y-m-d')) }}" required>
                        @error('Tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
                        <a href="{{ route('invoice.index') }}" class="btn btn-secondary btn-modern">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-modern">
                            <i class="fas fa-save me-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

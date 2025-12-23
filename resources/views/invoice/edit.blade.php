@extends('layouts.app')

@section('title', 'Edit Invoice')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Invoice</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('invoice.update', $invoice->NoInvoice) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="NoInvoice" class="form-label">No Invoice</label>
                        <input type="text" class="form-control" id="NoInvoice" 
                               value="{{ $invoice->NoInvoice }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label for="IdCustomer" class="form-label">Customer</label>
                        <select class="form-select @error('IdCustomer') is-invalid @enderror" 
                                id="IdCustomer" name="IdCustomer" required>
                            @forelse($customers as $customer)
                                <option value="{{ $customer->IdCustomer }}" 
                                        {{ $invoice->IdCustomer == $customer->IdCustomer ? 'selected' : '' }}>
                                    {{ $customer->NamaCustomer }}
                                </option>
                            @empty
                                <option disabled>Tidak ada data customer</option>
                            @endforelse
                        </select>
                        @error('IdCustomer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="Tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control @error('Tanggal') is-invalid @enderror" 
                               id="Tanggal" name="Tanggal" value="{{ $invoice->Tanggal }}" required>
                        @error('Tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
                        <a href="{{ route('invoice.index') }}" class="btn btn-secondary btn-modern">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary btn-modern">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

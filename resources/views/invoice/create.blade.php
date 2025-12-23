@extends('layouts.app')

@section('title', 'Buat Invoice Baru')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <h3><i class="fas fa-plus me-2"></i>Invoice Baru</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('invoice.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group mb-3">
                        <label for="NoInvoice" class="form-label">No Invoice</label>
                        <input type="text" class="form-control @error('NoInvoice') is-invalid @enderror" 
                               id="NoInvoice" name="NoInvoice" value="{{ old('NoInvoice') }}" required>
                        @error('NoInvoice')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="IdCustomer" class="form-label">Customer</label>
                        <select class="form-control @error('IdCustomer') is-invalid @enderror" 
                                id="IdCustomer" name="IdCustomer" required>
                            <option value="">-- Pilih Customer --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->IdCustomer }}" {{ old('IdCustomer') == $customer->IdCustomer ? 'selected' : '' }}>
                                    {{ $customer->NamaCustomer }}
                                </option>
                            @endforeach
                        </select>
                        @error('IdCustomer')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="Account" class="form-label">Account (Bank)</label>
                        <select class="form-control @error('Account') is-invalid @enderror" 
                                id="Account" name="Account" required>
                            <option value="">-- Pilih Account Bank --</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->Account }}" {{ old('Account') == $account->Account ? 'selected' : '' }}>
                                    {{ $account->Account }} - {{ $account->NamaBank }}
                                </option>
                            @endforeach
                        </select>
                        @error('Account')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="Tanggal" class="form-label">Tanggal</label>
                        <input type="datetime-local" class="form-control @error('Tanggal') is-invalid @enderror" 
                               id="Tanggal" name="Tanggal" value="{{ old('Tanggal', now()->format('Y-m-d\TH:i')) }}" required>
                        @error('Tanggal')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Invoice
                        </button>
                        <a href="{{ route('invoice.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Daftar Invoice')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3">
            <i class="fas fa-receipt me-2"></i>Daftar Invoice
        </h1>
        <p class="text-muted">Daftar seluruh invoice penyewaan alat berat</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <a href="{{ route('invoice.create') }}" class="btn btn-primary ms-2">
            <i class="fas fa-plus me-2"></i>Invoice Baru
        </a>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Daftar Invoice</h5>
    </div>
    <div class="card-body p-0">
        @if($invoices->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No Invoice</th>
                            <th>Customer</th>
                            <th>Tanggal</th>
                            <th class="text-center pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoices as $invoice)
                        <tr>
                            <td class="ps-4"><strong>{{ $invoice->NoInvoice }}</strong></td>
                            <td>{{ $invoice->NamaCustomer ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->Tanggal)->format('d/m/Y') }}</td>
                            <td class="text-center pe-4">
                                <a href="{{ route('invoice.show', $invoice->NoInvoice) }}" 
                                   class="btn btn-sm btn-info text-white" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('invoice.print', $invoice->NoInvoice) }}" 
                                   class="btn btn-sm btn-secondary" title="Cetak" target="_blank">
                                    <i class="fas fa-print"></i>
                                </a>
                                <a href="{{ route('invoice.edit', $invoice->NoInvoice) }}" 
                                   class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('invoice.destroy', $invoice->NoInvoice) }}" 
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Yakin?')" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-inbox" style="font-size: 3rem;"></i>
                <p class="mt-3">Belum ada invoice</p>
            </div>
        @endif
    </div>
    @if($invoices->count() > 0)
        <div class="card-footer bg-white">
            {{ $invoices->links() }}
        </div>
    @endif
</div>
@endsection

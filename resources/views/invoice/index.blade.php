@extends('layouts.app')

@section('title', 'Daftar Invoice')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h3><i class="fas fa-receipt me-2"></i>Daftar Invoice</h3>
            <a href="{{ route('invoice.create') }}" class="btn btn-primary btn-modern">
                <i class="fas fa-plus me-2"></i>Invoice Baru
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-modern mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">No Invoice</th>
                                <th>Customer</th>
                                <th>Tanggal</th>
                                <th class="pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                            <tr>
                                <td class="ps-4"><strong>{{ $invoice->NoInvoice }}</strong></td>
                                <td>{{ $invoice->NamaCustomer ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($invoice->Tanggal)->format('d/m/Y') }}</td>
                                <td class="pe-4">
                                    <a href="{{ route('invoice.show', $invoice->NoInvoice) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('invoice.print', $invoice->NoInvoice) }}" class="btn btn-sm btn-secondary" title="Cetak" target="_blank">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <a href="{{ route('invoice.edit', $invoice->NoInvoice) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('invoice.destroy', $invoice->NoInvoice) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <i class="fas fa-inbox" style="font-size: 2rem; color: #ddd;"></i>
                                    <p class="text-muted mt-2">Belum ada invoice</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-light">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

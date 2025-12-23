@extends('layouts.app')

@section('title', 'Pending Order')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3"><i class="fas fa-hourglass-half me-2"></i>Pending Order</h1>
        <p class="text-muted">Pesanan customer yang menunggu approval</p>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
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
        <h5 class="mb-0">Daftar Pesanan Pending</h5>
    </div>
    <div class="card-body p-0">
        @if($pendingOrders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No Order</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Tanggal Order</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingOrders as $order)
                        <tr>
                            <td><strong>{{ $order->NoOrder }}</strong></td>
                            <td>{{ $order->NamaCustomer }}</td>
                            <td>{{ $order->Email }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->Tanggal)->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge bg-warning">{{ $order->Status }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('pending-order.show', $order->IdPendingOrder) }}" 
                                   class="btn btn-sm btn-info text-white">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white">
                {{ $pendingOrders->links() }}
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-inbox" style="font-size: 3rem;"></i>
                <p class="mt-3">Tidak ada pesanan pending</p>
            </div>
        @endif
    </div>
</div>
@endsection

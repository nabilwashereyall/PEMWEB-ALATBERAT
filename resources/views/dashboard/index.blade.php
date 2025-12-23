@extends('layouts.app')

@section('title', 'Dashboard - Penyewaan Akomodasi')

@section('content')
<!-- Welcome Header -->
<div class="mb-4">
    <div class="row">
        <div class="col-md-8">
            <h1 class="h3 mb-0">
                <i class="fas fa-chart-line"></i> Dashboard
            </h1>
            <p class="text-muted mt-2">Dashboard Penyewaan Akomodasi - {{ now()->format('d F Y') }}</p>
        </div>
        <div class="col-md-4 text-end d-none d-md-block">
            <i class="fas fa-chart-line" style="font-size: 4rem; opacity: 0.3;"></i>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-bolt"></i> Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <!-- Customers -->
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('customer.index') }}" class="btn btn-primary btn-modern w-100">
                            <i class="fas fa-users"></i> Customers
                        </a>
                    </div>
                    
                    <!-- Penyewaan (Invoice) -->
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('invoice.index') }}" class="btn btn-success btn-modern w-100">
                            <i class="fas fa-shopping-cart"></i> Penyewaan
                        </a>
                    </div>
                    
                    <!-- Alat Berat -->
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('alat-berat.index') }}" class="btn btn-warning btn-modern w-100">
                            <i class="fas fa-tools"></i> Alat Berat
                        </a>
                    </div>
                    
                    <!-- Invoice Baru -->
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('invoice.create') }}" class="btn btn-info btn-modern w-100">
                            <i class="fas fa-plus"></i> Invoice Baru
                        </a>
                    </div>

                    <!-- Pending Order -->
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('pending-order.index') }}" class="btn btn-warning btn-modern w-100 position-relative">
                            <i class="fas fa-hourglass-half"></i> Pending Order
                            @if($totalPendingOrders > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $totalPendingOrders }}
                                </span>
                            @endif
                        </a>
                    </div>

                    <!-- Staff -->
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('staff.index') }}" class="btn btn-danger btn-modern w-100">
                            <i class="fas fa-user-tie"></i> Staff
                        </a>
                    </div>

                    <!-- Bank -->
                    <div class="col-md-3 col-sm-6">
                        <a href="{{ route('bank.index') }}" class="btn btn-secondary btn-modern w-100">
                            <i class="fas fa-university"></i> Bank
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <!-- Total Customers -->
    <div class="col-md-6 col-lg-3">
        <div class="card stat-card h-100">
            <div class="card-body text-center position-relative">
                <i class="fas fa-users icon-stat"></i>
                <div class="stat-label">Total Customers</div>
                <div class="stat-number">{{ number_format($totalCustomers) }}</div>
                <small style="opacity: 0.85;">Registered customers</small>
            </div>
        </div>
    </div>

    <!-- Pending Orders -->
    <div class="col-md-6 col-lg-3">
        <div class="card stat-card stat-card-2 h-100">
            <div class="card-body text-center position-relative">
                <i class="fas fa-hourglass-half icon-stat"></i>
                <div class="stat-label">Pending Orders</div>
                <div class="stat-number">{{ number_format($totalPendingOrders) }}</div>
                <small style="opacity: 0.85;">
                    @if($totalPendingOrders > 0)
                        <a href="{{ route('pending-order.index') }}" class="text-decoration-none">
                            <strong>Lihat detail →</strong>
                        </a>
                    @else
                        No pending orders
                    @endif
                </small>
            </div>
        </div>
    </div>

    <!-- Invoices Today -->
    <div class="col-md-6 col-lg-3">
        <div class="card stat-card stat-card-3 h-100">
            <div class="card-body text-center position-relative">
                <i class="fas fa-file-invoice icon-stat"></i>
                <div class="stat-label">Invoices Today</div>
                <div class="stat-number">{{ number_format($invoicesToday) }}</div>
                <small style="opacity: 0.85;">
                    Last: 
                    @if($lastDate === 'Tidak ada data')
                        N/A
                    @else
                        {{ \Carbon\Carbon::parse($lastDate)->format('d/m/Y') }}
                    @endif
                </small>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue -->
    <div class="col-md-6 col-lg-3">
        <div class="card stat-card stat-card-4 h-100">
            <div class="card-body text-center position-relative">
                <i class="fas fa-money-bill-wave icon-stat"></i>
                <div class="stat-label">Monthly Revenue</div>
                <div class="stat-number" style="font-size: 1.8rem;">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <small style="opacity: 0.85;">{{ now()->format('F Y') }}</small>
            </div>
        </div>
    </div>
</div>

<!-- Rental Items Today Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 0.75rem 0.75rem 0 0;">
                <h5 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Peminjaman Hari Ini
                </h5>
            </div>
            <div class="card-body p-0">
                @if(isset($salesToday) && is_array($salesToday) && count($salesToday) > 0)
                    <div class="table-responsive">
                        <table class="table table-hover table-modern mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4"><i class="fas fa-file-invoice"></i> No Invoice</th>
                                    <th><i class="fas fa-user"></i> Customer</th>
                                    <th><i class="fas fa-tools"></i> Alat Berat</th>
                                    <th class="text-center"><i class="fas fa-list-ol"></i> Jumlah</th>
                                    <th class="text-right"><i class="fas fa-money-bill"></i> Subtotal</th>
                                    <th><i class="fas fa-calendar"></i> Dibuat</th>
                                    <th class="pe-4"><i class="fas fa-sync-alt"></i> Update</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($salesToday as $sale)
                                <tr>
                                    <td class="ps-4">
                                        <a href="{{ route('invoice.show', $sale['NoInvoice']) }}" class="text-decoration-none fw-bold">
                                            {{ $sale['NoInvoice'] }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $sale['NamaCustomer'] }}
                                        </span>
                                    </td>
                                    <td><strong>{{ $sale['Produk'] }}</strong></td>
                                    <td class="text-center">
                                        <span class="badge bg-primary">
                                            {{ $sale['JumlahTerjual'] }} unit
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <strong style="color: #43e97b;">
                                            Rp {{ number_format($sale['TotalHarga'], 0, ',', '.') }}
                                        </strong>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($sale['CreatedAt'])->format('d/m/Y H:i') }}
                                        </small>
                                    </td>
                                    <td class="pe-4">
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($sale['UpdatedAt'])->format('d/m/Y H:i') }}
                                        </small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox" style="font-size: 3rem; color: #ddd;"></i>
                        <h5 class="mt-3 text-muted">Belum ada peminjaman hari ini</h5>
                        <p class="text-muted mb-3">Mulai tambahkan transaksi peminjaman</p>
                        <a href="{{ route('invoice.create') }}" class="btn btn-primary btn-modern">
                            <i class="fas fa-plus"></i> Tambah Peminjaman
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Dashboard - Penyewaan Alat Berat')

@section('content')
<div class="container-fluid">
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Welcome Header --}}
    <div class="mb-4">
        <div class="row">
            <div class="col-md-8">
                <h1 class="h3 mb-0">
                    <i class="fas fa-chart-line"></i> Dashboard
                </h1>
                <p class="text-muted mt-2">
                    Dashboard Penyewaan Alat Berat - {{ now()->format('d F Y') }}
                </p>
            </div>
            <div class="col-md-4 text-end d-none d-md-block">
                <i class="fas fa-chart-line" style="font-size: 4rem; opacity: 0.3;"></i>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-bolt"></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('customer.index') }}" class="btn btn-primary w-100" style="border-radius: 8px; padding: 10px 16px; font-weight: 600;">
                                <i class="fas fa-users"></i> Customers
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('invoice.index') }}" class="btn btn-success w-100" style="border-radius: 8px; padding: 10px 16px; font-weight: 600;">
                                <i class="fas fa-shopping-cart"></i> Penyewaan
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('alat-berat.index') }}" class="btn btn-warning w-100" style="border-radius: 8px; padding: 10px 16px; font-weight: 600;">
                                <i class="fas fa-tools"></i> Alat Berat
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('invoice.create') }}" class="btn btn-info w-100" style="border-radius: 8px; padding: 10px 16px; font-weight: 600;">
                                <i class="fas fa-plus"></i> Invoice Baru
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('pending-order.index') }}" class="btn btn-warning w-100 position-relative" style="border-radius: 8px; padding: 10px 16px; font-weight: 600;">
                                <i class="fas fa-hourglass-half"></i> Pending Order
                                @if($totalPendingOrders > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $totalPendingOrders }}
                                    </span>
                                @endif
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('staff.index') }}" class="btn btn-danger w-100" style="border-radius: 8px; padding: 10px 16px; font-weight: 600;">
                                <i class="fas fa-user-tie"></i> Staff
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('bank.index') }}" class="btn btn-secondary w-100" style="border-radius: 8px; padding: 10px 16px; font-weight: 600;">
                                <i class="fas fa-university"></i> Bank
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card h-100" style="border-top: 4px solid #667eea;">
                <div class="card-body text-center">
                    <i class="fas fa-users" style="font-size: 2.5rem; color: #667eea; margin-bottom: 10px; opacity: 0.8; display: block;"></i>
                    <div style="font-size: 0.9rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin: 10px 0;">
                        Total Customers
                    </div>
                    <div style="font-size: 2rem; font-weight: 700; color: #333;">
                        {{ number_format($totalCustomers) }}
                    </div>
                    <small style="opacity: 0.85;">Registered customers</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card h-100" style="border-top: 4px solid #f5576c;">
                <div class="card-body text-center">
                    <i class="fas fa-hourglass-half" style="font-size: 2.5rem; color: #f5576c; margin-bottom: 10px; opacity: 0.8; display: block;"></i>
                    <div style="font-size: 0.9rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin: 10px 0;">
                        Pending Orders
                    </div>
                    <div style="font-size: 2rem; font-weight: 700; color: #333;">
                        {{ number_format($totalPendingOrders) }}
                    </div>
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

        <div class="col-md-6 col-lg-3">
            <div class="card h-100" style="border-top: 4px solid #00f2fe;">
                <div class="card-body text-center">
                    <i class="fas fa-file-invoice" style="font-size: 2.5rem; color: #00f2fe; margin-bottom: 10px; opacity: 0.8; display: block;"></i>
                    <div style="font-size: 0.9rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin: 10px 0;">
                        Invoices Today
                    </div>
                    <div style="font-size: 2rem; font-weight: 700; color: #333;">
                        {{ number_format($invoicesToday) }}
                    </div>
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

        <div class="col-md-6 col-lg-3">
            <div class="card h-100" style="border-top: 4px solid #43e97b;">
                <div class="card-body text-center">
                    <i class="fas fa-money-bill-wave" style="font-size: 2.5rem; color: #43e97b; margin-bottom: 10px; opacity: 0.8; display: block;"></i>
                    <div style="font-size: 0.9rem; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin: 10px 0;">
                        Monthly Revenue
                    </div>
                    <div style="font-size: 1.8rem; font-weight: 700; color: #333;">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </div>
                    <small style="opacity: 0.85;">{{ now()->format('F Y') }}</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Rental Items Today --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-0"
                     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 0.75rem 0.75rem 0 0;">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Peminjaman Hari Ini
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if(isset($salesToday) && is_array($salesToday) && count($salesToday) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
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
                                            <span class="badge bg-primary">{{ $sale['JumlahTerjual'] }} unit</span>
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
                            <a href="{{ route('invoice.create') }}" class="btn btn-primary"
                               style="border-radius: 8px; padding: 10px 16px; font-weight: 600;">
                                <i class="fas fa-plus"></i> Tambah Peminjaman
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }
        .table-hover tbody tr:hover {
            background: #f8f9fa;
        }
    </style>
</div>
@endsection

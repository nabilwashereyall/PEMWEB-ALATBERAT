@extends('layouts.app')

@section('title', 'Detail Pending Order')

@section('content')
<div class="row mb-4">
    <div class="col-md-8">
        <h1 class="h3"><i class="fas fa-hourglass-half me-2"></i>Detail Pending Order</h1>
    </div>
    <div class="col-md-4 text-end">
        <a href="{{ route('pending-order.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        {{-- Informasi Order --}}
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Informasi Pesanan</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p><strong>No Order:</strong><br>{{ $order->NoOrder }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p><strong>Tanggal Order:</strong><br>{{ \Carbon\Carbon::parse($order->Tanggal)->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p><strong>Customer:</strong><br>{{ $order->NamaCustomer }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p><strong>Email:</strong><br>{{ $order->Email }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <p><strong>No Telepon:</strong><br>{{ $order->NoTelepon ?? '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <p><strong>Status:</strong><br>
                            <span class="badge bg-warning">{{ $order->Status }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Item Pesanan --}}
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Detail Item Pesanan</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Alat Berat</th>
                                <th>Tgl Awal</th>
                                <th>Tgl Akhir</th>
                                <th class="text-center">Durasi</th>
                                <th class="text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td><strong>{{ $item->NamaAlatBerat }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($item->TanggalAwalSewa)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->TanggalAkhirSewa)->format('d/m/Y') }}</td>
                                <td class="text-center">{{ $item->DurasiHari ?? 0 }} hari</td>
                                <td class="text-right"><strong>Rp {{ number_format($item->SubtotalDetail ?? 0, 0, ',', '.') }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Ringkasan & Aksi --}}
    <div class="col-md-4">
        {{-- Ringkasan --}}
        <div class="card mb-3">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Ringkasan Pembayaran</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal:</span>
                    <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                    <span>PPN (10%):</span>
                    <span>Rp {{ number_format($ppn, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <strong>Total:</strong>
                    <strong class="text-success">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                </div>
            </div>
        </div>

        {{-- Tombol Approve / Reject --}}
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Tindakan</h5>
            </div>
            <div class="card-body">
                {{-- Approve Button --}}
                <form action="{{ route('pending-order.approve', $order->IdPendingOrder) }}" 
                      method="POST" class="mb-2">
                    @csrf
                    <button type="submit" class="btn btn-success w-100" 
                            onclick="return confirm('Approve pesanan ini dan convert ke invoice?')">
                        <i class="bi bi-check-circle"></i> Approve Order
                    </button>
                </form>

                {{-- Reject Button (Modal) --}}
                <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" 
                        data-bs-target="#rejectModal">
                    <i class="bi bi-x-circle"></i> Tolak Order
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Reject --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Tolak Pesanan</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pending-order.reject', $order->IdPendingOrder) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="reason" class="form-label">Alasan Penolakan</label>
                        <textarea class="form-control" id="reason" name="reason" 
                                  rows="4" placeholder="Masukkan alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

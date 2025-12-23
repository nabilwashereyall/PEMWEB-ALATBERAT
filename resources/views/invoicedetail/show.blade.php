@extends('layouts.app')

@section('title', 'Detail Invoice - ' . $invoice->NoInvoice)

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <h3><i class="fas fa-file-invoice me-2"></i>Detail Invoice</h3>
            <div>
                <a href="{{ route('invoice.print', $invoice->NoInvoice) }}" class="btn btn-secondary me-2" target="_blank">
                    <i class="fas fa-print me-2"></i>Cetak
                </a>
                <a href="{{ route('invoice.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Informasi Invoice</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>No Invoice:</strong></p>
                        <p class="text-muted">{{ $invoice->NoInvoice }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tanggal:</strong></p>
                        <p class="text-muted">{{ \Carbon\Carbon::parse($invoice->Tanggal)->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Customer:</strong></p>
                        <p class="text-muted">{{ $customer->NamaCustomer ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Account:</strong></p>
                        <p class="text-muted">{{ $invoice->Account }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Status:</strong></p>
                        <span class="badge bg-{{ $invoice->Status == 'Pending' ? 'warning' : ($invoice->Status == 'Completed' ? 'success' : 'secondary') }}">
                            {{ $invoice->Status }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Total Amount:</strong></p>
                        <p class="text-muted" id="totalAmountDisplay">Rp {{ number_format($total, 0, ',', '.') }}</p>
                    </div>
                </div>

                @if($invoice->Keterangan)
                <div class="row">
                    <div class="col-12">
                        <p><strong>Keterangan:</strong></p>
                        <p class="text-muted">{{ $invoice->Keterangan }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Item Invoice</h5>
                <a href="{{ route('invoicedetail.create', $invoice->NoInvoice) }}" class="btn btn-sm btn-light">
                    <i class="fas fa-plus me-1"></i>Tambah Item
                </a>
            </div>
            <div class="card-body p-0">
                @if($items->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Alat Berat</th>
                                    <th>Durasi (Hari)</th>
                                    <th>Tgl Awal Sewa</th>
                                    <th>Tgl Akhir Sewa</th>
                                    <th class="text-right">Subtotal</th>
                                    <th class="pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                <tr>
                                    <td><strong>{{ $item->NamaAlatBerat ?? 'N/A' }}</strong></td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ $item->DurasiHari ?? 0 }} hari</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->TanggalAwalSewa)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->TanggalAkhirSewa)->format('d/m/Y') }}</td>
                                    <td class="text-right">
                                        <strong class="text-success">Rp {{ number_format($item->SubtotalDetail ?? 0, 0, ',', '.') }}</strong>
                                    </td>
                                    <td class="pe-4">
    <a href="{{ route('invoicedetail.edit', [$invoice->NoInvoice, $item->IdAlatBerat]) }}"
       class="btn btn-sm btn-warning" title="Edit Item">
        <i class="fas fa-edit"></i>
    </a>
    <form method="POST"
          action="{{ route('invoicedetail.destroy', [$invoice->NoInvoice, $item->IdAlatBerat]) }}"
          style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger"
                onclick="return confirm('Yakin ingin menghapus item ini?')" title="Hapus Item">
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
                        <p class="mt-3">Belum ada item invoice</p>
                        <a href="{{ route('invoicedetail.create', $invoice->NoInvoice) }}" class="btn btn-primary btn-sm mt-2">
                            <i class="fas fa-plus me-1"></i>Tambah Item Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Ringkasan Pembayaran</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                    <span>Subtotal:</span>
                    <span id="subtotalDisplay">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                    <span>PPN (10%):</span>
                    <span id="ppnDisplay">Rp {{ number_format($ppn, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <strong>Total Pembayaran:</strong>
                    <strong class="text-success fs-5" id="totalDisplay">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                </div>
                
                @if($total > 0)
                    <div class="alert alert-info mt-3 mb-0">
                        <small><i class="fas fa-info-circle me-2"></i>
                        Invoice ini memiliki {{ $items->count() }} item dengan total pembayaran 
                        <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                        </small>
                    </div>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Informasi Sistem</h5>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Dibuat:</strong><br>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($invoice->CreatedAt)->format('d/m/Y H:i') }}</small>
                </p>
                <p class="mb-0"><strong>Diperbarui:</strong><br>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($invoice->UpdatedAt)->format('d/m/Y H:i') }}</small>
                </p>
            </div>
        </div>
    </div>
</div>

<script>
// Refresh data saat halaman dimuat atau setelah tambah item
document.addEventListener('DOMContentLoaded', function() {
    // Data sudah dihitung di server, tidak perlu JS lagi
    console.log('Invoice loaded - Subtotal: Rp {{ number_format($subtotal, 0, ',', '.') }}');
});
</script>

@endsection

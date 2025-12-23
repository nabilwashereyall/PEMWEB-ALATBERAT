<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Invoice {{ $invoice->NoInvoice }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body { font-size: 12px; }
        .invoice-box {
            max-width: 900px;
            margin: 0 auto;
            padding: 15px 25px;
        }
        .table td, .table th {
            padding: 0.35rem 0.5rem;
        }
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>
<div class="invoice-box">

    <div class="no-print mb-3 text-end">
        <button class="btn btn-sm btn-primary" onclick="window.print()">
            Cetak / Print
        </button>
    </div>

    {{-- Header --}}
    <div class="row mb-3">
        <div class="col-8">
            <h4>Penyewaan Akomodasi Alat Berat</h4>
            <p class="mb-0">Jl. Contoh Alamat No. 123<br>
            Telp: 021-12345678</p>
        </div>
        <div class="col-4 text-end">
            <h5 class="mb-1">INVOICE</h5>
            <p class="mb-0"><strong>No:</strong> {{ $invoice->NoInvoice }}</p>
            <p class="mb-0"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($invoice->Tanggal)->format('d/m/Y H:i') }}</p>
        </div>
    </div>

    <hr>

    {{-- Info Customer --}}
    <div class="row mb-3">
        <div class="col-6">
            <h6>Kepada Yth:</h6>
            <p class="mb-0"><strong>{{ $customer->NamaCustomer ?? '-' }}</strong></p>
            @if(!empty($customer->Alamat))
                <p class="mb-0">{{ $customer->Alamat }}</p>
            @endif
            @if(!empty($customer->Kota))
                <p class="mb-0">{{ $customer->Kota }}</p>
            @endif
            @if(!empty($customer->NoTelepon))
                <p class="mb-0">Telp: {{ $customer->NoTelepon }}</p>
            @endif
        </div>
        <div class="col-6 text-end">
            <p class="mb-0"><strong>Account:</strong> {{ $invoice->Account }}</p>
            <p class="mb-0"><strong>Status:</strong> {{ $invoice->Status }}</p>
        </div>
    </div>

    {{-- Tabel Item --}}
    <table class="table table-bordered table-sm">
        <thead class="table-light">
            <tr>
                <th style="width: 5%;">No</th>
                <th>Alat Berat</th>
                <th style="width: 14%;">Tgl Awal</th>
                <th style="width: 14%;">Tgl Akhir</th>
                <th style="width: 10%;" class="text-center">Durasi</th>
                <th style="width: 18%;" class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->NamaAlatBerat ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->TanggalAwalSewa)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->TanggalAkhirSewa)->format('d/m/Y') }}</td>
                    <td class="text-center">
                        {{ $item->DurasiHari ?? 0 }} hari
                    </td>
                    <td class="text-end">
                        Rp {{ number_format($item->SubtotalDetail ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Tidak ada item</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Ringkasan --}}
    @php
        $total = $subtotal + $ppn;
    @endphp

    <div class="row mt-3">
        <div class="col-6">
            @if($invoice->Keterangan)
                <p><strong>Keterangan:</strong><br>{{ $invoice->Keterangan }}</p>
            @endif
        </div>
        <div class="col-6">
            <table class="table table-borderless table-sm mb-0">
                <tr>
                    <td class="text-end">Subtotal:</td>
                    <td class="text-end" style="width: 40%;">
                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td class="text-end">PPN (10%):</td>
                    <td class="text-end">
                        Rp {{ number_format($ppn, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td class="text-end"><strong>Total:</strong></td>
                    <td class="text-end">
                        <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Footer --}}
    <div class="row mt-4">
        <div class="col-6">
            <p class="mb-0"><small>Dicetak: {{ now()->format('d/m/Y H:i') }}</small></p>
        </div>
        <div class="col-6 text-end">
            <p class="mb-0">Hormat kami,</p>
            <br><br>
            <p class="mb-0">(_______________________)</p>
        </div>
    </div>
</div>
</body>
</html>

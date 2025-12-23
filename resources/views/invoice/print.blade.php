<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Invoice - {{ $invoice->NoInvoice }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header {
            border-bottom: 3px solid #2c3e50;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .company-info {
            font-size: 12px;
            color: #7f8c8d;
            line-height: 1.6;
        }

        .invoice-title {
            text-align: right;
            margin-bottom: 20px;
        }

        .invoice-title h2 {
            font-size: 32px;
            color: #e74c3c;
            margin-bottom: 5px;
        }

        .invoice-title p {
            font-size: 14px;
            color: #7f8c8d;
        }

        .invoice-meta {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
            padding: 20px;
            background: #ecf0f1;
            border-radius: 5px;
        }

        .meta-item {
            font-size: 13px;
        }

        .meta-item strong {
            display: block;
            color: #2c3e50;
            margin-bottom: 5px;
            font-size: 12px;
            text-transform: uppercase;
        }

        .meta-item span {
            color: #34495e;
            font-size: 14px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table thead {
            background: #34495e;
            color: white;
        }

        .items-table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #ecf0f1;
            font-size: 13px;
        }

        .items-table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .items-table tbody tr:hover {
            background: #ecf0f1;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .summary {
            width: 400px;
            margin-left: auto;
            margin-bottom: 30px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 13px;
            border-bottom: 1px solid #ecf0f1;
        }

        .summary-row.total {
            background: #ecf0f1;
            padding: 15px;
            margin: 10px 0;
            font-weight: bold;
            font-size: 16px;
            border: 2px solid #e74c3c;
            color: #2c3e50;
        }

        .notes {
            margin-top: 30px;
            padding: 15px;
            background: #ecf0f1;
            border-left: 4px solid #e74c3c;
            border-radius: 3px;
        }

        .notes strong {
            color: #2c3e50;
            display: block;
            margin-bottom: 8px;
            font-size: 12px;
            text-transform: uppercase;
        }

        .notes p {
            color: #34495e;
            font-size: 13px;
            line-height: 1.6;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #ecf0f1;
            text-align: center;
            font-size: 11px;
            color: #7f8c8d;
        }

        .signature-section {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin-top: 40px;
        }

        .signature {
            text-align: center;
        }

        .signature-line {
            border-top: 1px solid #2c3e50;
            padding-top: 40px;
            margin-top: 60px;
            font-weight: 600;
            font-size: 12px;
            color: #2c3e50;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }
            .container {
                box-shadow: none;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }

        .print-button {
            text-align: center;
            margin-bottom: 20px;
        }

        .print-button button {
            background: #3498db;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
        }

        .print-button button:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="print-button no-print">
        <button onclick="window.print()">Cetak Dokumen</button>
        <button onclick="window.history.back()" style="background: #95a5a6; margin-left: 10px;">Kembali</button>
    </div>

    <div class="container">
        <div class="header">
            <div class="company-name">PT. PROWEBVEL</div>
            <div class="company-info">
                Jalan Merdeka No. 123, Jakarta<br>
                Telepon: (021) 1234-5678 | Email: info@prowebvel.com
            </div>
        </div>

        <div class="invoice-title">
            <h2>INVOICE</h2>
            <p>{{ \Carbon\Carbon::parse($invoice->Tanggal)->format('d F Y') }}</p>
        </div>

        <div class="invoice-meta">
            <div class="meta-item">
                <strong>Nomor Invoice</strong>
                <span>{{ $invoice->NoInvoice }}</span>
            </div>
            <div class="meta-item">
                <strong>Tanggal</strong>
                <span>{{ \Carbon\Carbon::parse($invoice->Tanggal)->format('d/m/Y') }}</span>
            </div>
            <div class="meta-item">
                <strong>Customer</strong>
                <span>{{ $customer->NamaCustomer ?? '-' }}</span>
            </div>
            <div class="meta-item">
                <strong>Account</strong>
                <span>{{ $invoice->Account }}</span>
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 40%;">Deskripsi</th>
                    <th style="width: 15%;" class="text-center">Qty</th>
                    <th style="width: 20%;" class="text-right">Harga Satuan</th>
                    <th style="width: 25%;" class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td>{{ $item->NamaAlatBerat ?? 'Item' }}</td>
                    <td class="text-center">{{ $item->QttyDetail ?? 0 }}</td>
                    <td class="text-right">Rp {{ number_format($item->HargaSatuanDetail ?? 0, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item->SubtotalDetail ?? 0, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada item</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="summary">
            <div class="summary-row">
                <span>Subtotal:</span>
                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row">
                <span>PPN (10%):</span>
                <span>Rp {{ number_format($ppn, 0, ',', '.') }}</span>
            </div>
            <div class="summary-row total">
                <span>Total:</span>
                <span>Rp {{ number_format($invoice->TotalAmount, 0, ',', '.') }}</span>
            </div>
        </div>

        @if($invoice->Keterangan)
        <div class="notes">
            <strong>Catatan:</strong>
            <p>{{ $invoice->Keterangan }}</p>
        </div>
        @endif

        <div class="signature-section">
            <div class="signature">
                <p style="font-size: 12px; color: #7f8c8d; margin-bottom: 5px;">Dibuat oleh</p>
                <div class="signature-line"></div>
            </div>
            <div class="signature">
                <p style="font-size: 12px; color: #7f8c8d; margin-bottom: 5px;">Disetujui oleh</p>
                <div class="signature-line"></div>
            </div>
            <div class="signature">
                <p style="font-size: 12px; color: #7f8c8d; margin-bottom: 5px;">Penerima</p>
                <div class="signature-line"></div>
            </div>
        </div>

        <div class="footer">
            <p>Dokumen ini dibuat secara otomatis oleh sistem dan tidak memerlukan tanda tangan asli.</p>
            <p>Terima kasih telah berbisnis dengan kami!</p>
        </div>
    </div>
</body>
</html>

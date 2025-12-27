@extends('layouts.app')

@section('title', 'Tambah Item Invoice')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <h3><i class="fas fa-plus me-2"></i>Tambah Item Invoice</h3>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
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

                <form action="{{ route('invoicedetail.store', $invoice->NoInvoice) }}" method="POST">
                    @csrf
                    
                    <!-- Alat Berat Selection -->
                    <div class="form-group mb-3">
                        <label for="IdAlatBerat" class="form-label">Alat Berat <span class="text-danger">*</span></label>
                        <select class="form-control @error('IdAlatBerat') is-invalid @enderror" 
                                id="IdAlatBerat" name="IdAlatBerat" required onchange="updateHargaSewa()">
                            <option value="">-- Pilih Alat Berat --</option>
                            @foreach($alatBerat as $alat)
                                <option value="{{ $alat->IdAlatBerat }}" 
                                        data-harga="{{ $alat->HargaSewa }}"
                                        {{ old('IdAlatBerat') == $alat->IdAlatBerat ? 'selected' : '' }}>
                                    {{ $alat->NamaAlatBerat }} 
                                    (Rp {{ number_format($alat->HargaSewa, 0, ',', '.') }}/hari)
                                </option>
                            @endforeach
                        </select>
                        @error('IdAlatBerat')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Harga Sewa Per Hari (Read-only) -->
                    <div class="form-group mb-3">
                        <label for="HargaSewaPerHari" class="form-label">Harga Sewa Per Hari</label>
                        <input type="number" class="form-control" 
                               id="HargaSewaPerHari" readonly step="0.01">
                        <small class="text-muted">Harga otomatis terisi saat memilih alat berat</small>
                    </div>

                    <!-- Tanggal Awal Sewa -->
                    <div class="form-group mb-3">
                        <label for="TanggalAwalSewa" class="form-label">Tanggal Awal Sewa <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('TanggalAwalSewa') is-invalid @enderror" 
                               id="TanggalAwalSewa" name="TanggalAwalSewa" value="{{ old('TanggalAwalSewa') }}" 
                               required onchange="hitungSubtotal()">
                        @error('TanggalAwalSewa')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Tanggal Akhir Sewa -->
                    <div class="form-group mb-3">
                        <label for="TanggalAkhirSewa" class="form-label">Tanggal Akhir Sewa <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('TanggalAkhirSewa') is-invalid @enderror" 
                               id="TanggalAkhirSewa" name="TanggalAkhirSewa" value="{{ old('TanggalAkhirSewa') }}" 
                               required onchange="hitungSubtotal()">
                        @error('TanggalAkhirSewa')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Total Hari Sewa (Read-only) -->
                    <div class="form-group mb-3">
                        <label for="TotalHariSewa" class="form-label">Total Hari Sewa</label>
                        <input type="number" class="form-control" 
                               id="TotalHariSewa" readonly min="0">
                        <small class="text-muted">Dihitung otomatis dari tanggal awal dan akhir sewa</small>
                    </div>

                    <!-- Subtotal (Auto-calculated) -->
                    <div class="form-group mb-3">
                        <label for="SubtotalDetail" class="form-label">Subtotal <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('SubtotalDetail') is-invalid @enderror" 
                                   id="SubtotalDetail" name="SubtotalDetail" value="{{ old('SubtotalDetail') }}" 
                                   step="0.01" readonly>
                        </div>
                        <small class="text-muted">Subtotal = Harga Sewa Per Hari × Total Hari Sewa</small>
                        @error('SubtotalDetail')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Summary Box -->
                    <div class="alert alert-info">
                        <strong>Ringkasan Perhitungan:</strong><br>
                        <span id="summaryText">Pilih alat berat dan tanggal sewa untuk melihat perhitungan</span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Item
                        </button>
                        <a href="{{ route('invoice.show', $invoice->NoInvoice) }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Box -->
    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Informasi Invoice</h5>
            </div>
            <div class="card-body">
                <p><strong>No. Invoice:</strong> {{ $invoice->NoInvoice }}</p>
                <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($invoice->Tanggal)->format('d F Y') }}</p>
                <p><strong>Total Saat Ini:</strong> Rp <span id="totalInvoice">0</span></p>
                <hr>
                <p class="text-muted small">Item yang ditambahkan akan otomatis menghitung subtotal berdasarkan:</p>
                <ul class="text-muted small">
                    <li>Harga sewa alat berat per hari</li>
                    <li>Jumlah hari sewa</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk Kalkulasi Otomatis -->
<!-- JavaScript untuk Kalkulasi Otomatis -->
<script>
// Data harga alat berat (dari select options)
const alatBeratData = {
    @foreach($alatBerat as $alat)
        {{ $alat->IdAlatBerat }}: {{ $alat->HargaSewa }},
    @endforeach
};

// Update harga sewa saat alat berat dipilih
function updateHargaSewa() {
    const idAlatBerat = document.getElementById('IdAlatBerat').value;
    const hargaSewaPerHari = alatBeratData[idAlatBerat] || 0;
    
    document.getElementById('HargaSewaPerHari').value = hargaSewaPerHari;
    hitungSubtotal();
}

// Hitung subtotal otomatis
function hitungSubtotal() {
    // Ambil nilai
    const hargaSewaPerHari = parseFloat(document.getElementById('HargaSewaPerHari').value) || 0;
    const tanggalAwal = document.getElementById('TanggalAwalSewa').value;
    const tanggalAkhir = document.getElementById('TanggalAkhirSewa').value;
    
    let totalHariSewa = 0;
    let subtotal = 0;
    
    // Hitung total hari sewa
    if (tanggalAwal && tanggalAkhir) {
        const awal = new Date(tanggalAwal);
        const akhir = new Date(tanggalAkhir);
        
        if (akhir >= awal) {
            // Hitung selisih hari (termasuk hari pertama)
            totalHariSewa = Math.floor((akhir - awal) / (1000 * 60 * 60 * 24)) + 1;
            subtotal = hargaSewaPerHari * totalHariSewa;
        } else {
            alert('Tanggal akhir sewa harus lebih besar atau sama dengan tanggal awal sewa!');
            document.getElementById('TanggalAkhirSewa').value = '';
            totalHariSewa = 0;
            subtotal = 0;
        }
    }
    
    // Update tampilan
    document.getElementById('TotalHariSewa').value = totalHariSewa;
    document.getElementById('SubtotalDetail').value = subtotal;
    
    // Update summary
    if (totalHariSewa > 0) {
        const hargaFormatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(hargaSewaPerHari);
        
        const subtotalFormatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(subtotal);
        
        document.getElementById('summaryText').innerHTML = `
            <strong>${hargaFormatted}</strong> × <strong>${totalHariSewa} hari</strong> = <strong>${subtotalFormatted}</strong>
        `;
    }
}

// TAMBAHAN: Load total invoice dari database
function loadInvoiceTotal() {
    fetch('{{ route("invoice.show", $invoice->NoInvoice) }}')
        .then(response => response.text())
        .then(html => {
            // Parse HTML dan cari total amount
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            // Cari elemen yang berisi total (sesuaikan selector sesuai view invoice.show kamu)
            const totalElement = doc.querySelector('[data-total]') || 
                                doc.querySelector('.invoice-total') ||
                                doc.querySelector('[id*="total"]');
            
            if (totalElement) {
                const totalValue = totalElement.getAttribute('data-total') || 
                                 totalElement.textContent.replace(/[^0-9]/g, '');
                document.getElementById('totalInvoice').textContent = 
                    new Intl.NumberFormat('id-ID').format(totalValue);
            }
        })
        .catch(err => console.log('Could not load invoice total'));
}

// TAMBAHAN: Load dari database langsung dengan AJAX
function loadInvoiceTotalDirect() {
    const noInvoice = '{{ $invoice->NoInvoice }}';
    
    fetch(`/api/invoice/${noInvoice}/total`)
        .then(response => response.json())
        .then(data => {
            if (data.total) {
                document.getElementById('totalInvoice').textContent = 
                    new Intl.NumberFormat('id-ID').format(data.total);
            }
        })
        .catch(err => console.log('Could not load invoice total'));
}

// Initialize saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    updateHargaSewa();
    loadInvoiceTotalDirect(); // Load total dari API
});
</script>


<style>
    .form-label {
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
    }
</style>

@endsection

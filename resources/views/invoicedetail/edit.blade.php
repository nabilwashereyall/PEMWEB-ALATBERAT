@extends('layouts.app')

@section('title', 'Edit Item Invoice')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <h3><i class="fas fa-edit me-2"></i>Edit Item Invoice</h3>
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

                <form action="{{ route('invoicedetail.update', [$invoice->NoInvoice, $item->IdAlatBerat]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    {{-- Alat Berat --}}
                    <div class="form-group mb-3">
                        <label for="IdAlatBerat" class="form-label">Alat Berat</label>
                        <select class="form-control @error('IdAlatBerat') is-invalid @enderror" 
                                id="IdAlatBerat" name="IdAlatBerat" required onchange="updateHargaSewa()">
                            <option value="">-- Pilih Alat Berat --</option>
                            @foreach($alatBerat as $alat)
                                <option value="{{ $alat->IdAlatBerat }}"
                                        data-harga="{{ $alat->HargaSewa }}"
                                        {{ old('IdAlatBerat', $item->IdAlatBerat) == $alat->IdAlatBerat ? 'selected' : '' }}>
                                    {{ $alat->NamaAlatBerat }} (Rp {{ number_format($alat->HargaSewa, 0, ',', '.') }}/hari)
                                </option>
                            @endforeach
                        </select>
                        @error('IdAlatBerat')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Harga sewa per hari (readonly) --}}
                    <div class="form-group mb-3">
                        <label for="HargaSewaPerHari" class="form-label">Harga Sewa Per Hari</label>
                        <input type="number" class="form-control" id="HargaSewaPerHari" readonly step="0.01">
                        <small class="text-muted">Otomatis dari alat berat yang dipilih.</small>
                    </div>

                    {{-- Tanggal awal --}}
                    <div class="form-group mb-3">
                        <label for="TanggalAwalSewa" class="form-label">Tanggal Awal Sewa</label>
                        <input type="date" class="form-control @error('TanggalAwalSewa') is-invalid @enderror" 
                               id="TanggalAwalSewa" name="TanggalAwalSewa" 
                               value="{{ old('TanggalAwalSewa', \Carbon\Carbon::parse($item->TanggalAwalSewa)->format('Y-m-d')) }}"
                               required onchange="hitungSubtotal()">
                        @error('TanggalAwalSewa')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Tanggal akhir --}}
                    <div class="form-group mb-3">
                        <label for="TanggalAkhirSewa" class="form-label">Tanggal Akhir Sewa</label>
                        <input type="date" class="form-control @error('TanggalAkhirSewa') is-invalid @enderror" 
                               id="TanggalAkhirSewa" name="TanggalAkhirSewa" 
                               value="{{ old('TanggalAkhirSewa', \Carbon\Carbon::parse($item->TanggalAkhirSewa)->format('Y-m-d')) }}"
                               required onchange="hitungSubtotal()">
                        @error('TanggalAkhirSewa')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Total hari sewa (readonly) --}}
                    <div class="form-group mb-3">
                        <label for="TotalHariSewa" class="form-label">Total Hari Sewa</label>
                        <input type="number" class="form-control" id="TotalHariSewa" readonly min="0">
                    </div>

                    {{-- Subtotal (readonly, auto calculate) --}}
                    <div class="form-group mb-3">
                        <label for="SubtotalDetail" class="form-label">Subtotal</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control @error('SubtotalDetail') is-invalid @enderror" 
                                   id="SubtotalDetail" name="SubtotalDetail" 
                                   value="{{ old('SubtotalDetail', $item->SubtotalDetail) }}"
                                   step="0.01" readonly>
                        </div>
                        <small class="text-muted">Subtotal = Harga per hari × total hari sewa.</small>
                        @error('SubtotalDetail')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Ringkasan --}}
                    <div class="alert alert-info">
                        <small id="summaryText">Silakan ubah tanggal atau alat berat untuk melihat perhitungan.</small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Item
                        </button>
                        <a href="{{ route('invoice.show', $invoice->NoInvoice) }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- JS kalkulasi otomatis --}}
<script>
    // mapping harga dari blade
    const alatBeratData = {
        @foreach($alatBerat as $alat)
            {{ $alat->IdAlatBerat }}: {{ $alat->HargaSewa }},
        @endforeach
    };

    function updateHargaSewa() {
        const idAlatBerat = document.getElementById('IdAlatBerat').value;
        const harga = alatBeratData[idAlatBerat] || 0;
        document.getElementById('HargaSewaPerHari').value = harga;
        hitungSubtotal();
    }

    function hitungSubtotal() {
        const harga = parseFloat(document.getElementById('HargaSewaPerHari').value) || 0;
        const tAwal = document.getElementById('TanggalAwalSewa').value;
        const tAkhir = document.getElementById('TanggalAkhirSewa').value;

        let hari = 0;
        let subtotal = 0;

        if (tAwal && tAkhir) {
            const awal = new Date(tAwal);
            const akhir = new Date(tAkhir);
            if (akhir >= awal) {
                hari = Math.floor((akhir - awal) / (1000 * 60 * 60 * 24)) + 1;
                subtotal = harga * hari;
            } else {
                alert('Tanggal akhir harus >= tanggal awal');
                document.getElementById('TanggalAkhirSewa').value = '';
            }
        }

        document.getElementById('TotalHariSewa').value = hari;
        document.getElementById('SubtotalDetail').value = subtotal;

        if (hari > 0 && harga > 0) {
            const fmt = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });
            document.getElementById('summaryText').innerHTML =
                fmt.format(harga) + ' × ' + hari + ' hari = <strong>' + fmt.format(subtotal) + '</strong>';
        } else {
            document.getElementById('summaryText').innerText =
                'Silakan pilih alat berat dan tanggal sewa untuk menghitung subtotal.';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        // set harga awal sesuai item yang sedang diedit
        const currentId = '{{ $item->IdAlatBerat }}';
        const harga = alatBeratData[currentId] || 0;
        document.getElementById('HargaSewaPerHari').value = harga;

        // hitung ulang berdasarkan tanggal existing
        hitungSubtotal();
    });
</script>
@endsection

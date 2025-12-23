@extends('layouts.app')

@section('title', 'Pesan Alat Berat')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3"><i class="fas fa-shopping-cart me-2"></i>Pesan Alat Berat</h1>
        <p class="text-muted">Pilih alat yang Anda butuhkan dan tentukan durasi sewa</p>
    </div>
</div>

{{-- Filter Section --}}
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="searchAlat" placeholder="Cari alat berat...">
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="filterTipe">
                            <option value="">Filter Tipe</option>
                            <option value="Excavator">Excavator</option>
                            <option value="Dump Truck">Dump Truck</option>
                            <option value="Roller">Roller</option>
                            <option value="Generator">Generator</option>
                            <option value="Crane">Crane</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="sortHarga">
                            <option value="">Urutkan Harga</option>
                            <option value="asc">Terendah ke Tertinggi</option>
                            <option value="desc">Tertinggi ke Terendah</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Equipment Grid --}}
<div class="row mb-4" id="equipmentContainer">
    @forelse($alatBerat as $alat)
    <div class="col-md-6 col-lg-4 mb-4 equipment-item" data-tipe="{{ $alat->Tipe }}" data-harga="{{ $alat->HargaSewa }}">
        <div class="card h-100 shadow-sm equipment-card">
            {{-- Equipment Image --}}
            <div class="equipment-image" style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-hammer" style="font-size: 4rem; color: white; opacity: 0.8;"></i>
            </div>

            {{-- Equipment Info --}}
            <div class="card-body">
                <h5 class="card-title fw-bold">{{ $alat->NamaAlatBerat }}</h5>
                
                <p class="text-muted small mb-2">
                    <i class="fas fa-tag"></i> {{ $alat->Tipe }}
                </p>

                <p class="text-muted small mb-3">
                    {{ substr($alat->Spesifikasi, 0, 80) }}...
                </p>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-success">
                        <i class="fas fa-check-circle"></i> 
                        {{ $alat->Kondisi }}
                    </span>
                    <strong class="text-primary" style="font-size: 1.2rem;">
                        Rp {{ number_format($alat->HargaSewa, 0, ',', '.') }}
                    </strong>
                </div>

                <hr>

                {{-- Quick Preview Button --}}
                <button class="btn btn-outline-primary w-100 btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $alat->IdAlatBerat }}">
                    <i class="fas fa-eye"></i> Lihat Detail
                </button>
            </div>
        </div>
    </div>

    {{-- Detail Modal --}}
    <div class="modal fade" id="detailModal{{ $alat->IdAlatBerat }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">{{ $alat->NamaAlatBerat }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div style="height: 250px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                                <i class="fas fa-hammer" style="font-size: 5rem; color: white; opacity: 0.8;"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>Tipe:</strong></td>
                                    <td>{{ $alat->Tipe }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Harga/Hari:</strong></td>
                                    <td><strong class="text-success">Rp {{ number_format($alat->HargaSewa, 0, ',', '.') }}</strong></td>
                                </tr>
                                <tr>
                                    <td><strong>Kondisi:</strong></td>
                                    <td><span class="badge bg-success">{{ $alat->Kondisi }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td><span class="badge bg-info">Tersedia</span></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <h6 class="fw-bold">Spesifikasi Lengkap:</h6>
                    <p class="text-muted">{{ $alat->Spesifikasi }}</p>

                    <hr>

                    {{-- Quick Order Form --}}
                    <h6 class="fw-bold mb-3">Pesan Sekarang</h6>
                    <form action="{{ route('customer-order.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="IdAlatBerat" value="{{ $alat->IdAlatBerat }}">

                        <div class="mb-3">
                            <label for="TanggalAwal{{ $alat->IdAlatBerat }}" class="form-label">Tanggal Awal Sewa</label>
                            <input type="date" class="form-control" id="TanggalAwal{{ $alat->IdAlatBerat }}" name="TanggalAwalSewa" required>
                        </div>

                        <div class="mb-3">
                            <label for="TanggalAkhir{{ $alat->IdAlatBerat }}" class="form-label">Tanggal Akhir Sewa</label>
                            <input type="date" class="form-control" id="TanggalAkhir{{ $alat->IdAlatBerat }}" name="TanggalAkhirSewa" required>
                        </div>

                        <div class="alert alert-info">
                            <small>
                                <strong>Durasi:</strong> <span id="durasi{{ $alat->IdAlatBerat }}">-</span> hari<br>
                                <strong>Estimasi Total:</strong> Rp <span id="total{{ $alat->IdAlatBerat }}">0</span>
                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-plus"></i> Tambah ke Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- Empty State --}}
@if($alatBerat->isEmpty())
<div class="col-12">
    <div class="text-center py-5">
        <i class="fas fa-inbox" style="font-size: 3rem; color: #ddd;"></i>
        <h5 class="mt-3 text-muted">Alat berat tidak ditemukan</h5>
    </div>
</div>
@endif

{{-- Shopping Cart Summary --}}
<div class="row mt-5" id="cartSummary" style="display: none;">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Ringkasan Pesanan</h5>
            </div>
            <div class="card-body">
                <table class="table" id="cartTable">
                    <thead>
                        <tr>
                            <th>Alat</th>
                            <th>Durasi</th>
                            <th>Harga/Hari</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="cartBody">
                    </tbody>
                </table>

                <div class="text-end mt-4">
                    <div class="row">
                        <div class="col-6 text-end">
                            <strong>Total Pesanan:</strong>
                        </div>
                        <div class="col-6 text-end">
                            <strong class="text-success" id="cartTotal">Rp 0</strong>
                        </div>
                    </div>

                    <button class="btn btn-success btn-lg mt-3" id="submitOrder">
                        <i class="fas fa-check"></i> Ajukan Pesanan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Calculate duration and total price
    document.addEventListener('change', function(e) {
        if (e.target.name === 'TanggalAwalSewa' || e.target.name === 'TanggalAkhirSewa') {
            const modal = e.target.closest('.modal');
            if (modal) {
                const awalInput = modal.querySelector('input[name="TanggalAwalSewa"]');
                const akhirInput = modal.querySelector('input[name="TanggalAkhirSewa"]');
                
                if (awalInput.value && akhirInput.value) {
                    const awal = new Date(awalInput.value);
                    const akhir = new Date(akhirInput.value);
                    const durasi = Math.floor((akhir - awal) / (1000 * 60 * 60 * 24)) + 1;
                    
                    const hargaText = modal.querySelector('strong.text-success').textContent;
                    const harga = parseInt(hargaText.replace(/[^0-9]/g, ''));
                    const total = durasi * harga;

                    const alatId = modal.querySelector('input[name="IdAlatBerat"]').value;
                    document.getElementById('durasi' + alatId).textContent = durasi;
                    document.getElementById('total' + alatId).textContent = total.toLocaleString('id-ID');
                }
            }
        }
    });

    // Search filter
    document.getElementById('searchAlat').addEventListener('keyup', function() {
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('.equipment-item').forEach(item => {
            const nama = item.querySelector('.card-title').textContent.toLowerCase();
            item.style.display = nama.includes(keyword) ? '' : 'none';
        });
    });

    // Type filter
    document.getElementById('filterTipe').addEventListener('change', function() {
        const tipe = this.value;
        document.querySelectorAll('.equipment-item').forEach(item => {
            item.style.display = !tipe || item.dataset.tipe === tipe ? '' : 'none';
        });
    });

    // Price sort
    document.getElementById('sortHarga').addEventListener('change', function() {
        // Implement sorting logic
    });
</script>
@endsection

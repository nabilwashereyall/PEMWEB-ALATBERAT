@extends('layouts.app')

@section('title', 'Sewa Alat Berat')

@push('styles')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        padding: 40px 20px;
    }

    .hero-section {
        text-align: center;
        color: white;
        margin-bottom: 60px;
    }

    .hero-section h1 {
        font-size: 2.8rem;
        font-weight: 800;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .hero-section p {
        font-size: 1.1rem;
        opacity: 0.9;
        font-weight: 300;
    }

    .container-main {
        max-width: 1400px;
        margin: 0 auto;
    }

    .alerts-wrapper {
        max-width: 1400px;
        margin: 0 auto 30px;
    }

    .catalog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 32px;
        padding: 0 20px;
    }

    @media (max-width: 1024px) {
        .catalog-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
        }
    }

    @media (max-width: 768px) {
        .catalog-grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
        }
        .hero-section h1 {
            font-size: 2rem;
        }
    }

    /* CARD STYLING */
    .equipment-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .equipment-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 60px rgba(102, 126, 234, 0.25);
    }

    .image-wrapper {
        position: relative;
        overflow: hidden;
        height: 220px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .equipment-card:hover .image-wrapper img {
        transform: scale(1.08);
    }

    .price-tag {
        position: absolute;
        top: 14px;
        right: 14px;
        background: rgba(255, 255, 255, 0.95);
        color: #667eea;
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.9rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .card-content {
        padding: 24px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .equipment-name {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 6px;
        line-height: 1.3;
    }

    .equipment-type {
        font-size: 0.9rem;
        color: #6b7280;
        margin-bottom: 12px;
        font-weight: 500;
    }

    .equipment-specs {
        font-size: 0.85rem;
        color: #9ca3af;
        line-height: 1.5;
        margin-bottom: 14px;
        flex-grow: 1;
    }

    .condition-badge {
        display: inline-block;
        font-size: 0.8rem;
        padding: 6px 12px;
        border-radius: 20px;
        background: #ecfdf5;
        color: #047857;
        font-weight: 600;
        margin-bottom: 18px;
    }

    .btn-order-now {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-order-now:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-order-now:active {
        transform: translateY(0);
    }

    /* MODAL STYLING */
    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 24px;
    }

    .modal-header .btn-close {
        filter: invert(1);
    }

    .modal-body {
        padding: 28px;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px 14px;
        font-size: 1rem;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-control:disabled {
        background: #f9fafb;
        color: #6b7280;
    }

    /* PRICE CALCULATION SECTION */
    .price-breakdown {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(118, 75, 162, 0.08) 100%);
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 18px;
        margin: 20px 0;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
        font-size: 0.95rem;
    }

    .price-row:last-child {
        margin-bottom: 0;
    }

    .price-label {
        color: #6b7280;
        font-weight: 500;
    }

    .price-value {
        color: #374151;
        font-weight: 600;
        text-align: right;
        min-width: 140px;
    }

    .price-divider {
        border-top: 1px solid #d1d5db;
        margin: 12px 0;
    }

    .price-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 14px;
        padding-top: 14px;
        border-top: 2px solid #d1d5db;
    }

    .price-total-label {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
    }

    .price-total-value {
        font-size: 1.3rem;
        font-weight: 800;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .duration-info {
        font-size: 0.85rem;
        color: #9ca3af;
        margin-top: 8px;
        font-style: italic;
    }

    .modal-footer {
        padding: 20px 28px;
        border-top: 1px solid #e5e7eb;
    }

    .btn-modal-close {
        padding: 12px 24px;
        border-radius: 10px;
        border: 2px solid #e5e7eb;
        background: white;
        color: #374151;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-modal-close:hover {
        background: #f9fafb;
        border-color: #d1d5db;
    }

    .btn-modal-confirm {
        padding: 12px 32px;
        border-radius: 10px;
        border: none;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-modal-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }

    .form-hint {
        font-size: 0.8rem;
        color: #9ca3af;
        margin-top: 8px;
        line-height: 1.5;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: white;
    }

    .empty-state-icon {
        font-size: 5rem;
        margin-bottom: 20px;
        opacity: 0.8;
    }

    .empty-state-text {
        font-size: 1.3rem;
        opacity: 0.9;
    }

    .tax-badge {
        background: #fef3c7;
        color: #92400e;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="hero-section">
    <h1>🏗️ Sewa Alat Berat Profesional</h1>
    <p>Pilih alat berkualitas tinggi dengan harga terjangkau. Proses pemesanan cepat dan mudah.</p>
</div>

<div class="alerts-wrapper">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>✓ Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>✗ Gagal!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<div class="container-main">
    @if($alatBerat->count() > 0)
        <div class="catalog-grid">
            @foreach($alatBerat as $alat)
                <div class="equipment-card">
                    {{-- IMAGE --}}
                    <div class="image-wrapper">
                        @php
                            $foto = $alat->Foto ?? null;
                        @endphp
                        @if($foto)
                            <img src="{{ asset($foto) }}" alt="{{ $alat->NamaAlatBerat }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?w=600&q=80"
                                 alt="Alat berat">
                        @endif
                        <div class="price-tag">
                            Rp {{ number_format($alat->HargaSewa ?? 0, 0, ',', '.') }}/hari
                        </div>
                    </div>

                    {{-- CONTENT --}}
                    <div class="card-content">
                        <div class="equipment-name">
                            {{ $alat->NamaAlatBerat ?? '-' }}
                        </div>
                        <div class="equipment-type">
                            {{ $alat->Tipe ?? 'Alat Berat' }}
                        </div>

                        @if(!empty($alat->Spesifikasi))
                            <div class="equipment-specs">
                                {{ \Illuminate\Support\Str::limit($alat->Spesifikasi, 100) }}
                            </div>
                        @endif

                        @if(!empty($alat->Kondisi))
                            <span class="condition-badge">
                                ✓ {{ $alat->Kondisi }}
                            </span>
                        @endif

                        <button type="button"
                                class="btn-order-now"
                                data-bs-toggle="modal"
                                data-bs-target="#orderModal{{ $alat->IdAlatBerat }}">
                            Pesan Sekarang →
                        </button>
                    </div>
                </div>

                {{-- MODAL --}}
                <div class="modal fade" id="orderModal{{ $alat->IdAlatBerat }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('customer-order.store') }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" style="font-weight: 700;">
                                        Pesan: {{ $alat->NamaAlatBerat }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-4">
                                        <label class="form-label">Nama Alat</label>
                                        <input type="text" class="form-control"
                                               value="{{ $alat->NamaAlatBerat }}" disabled>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Harga Sewa / Hari</label>
                                        <input type="text" class="form-control harga-sewa"
                                               value="Rp {{ number_format($alat->HargaSewa ?? 0, 0, ',', '.') }}"
                                               data-harga="{{ $alat->HargaSewa ?? 0 }}"
                                               disabled>
                                    </div>

                                    <input type="hidden" name="IdAlatBerat" value="{{ $alat->IdAlatBerat }}">

                                    <div class="row g-3 mb-4">
                                        <div class="col-6">
                                            <label class="form-label">📅 Tanggal Awal</label>
                                            <input type="date" name="TanggalAwalSewa" 
                                                   class="form-control tanggal-awal"
                                                   data-modal-id="{{ $alat->IdAlatBerat }}"
                                                   required>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">📅 Tanggal Akhir</label>
                                            <input type="date" name="TanggalAkhirSewa" 
                                                   class="form-control tanggal-akhir"
                                                   data-modal-id="{{ $alat->IdAlatBerat }}"
                                                   required>
                                        </div>
                                    </div>

                                    {{-- PRICE BREAKDOWN --}}
                                    <div class="price-breakdown">
                                        <div class="price-row">
                                            <span class="price-label">Durasi Sewa</span>
                                            <span class="price-value durasi-display" data-modal-id="{{ $alat->IdAlatBerat }}">
                                                0 hari
                                            </span>
                                        </div>
                                        <div class="price-row">
                                            <span class="price-label">Subtotal</span>
                                            <span class="price-value subtotal-display" data-modal-id="{{ $alat->IdAlatBerat }}">
                                                Rp 0
                                            </span>
                                        </div>
                                        <div class="price-row">
                                            <span class="price-label">Pajak (11%) <span class="tax-badge">PPN</span></span>
                                            <span class="price-value pajak-display" data-modal-id="{{ $alat->IdAlatBerat }}">
                                                Rp 0
                                            </span>
                                        </div>
                                        <div class="price-total">
                                            <span class="price-total-label">Total Bayar</span>
                                            <span class="price-total-value total-display" data-modal-id="{{ $alat->IdAlatBerat }}">
                                                Rp 0
                                            </span>
                                        </div>
                                        <div class="duration-info" data-modal-id="{{ $alat->IdAlatBerat }}">
                                            📌 Pilih tanggal awal dan akhir untuk melihat total biaya
                                        </div>
                                    </div>

                                    <div class="mb-4">
    <label class="form-label">💳 Rekening Pembayaran</label>
    <select name="Account" class="form-control" required>
        <option value="">-- Pilih Rekening --</option>
        @foreach (DB::table('Bank')->get() as $bank)
            <option value="{{ $bank->Account }}">
                {{ $bank->NamaBank }} - {{ $bank->Account }} 
                @if($bank->NomorRekening)
                    - No. {{ $bank->NomorRekening }}
                @endif
            </option>
        @endforeach
    </select>
</div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn-modal-close" data-bs-dismiss="modal">
                                        Batal
                                    </button>
                                    <button type="submit" class="btn-modal-confirm">
                                        Konfirmasi Pesanan ✓
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📦</div>
            <p class="empty-state-text">Belum ada alat yang tersedia saat ini</p>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function formatCurrency(num) {
            return 'Rp ' + num.toLocaleString('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            });
        }

        function calculatePrice(modalId) {
            // Ambil semua element berdasarkan modal ID
            const tanggalAwal = document.querySelector(`.tanggal-awal[data-modal-id="${modalId}"]`);
            const tanggalAkhir = document.querySelector(`.tanggal-akhir[data-modal-id="${modalId}"]`);
            
            // PENTING: ambil harga dari parent modal
            const modal = document.getElementById(`orderModal${modalId}`);
            const hargaInput = modal.querySelector('.harga-sewa');
            const hargaSewa = parseFloat(hargaInput.getAttribute('data-harga')) || 0;

            const durasiDisplay = document.querySelector(`.durasi-display[data-modal-id="${modalId}"]`);
            const subtotalDisplay = document.querySelector(`.subtotal-display[data-modal-id="${modalId}"]`);
            const pajakDisplay = document.querySelector(`.pajak-display[data-modal-id="${modalId}"]`);
            const totalDisplay = document.querySelector(`.total-display[data-modal-id="${modalId}"]`);
            const durationInfo = document.querySelector(`.duration-info[data-modal-id="${modalId}"]`);

            if (tanggalAwal && tanggalAkhir && tanggalAwal.value && tanggalAkhir.value) {
                const awal = new Date(tanggalAwal.value);
                const akhir = new Date(tanggalAkhir.value);
                
                // Hitung durasi (pastikan minimal 1 hari)
                let durasi = Math.ceil((akhir - awal) / (1000 * 60 * 60 * 24)) + 1;
                if (durasi < 1) durasi = 1;

                // Hitung subtotal
                const subtotal = hargaSewa * durasi;

                // Hitung pajak (11%)
                const pajak = subtotal * 0.11;

                // Hitung total
                const total = subtotal + pajak;

                // Update tampilan
                durasiDisplay.textContent = durasi + ' hari';
                subtotalDisplay.textContent = formatCurrency(subtotal);
                pajakDisplay.textContent = formatCurrency(pajak);
                totalDisplay.textContent = formatCurrency(total);
                durationInfo.textContent = '✓ Total untuk ' + durasi + ' hari sewa';
            } else {
                // Reset jika tanggal tidak lengkap
                durasiDisplay.textContent = '0 hari';
                subtotalDisplay.textContent = 'Rp 0';
                pajakDisplay.textContent = 'Rp 0';
                totalDisplay.textContent = 'Rp 0';
                durationInfo.textContent = '📌 Pilih tanggal awal dan akhir untuk melihat total biaya';
            }
        }

        // Event listener untuk semua input tanggal
        const tanggalAwals = document.querySelectorAll('.tanggal-awal');
        const tanggalAkhirs = document.querySelectorAll('.tanggal-akhir');

        tanggalAwals.forEach(input => {
            input.addEventListener('change', function() {
                const modalId = this.getAttribute('data-modal-id');
                calculatePrice(modalId);
            });
        });

        tanggalAkhirs.forEach(input => {
            input.addEventListener('change', function() {
                const modalId = this.getAttribute('data-modal-id');
                calculatePrice(modalId);
            });
        });
    });
</script>
@endpush


@endsection

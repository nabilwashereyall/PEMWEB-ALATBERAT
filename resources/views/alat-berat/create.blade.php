@extends('layouts.app')
@section('title', 'Tambah Alat Berat')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3">Tambah Alat Berat Baru</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('alat-berat.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('alat-berat.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="NamaAlatBerat" class="form-label">Nama Alat Berat <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('NamaAlatBerat') is-invalid @enderror" 
                           id="NamaAlatBerat" name="NamaAlatBerat" value="{{ old('NamaAlatBerat') }}" required>
                    @error('NamaAlatBerat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="Tipe" class="form-label">Tipe</label>
                    <input type="text" class="form-control @error('Tipe') is-invalid @enderror" 
                           id="Tipe" name="Tipe" value="{{ old('Tipe') }}" placeholder="Misal: Excavator, Bulldozer">
                    @error('Tipe')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="Spesifikasi" class="form-label">Spesifikasi</label>
                    <textarea class="form-control @error('Spesifikasi') is-invalid @enderror" 
                              id="Spesifikasi" name="Spesifikasi" rows="3" placeholder="Misal: 20 Ton, Diesel">{{ old('Spesifikasi') }}</textarea>
                    @error('Spesifikasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="HargaSewa" class="form-label">Harga Sewa <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control @error('HargaSewa') is-invalid @enderror" 
                               id="HargaSewa" name="HargaSewa" value="{{ old('HargaSewa') }}" step="1000" min="0" required>
                    </div>
                    @error('HargaSewa')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="Kondisi" class="form-label">Kondisi</label>
                    <select class="form-select @error('Kondisi') is-invalid @enderror" id="Kondisi" name="Kondisi">
                        <option value="">-- Pilih Kondisi --</option>
                        <option value="Baik" {{ old('Kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak Ringan" {{ old('Kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ old('Kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                    @error('Kondisi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Simpan
                    </button>
                    <a href="{{ route('alat-berat.index') }}" class="btn btn-light">
                        <i class="bi bi-x-circle"></i> Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

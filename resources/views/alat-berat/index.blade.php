@extends('layouts.app')
@section('title', 'Daftar Alat Berat')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3">Data Alat Berat</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('alat-berat.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Alat Berat
            </a>
        </div>
    </div>

    @if ($message = session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Alat Berat</th>
                            <th>Tipe</th>
                            <th>Harga Sewa</th>
                            <th>Kondisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($alatBerat as $alat)
                            <tr>
                                <td>{{ ($alatBerat->currentPage() - 1) * $alatBerat->perPage() + $loop->iteration }}</td>
                                <td><strong>{{ $alat->NamaAlatBerat }}</strong></td>
                                <td><span class="badge bg-secondary">{{ $alat->Tipe ?? '-' }}</span></td>
                                <td>Rp {{ number_format($alat->HargaSewa, 0, ',', '.') }}</td>
                                <td>
                                    @if ($alat->Kondisi == 'Baik')
                                        <span class="badge bg-success">{{ $alat->Kondisi }}</span>
                                    @elseif ($alat->Kondisi == 'Rusak Ringan')
                                        <span class="badge bg-warning">{{ $alat->Kondisi }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $alat->Kondisi ?? '-' }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('alat-berat.show', $alat->IdAlatBerat) }}" class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('alat-berat.edit', $alat->IdAlatBerat) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('alat-berat.destroy', $alat->IdAlatBerat) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Tidak ada data alat berat</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $alatBerat->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

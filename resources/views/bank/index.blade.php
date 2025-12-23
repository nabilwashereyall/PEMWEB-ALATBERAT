@extends('layouts.app')
@section('title', 'Daftar Bank')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3">Data Bank</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('bank.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Bank
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
                            <th>Account</th>
                            <th>Nama Bank</th>
                            <th>No. Rekening</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($banks as $bank)
                            <tr>
                                <td>{{ ($banks->currentPage() - 1) * $banks->perPage() + $loop->iteration }}</td>
                                <td><span class="badge bg-info">{{ $bank->Account }}</span></td>
                                <td><strong>{{ $bank->NamaBank }}</strong></td>
                                <td>{{ $bank->NomorRekening ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('bank.show', $bank->Account) }}" class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('bank.edit', $bank->Account) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('bank.destroy', $bank->Account) }}" method="POST" style="display: inline;">
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
                                <td colspan="5" class="text-center py-4 text-muted">Tidak ada data bank</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $banks->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

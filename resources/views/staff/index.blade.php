@extends('layouts.app')
@section('title', 'Daftar Staff')
@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3 d-inline-block">Data Staff</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('staff.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Staff
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
                            <th>Nama Staff</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($staff as $item)
                            <tr>
                                <td>{{ ($staff->currentPage() - 1) * $staff->perPage() + $loop->iteration }}</td>
                                <td><strong>{{ $item->NamaStaff }}</strong></td>
                                <td>{{ $item->Email }}</td>
                                <td>{{ $item->NoTelepon ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->CreatedAt)->format('d F Y') }}</td>
                                <td>
                                    <a href="{{ route('staff.show', $item->IdStaff) }}" class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('staff.edit', $item->IdStaff) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('staff.destroy', $item->IdStaff) }}" method="POST" style="display: inline;">
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
                                <td colspan="6" class="text-center py-4 text-muted">
                                    Tidak ada data staff
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $staff->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Daftar Customer')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="h3">Data Customer</h1>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('customer.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Customer
            </a>
        </div>
    </div>

    @if ($message = session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Card + tabel berada di tengah area konten --}}
    <div class="card mx-auto" style="max-width: 1200px;">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Customer</th>
                            <th>Email</th>
                            <th>No. Telepon</th>
                            <th>Kota</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $customer)
                            <tr>
                                <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}</td>
                                <td><strong>{{ $customer->NamaCustomer }}</strong></td>
                                <td>{{ $customer->Email ?? '-' }}</td>
                                <td>{{ $customer->NoTelepon ?? '-' }}</td>
                                <td>{{ $customer->Kota ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('customer.show', $customer->IdCustomer) }}" class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('customer.edit', $customer->IdCustomer) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('customer.destroy', $customer->IdCustomer) }}" method="POST" style="display:inline;">
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
                                <td colspan="6" class="text-center py-4 text-muted">Tidak ada data customer</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

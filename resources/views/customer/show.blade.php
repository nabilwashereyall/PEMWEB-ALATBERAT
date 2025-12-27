<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Customer - Penyewaan Alat Berat</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            padding-top: 60px;
            padding-left: 260px;
        }

        /* NAVBAR */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            z-index: 1030;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            height: 60px;
        }

        .navbar-brand { font-weight: 700; font-size: 1.3rem; color: white !important; }
        .navbar .nav-link { color: rgba(255,255,255,0.8) !important; transition: 0.3s; }
        .navbar .nav-link:hover { color: white !important; }
        .navbar .dropdown-menu { background: #f8f9fa; border: none; border-radius: 8px; }
        .navbar .dropdown-item:hover { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            left: 0;
            top: 60px;
            width: 260px;
            height: calc(100vh - 60px);
            background: white;
            border-right: 1px solid #e0e0e0;
            padding: 20px 0;
            overflow-y: auto;
            z-index: 1020;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
        }

        .sidebar .nav-link {
            color: #666;
            padding: 12px 20px;
            font-weight: 500;
            border-left: 3px solid transparent;
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 5px 0;
            transition: all 0.3s;
            text-decoration: none;
        }

        .sidebar .nav-link:hover {
            background: #f8f9fa;
            color: #667eea;
            border-left-color: #667eea;
        }

        .sidebar .nav-link.active {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            border-left-color: #667eea;
        }

        .sidebar .nav-link i { width: 20px; text-align: center; }

        .sidebar-title {
            padding: 15px 20px;
            font-weight: 700;
            font-size: 0.85rem;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 15px;
        }

        .main-content {
            padding: 30px;
            min-height: calc(100vh - 60px);
        }

        .card { border: none; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }

        @media (max-width: 768px) {
            body { padding-left: 0; }
            .sidebar { transform: translateX(-100%); transition: 0.3s; width: 260px; }
            .sidebar.active { transform: translateX(0); }
        }

        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-thumb { background: #ddd; border-radius: 3px; }
    </style>
</head>
<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-gears"></i> Penyewaan Alat Berat
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> {{ Auth::user()->Username ?? 'User' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Pengaturan</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="cursor: pointer; border: none; background: none; width: 100%; text-align: left;">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-title">Menu Utama</div>
        <a href="{{ route('dashboard') }}" class="nav-link">
            <i class="fas fa-chart-line"></i> <span>Dashboard</span>
        </a>

        <div class="sidebar-title">Data Master</div>
        <a href="{{ route('customer.index') }}" class="nav-link active">
            <i class="fas fa-users"></i> <span>Customers</span>
        </a>
        <a href="{{ route('alat-berat.index') }}" class="nav-link">
            <i class="fas fa-tools"></i> <span>Alat Berat</span>
        </a>
        <a href="{{ route('staff.index') }}" class="nav-link">
            <i class="fas fa-user-tie"></i> <span>Staff</span>
        </a>
        <a href="{{ route('bank.index') }}" class="nav-link">
            <i class="fas fa-university"></i> <span>Bank</span>
        </a>

        <div class="sidebar-title">Transaksi</div>
        <a href="{{ route('invoice.index') }}" class="nav-link">
            <i class="fas fa-file-invoice"></i> <span>Invoice</span>
        </a>
        <a href="{{ route('pending-order.index') }}" class="nav-link">
            <i class="fas fa-hourglass-half"></i> <span>Pending Order</span>
        </a>
        <a href="{{ route('invoice.create') }}" class="nav-link">
            <i class="fas fa-plus-circle"></i> <span>Invoice Baru</span>
        </a>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="h3 mb-0">
                    <i class="fas fa-user-circle"></i> Detail Customer
                </h1>
                <p class="text-muted mt-2">Informasi lengkap tentang customer</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('customer.index') }}" class="btn btn-secondary me-2" style="border-radius: 8px;">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <a href="{{ route('customer.edit', $customer->IdCustomer) }}" class="btn btn-warning" style="border-radius: 8px;">
                    <i class="fas fa-pencil"></i> Edit
                </a>
            </div>
        </div>

        <!-- Main Card -->
        <div class="card" style="border: none; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <!-- Card Header -->
            <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 12px 12px 0 0;">
                <h5 class="mb-0">
                    <i class="fas fa-building"></i> {{ $customer->NamaCustomer }}
                </h5>
            </div>

            <!-- Card Body -->
            <div class="card-body" style="padding: 30px;">
                <!-- Row 1: ID & Nama -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div style="padding: 15px; background: #f8f9fa; border-radius: 8px;">
                            <label style="font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 5px;">
                                <i class="fas fa-id-card"></i> ID Customer
                            </label>
                            <p style="font-size: 1.1rem; color: #333; margin: 0;">{{ $customer->IdCustomer }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="padding: 15px; background: #f8f9fa; border-radius: 8px;">
                            <label style="font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 5px;">
                                <i class="fas fa-store"></i> Nama Customer
                            </label>
                            <p style="font-size: 1.1rem; color: #333; margin: 0;">{{ $customer->NamaCustomer }}</p>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Email & Telepon -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div style="padding: 15px; background: #f8f9fa; border-radius: 8px;">
                            <label style="font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 5px;">
                                <i class="fas fa-envelope"></i> Email
                            </label>
                            <p style="font-size: 1.1rem; color: #333; margin: 0;">
                                @if($customer->Email)
                                    <a href="mailto:{{ $customer->Email }}" class="text-decoration-none">{{ $customer->Email }}</a>
                                @else
                                    <span class="badge bg-light text-muted">-</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div style="padding: 15px; background: #f8f9fa; border-radius: 8px;">
                            <label style="font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 5px;">
                                <i class="fas fa-phone"></i> No. Telepon
                            </label>
                            <p style="font-size: 1.1rem; color: #333; margin: 0;">
                                @if($customer->NoTelepon)
                                    <a href="tel:{{ $customer->NoTelepon }}" class="text-decoration-none">{{ $customer->NoTelepon }}</a>
                                @else
                                    <span class="badge bg-light text-muted">-</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Row 3: Kota -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div style="padding: 15px; background: #f8f9fa; border-radius: 8px;">
                            <label style="font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 5px;">
                                <i class="fas fa-map-marker-alt"></i> Kota
                            </label>
                            <p style="font-size: 1.1rem; color: #333; margin: 0;">
                                @if($customer->Kota)
                                    {{ $customer->Kota }}
                                @else
                                    <span class="badge bg-light text-muted">-</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Row 4: Alamat Lengkap -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div style="padding: 15px; background: #f8f9fa; border-radius: 8px;">
                            <label style="font-weight: 700; color: #667eea; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 5px;">
                                <i class="fas fa-location-dot"></i> Alamat Lengkap
                            </label>
                            <p style="font-size: 1rem; color: #333; margin: 0; line-height: 1.6;">
                                @if($customer->Alamat)
                                    {{ $customer->Alamat }}
                                @else
                                    <span class="badge bg-light text-muted">-</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <hr style="margin: 30px 0; border: none; border-top: 1px solid #e0e0e0;">

                <!-- Timestamp Info -->
                <div class="row text-muted small">
                    <div class="col-md-6">
                        <p style="margin: 0;">
                            <strong><i class="fas fa-calendar-plus"></i> Dibuat:</strong><br>
                            {{ \Carbon\Carbon::parse($customer->CreatedAt)->format('d F Y H:i') }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p style="margin: 0;">
                            <strong><i class="fas fa-calendar-check"></i> Diupdate:</strong><br>
                            {{ \Carbon\Carbon::parse($customer->UpdatedAt)->format('d F Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card Footer -->
            <div class="card-footer" style="background: #f8f9fa; border-top: 1px solid #e0e0e0; border-radius: 0 0 12px 12px;">
                <form action="{{ route('customer.destroy', $customer->IdCustomer) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="border-radius: 8px; padding: 10px 20px;" onclick="return confirm('Yakin ingin menghapus customer ini? Tindakan ini tidak dapat dibatalkan!')">
                        <i class="fas fa-trash"></i> Hapus Customer
                    </button>
                </form>
                <a href="{{ route('customer.edit', $customer->IdCustomer) }}" class="btn btn-primary" style="border-radius: 8px; padding: 10px 20px; margin-left: 10px;">
                    <i class="fas fa-edit"></i> Edit Customer
                </a>
            </div>
        </div>
    </div>

    <style>
        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
        }

        a {
            transition: all 0.3s ease;
        }

        a:hover {
            color: #667eea !important;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

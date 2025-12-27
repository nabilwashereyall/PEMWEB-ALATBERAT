{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Penyewaan Alat Berat')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
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
        .navbar .dropdown-item:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

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

        /* MAIN CONTENT */
        .main-content {
            padding: 30px;
            min-height: calc(100vh - 60px);
            margin-top: 60px;
            margin-left: 260px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: 0.3s;
                width: 260px;
            }
            .sidebar.active { transform: translateX(0); }
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
        }

        .sidebar::-webkit-scrollbar { width: 6px; }
        .sidebar::-webkit-scrollbar-thumb { background: #ddd; border-radius: 3px; }
    </style>

    @stack('styles')
</head>
<body>
@php
    // halaman tanpa navbar+sidebar
    $hideLayout = request()->routeIs('login') ||
                  request()->routeIs('register') ||
                  request()->routeIs('customer-order.*');

    $sessionUsername = session('username');
@endphp

@if (! $hideLayout)
    {{-- NAVBAR --}}
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
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a>
                    </li>
                    @if($sessionUsername)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                               role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> {{ $sessionUsername }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button class="dropdown-item" type="submit">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    {{-- SIDEBAR --}}
    <aside class="sidebar">
        <div class="sidebar-title">Menu Utama</div>
        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> <span>Dashboard</span>
        </a>

        <div class="sidebar-title">Data Master</div>
        <a href="{{ route('customer.index') }}"
           class="nav-link {{ request()->routeIs('customer.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> <span>Customers</span>
        </a>
        <a href="{{ route('alat-berat.index') }}"
           class="nav-link {{ request()->routeIs('alat-berat.*') ? 'active' : '' }}">
            <i class="fas fa-tools"></i> <span>Alat Berat</span>
        </a>
        <a href="{{ route('staff.index') }}"
           class="nav-link {{ request()->routeIs('staff.*') ? 'active' : '' }}">
            <i class="fas fa-user-tie"></i> <span>Staff</span>
        </a>
        <a href="{{ route('bank.index') }}"
           class="nav-link {{ request()->routeIs('bank.*') ? 'active' : '' }}">
            <i class="fas fa-university"></i> <span>Bank</span>
        </a>

        <div class="sidebar-title">Transaksi</div>
        <a href="{{ route('invoice.index') }}"
           class="nav-link {{ request()->routeIs('invoice.index') ? 'active' : '' }}">
            <i class="fas fa-file-invoice"></i> <span>Invoice</span>
        </a>
        <a href="{{ route('pending-order.index') }}"
           class="nav-link {{ request()->routeIs('pending-order.*') ? 'active' : '' }}">
            <i class="fas fa-hourglass-half"></i> <span>Pending Order</span>
        </a>
        <a href="{{ route('invoice.create') }}"
           class="nav-link {{ request()->routeIs('invoice.create') ? 'active' : '' }}">
            <i class="fas fa-plus-circle"></i> <span>Invoice Baru</span>
        </a>
    </aside>
@endif

    <main class="main-content {{ $hideLayout ? 'p-0 m-0' : '' }}">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>

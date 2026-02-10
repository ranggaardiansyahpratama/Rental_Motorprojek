<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - RentMotor</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f7fe;
        }

        /* Sidebar Styles */
        .sidebar {
            background-color: #3b5bdb; 
            min-height: 100vh;
            width: 240px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
        }

        .sidebar-brand {
            padding: 1.5rem;
            color: white;
            font-weight: 800;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }

        .sidebar-menu {
            padding-top: 1rem;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            transition: all 0.2s;
            text-decoration: none;
        }

        .menu-item:hover, .menu-item.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .menu-item i {
            width: 24px;
            font-size: 14px;
            margin-right: 10px;
        }

        .menu-item .chevron {
            margin-left: auto;
            font-size: 10px;
        }

        .collapse-btn {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            width: 32px;
            height: 32px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
        }

        /* Main Content */
        .main-content {
            margin-left: 240px;
            padding: 1.5rem 2rem;
        }

        .header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 2rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-name {
            font-size: 0.8rem;
            color: #718096;
            font-weight: 500;
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #e2e8f0;
            overflow: hidden;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 1.5rem;
        }

        /* Stats Cards */
        .stats-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 4px;
            padding: 1.25rem 1.5rem;
            flex: 1;
            min-width: 240px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            border-left: 4px solid #3b82f6;
        }

        .stat-card.blue { border-left-color: #3b82f6; }
        .stat-card.indigo { border-left-color: #4f46e5; }
        .stat-card.yellow { border-left-color: #f59e0b; }
        .stat-card.mint { border-left-color: #10b981; }
        .stat-card.green { border-left-color: #22c55e; }

        .stat-info .stat-label {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }
        .stat-card.blue .stat-label { color: #3b82f6; }
        .stat-card.indigo .stat-label { color: #4f46e5; }
        .stat-card.yellow .stat-label { color: #f59e0b; }
        .stat-card.mint .stat-label { color: #10b981; }
        .stat-card.green .stat-label { color: #22c55e; }

        .stat-info .stat-value {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2d3748;
        }

        .stat-icon {
            color: #e2e8f0;
            font-size: 1.75rem;
        }

        /* Card / Table Style */
        .card-table {
            background: white;
            border-radius: 4px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        @media (max-width: 768px) {
            .sidebar { width: 0; overflow: hidden; }
            .main-content { margin-left: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            Rental Motor
        </div>
        <div class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-home"></i>
                Dashboard
            </a>
            <a href="{{ route('admin.motors.index') }}" class="menu-item {{ request()->routeIs('admin.motors.*') ? 'active' : '' }}">
                <i class="fas fa-motorcycle"></i>
                Kelola Motor
            </a>
            <a href="{{ route('admin.users.index') }}" class="menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                Kelola User
            </a>
            <a href="{{ route('admin.rentals.index') }}" class="menu-item {{ request()->routeIs('admin.rentals.*') ? 'active' : '' }}">
                <i class="fas fa-exchange-alt"></i>
                Penyewaan
            </a>
            <a href="{{ route('admin.payments.index') }}" class="menu-item {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                <i class="fas fa-dollar-sign"></i>
                Pembayaran
            </a>
            <a href="{{ route('admin.reports.total-revenue') }}" class="menu-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                Laporan
            </a>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="collapse-btn">
            @csrf
            <button type="submit" class="text-white hover:text-red-300">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="user-profile">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-avatar">
                   <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="Avatar">
                </div>
            </div>
        </div>

        @yield('content')

        <div class="mt-12 text-center text-xs text-gray-400">
            Copyright &copy; Rental Motor {{ date('Y') }}
        </div>
    </div>

    @stack('scripts')
</body>
</html>

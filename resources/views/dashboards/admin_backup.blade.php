<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - RentMotor</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .sidebar {
            background: #1f2937;
            min-height: 100vh;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #374151;
        }

        .sidebar-menu {
            padding: 1rem 0;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.875rem 1.5rem;
            color: #d1d5db;
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .menu-item:hover {
            background-color: #374151;
            color: #ffffff;
            border-left-color: #6366f1;
        }

        .menu-item.active {
            background-color: #4f46e5;
            color: #ffffff;
            border-left-color: #6366f1;
        }

        .menu-item i {
            width: 20px;
            margin-right: 0.75rem;
            font-size: 16px;
        }

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }

        .top-bar {
            background: #ffffff;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .content-area {
            padding: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 20px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 1.5rem;
        }

        .menu-section {
            margin-bottom: 2rem;
        }

        .menu-section-title {
            color: #9ca3af;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 0 1.5rem;
            margin-bottom: 0.5rem;
        }

        .project-table {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            border: 1px solid #e5e7eb;
        }

        .table-header {
            background: #f9fafb;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .table-content {
            padding: 1.5rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #6366f1;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
        }

        .btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: #4f46e5;
            color: white;
        }

        .btn-primary:hover {
            background: #4338ca;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #374151;
        }

        .btn-secondary:hover {
            background: #d1d5db;
        }

        .notification-dot {
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            margin-left: auto;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <h2 class="text-xl font-bold text-white">RentMotor Admin</h2>
        </div>

        <!-- Sidebar Menu -->
        <nav class="sidebar-menu">
            <!-- Dashboard Section -->
            <div class="menu-section">
                <a href="{{ route('admin.dashboard') }}" class="menu-item active">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </div>

            <!-- CRUD Section -->
            <div class="menu-section">
                <div class="menu-section-title">CRUD Management</div>
                
                <a href="{{ route('admin.users.index') }}" class="menu-item">
                    <i class="fas fa-users"></i>
                    CRUD Data User
                </a>
                
                <a href="{{ route('motors.index') }}" class="menu-item">
                    <i class="fas fa-motorcycle"></i>
                    CRUD Data Motor
                </a>
                
                <a href="#" class="menu-item">
                    <i class="fas fa-tags"></i>
                    CRUD Data Tarif Rental
                </a>
                
                <a href="{{ route('rentals.index') }}" class="menu-item">
                    <i class="fas fa-clipboard-list"></i>
                    CRUD Data Penyewaan
                </a>
                
                <a href="{{ route('payments.index') }}" class="menu-item">
                    <i class="fas fa-credit-card"></i>
                    CRUD Data Pembayaran
                </a>
            </div>

            <!-- Transaction Section -->
            <div class="menu-section">
                <div class="menu-section-title">Transaksi</div>
                
                <a href="{{ route('payments.create') }}" class="menu-item">
                    <i class="fas fa-plus-circle"></i>
                    Entri Transaksi
                </a>
                
                <a href="{{ route('reports.revenue-sharing') }}" class="menu-item">
                    <i class="fas fa-chart-pie"></i>
                    Lihat History Bagi Hasil
                </a>
            </div>

            <!-- Reports Section -->
            <div class="menu-section">
                <div class="menu-section-title">Laporan & Analytics</div>
                
                <a href="{{ route('reports.rental-chart') }}" class="menu-item">
                    <i class="fas fa-chart-line"></i>
                    Grafik Penyewaan per Periode
                </a>
                
                <a href="{{ route('reports.rental-history') }}" class="menu-item">
                    <i class="fas fa-history"></i>
                    Generate Riwayat Penyewaan
                </a>
                
                <a href="{{ route('reports.registered-motors') }}" class="menu-item">
                    <i class="fas fa-list-alt"></i>
                    Generate Daftar Motor Terdaftar
                </a>
                
                <a href="{{ route('reports.rented-motors') }}" class="menu-item">
                    <i class="fas fa-rocket"></i>
                    Generate Daftar Motor Disewa
                </a>
                
                <a href="{{ route('reports.total-revenue') }}" class="menu-item">
                    <i class="fas fa-money-bill-wave"></i>
                    Generate Total Pendapatan
                </a>
                
                <a href="{{ route('reports.payment-report') }}" class="menu-item">
                    <i class="fas fa-file-invoice-dollar"></i>
                    Generate Laporan Pembayaran
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="flex items-center">
                <h1 class="text-xl font-semibold text-gray-900">Dashboard</h1>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <input type="text" placeholder="Search..." class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                    <button class="p-2 text-gray-400 hover:text-gray-600">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <button class="p-2 text-gray-400 hover:text-gray-600 relative">
                    <i class="fas fa-bell"></i>
                    @if($pendingMotors > 0 || $pendingPayments > 0)
                    <span class="notification-dot"></span>
                    @endif
                </button>
                <div class="flex items-center space-x-2">
                    <div class="user-avatar">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="text-sm">
                        <div class="font-medium text-gray-900">{{ Auth::user()->name }}</div>
                        <div class="text-gray-500">Administrator</div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-600 ml-2">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            <!-- Stats Cards -->
            <div class="stats-grid">
                <!-- CRUD Data Cards -->
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon" style="background: #dbeafe; color: #3b82f6;">
                            <i class="fas fa-folder"></i>
                        </div>
                        <div>
                            <div class="stat-number">{{ $totalMotors }}</div>
                            <div class="stat-label">Total Motor</div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600 mb-2">Motor terdaftar dalam sistem</div>
                    <a href="{{ route('motors.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-eye mr-1"></i> Kelola
                    </a>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon" style="background: #dcfce7; color: #22c55e;">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <div>
                            <div class="stat-number">{{ $activeRentals }}</div>
                            <div class="stat-label">Penyewaan Aktif</div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600 mb-2">Transaksi penyewaan berjalan</div>
                    <a href="{{ route('rentals.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-eye mr-1"></i> Kelola
                    </a>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon" style="background: #fef3c7; color: #f59e0b;">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <div class="stat-number">{{ \App\Models\User::count() }}</div>
                            <div class="stat-label">Total User</div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600 mb-2">Pengguna terdaftar</div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-eye mr-1"></i> Kelola
                    </a>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon" style="background: #e0e7ff; color: #6366f1;">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div>
                            <div class="stat-number">76%</div>
                            <div class="stat-label">Produktivitas</div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600 mb-2">Efisiensi sistem</div>
                    <a href="{{ route('reports.rental-chart') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-chart-line mr-1"></i> Lihat
                    </a>
                </div>
            </div>

            <!-- Active Management Section -->
            <div class="project-table">
                <div class="table-header">
                    <div class="flex justify-between items-center">
                        <h2 class="section-title mb-0">Manajemen Aktif</h2>
                        <a href="{{ route('payments.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus mr-2"></i>Entri Transaksi Baru
                        </a>
                    </div>
                </div>
                <div class="table-content">
                    <!-- Pending Verifications -->
                    @if($pendingMotors > 0)
                    <div class="mb-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="stat-icon mr-3" style="background: #fef3c7; color: #f59e0b; width: 40px; height: 40px;">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">Motor Menunggu Verifikasi</div>
                                    <div class="text-sm text-gray-600">{{ $pendingMotors }} motor perlu diverifikasi</div>
                                </div>
                            </div>
                            <a href="{{ route('motors.index') }}" class="btn btn-primary">
                                <i class="fas fa-check-circle mr-1"></i> Verifikasi
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($pendingPayments > 0)
                    <div class="mb-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="stat-icon mr-3" style="background: #dbeafe; color: #3b82f6; width: 40px; height: 40px;">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">Pembayaran Menunggu Konfirmasi</div>
                                    <div class="text-sm text-gray-600">{{ $pendingPayments }} pembayaran perlu dikonfirmasi</div>
                                </div>
                            </div>
                            <a href="{{ route('payments.index') }}" class="btn btn-primary">
                                <i class="fas fa-check-circle mr-1"></i> Konfirmasi
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Quick Actions Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
                        <!-- CRUD Actions -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-medium text-gray-900 mb-3">CRUD Management</h3>
                            <div class="space-y-2">
                                <a href="{{ route('admin.users.index') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-users w-4 mr-2"></i> CRUD Data User
                                </a>
                                <a href="{{ route('motors.index') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-motorcycle w-4 mr-2"></i> CRUD Data Motor
                                </a>
                                <a href="{{ route('rentals.index') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-clipboard-list w-4 mr-2"></i> CRUD Data Penyewaan
                                </a>
                                <a href="{{ route('payments.index') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-credit-card w-4 mr-2"></i> CRUD Data Pembayaran
                                </a>
                            </div>
                        </div>

                        <!-- Generate Reports -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-medium text-gray-900 mb-3">Generate Laporan</h3>
                            <div class="space-y-2">
                                <a href="{{ route('reports.rental-history') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-history w-4 mr-2"></i> Riwayat Penyewaan
                                </a>
                                <a href="{{ route('reports.registered-motors') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-list-alt w-4 mr-2"></i> Motor Terdaftar
                                </a>
                                <a href="{{ route('reports.rented-motors') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-rocket w-4 mr-2"></i> Motor Disewa
                                </a>
                                <a href="{{ route('reports.total-revenue') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-money-bill-wave w-4 mr-2"></i> Total Pendapatan
                                </a>
                                <a href="{{ route('reports.payment-report') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-file-invoice-dollar w-4 mr-2"></i> Laporan Pembayaran
                                </a>
                            </div>
                        </div>

                        <!-- Analytics & History -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-medium text-gray-900 mb-3">Analytics & History</h3>
                            <div class="space-y-2">
                                <a href="{{ route('reports.rental-chart') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-chart-line w-4 mr-2"></i> Grafik Penyewaan per Periode
                                </a>
                                <a href="{{ route('reports.revenue-sharing') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-chart-pie w-4 mr-2"></i> History Bagi Hasil
                                </a>
                                <a href="{{ route('payments.create') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-plus-circle w-4 mr-2"></i> Entri Transaksi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                                <a href="{{ route('motors.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-green-50 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-motorcycle w-5 text-green-600 mr-3"></i>
                                    <div>
                                        <div class="font-medium">Kelola Motor</div>
                                        <div class="text-xs text-gray-500">Verifikasi & CRUD motor</div>
                                    </div>
                                </a>
                                <a href="{{ route('rentals.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-purple-50 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-clipboard-list w-5 text-purple-600 mr-3"></i>
                                    <div>
                                        <div class="font-medium">Kelola Penyewaan</div>
                                        <div class="text-xs text-gray-500">CRUD transaksi rental</div>
                                    </div>
                                </a>
                                <a href="{{ route('payments.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-yellow-50 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-credit-card w-5 text-yellow-600 mr-3"></i>
                                    <div>
                                        <div class="font-medium">Kelola Pembayaran</div>
                                        <div class="text-xs text-gray-500">Konfirmasi & CRUD payment</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Reports Dropdown -->
                    <div class="relative group">
                        <button class="flex items-center nav-link px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Laporan 
                            <i class="fas fa-chevron-down ml-2 text-xs"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-72 bg-white dark:bg-gray-800 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 border border-gray-200 dark:border-gray-600">
                            <div class="py-2">
                                <a href="{{ route('reports.rental-history') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-history w-5 text-blue-600 mr-3"></i>
                                    <div>
                                        <div class="font-medium">Riwayat Penyewaan</div>
                                        <div class="text-xs text-gray-500">Generate & export history</div>
                                    </div>
                                </a>
                                <a href="{{ route('reports.registered-motors') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-green-50 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-list-alt w-5 text-green-600 mr-3"></i>
                                    <div>
                                        <div class="font-medium">Motor Terdaftar</div>
                                        <div class="text-xs text-gray-500">Daftar lengkap motor</div>
                                    </div>
                                </a>
                                <a href="{{ route('reports.rented-motors') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-orange-50 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-rocket w-5 text-orange-600 mr-3"></i>
                                    <div>
                                        <div class="font-medium">Motor Disewa</div>
                                        <div class="text-xs text-gray-500">Motor dalam penyewaan</div>
                                    </div>
                                </a>
                                <a href="{{ route('reports.total-revenue') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-purple-50 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-money-bill-wave w-5 text-purple-600 mr-3"></i>
                                    <div>
                                        <div class="font-medium">Total Pendapatan</div>
                                        <div class="text-xs text-gray-500">Laporan keuangan</div>
                                    </div>
                                </a>
                                <a href="{{ route('reports.payment-report') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-file-invoice-dollar w-5 text-indigo-600 mr-3"></i>
                                    <div>
                                        <div class="font-medium">Laporan Pembayaran</div>
                                        <div class="text-xs text-gray-500">Generate transaksi payment</div>
                                    </div>
                                </a>
                                <a href="{{ route('reports.revenue-sharing') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-teal-50 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-chart-pie w-5 text-teal-600 mr-3"></i>
                                    <div>
                                        <div class="font-medium">Histori Bagi Hasil</div>
                                        <div class="text-xs text-gray-500">Lihat pembagian keuntungan</div>
                                    </div>
                                </a>
                                <a href="{{ route('reports.rental-chart') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-red-50 dark:hover:bg-gray-700 transition-colors">
                                    <i class="fas fa-chart-line w-5 text-red-600 mr-3"></i>
                                    <div>
                                        <div class="font-medium">Grafik Penyewaan</div>
                                        <div class="text-xs text-gray-500">Grafik per periode</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Button -->
                    <div class="relative group">
                        <button class="flex items-center nav-link px-3 py-2 rounded-lg text-sm font-medium bg-blue-50 text-blue-600 hover:bg-blue-100 transition-all duration-200">
                            <i class="fas fa-bolt mr-2"></i>
                            Quick Actions
                            <i class="fas fa-chevron-down ml-2 text-xs"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 border border-gray-200 dark:border-gray-600">
                            <div class="py-2">
                                <div class="px-4 py-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-gray-600">Tindakan Cepat</div>
                                <a href="{{ route('motors.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                                    <div class="p-2 bg-blue-100 dark:bg-blue-800 rounded-lg mr-3">
                                        <i class="fas fa-check-circle text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-medium">Verifikasi Motor</div>
                                        <div class="text-xs text-gray-500">{{ $pendingMotors }} menunggu verifikasi</div>
                                    </div>
                                    @if($pendingMotors > 0)
                                    <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">{{ $pendingMotors }}</span>
                                    @endif
                                </a>
                                <a href="{{ route('payments.index') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-orange-50 dark:hover:bg-gray-700 transition-colors">
                                    <div class="p-2 bg-orange-100 dark:bg-orange-800 rounded-lg mr-3">
                                        <i class="fas fa-credit-card text-orange-600 dark:text-orange-400"></i>
                                    </div>
                                    <div class="flex-1">
                                        <div class="font-medium">Konfirmasi Pembayaran</div>
                                        <div class="text-xs text-gray-500">{{ $pendingPayments }} menunggu konfirmasi</div>
                                    </div>
                                    @if($pendingPayments > 0)
                                    <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold">{{ $pendingPayments }}</span>
                                    @endif
                                </a>
                                <a href="{{ route('payments.create') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-green-50 dark:hover:bg-gray-700 transition-colors">
                                    <div class="p-2 bg-green-100 dark:bg-green-800 rounded-lg mr-3">
                                        <i class="fas fa-plus-circle text-green-600 dark:text-green-400"></i>
                                    </div>
                                    <div>
                                        <div class="font-medium">Entri Transaksi Manual</div>
                                        <div class="text-xs text-gray-500">Tambah pembayaran & bagi hasil</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Profile & Logout -->
                    <div class="flex items-center space-x-3 pl-6 border-l border-gray-200 dark:border-gray-600">
                        <div class="text-right">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Administrator</div>
                        </div>
                        <div class="relative group">
                            <button class="flex items-center p-2 rounded-full bg-gradient-to-r from-blue-500 to-indigo-600 text-white hover:from-blue-600 hover:to-indigo-700 transition-all duration-200">
                                <i class="fas fa-user-shield"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 border border-gray-200 dark:border-gray-600">
                                <div class="py-2">
                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <i class="fas fa-user-edit mr-2"></i> Edit Profile
                                    </a>
                                    <div class="border-t border-gray-200 dark:border-gray-600 my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full text-left px-4 py-2 text-sm text-red-700 dark:text-red-400 hover:bg-red-50 dark:hover:bg-gray-700">
                                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Enhanced Welcome Header -->
        <div class="relative bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 rounded-xl shadow-xl mb-8 card overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-10"></div>
            <div class="relative px-8 py-10">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center mb-3">
                            <i class="fas fa-shield-alt text-white text-2xl mr-3"></i>
                            <h1 class="text-4xl font-bold text-white">Panel Admin RentMotor</h1>
                        </div>
                        <p class="text-blue-100 text-lg">Kelola verifikasi motor, konfirmasi pembayaran, dan pantau sistem secara real-time</p>
                        <div class="flex items-center mt-4 space-x-4 text-blue-100">
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-2"></i>
                                <span>{{ now()->format('d M Y, H:i') }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-user mr-2"></i>
                                <span>{{ Auth::user()->name }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="hidden lg:block">
                        <div class="bg-white bg-opacity-20 rounded-lg p-4">
                            <i class="fas fa-tachometer-alt text-white text-5xl"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute top-0 right-0 w-32 h-32 bg-white bg-opacity-10 rounded-bl-full"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white bg-opacity-10 rounded-tr-full"></div>
        </div>

        <!-- Enhanced Alert for pending items -->
        @if($pendingMotors > 0 || $pendingPayments > 0)
        <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900 dark:to-orange-900 border border-amber-200 dark:border-amber-700 rounded-xl p-6 mb-8 shadow-lg">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="p-2 bg-amber-100 dark:bg-amber-800 rounded-full">
                        <i class="fas fa-exclamation-triangle text-amber-600 dark:text-amber-400 text-xl"></i>
                    </div>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-semibold text-amber-800 dark:text-amber-300 mb-2">
                        <i class="fas fa-bell mr-2"></i>Tindakan Diperlukan!
                    </h3>
                    <div class="space-y-2">
                        @if($pendingMotors > 0)
                        <div class="flex items-center justify-between bg-white dark:bg-gray-800 rounded-lg p-3 border border-amber-200 dark:border-amber-700">
                            <div class="flex items-center">
                                <i class="fas fa-motorcycle text-blue-600 mr-3"></i>
                                <span class="text-gray-700 dark:text-gray-300">{{ $pendingMotors }} motor menunggu verifikasi</span>
                            </div>
                            <a href="{{ route('motors.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                <i class="fas fa-check-circle mr-1"></i>Verifikasi
                            </a>
                        </div>
                        @endif
                        @if($pendingPayments > 0)
                        <div class="flex items-center justify-between bg-white dark:bg-gray-800 rounded-lg p-3 border border-amber-200 dark:border-amber-700">
                            <div class="flex items-center">
                                <i class="fas fa-credit-card text-orange-600 mr-3"></i>
                                <span class="text-gray-700 dark:text-gray-300">{{ $pendingPayments }} pembayaran menunggu konfirmasi</span>
                            </div>
                            <a href="{{ route('payments.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                <i class="fas fa-check-circle mr-1"></i>Konfirmasi
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Enhanced Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Motor Pending Verification -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 stat-card border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg">
                            <i class="fas fa-motorcycle text-xl"></i>
                        </div>
                        @if($pendingMotors > 0)
                        <span class="ml-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold notification-badge">{{ $pendingMotors }}</span>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Motor Menunggu</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $pendingMotors }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Verifikasi</span>
                    @if($pendingMotors > 0)
                    <a href="{{ route('motors.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-lg text-xs font-medium transition-colors">
                        <i class="fas fa-arrow-right mr-1"></i>Proses
                    </a>
                    @else
                    <span class="text-green-500 text-xs font-medium">
                        <i class="fas fa-check-circle mr-1"></i>Selesai
                    </span>
                    @endif
                </div>
            </div>

            <!-- Payment Pending -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 stat-card border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="p-3 rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 text-white shadow-lg">
                            <i class="fas fa-credit-card text-xl"></i>
                        </div>
                        @if($pendingPayments > 0)
                        <span class="ml-2 bg-red-500 text-white px-2 py-1 rounded-full text-xs font-bold notification-badge">{{ $pendingPayments }}</span>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pembayaran Pending</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $pendingPayments }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Konfirmasi</span>
                    @if($pendingPayments > 0)
                    <a href="{{ route('payments.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white px-3 py-1 rounded-lg text-xs font-medium transition-colors">
                        <i class="fas fa-arrow-right mr-1"></i>Proses
                    </a>
                    @else
                    <span class="text-green-500 text-xs font-medium">
                        <i class="fas fa-check-circle mr-1"></i>Selesai
                    </span>
                    @endif
                </div>
            </div>

            <!-- Active Rentals -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 stat-card border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Penyewaan Aktif</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $activeRentals }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Sedang Berjalan</span>
                    <a href="{{ route('rentals.index') }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-lg text-xs font-medium transition-colors">
                        <i class="fas fa-eye mr-1"></i>Lihat
                    </a>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 stat-card border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 rounded-xl bg-gradient-to-r from-purple-500 to-purple-600 text-white shadow-lg">
                        <i class="fas fa-coins text-xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Komisi Platform</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Total Pendapatan</span>
                    <a href="{{ route('reports.total-revenue') }}" class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded-lg text-xs font-medium transition-colors">
                        <i class="fas fa-chart-bar mr-1"></i>Detail
                    </a>
                </div>
            </div>
        </div>

        <!-- Laporan Admin Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
            <!-- Grafik Penyewaan -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-lg shadow p-6 card">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Grafik Penyewaan</h2>
                    <div class="period-selector">
                        <button class="period-btn active" data-period="daily">Harian</button>
                        <button class="period-btn" data-period="weekly">Mingguan</button>
                        <button class="period-btn" data-period="monthly">Bulanan</button>
                    </div>
                </div>
                
                <div class="chart-container p-4 rounded-lg">
                    <!-- Placeholder for chart - in real implementation, use Chart.js or similar -->
                    <div class="h-64 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-16 h-16 text-blue-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">Grafik akan ditampilkan di sini</p>
                            <p class="text-sm text-gray-400 dark:text-gray-500">(Integrasikan dengan Chart.js)</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Ringkasan Motor -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 card">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Ringkasan Motor</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-blue-800 dark:text-blue-300">Total Motor Terdaftar</p>
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $totalMotors }}</p>
                        </div>
                        <div class="p-2 bg-blue-100 dark:bg-blue-800 rounded-full">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h3M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 8h5a2 2 0 002-2V9a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-green-800 dark:text-green-300">Motor Tersedia</p>
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $availableMotors }}</p>
                        </div>
                        <div class="p-2 bg-green-100 dark:bg-green-800 rounded-full">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-orange-800 dark:text-orange-300">Motor Disewa</p>
                            <p class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ $rentedMotors }}</p>
                        </div>
                        <div class="p-2 bg-orange-100 dark:bg-orange-800 rounded-full">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pendapatan Breakdown -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 card">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Pendapatan Platform</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg">
                        <div>
                            <p class="text-sm font-medium">Total Pendapatan</p>
                            <p class="text-2xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-2 bg-white/20 rounded-full">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                            <p class="text-sm font-medium text-green-800 dark:text-green-300">Bagi Hasil Pemilik</p>
                            <p class="text-lg font-semibold text-green-600 dark:text-green-400">Rp {{ number_format($ownerRevenue, 0, ',', '.') }}</p>
                            <p class="text-xs text-green-600 dark:text-green-400 mt-1">80% dari total</p>
                        </div>
                        
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <p class="text-sm font-medium text-blue-800 dark:text-blue-300">Bagi Hasil Admin</p>
                            <p class="text-lg font-semibold text-blue-600 dark:text-blue-400">Rp {{ number_format($adminRevenue, 0, ',', '.') }}</p>
                            <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">20% dari total</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 card">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-6">Aksi Cepat</h2>
                
                <div class="grid grid-cols-1 gap-3">
                    <a href="{{ route('motors.index') }}" class="flex items-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                        <div class="p-2 bg-blue-100 dark:bg-blue-800 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-blue-800 dark:text-blue-300 text-sm">Verifikasi Motor</p>
                            <p class="text-xs text-blue-600 dark:text-blue-400">{{ $pendingMotors }} menunggu</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('payments.index') }}" class="flex items-center p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg hover:bg-orange-100 dark:hover:bg-orange-900/30 transition-colors">
                        <div class="p-2 bg-orange-100 dark:bg-orange-800 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-orange-800 dark:text-orange-300 text-sm">Konfirmasi Pembayaran</p>
                            <p class="text-xs text-orange-600 dark:text-orange-400">{{ $pendingPayments }} menunggu</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('rentals.index') }}" class="flex items-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                        <div class="p-2 bg-green-100 dark:bg-green-800 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-green-800 dark:text-green-300 text-sm">Kelola Penyewaan</p>
                            <p class="text-xs text-green-600 dark:text-green-400">{{ $activeRentals }} aktif</p>
                        </div>
                    </a>
                    
                    <!-- Report Shortcuts -->
                    <div class="border-t border-gray-200 dark:border-gray-600 my-2 pt-2">
                        <p class="text-xs font-medium text-gray-500 dark:text-gray-400 mb-2 uppercase tracking-wider">Laporan Cepat</p>
                    </div>
                    
                    <a href="{{ route('reports.rental-chart') }}" class="flex items-center p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
                        <div class="p-2 bg-purple-100 dark:bg-purple-800 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-purple-800 dark:text-purple-300 text-sm">Grafik Penyewaan</p>
                            <p class="text-xs text-purple-600 dark:text-purple-400">Analisis visual</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('reports.total-revenue') }}" class="flex items-center p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg hover:bg-indigo-100 dark:hover:bg-indigo-900/30 transition-colors">
                        <div class="p-2 bg-indigo-100 dark:bg-indigo-800 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-indigo-800 dark:text-indigo-300 text-sm">Total Pendapatan</p>
                            <p class="text-xs text-indigo-600 dark:text-indigo-400">Laporan keuangan</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('reports.revenue-sharing') }}" class="flex items-center p-3 bg-teal-50 dark:bg-teal-900/20 rounded-lg hover:bg-teal-100 dark:hover:bg-teal-900/30 transition-colors">
                        <div class="p-2 bg-teal-100 dark:bg-teal-800 rounded-lg mr-3">
                            <svg class="w-5 h-5 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-teal-800 dark:text-teal-300 text-sm">Bagi Hasil</p>
                            <p class="text-xs text-teal-600 dark:text-teal-400">Histori pembayaran</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Laporan CRUD Dashboard Section -->
        <div class="mt-8 mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">📊 Dashboard Laporan & Analytics</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <!-- Riwayat Penyewaan -->
                <a href="{{ route('reports.rental-history') }}" class="group bg-white dark:bg-gray-800 rounded-lg shadow p-6 card hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg mr-4 group-hover:bg-blue-200 dark:group-hover:bg-blue-800 transition-colors">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Riwayat Penyewaan</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Generate & export riwayat</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">Laporan lengkap semua aktivitas penyewaan dengan filter periode dan status</p>
                </a>

                <!-- Motor Terdaftar -->
                <a href="{{ route('reports.registered-motors') }}" class="group bg-white dark:bg-gray-800 rounded-lg shadow p-6 card hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg mr-4 group-hover:bg-green-200 dark:group-hover:bg-green-800 transition-colors">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h3M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 8h5a2 2 0 002-2V9a2 2 0 00-2-2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">Motor Terdaftar</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Daftar lengkap motor</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">Generate daftar semua motor terdaftar dengan statistik dan filter brand</p>
                </a>

                <!-- Motor Disewa -->
                <a href="{{ route('reports.rented-motors') }}" class="group bg-white dark:bg-gray-800 rounded-lg shadow p-6 card hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900 rounded-lg mr-4 group-hover:bg-yellow-200 dark:group-hover:bg-yellow-800 transition-colors">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-yellow-600 dark:group-hover:text-yellow-400 transition-colors">Motor Disewa</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Motor dalam penyewaan</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">Generate daftar motor yang sedang disewa dengan tracking waktu sisa</p>
                </a>

                <!-- Total Pendapatan -->
                <a href="{{ route('reports.total-revenue') }}" class="group bg-white dark:bg-gray-800 rounded-lg shadow p-6 card hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-indigo-100 dark:bg-indigo-900 rounded-lg mr-4 group-hover:bg-indigo-200 dark:group-hover:bg-indigo-800 transition-colors">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">Total Pendapatan</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Generate laporan keuangan</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">Generate total pendapatan dengan breakdown per periode dan analisis</p>
                </a>

                <!-- Laporan Pembayaran -->
                <a href="{{ route('reports.payment-report') }}" class="group bg-white dark:bg-gray-800 rounded-lg shadow p-6 card hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-purple-100 dark:bg-purple-900 rounded-lg mr-4 group-hover:bg-purple-200 dark:group-hover:bg-purple-800 transition-colors">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">Laporan Pembayaran</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Generate transaksi pembayaran</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">Generate laporan semua transaksi pembayaran dengan metode dan status</p>
                </a>

                <!-- Histori Bagi Hasil -->
                <a href="{{ route('reports.revenue-sharing') }}" class="group bg-white dark:bg-gray-800 rounded-lg shadow p-6 card hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-teal-100 dark:bg-teal-900 rounded-lg mr-4 group-hover:bg-teal-200 dark:group-hover:bg-teal-800 transition-colors">
                            <svg class="w-6 h-6 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors">Histori Bagi Hasil</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Lihat pembagian keuntungan</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">Lihat histori bagi hasil kepada pemilik motor dengan status pembayaran</p>
                </a>

                <!-- Grafik Penyewaan -->
                <a href="{{ route('reports.rental-chart') }}" class="group bg-white dark:bg-gray-800 rounded-lg shadow p-6 card hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-red-100 dark:bg-red-900 rounded-lg mr-4 group-hover:bg-red-200 dark:group-hover:bg-red-800 transition-colors">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors">Grafik Penyewaan</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Grafik per periode</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">Grafik penyewaan per periode dengan berbagai visualisasi chart interaktif</p>
                </a>

                <!-- Entry Transaksi Manual -->
                <a href="{{ route('payments.create') }}" class="group bg-white dark:bg-gray-800 rounded-lg shadow p-6 card hover:shadow-lg transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="p-3 bg-orange-100 dark:bg-orange-900 rounded-lg mr-4 group-hover:bg-orange-200 dark:group-hover:bg-orange-800 transition-colors">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">Entri Transaksi</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Tambah pembayaran manual</p>
                        </div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">Entri transaksi pembayaran manual dengan otomatis bagi hasil</p>
                </a>
            </div>
        </div>
    </div>

    <script>
        // Enhanced Admin Dashboard JavaScript
        document.addEventListener('DOMContentLoaded', function() {
            // Period selector functionality
            const periodBtns = document.querySelectorAll('.period-btn');
            
            periodBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    periodBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Show loading indicator
                    const chartContainer = document.querySelector('.chart-container');
                    if (chartContainer) {
                        chartContainer.innerHTML = `
                            <div class="h-64 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                                    <p class="text-gray-500">Memuat data ${this.textContent.toLowerCase()}...</p>
                                </div>
                            </div>
                        `;
                        
                        // Simulate loading delay
                        setTimeout(() => {
                            chartContainer.innerHTML = `
                                <div class="h-64 flex items-center justify-center">
                                    <div class="text-center">
                                        <i class="fas fa-chart-bar text-4xl text-blue-400 mb-4"></i>
                                        <p class="text-gray-500 dark:text-gray-400">Data ${this.textContent.toLowerCase()}</p>
                                        <p class="text-sm text-gray-400 dark:text-gray-500">(Integrasikan dengan Chart.js)</p>
                                    </div>
                                </div>
                            `;
                        }, 1000);
                    }
                    
                    console.log('Period changed to:', this.dataset.period);
                });
            });
            
            // Enhanced card hover effects
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px)';
                    this.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '';
                });
            });

            // Stat cards animation on scroll
            const statCards = document.querySelectorAll('.stat-card');
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            statCards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease-out';
                observer.observe(card);
            });

            // Auto-refresh notifications
            setInterval(function() {
                // In a real implementation, this would make an AJAX call to check for new notifications
                console.log('Checking for new notifications...');
            }, 30000); // Check every 30 seconds

            // Add click handlers for quick action buttons
            document.querySelectorAll('a[href*="motors"], a[href*="payments"], a[href*="rentals"]').forEach(link => {
                link.addEventListener('click', function(e) {
                    // Add loading state
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Loading...';
                    this.classList.add('pointer-events-none', 'opacity-75');
                    
                    // Restore after a brief delay (the page will navigate anyway)
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.classList.remove('pointer-events-none', 'opacity-75');
                    }, 500);
                });
            });

            // Notification badge pulse animation
            const badges = document.querySelectorAll('.notification-badge');
            badges.forEach(badge => {
                badge.classList.add('animate-pulse');
            });

            // Welcome message with time-based greeting
            const currentHour = new Date().getHours();
            let greeting = 'Selamat Malam';
            if (currentHour >= 5 && currentHour < 12) {
                greeting = 'Selamat Pagi';
            } else if (currentHour >= 12 && currentHour < 17) {
                greeting = 'Selamat Siang';
            } else if (currentHour >= 17 && currentHour < 21) {
                greeting = 'Selamat Sore';
            }

            console.log(`${greeting}, Admin! Dashboard loaded successfully.`);
        });

        // Function to show success message
        function showSuccessMessage(message) {
            const alert = document.createElement('div');
            alert.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300';
            alert.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(alert);
            
            // Slide in
            setTimeout(() => {
                alert.classList.remove('translate-x-full');
            }, 100);
            
            // Slide out after 3 seconds
            setTimeout(() => {
                alert.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(alert);
                }, 300);
            }, 3000);
        }

        // Function to format numbers with Indonesian locale
        function formatIDR(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(number);
        }
    </script>
</body>
</html>
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
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            width: 250px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
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
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            border-left-color: #ffffff;
        }

        .menu-item.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            border-left-color: #ffffff;
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

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.75rem;
        }

        .notification-dot {
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            position: absolute;
            top: -2px;
            right: -2px;
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
                
                <a href="{{ route('admin.motors.index') }}" class="menu-item">
                    <i class="fas fa-motorcycle"></i>
                    CRUD Data Motor
                </a>
                
                <a href="#" class="menu-item">
                    <i class="fas fa-tags"></i>
                    CRUD Data Tarif Rental
                </a>
                
                <a href="{{ route('admin.rentals.index') }}" class="menu-item">
                    <i class="fas fa-clipboard-list"></i>
                    CRUD Data Penyewaan
                </a>
                
                <a href="{{ route('admin.payments.index') }}" class="menu-item">
                    <i class="fas fa-credit-card"></i>
                    CRUD Data Pembayaran
                </a>
            </div>

            <!-- Transaction Section -->
            <div class="menu-section">
                <div class="menu-section-title">Transaksi</div>
                
                <a href="{{ route('admin.payments.create') }}" class="menu-item">
                    <i class="fas fa-plus-circle"></i>
                    Entri Transaksi
                </a>
                
                <a href="{{ route('admin.reports.revenue-sharing') }}" class="menu-item">
                    <i class="fas fa-chart-pie"></i>
                    Lihat History Bagi Hasil
                </a>
            </div>

            <!-- Reports Section -->
            <div class="menu-section">
                <div class="menu-section-title">Laporan & Analytics</div>
                
                <a href="{{ route('admin.reports.rental-chart') }}" class="menu-item">
                    <i class="fas fa-chart-line"></i>
                    Grafik Penyewaan per Periode
                </a>
                
                <a href="{{ route('admin.reports.rental-history') }}" class="menu-item">
                    <i class="fas fa-history"></i>
                    Generate Riwayat Penyewaan
                </a>
                
                <a href="{{ route('admin.reports.registered-motors') }}" class="menu-item">
                    <i class="fas fa-list-alt"></i>
                    Generate Daftar Motor Terdaftar
                </a>
                
                <a href="{{ route('admin.reports.rented-motors') }}" class="menu-item">
                    <i class="fas fa-rocket"></i>
                    Generate Daftar Motor Disewa
                </a>
                
                <a href="{{ route('admin.reports.total-revenue') }}" class="menu-item">
                    <i class="fas fa-money-bill-wave"></i>
                    Generate Total Pendapatan
                </a>
                
                <a href="{{ route('admin.reports.payment-report') }}" class="menu-item">
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
                        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff;">
                            <i class="fas fa-folder"></i>
                        </div>
                        <div>
                            <div class="stat-number">{{ $totalMotors }}</div>
                            <div class="stat-label">Total Motor</div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600 mb-2">{{ $pendingMotors }} menunggu verifikasi</div>
                    <a href="{{ route('admin.motors.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-eye mr-1"></i> Kelola
                    </a>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff;">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <div>
                            <div class="stat-number">{{ $activeRentals }}</div>
                            <div class="stat-label">Penyewaan Aktif</div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600 mb-2">Transaksi penyewaan berjalan</div>
                    <a href="{{ route('admin.rentals.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-eye mr-1"></i> Kelola
                    </a>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff;">
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
                        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff;">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <div>
                            <div class="stat-number">76%</div>
                            <div class="stat-label">Produktivitas</div>
                        </div>
                    </div>
                    <div class="text-sm text-gray-600 mb-2">5% Selesai bulan ini</div>
                    <a href="{{ route('admin.reports.rental-chart') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-chart-line mr-1"></i> Lihat
                    </a>
                </div>
            </div>

            <!-- Active Management Section -->
            <div class="project-table">
                <div class="table-header">
                    <div class="flex justify-between items-center">
                        <h2 class="section-title mb-0">Manajemen Aktif</h2>
                        <a href="{{ route('admin.payments.create') }}" class="btn btn-primary">
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
                                <div class="stat-icon mr-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; width: 40px; height: 40px;">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">Motor Menunggu Verifikasi</div>
                                    <div class="text-sm text-gray-600">{{ $pendingMotors }} motor perlu diverifikasi</div>
                                </div>
                            </div>
                            <a href="{{ route('admin.motors.index') }}" class="btn btn-primary">
                                <i class="fas fa-check-circle mr-1"></i> Verifikasi
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($pendingPayments > 0)
                    <div class="mb-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="stat-icon mr-3" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #ffffff; width: 40px; height: 40px;">
                                    <i class="fas fa-credit-card"></i>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900">Pembayaran Menunggu Konfirmasi</div>
                                    <div class="text-sm text-gray-600">{{ $pendingPayments }} pembayaran perlu dikonfirmasi</div>
                                </div>
                            </div>
                            <a href="{{ route('admin.payments.index') }}" class="btn btn-primary">
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
                                <a href="{{ route('admin.motors.index') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-motorcycle w-4 mr-2"></i> CRUD Data Motor
                                </a>
                                <a href="#" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-tags w-4 mr-2"></i> CRUD Data Tarif Rental
                                </a>
                                <a href="{{ route('admin.rentals.index') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-clipboard-list w-4 mr-2"></i> CRUD Data Penyewaan
                                </a>
                                <a href="{{ route('admin.payments.index') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-credit-card w-4 mr-2"></i> CRUD Data Pembayaran
                                </a>
                            </div>
                        </div>

                        <!-- Generate Reports -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-medium text-gray-900 mb-3">Generate Laporan</h3>
                            <div class="space-y-2">
                                <a href="{{ route('admin.reports.rental-history') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-history w-4 mr-2"></i> Generate Riwayat Penyewaan
                                </a>
                                <a href="{{ route('admin.reports.registered-motors') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-list-alt w-4 mr-2"></i> Generate Daftar Motor Terdaftar
                                </a>
                                <a href="{{ route('admin.reports.rented-motors') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-rocket w-4 mr-2"></i> Generate Daftar Motor Disewa
                                </a>
                                <a href="{{ route('admin.reports.total-revenue') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-money-bill-wave w-4 mr-2"></i> Generate Total Pendapatan
                                </a>
                                <a href="{{ route('admin.reports.payment-report') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-file-invoice-dollar w-4 mr-2"></i> Generate Laporan Pembayaran
                                </a>
                            </div>
                        </div>

                        <!-- Analytics & History -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <h3 class="font-medium text-gray-900 mb-3">Analytics & History</h3>
                            <div class="space-y-2">
                                <a href="{{ route('admin.reports.rental-chart') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-chart-line w-4 mr-2"></i> Grafik Penyewaan per Periode
                                </a>
                                <a href="{{ route('admin.reports.revenue-sharing') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-chart-pie w-4 mr-2"></i> Lihat History Bagi Hasil
                                </a>
                                <a href="{{ route('admin.payments.create') }}" class="flex items-center text-sm text-gray-700 hover:text-blue-600 py-1">
                                    <i class="fas fa-plus-circle w-4 mr-2"></i> Entri Transaksi
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Overview -->
            <div class="project-table mt-6">
                <div class="table-header">
                    <h2 class="section-title mb-0">Revenue Overview</h2>
                </div>
                <div class="table-content">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="text-center p-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-lg">
                            <div class="text-2xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                            <div class="text-blue-100">Total Komisi Platform</div>
                        </div>
                        <div class="text-center p-4 bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-lg">
                            <div class="text-2xl font-bold">Rp {{ number_format($ownerRevenue ?? 0, 0, ',', '.') }}</div>
                            <div class="text-purple-100">Bagi Hasil Pemilik (80%)</div>
                        </div>
                        <div class="text-center p-4 bg-gradient-to-r from-indigo-500 to-blue-600 text-white rounded-lg">
                            <div class="text-2xl font-bold">Rp {{ number_format($adminRevenue ?? 0, 0, ',', '.') }}</div>
                            <div class="text-indigo-100">Komisi Admin (20%)</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple JavaScript for interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover effects to cards
            const cards = document.querySelectorAll('.stat-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px)';
                    this.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.15)';
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 1px 3px rgba(0, 0, 0, 0.1)';
                });
            });

            // Add loading state to buttons
            document.querySelectorAll('a[href], button[type="submit"]').forEach(element => {
                element.addEventListener('click', function(e) {
                    if (!this.classList.contains('no-loading')) {
                        const originalText = this.innerHTML;
                        this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i>Loading...';
                        this.classList.add('pointer-events-none', 'opacity-75');
                        
                        setTimeout(() => {
                            this.innerHTML = originalText;
                            this.classList.remove('pointer-events-none', 'opacity-75');
                        }, 1000);
                    }
                });
            });

            console.log('Admin Dashboard loaded successfully!');
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Pemilik - RentMotor</title>
    
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <style>
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3), 0 2px 4px -1px rgba(59, 130, 246, 0.2);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3), 0 4px 6px -2px rgba(59, 130, 246, 0.2);
        }
        
        .card {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-radius: 12px;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .motor-status-available { background: #10b981; }
        .motor-status-rented { background: #f59e0b; }
        .motor-status-maintenance { background: #ef4444; }
        .motor-status-pending { background: #8b5cf6; }
        
        .revenue-card {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        
        .section-tab {
            transition: all 0.3s ease;
            border-bottom: 3px solid transparent;
        }
        
        .section-tab.active {
            border-bottom-color: #3b82f6;
            color: #3b82f6;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-50"
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('owner.dashboard') }}" class="text-2xl font-bold text-blue-600">
                        🏍️ RentMotor
                    </a>
                    <div class="ml-10 flex space-x-8">
                        <a href="{{ route('owner.dashboard') }}" class="text-blue-600 border-b-2 border-blue-600 px-1 pt-1 text-sm font-medium">Dashboard</a>
                        <a href="{{ route('owner.motors.index') }}" class="text-gray-500 hover:text-blue-600 px-1 pt-1 text-sm font-medium transition">Motor Saya</a>
                        <a href="{{ route('owner.rentals.index') }}" class="text-gray-500 hover:text-blue-600 px-1 pt-1 text-sm font-medium transition">Penyewaan</a>
                        <a href="#" class="text-gray-500 hover:text-blue-600 px-1 pt-1 text-sm font-medium transition">Laporan Bagi Hasil</a>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-700">{{ Auth::user()->name }}</span>
                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold">PEMILIK</span>
                    <a href="{{ route('profile.edit') }}" class="text-gray-500 hover:text-blue-600 px-3 py-2 rounded-lg text-sm transition">
                        <i class="fas fa-user mr-1"></i>Profil
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="btn-primary px-4 py-2 rounded-lg text-sm">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Welcome Header -->
        <div class="bg-gradient-to-r from-green-500 to-blue-600 rounded-lg shadow-lg mb-6 card">
            <div class="px-6 py-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-4xl font-bold text-white">Dashboard Pemilik Motor</h1>
                        <p class="text-green-100 text-lg mt-2">Selamat datang kembali, {{ Auth::user()->name }}!</p>
                        <p class="text-green-200 text-sm mt-1">Kelola motor dan pantau pendapatan Anda dengan mudah</p>
                    </div>
                    <div class="text-right">
                        <div class="bg-white/20 rounded-lg p-4">
                            <div class="text-white text-sm font-medium">Total Pendapatan Bulan Ini</div>
                            <div class="text-white text-2xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Navigation -->
        <div class="bg-white rounded-lg shadow-sm mb-6 card">
            <div class="px-6 py-4">
                <div class="flex space-x-8">
                    <button onclick="showSection('overview')" class="section-tab active px-1 py-2 text-sm font-medium" id="tab-overview">
                        <i class="fas fa-tachometer-alt mr-2"></i>Overview
                    </button>
                    <button onclick="showSection('motors')" class="section-tab px-1 py-2 text-sm font-medium text-gray-500" id="tab-motors">
                        <i class="fas fa-motorcycle mr-2"></i>Kelola Motor
                    </button>
                    <button onclick="showSection('status')" class="section-tab px-1 py-2 text-sm font-medium text-gray-500" id="tab-status">
                        <i class="fas fa-chart-pie mr-2"></i>Status Motor
                    </button>
                    <button onclick="showSection('revenue')" class="section-tab px-1 py-2 text-sm font-medium text-gray-500" id="tab-revenue">
                        <i class="fas fa-chart-line mr-2"></i>Laporan Bagi Hasil
                    </button>
                </div>
            </div>
        </div>

        <!-- Overview Section -->
        <div id="section-overview" class="section-content">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 card">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100">
                            <i class="fas fa-motorcycle text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Motor</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $totalMotors }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 card">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Sedang Disewa</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $activeRentals }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 card">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100">
                            <i class="fas fa-money-bill-wave text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-sm p-6 card">
                    <div class="text-center text-white">
                        <i class="fas fa-plus-circle text-3xl mb-3"></i>
                        <h3 class="font-semibold mb-2">Daftarkan Motor Baru</h3>
                        <a href="{{ route('owner.motors.create') }}" class="bg-white text-blue-600 font-semibold py-2 px-4 rounded-lg hover:bg-gray-50 transition inline-block">
                            + Tambah Motor
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-200 card">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Aksi Cepat</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <button onclick="showSection('motors')" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition cursor-pointer">
                        <i class="fas fa-motorcycle text-blue-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-blue-900">Kelola Motor</span>
                    </button>
                    
                    <button onclick="showSection('status')" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition cursor-pointer">
                        <i class="fas fa-chart-pie text-green-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-green-900">Status Motor</span>
                    </button>
                    
                    <button onclick="showSection('revenue')" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition cursor-pointer">
                        <i class="fas fa-chart-line text-purple-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-purple-900">Laporan Bagi Hasil</span>
                    </button>
                    
                    <a href="{{ route('owner.motors.create') }}" class="flex flex-col items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition">
                        <i class="fas fa-plus text-orange-600 text-2xl mb-2"></i>
                        <span class="text-sm font-medium text-orange-900">Tambah Motor</span>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 card">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Aktivitas Terbaru</h2>
                    <a href="{{ route('owner.rentals.index') }}" class="text-blue-600 hover:text-blue-800">Lihat Semua</a>
                </div>
                
                <div class="space-y-4">
                    @forelse(auth()->user()->ownedMotors()->whereHas('rentals')->with('rentals.renter')->latest()->take(5)->get() as $motor)
                        @foreach($motor->rentals()->latest()->take(1)->get() as $rental)
                        <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-motorcycle text-blue-600"></i>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $motor->brand }} {{ $motor->type }} disewa oleh {{ $rental->renter->name }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $rental->created_at->diffForHumans() }} • {{ $rental->duration_days }} hari
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $rental->status_badge }}">
                                    {{ ucfirst(str_replace('_', ' ', $rental->status)) }}
                                </span>
                                <p class="text-sm font-medium text-gray-900 mt-1">Rp {{ number_format($rental->total_amount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-history text-gray-400 text-4xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Aktivitas</h3>
                            <p class="text-gray-600">Aktivitas penyewaan motor akan muncul di sini</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Motors Management Section -->
        <div id="section-motors" class="section-content" style="display: none;">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 card">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Kelola Motor Anda</h2>
                    <a href="{{ route('owner.motors.create') }}" class="btn-primary px-4 py-2 rounded-lg text-sm">
                        <i class="fas fa-plus mr-2"></i>Tambah Motor Baru
                    </a>
                </div>
                
                @if($motors->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($motors as $motor)
                        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-all card">
                            @if($motor->photo)
                                <img src="{{ asset('storage/' . $motor->photo) }}" alt="{{ $motor->brand }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-motorcycle text-gray-400 text-4xl"></i>
                                </div>
                            @endif
                            
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-bold text-lg text-gray-900">{{ $motor->brand }} {{ $motor->type }}</h3>
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full mr-2 
                                            @if($motor->status === 'available') bg-green-500
                                            @elseif($motor->status === 'rented') bg-yellow-500
                                            @elseif($motor->status === 'maintenance') bg-red-500
                                            @else bg-purple-500
                                            @endif"></div>
                                        <span class="text-xs font-medium
                                            @if($motor->status === 'available') text-green-700
                                            @elseif($motor->status === 'rented') text-yellow-700
                                            @elseif($motor->status === 'maintenance') text-red-700
                                            @else text-purple-700
                                            @endif">
                                            @if($motor->status === 'available') Tersedia
                                            @elseif($motor->status === 'rented') Disewa
                                            @elseif($motor->status === 'maintenance') Perawatan
                                            @else Pending
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                
                                <p class="text-gray-600 text-sm mb-2">{{ $motor->license_plate }} • {{ $motor->year }} • {{ $motor->color }}</p>
                                <p class="text-gray-700 text-sm mb-3">{{ Str::limit($motor->description, 60) }}</p>
                                
                                @if($motor->rental_price)
                                    <div class="flex justify-between items-center mb-3">
                                        <span class="text-blue-600 font-bold text-lg">Rp {{ number_format($motor->rental_price, 0, ',', '.') }}</span>
                                        <span class="text-gray-500 text-sm">/hari</span>
                                    </div>
                                @endif
                                
                                <div class="flex space-x-2">
                                    <a href="{{ route('owner.motors.show', $motor) }}" class="flex-1 bg-gray-100 text-gray-700 px-3 py-2 rounded text-sm hover:bg-gray-200 transition text-center">
                                        Detail
                                    </a>
                                    <a href="{{ route('owner.motors.edit', $motor) }}" class="flex-1 bg-blue-100 text-blue-700 px-3 py-2 rounded text-sm hover:bg-blue-200 transition text-center">
                                        Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-motorcycle text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">Belum Ada Motor Terdaftar</h3>
                        <p class="text-gray-500 mb-6">Daftarkan motor Anda untuk mulai mendapatkan penghasilan dari penyewaan</p>
                        <a href="{{ route('owner.motors.create') }}" class="btn-primary px-6 py-3 rounded-lg font-medium">
                            <i class="fas fa-plus mr-2"></i>Daftarkan Motor Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Motor Status Section -->
        <div id="section-status" class="section-content" style="display: none;">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Status Overview -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 border border-gray-200 card">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Status Motor Overview</h2>
                    
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-green-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-white text-sm"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-green-800">Tersedia</p>
                                    <p class="text-2xl font-bold text-green-900">{{ auth()->user()->ownedMotors()->where('status', 'available')->count() }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-yellow-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-clock text-white text-sm"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-yellow-800">Disewa</p>
                                    <p class="text-2xl font-bold text-yellow-900">{{ auth()->user()->ownedMotors()->where('status', 'rented')->count() }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-red-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-wrench text-white text-sm"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-red-800">Perawatan</p>
                                    <p class="text-2xl font-bold text-red-900">{{ auth()->user()->ownedMotors()->where('status', 'maintenance')->count() }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-purple-50 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-hourglass-half text-white text-sm"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-purple-800">Pending</p>
                                    <p class="text-2xl font-bold text-purple-900">{{ auth()->user()->ownedMotors()->where('status', 'pending_verification')->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Status Chart Placeholder -->
                    <div class="bg-gray-50 rounded-lg p-8 text-center">
                        <i class="fas fa-chart-pie text-gray-400 text-4xl mb-4"></i>
                        <p class="text-gray-600 font-medium mb-2">Grafik Status Motor</p>
                        <p class="text-gray-500 text-sm">Visualisasi status akan ditampilkan di sini</p>
                    </div>
                </div>
                
                <!-- Quick Status Actions -->
                <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 card">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Aksi Cepat</h3>
                    
                    <div class="space-y-3">
                        <button onclick="updateAllMotorStatus('available')" class="w-full bg-green-50 text-green-700 border border-green-200 px-4 py-3 rounded-lg hover:bg-green-100 transition text-left">
                            <i class="fas fa-check mr-3"></i>
                            <span class="font-medium">Set Tersedia</span>
                            <p class="text-sm text-green-600 mt-1">Ubah status motor menjadi tersedia untuk disewa</p>
                        </button>
                        
                        <button onclick="updateAllMotorStatus('maintenance')" class="w-full bg-red-50 text-red-700 border border-red-200 px-4 py-3 rounded-lg hover:bg-red-100 transition text-left">
                            <i class="fas fa-wrench mr-3"></i>
                            <span class="font-medium">Set Perawatan</span>
                            <p class="text-sm text-red-600 mt-1">Ubah status motor menjadi dalam perawatan</p>
                        </button>
                        
                        <a href="{{ route('owner.motors.create') }}" class="block w-full bg-blue-50 text-blue-700 border border-blue-200 px-4 py-3 rounded-lg hover:bg-blue-100 transition">
                            <i class="fas fa-plus mr-3"></i>
                            <span class="font-medium">Tambah Motor Baru</span>
                            <p class="text-sm text-blue-600 mt-1">Daftarkan motor baru untuk disewakan</p>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Motor Status List -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 card">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Detail Status Motor</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga/Hari</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terakhir Disewa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse(auth()->user()->ownedMotors as $motor)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <i class="fas fa-motorcycle text-gray-500"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $motor->brand }} {{ $motor->type }}</div>
                                            <div class="text-sm text-gray-500">{{ $motor->license_plate }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($motor->status === 'available') bg-green-100 text-green-800
                                        @elseif($motor->status === 'rented') bg-yellow-100 text-yellow-800
                                        @elseif($motor->status === 'maintenance') bg-red-100 text-red-800
                                        @else bg-purple-100 text-purple-800
                                        @endif">
                                        @if($motor->status === 'available') Tersedia
                                        @elseif($motor->status === 'rented') Disewa
                                        @elseif($motor->status === 'maintenance') Perawatan
                                        @else Pending
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Rp {{ number_format($motor->rental_price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @php
                                        $lastRental = $motor->rentals()->latest()->first();
                                    @endphp
                                    {{ $lastRental ? $lastRental->created_at->diffForHumans() : 'Belum pernah' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('owner.motors.edit', $motor) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                    <a href="{{ route('owner.motors.show', $motor) }}" class="text-green-600 hover:text-green-900">Detail</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Belum ada motor terdaftar
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Revenue Sharing Section -->
        <div id="section-revenue" class="section-content" style="display: none;">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Revenue Summary -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Total Revenue Card -->
                    <div class="revenue-card rounded-xl shadow-sm p-6 card">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-white text-lg font-bold mb-2">Total Pendapatan Anda</h3>
                                <p class="text-4xl font-bold text-white mb-2">Rp {{ number_format($totalRevenue * 0.8, 0, ',', '.') }}</p>
                                <p class="text-green-100 text-sm">80% dari total penyewaan motor Anda</p>
                            </div>
                            <div class="bg-white/20 rounded-lg p-3">
                                <i class="fas fa-chart-line text-white text-2xl"></i>
                            </div>
                        </div>
                        
                        <div class="mt-6 pt-4 border-t border-green-400/30">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-green-100 text-sm">Pendapatan Bulan Ini</p>
                                    <p class="text-white text-xl font-bold">Rp {{ number_format($totalRevenue * 0.8 * 0.3, 0, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-green-100 text-sm">Motor Aktif</p>
                                    <p class="text-white text-xl font-bold">{{ $activeRentals }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Revenue Breakdown -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 card">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Breakdown Bagi Hasil</h3>
                        
                        <div class="space-y-4">
                            <div class="bg-blue-50 rounded-lg p-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm font-medium text-blue-800">Total Penyewaan</p>
                                        <p class="text-2xl font-bold text-blue-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                                    </div>
                                    <i class="fas fa-motorcycle text-blue-600 text-2xl"></i>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-green-50 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-green-800">Bagian Anda (80%)</p>
                                            <p class="text-xl font-bold text-green-900">Rp {{ number_format($totalRevenue * 0.8, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-white text-sm"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">Platform (20%)</p>
                                            <p class="text-xl font-bold text-gray-900">Rp {{ number_format($totalRevenue * 0.2, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center">
                                            <i class="fas fa-building text-white text-sm"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Revenue Actions -->
                <div class="space-y-6">
                    <!-- Monthly Performance -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 card">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Performa Bulanan</h3>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">September 2025</span>
                                <span class="text-sm font-bold text-gray-900">Rp {{ number_format($totalRevenue * 0.8 * 0.3, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">Agustus 2025</span>
                                <span class="text-sm font-bold text-gray-900">Rp {{ number_format($totalRevenue * 0.8 * 0.4, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm font-medium text-gray-700">Juli 2025</span>
                                <span class="text-sm font-bold text-gray-900">Rp {{ number_format($totalRevenue * 0.8 * 0.3, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Revenue Actions -->
                    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 card">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Aksi</h3>
                        
                        <div class="space-y-3">
                            <a href="#" class="block w-full bg-blue-50 text-blue-700 border border-blue-200 px-4 py-3 rounded-lg hover:bg-blue-100 transition text-center">
                                <i class="fas fa-file-alt mr-2"></i>Laporan Detail
                            </a>
                            
                            <button onclick="exportRevenue()" class="w-full bg-green-50 text-green-700 border border-green-200 px-4 py-3 rounded-lg hover:bg-green-100 transition">
                                <i class="fas fa-download mr-2"></i>Export Excel
                            </button>
                            
                            <a href="{{ route('owner.motors.create') }}" class="block w-full bg-purple-50 text-purple-700 border border-purple-200 px-4 py-3 rounded-lg hover:bg-purple-100 transition text-center">
                                <i class="fas fa-plus mr-2"></i>Tambah Motor
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Revenue -->
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200 card">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Riwayat Bagi Hasil</h3>
                    <a href="#" class="text-blue-600 hover:text-blue-800 text-sm">Lihat Semua</a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyewa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Sewa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bagian Anda</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse(auth()->user()->ownedMotors()->whereHas('rentals')->with('rentals.renter')->latest()->take(10)->get() as $motor)
                                @foreach($motor->rentals()->latest()->take(2)->get() as $rental)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $rental->created_at->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $motor->brand }} {{ $motor->type }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $rental->renter->name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp {{ number_format($rental->total_amount, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                                        Rp {{ number_format($rental->total_amount * 0.8, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Dibayar
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Belum ada riwayat bagi hasil
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<script>
function showSection(section) {
    // Hide all sections
    const sections = ['overview', 'motors', 'status', 'revenue'];
    sections.forEach(s => {
        document.getElementById('section-' + s).style.display = 'none';
        document.getElementById('tab-' + s).classList.remove('active');
        document.getElementById('tab-' + s).classList.add('text-gray-500');
    });
    
    // Show selected section
    document.getElementById('section-' + section).style.display = 'block';
    document.getElementById('tab-' + section).classList.add('active');
    document.getElementById('tab-' + section).classList.remove('text-gray-500');
}

function updateAllMotorStatus(status) {
    if (confirm('Apakah Anda yakin ingin mengubah status semua motor?')) {
        // In real implementation, this would make an AJAX call
        alert('Fitur ini akan mengubah status semua motor Anda menjadi: ' + status);
    }
}

function exportRevenue() {
    // In real implementation, this would trigger a download
    alert('Export laporan bagi hasil akan segera dimulai...');
}

// Initialize default view
document.addEventListener('DOMContentLoaded', function() {
    showSection('overview');
});
</script>
</body>
</html>
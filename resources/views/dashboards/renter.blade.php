<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Penyewa - RentMotor</title>
    
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
        
        .motor-card {
            transition: all 0.3s ease;
        }
        
        .motor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-50 text-gray-800"
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('renter.dashboard') }}" class="text-2xl font-bold text-blue-600">
                        Rental Motor
                    </a>
                    <div class="ml-10 flex space-x-8">
                        <a href="{{ route('renter.dashboard') }}" class="text-blue-600 border-b-2 border-blue-600 px-1 pt-1 text-sm font-medium">Dashboard</a>
                        <a href="{{ route('renter.motors.index') }}" class="text-gray-500 hover:text-blue-600 px-1 pt-1 text-sm font-medium transition">Browse Motor</a>
                        <a href="{{ route('renter.rentals.index') }}" class="text-gray-500 hover:text-blue-600 px-1 pt-1 text-sm font-medium transition">Penyewaan Saya</a>
                        <a href="#" class="text-gray-500 hover:text-blue-600 px-1 pt-1 text-sm font-medium transition">Riwayat</a>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-700">{{ Auth::user()->name }}</span>
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">PENYEWA</span>
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

    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 card">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-white mb-2">Dashboard Penyewa Motor</h1>
                    <p class="text-blue-100 text-lg">Selamat datang kembali, {{ auth()->user()->name }}!</p>
                    <p class="text-blue-200 text-sm mt-2">Kelola penyewaan motor Anda dengan mudah dan aman</p>
                </div>
            </div>
        </div>    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100">
                        <i class="fas fa-motorcycle text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Penyewaan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalRentals }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Sewa Aktif</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $activeRentals }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100">
                        <i class="fas fa-clock text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pembayaran Tertunda</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $pendingPayments }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-200">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100">
                        <i class="fas fa-money-bill-wave text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Pengeluaran</p>
                        <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Aksi Cepat</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <button onclick="showBrowseMotors()" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition cursor-pointer">
                    <i class="fas fa-search text-blue-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-blue-900">Cari Motor</span>
                </button>
                
                <button onclick="showRentalPackages()" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition cursor-pointer">
                    <i class="fas fa-calendar-alt text-green-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-green-900">Paket Sewa</span>
                </button>
                
                <button onclick="showRentalHistory()" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition cursor-pointer">
                    <i class="fas fa-history text-purple-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-purple-900">Riwayat Sewa</span>
                </button>
                
                <button onclick="showPaymentStatus()" class="flex flex-col items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition cursor-pointer">
                    <i class="fas fa-credit-card text-orange-600 text-2xl mb-2"></i>
                    <span class="text-sm font-medium text-orange-900">Status Pembayaran</span>
                </button>
            </div>
        </div>

        <!-- Browse Motors Section -->
        <div id="browse-section" class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-200">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-900">Cari & Sewa Motor</h2>
                <button onclick="resetFilters()" class="text-blue-600 hover:text-blue-800">Reset Filter</button>
            </div>
            
            <!-- Filters -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Merk Motor</label>
                    <select id="brand-filter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Merk</option>
                        <option value="Honda">Honda</option>
                        <option value="Yamaha">Yamaha</option>
                        <option value="Suzuki">Suzuki</option>
                        <option value="Kawasaki">Kawasaki</option>
                        <option value="TVS">TVS</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipe CC</label>
                    <select id="cc-filter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Tipe</option>
                        <option value="100cc">100cc</option>
                        <option value="125cc">125cc</option>
                        <option value="150cc">150cc</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Harga Maksimal/Hari</label>
                    <input type="number" id="price-filter" placeholder="Contoh: 50000" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            
            <!-- Motor Grid -->
            <div id="motors-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($availableMotors as $motor)
                <div class="motor-card border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition" data-brand="{{ $motor->brand }}" data-type="{{ $motor->type }}" data-price="{{ $motor->rental_price }}">
                    <div class="h-48 bg-gray-100 flex items-center justify-center">
                        @if($motor->photo)
                            <img src="{{ asset('storage/' . $motor->photo) }}" alt="{{ $motor->brand }} {{ $motor->type }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-motorcycle text-4xl text-gray-400"></i>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-lg text-gray-900">{{ $motor->brand }} {{ $motor->type }}</h3>
                        <p class="text-gray-600 text-sm">{{ $motor->year }} • {{ $motor->color }} • {{ $motor->license_plate }}</p>
                        <p class="text-gray-700 mt-2 text-sm">{{ Str::limit($motor->description, 80) }}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <div>
                                <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($motor->rental_price, 0, ',', '.') }}</span>
                                <span class="text-gray-500 text-sm">/hari</span>
                            </div>
                            <button onclick="openRentalModal({{ $motor->id }})" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                Sewa Sekarang
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Rental Packages Section -->
        <div id="packages-section" class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-200" style="display: none;">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Paket Penyewaan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Daily Package -->
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition">
                    <div class="text-center">
                        <i class="fas fa-calendar-day text-blue-600 text-3xl mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Paket Harian</h3>
                        <p class="text-gray-600 mb-4">Sewa motor untuk 1-6 hari</p>
                        <div class="bg-blue-50 rounded-lg p-4 mb-4">
                            <p class="text-sm text-blue-800">Harga Normal</p>
                            <p class="text-gray-600 text-sm">Tanpa diskon khusus</p>
                        </div>
                        <ul class="text-left text-sm text-gray-600 space-y-2">
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Fleksibel untuk sewa singkat</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Pembayaran per hari</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Cocok untuk keperluan mendadak</li>
                        </ul>
                    </div>
                </div>
                
                <!-- Weekly Package -->
                <div class="border border-blue-200 rounded-lg p-6 bg-blue-50 hover:shadow-lg transition relative">
                    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                        <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm">Populer</span>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-calendar-week text-blue-600 text-3xl mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Paket Mingguan</h3>
                        <p class="text-gray-600 mb-4">Sewa motor untuk 7-29 hari</p>
                        <div class="bg-white rounded-lg p-4 mb-4">
                            <p class="text-lg font-bold text-blue-600">Diskon 10%</p>
                            <p class="text-gray-600 text-sm">dari harga harian</p>
                        </div>
                        <ul class="text-left text-sm text-gray-600 space-y-2">
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Hemat 10% dari harga harian</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Cocok untuk liburan panjang</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Pembayaran bisa dicicil</li>
                        </ul>
                    </div>
                </div>
                
                <!-- Monthly Package -->
                <div class="border border-green-200 rounded-lg p-6 bg-green-50 hover:shadow-lg transition relative">
                    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                        <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm">Hemat</span>
                    </div>
                    <div class="text-center">
                        <i class="fas fa-calendar text-green-600 text-3xl mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Paket Bulanan</h3>
                        <p class="text-gray-600 mb-4">Sewa motor 30+ hari</p>
                        <div class="bg-white rounded-lg p-4 mb-4">
                            <p class="text-lg font-bold text-green-600">Diskon 20%</p>
                            <p class="text-gray-600 text-sm">dari harga harian</p>
                        </div>
                        <ul class="text-left text-sm text-gray-600 space-y-2">
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Hemat 20% dari harga harian</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Ideal untuk kebutuhan jangka panjang</li>
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Prioritas maintenance</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Rentals -->
        @if($myRentals->count() > 0)
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-200">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Penyewaan Terkini</h2>
            <div class="space-y-4">
                @foreach($myRentals as $rental)
                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900">{{ $rental->motor->brand }} {{ $rental->motor->type }}</h3>
                            <p class="text-gray-600 text-sm">{{ $rental->start_date->format('d M Y') }} - {{ $rental->end_date->format('d M Y') }}</p>
                            <p class="text-gray-600 text-sm">{{ $rental->duration_days }} hari • Rp {{ number_format($rental->total_amount, 0, ',', '.') }}</p>
                        </div>
                        <div class="flex flex-col items-end space-y-2">
                            <span class="px-3 py-1 rounded-full text-xs font-medium {{ $rental->status_badge }}">
                                {{ ucfirst(str_replace('_', ' ', $rental->status)) }}
                            </span>
                            @if($rental->status === 'pending_payment')
                                <a href="{{ route('renter.payments.create', ['rental_id' => $rental->id]) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                    Bayar Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Rental History Section -->
        <div id="history-section" class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-200" style="display: none;">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-900">Riwayat Penyewaan</h2>
                <a href="{{ route('renter.rentals.index') }}" class="text-blue-600 hover:text-blue-800">Lihat Semua</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="rental-history-tbody">
                        @foreach($myRentals as $rental)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-motorcycle text-gray-500"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $rental->motor->brand }} {{ $rental->motor->type }}</div>
                                        <div class="text-sm text-gray-500">{{ $rental->motor->license_plate }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $rental->start_date->format('d/m/Y') }} - {{ $rental->end_date->format('d/m/Y') }}
                                <div class="text-xs text-gray-500">{{ $rental->duration_days }} hari</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                Rp {{ number_format($rental->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $rental->status_badge }}">
                                    {{ ucfirst(str_replace('_', ' ', $rental->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('renter.rentals.show', $rental) }}" class="text-blue-600 hover:text-blue-900">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment Status Section -->
        <div id="payments-section" class="bg-white rounded-xl shadow-sm p-6 mb-8 border border-gray-200" style="display: none;">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Status Pembayaran</h2>
            
            <div class="space-y-4">
                @foreach($myRentals->where('status', 'pending_payment') as $rental)
                <div class="border-l-4 border-yellow-400 bg-yellow-50 p-4 rounded-r-lg">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $rental->motor->brand }} {{ $rental->motor->type }}</h3>
                            <p class="text-gray-600 text-sm">Menunggu pembayaran sebesar Rp {{ number_format($rental->total_amount, 0, ',', '.') }}</p>
                            <p class="text-gray-500 text-xs mt-1">Deadline: {{ $rental->created_at->addDays(1)->format('d M Y, H:i') }}</p>
                        </div>
                        <a href="{{ route('renter.payments.create', ['rental_id' => $rental->id]) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition">
                            Bayar Sekarang
                        </a>
                    </div>
                </div>
                @endforeach
                
                @if($myRentals->where('status', 'pending_payment')->count() == 0)
                <div class="text-center py-8">
                    <i class="fas fa-check-circle text-green-500 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Semua Pembayaran Lunas</h3>
                    <p class="text-gray-600">Tidak ada pembayaran yang tertunda saat ini.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Rental Modal -->
<div id="rental-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Form Penyewaan Motor</h3>
                <button onclick="closeRentalModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <form id="rental-form" action="" method="POST">
                @csrf
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                            <input type="date" name="start_date" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                            <input type="date" name="end_date" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Paket Penyewaan</label>
                        <select name="rental_package" id="rental-package" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="daily">Harian (Harga Normal)</option>
                            <option value="weekly">Mingguan (Diskon 10%)</option>
                            <option value="monthly">Bulanan (Diskon 20%)</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Tambahan</label>
                        <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Catatan khusus untuk penyewaan ini (opsional)"></textarea>
                    </div>
                    
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-medium text-gray-900 mb-2">Ringkasan Pembayaran</h4>
                        <div class="space-y-1 text-sm">
                            <div class="flex justify-between">
                                <span>Harga per hari:</span>
                                <span id="daily-price">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Durasi:</span>
                                <span id="duration">-</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Subtotal:</span>
                                <span id="subtotal">-</span>
                            </div>
                            <div class="flex justify-between text-green-600">
                                <span>Diskon:</span>
                                <span id="discount">-</span>
                            </div>
                            <hr class="my-2">
                            <div class="flex justify-between font-bold">
                                <span>Total:</span>
                                <span id="total-amount">-</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="closeRentalModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Buat Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

    </div>
</div>

<script>
// Show/Hide Sections
function showBrowseMotors() {
    hideAllSections();
    document.getElementById('browse-section').style.display = 'block';
}

function showRentalPackages() {
    hideAllSections();
    document.getElementById('packages-section').style.display = 'block';
}

function showRentalHistory() {
    hideAllSections();
    document.getElementById('history-section').style.display = 'block';
}

function showPaymentStatus() {
    hideAllSections();
    document.getElementById('payments-section').style.display = 'block';
}

function hideAllSections() {
    document.getElementById('browse-section').style.display = 'none';
    document.getElementById('packages-section').style.display = 'none';
    document.getElementById('history-section').style.display = 'none';
    document.getElementById('payments-section').style.display = 'none';
}

// Motor Filtering
function resetFilters() {
    document.getElementById('brand-filter').value = '';
    document.getElementById('cc-filter').value = '';
    document.getElementById('price-filter').value = '';
    filterMotors();
}

function filterMotors() {
    const brandFilter = document.getElementById('brand-filter').value.toLowerCase();
    const ccFilter = document.getElementById('cc-filter').value.toLowerCase();
    const priceFilter = parseFloat(document.getElementById('price-filter').value) || Infinity;
    
    const motorCards = document.querySelectorAll('.motor-card');
    
    motorCards.forEach(card => {
        const brand = card.getAttribute('data-brand').toLowerCase();
        const type = card.getAttribute('data-type').toLowerCase();
        const price = parseFloat(card.getAttribute('data-price'));
        
        const brandMatch = !brandFilter || brand.includes(brandFilter);
        const ccMatch = !ccFilter || type.includes(ccFilter);
        const priceMatch = price <= priceFilter;
        
        if (brandMatch && ccMatch && priceMatch) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Add event listeners for filters
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('brand-filter').addEventListener('change', filterMotors);
    document.getElementById('cc-filter').addEventListener('change', filterMotors);
    document.getElementById('price-filter').addEventListener('input', filterMotors);
});

// Rental Modal
function openRentalModal(motorId) {
    document.getElementById('rental-modal').classList.remove('hidden');
    const form = document.getElementById('rental-form');
    form.action = `/renter/motors/${motorId}/rent`;
    
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    form.querySelector('input[name="start_date"]').min = today;
    form.querySelector('input[name="end_date"]').min = today;
    
    // Set default start date to today
    form.querySelector('input[name="start_date"]').value = today;
}

function closeRentalModal() {
    document.getElementById('rental-modal').classList.add('hidden');
}

// Calculate rental costs
function calculateRentalCost() {
    const startDate = new Date(document.querySelector('input[name="start_date"]').value);
    const endDate = new Date(document.querySelector('input[name="end_date"]').value);
    const package = document.getElementById('rental-package').value;
    
    if (startDate && endDate && startDate < endDate) {
        const days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
        const dailyPrice = 75000; // This should be dynamic based on selected motor
        
        let discount = 0;
        if (package === 'weekly' && days >= 7) {
            discount = 0.1;
        } else if (package === 'monthly' && days >= 30) {
            discount = 0.2;
        }
        
        const subtotal = days * dailyPrice;
        const discountAmount = subtotal * discount;
        const total = subtotal - discountAmount;
        
        document.getElementById('daily-price').textContent = `Rp ${dailyPrice.toLocaleString()}`;
        document.getElementById('duration').textContent = `${days} hari`;
        document.getElementById('subtotal').textContent = `Rp ${subtotal.toLocaleString()}`;
        document.getElementById('discount').textContent = discount > 0 ? `-Rp ${discountAmount.toLocaleString()}` : '-';
        document.getElementById('total-amount').textContent = `Rp ${total.toLocaleString()}`;
    }
}

// Add event listeners for rental calculation
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('input[name="start_date"]').addEventListener('change', calculateRentalCost);
    document.querySelector('input[name="end_date"]').addEventListener('change', calculateRentalCost);
    document.getElementById('rental-package').addEventListener('change', calculateRentalCost);
    
    // Initialize default view
    showBrowseMotors();
});

// Close modal when clicking outside
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('rental-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRentalModal();
        }
    });
});
</script>
</body>
</html>
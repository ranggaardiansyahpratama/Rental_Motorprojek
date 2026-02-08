<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail User - RentMotor</title>
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white dark:bg-gray-800 shadow-lg">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">🏍️ RentMotor</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Admin Panel</p>
            </div>
            
            <nav class="mt-6">
                <div class="px-6 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" 
                       class="flex items-center px-4 py-2 bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300 rounded-lg">
                        <i class="fas fa-users mr-3"></i>
                        Manajemen User
                    </a>
                    
                    <a href="{{ route('admin.motors.index') }}" 
                       class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-motorcycle mr-3"></i>
                        Motor
                    </a>
                    
                    <a href="{{ route('admin.rentals.index') }}" 
                       class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-file-contract mr-3"></i>
                        Penyewaan
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('admin.users.index') }}" 
                           class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                            <i class="fas fa-arrow-left text-lg"></i>
                        </a>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detail User</h1>
                            <p class="text-gray-600 dark:text-gray-400">Informasi lengkap pengguna</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.users.edit', $user) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-edit mr-2"></i>
                            Edit User
                        </a>
                        
                        @if($user->id !== auth()->id())
                            <form class="inline-block" method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                    <i class="fas fa-trash mr-2"></i>
                                    Hapus User
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- User Info Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <div class="text-center mb-6">
                            <div class="mx-auto h-24 w-24 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center mb-4">
                                <i class="fas fa-user text-3xl text-gray-500 dark:text-gray-400"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h2>
                            <p class="text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                            
                            <span class="inline-flex mt-3 px-3 py-1 text-sm font-semibold rounded-full 
                                @if($user->role === 'admin') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300
                                @elseif($user->role === 'owner') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                                @else bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300 @endif">
                                <i class="fas fa-{{ $user->role === 'admin' ? 'user-shield' : ($user->role === 'owner' ? 'motorcycle' : 'user') }} mr-1"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>

                        <div class="space-y-4">
                            @if($user->phone)
                                <div class="flex items-center">
                                    <i class="fas fa-phone text-gray-400 dark:text-gray-500 w-5"></i>
                                    <span class="ml-3 text-gray-900 dark:text-white">{{ $user->phone }}</span>
                                </div>
                            @endif
                            
                            @if($user->address)
                                <div class="flex items-start">
                                    <i class="fas fa-map-marker-alt text-gray-400 dark:text-gray-500 w-5 mt-1"></i>
                                    <span class="ml-3 text-gray-900 dark:text-white">{{ $user->address }}</span>
                                </div>
                            @endif
                            
                            <div class="flex items-center">
                                <i class="fas fa-calendar text-gray-400 dark:text-gray-500 w-5"></i>
                                <span class="ml-3 text-gray-900 dark:text-white">
                                    Bergabung {{ $user->created_at->format('d M Y') }}
                                </span>
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fas fa-clock text-gray-400 dark:text-gray-500 w-5"></i>
                                <span class="ml-3 text-gray-900 dark:text-white">
                                    Terakhir update {{ $user->updated_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity & Statistics -->
                <div class="lg:col-span-2">
                    <div class="space-y-6">
                        
                        <!-- Statistics Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if($user->role === 'owner')
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-motorcycle text-2xl text-blue-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Motor</p>
                                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                                {{ $user->ownedMotors()->count() ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-check-circle text-2xl text-green-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Motor Aktif</p>
                                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                                {{ $user->ownedMotors()->whereIn('status', ['available', 'rented'])->count() ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-money-bill-wave text-2xl text-yellow-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Pendapatan</p>
                                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                                Rp {{ number_format($user->revenueShares()->where('status', 'paid')->sum('owner_share') ?? 0, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                            @elseif($user->role === 'renter')
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-file-contract text-2xl text-blue-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Sewa</p>
                                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                                {{ $user->rentals()->count() ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-clock text-2xl text-yellow-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Sewa Aktif</p>
                                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                                {{ $user->rentals()->where('status', 'active')->count() ?? 0 }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <i class="fas fa-money-bill-wave text-2xl text-green-600"></i>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Pengeluaran</p>
                                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                                Rp {{ number_format($user->rentals()->whereIn('status', ['completed', 'active'])->sum('total_amount') ?? 0, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Recent Activity -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Aktivitas Terbaru</h3>
                            </div>
                            
                            <div class="p-6">
                                @if($user->role === 'owner')
                                    @php
                                        $recentMotors = $user->ownedMotors()->latest()->limit(5)->get();
                                    @endphp
                                    
                                    @forelse($recentMotors as $motor)
                                        <div class="flex items-center py-3 @if(!$loop->last) border-b border-gray-200 dark:border-gray-700 @endif">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-motorcycle text-blue-600"></i>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <p class="text-sm text-gray-900 dark:text-white">
                                                    Motor <strong>{{ $motor->brand }} {{ $motor->model }}</strong>
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $motor->created_at->diffForHumans() }} • Status: {{ ucfirst($motor->status) }}
                                                </p>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada motor yang didaftarkan</p>
                                    @endforelse
                                    
                                @elseif($user->role === 'renter')
                                    @php
                                        $recentRentals = $user->rentals()->with('motor')->latest()->limit(5)->get();
                                    @endphp
                                    
                                    @forelse($recentRentals as $rental)
                                        <div class="flex items-center py-3 @if(!$loop->last) border-b border-gray-200 dark:border-gray-700 @endif">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-file-contract text-green-600"></i>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <p class="text-sm text-gray-900 dark:text-white">
                                                    Sewa <strong>{{ $rental->motor->brand }} {{ $rental->motor->model }}</strong>
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $rental->created_at->diffForHumans() }} • Status: {{ ucfirst($rental->status) }}
                                                </p>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">Belum ada aktivitas penyewaan</p>
                                    @endforelse
                                @else
                                    <p class="text-gray-500 dark:text-gray-400 text-center py-4">Pengguna Admin - Tidak ada aktivitas spesifik</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Pembayaran - RentMotor</title>
    
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
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" 
                           class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>
                        
                        <a href="{{ route('admin.users.index') }}" 
                           class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-users mr-3"></i>
                            Kelola User
                        </a>
                        
                        <a href="{{ route('admin.payments.index') }}" 
                           class="flex items-center px-4 py-2 bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300 rounded-lg">
                            <i class="fas fa-credit-card mr-3"></i>
                            Kelola Pembayaran
                        </a>
                        
                        <a href="{{ route('admin.motors.index') }}" 
                           class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-motorcycle mr-3"></i>
                            Kelola Motor
                        </a>
                        
                        <a href="{{ route('admin.rentals.index') }}" 
                           class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <i class="fas fa-calendar-check mr-3"></i>
                            Kelola Penyewaan
                        </a>
                    @endif
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detail Pembayaran</h1>
                        <p class="text-gray-600 dark:text-gray-400">Informasi lengkap transaksi pembayaran</p>
                    </div>
                    
                    <div class="flex gap-3">
                        @if($payment->status === 'pending')
                            <form method="POST" action="{{ route('admin.payments.update', $payment) }}" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="action" value="confirm">
                                <button type="submit" 
                                        class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Konfirmasi Pembayaran
                                </button>
                            </form>
                        @endif
                        
                        <a href="{{ route(auth()->user()->role . '.payments.edit', $payment) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-edit mr-2"></i>
                            Edit
                        </a>
                        
                        <a href="{{ route(auth()->user()->role . '.payments.index') }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>
            </div>

            <!-- Payment Status Card -->
            <div class="mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full 
                                @if($payment->status === 'confirmed') bg-green-100 text-green-600
                                @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-600
                                @else bg-red-100 text-red-600 @endif">
                                @if($payment->status === 'confirmed') <i class="fas fa-check-circle text-2xl"></i>
                                @elseif($payment->status === 'pending') <i class="fas fa-clock text-2xl"></i>
                                @else <i class="fas fa-times-circle text-2xl"></i> @endif
                            </div>
                            <div class="ml-4">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                                    @if($payment->status === 'confirmed') Pembayaran Terkonfirmasi
                                    @elseif($payment->status === 'pending') Menunggu Konfirmasi
                                    @else Pembayaran Dibatalkan @endif
                                </h3>
                                <p class="text-lg text-gray-600 dark:text-gray-400">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500 dark:text-gray-400">ID Pembayaran</p>
                            <p class="text-lg font-mono font-bold text-gray-900 dark:text-white">#{{ $payment->id }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Payment Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            <i class="fas fa-credit-card mr-2"></i>
                            Informasi Pembayaran
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Jumlah Pembayaran</label>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Metode Pembayaran</label>
                            <p class="text-gray-900 dark:text-white">
                                @if($payment->payment_method === 'bank_transfer')
                                    <i class="fas fa-university mr-2"></i> Transfer Bank
                                @elseif($payment->payment_method === 'cash')
                                    <i class="fas fa-money-bill mr-2"></i> Tunai
                                @elseif($payment->payment_method === 'e_wallet')
                                    <i class="fas fa-mobile-alt mr-2"></i> E-Wallet
                                @else
                                    {{ ucfirst($payment->payment_method) }}
                                @endif
                            </p>
                        </div>
                        
                        @if($payment->transaction_id)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">ID Transaksi</label>
                                <p class="text-gray-900 dark:text-white font-mono">{{ $payment->transaction_id }}</p>
                            </div>
                        @endif
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                                @if($payment->status === 'confirmed') bg-green-100 text-green-800
                                @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                @if($payment->status === 'confirmed') Terkonfirmasi
                                @elseif($payment->status === 'pending') Menunggu Konfirmasi
                                @else Dibatalkan @endif
                            </span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tanggal Pembayaran</label>
                            <p class="text-gray-900 dark:text-white">{{ $payment->created_at->format('d M Y H:i') }}</p>
                        </div>
                        
                        @if($payment->payment_notes)
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Catatan</label>
                                <p class="text-gray-900 dark:text-white">{{ $payment->payment_notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Rental Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            <i class="fas fa-calendar-check mr-2"></i>
                            Informasi Penyewaan
                        </h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Motor</label>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $payment->rental->motor->brand }} {{ $payment->rental->motor->type }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $payment->rental->motor->license_plate }} • {{ $payment->rental->motor->year }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Penyewa</label>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $payment->rental->renter->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $payment->rental->renter->email }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $payment->rental->renter->phone }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Pemilik Motor</label>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $payment->rental->motor->owner->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $payment->rental->motor->owner->phone }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Periode Sewa</label>
                            <p class="text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($payment->rental->start_date)->format('d M Y') }} - 
                                {{ \Carbon\Carbon::parse($payment->rental->end_date)->format('d M Y') }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $payment->rental->duration }} hari</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tarif Harian</label>
                            <p class="text-gray-900 dark:text-white">
                                Rp {{ number_format($payment->rental->motor->daily_rate, 0, ',', '.') }}
                            </p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Penyewaan</label>
                            <p class="text-xl font-bold text-gray-900 dark:text-white">
                                Rp {{ number_format($payment->rental->total_amount, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Sharing -->
            @if($payment->revenueShares->isNotEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-8">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            <i class="fas fa-chart-pie mr-2"></i>
                            Bagi Hasil
                        </h3>
                    </div>
                    <div class="p-6">
                        @foreach($payment->revenueShares as $share)
                            <div class="flex justify-between items-center p-4 border border-gray-200 dark:border-gray-600 rounded-lg mb-4 last:mb-0">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">
                                        {{ $share->payment->rental->motor->owner->name }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Pemilik Motor • {{ $share->percentage }}% dari total pembayaran
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-gray-900 dark:text-white">
                                        Rp {{ number_format($share->owner_share, 0, ',', '.') }}
                                    </p>
                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($share->is_paid) bg-green-100 text-green-800 
                                            @else bg-red-100 text-red-800 @endif">
                                            @if($share->is_paid) Sudah Dibayar @else Belum Dibayar @endif
                                        </span>
                                        @if(!$share->is_paid && $payment->status === 'confirmed')
                                            <form method="POST" action="{{ route('admin.payments.mark-revenue-paid', $share) }}" class="inline">
                                                @csrf
                                                @method('POST')
                                                <button type="submit" 
                                                        class="text-xs bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded transition-colors">
                                                    Tandai Dibayar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                    @if($share->paid_at)
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            Dibayar: {{ $share->paid_at->format('d M Y') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-blue-800 dark:text-blue-200">Platform Fee</span>
                                <span class="font-bold text-blue-900 dark:text-blue-100">
                                    Rp {{ number_format($payment->amount - $payment->revenueShares->sum('owner_share'), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Activity Timeline -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        <i class="fas fa-history mr-2"></i>
                        Riwayat Aktivitas
                    </h3>
                </div>
                <div class="p-6">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            <li>
                                <div class="relative pb-8">
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                <i class="fas fa-plus text-white text-xs"></i>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    Pembayaran dibuat
                                                </p>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                {{ $payment->created_at->format('d M Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            
                            @if($payment->status === 'confirmed')
                                <li>
                                    <div class="relative pb-8">
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                    <i class="fas fa-check text-white text-xs"></i>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        Pembayaran dikonfirmasi
                                                    </p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                    {{ $payment->updated_at->format('d M Y H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                            
                            @if($payment->revenueShares->isNotEmpty())
                                <li>
                                    <div class="relative">
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full bg-purple-500 flex items-center justify-center ring-8 ring-white dark:ring-gray-800">
                                                    <i class="fas fa-chart-pie text-white text-xs"></i>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        Bagi hasil dibuat untuk {{ $payment->revenueShares->count() }} pemilik
                                                    </p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500 dark:text-gray-400">
                                                    {{ $payment->revenueShares->first()->created_at->format('d M Y H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
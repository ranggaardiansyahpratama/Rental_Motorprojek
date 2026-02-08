<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Pembayaran - RentMotor</title>
    
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
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Entri Transaksi Pembayaran</h1>
                        <p class="text-gray-600 dark:text-gray-400">Tambah pembayaran manual untuk penyewaan</p>
                    </div>
                    
                    <a href="{{ route('admin.payments.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Form Pembayaran</h3>
                </div>
                
                <form method="POST" action="{{ route('admin.payments.store') }}" class="p-6">
                    @csrf
                    
                    <!-- Rental Selection -->
                    <div class="mb-6">
                        <label for="rental_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Pilih Penyewaan *
                        </label>
                        <select name="rental_id" id="rental_id" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">-- Pilih Penyewaan --</option>
                            @foreach($unpaidRentals as $rental)
                                <option value="{{ $rental->id }}" data-amount="{{ $rental->total_amount }}">
                                    {{ $rental->motor->brand }} {{ $rental->motor->type }} ({{ $rental->motor->license_plate }}) - 
                                    {{ $rental->renter->name }} - 
                                    Rp {{ number_format($rental->total_amount, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('rental_id')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Amount -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Jumlah Pembayaran *
                            </label>
                            <input type="number" name="amount" id="amount" required min="1" step="1000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="Masukkan jumlah pembayaran">
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Metode Pembayaran *
                            </label>
                            <input type="hidden" name="payment_method" value="cash">
                            <div class="w-full px-3 py-2 border border-gray-300 rounded-md bg-green-50 dark:bg-green-900 dark:border-green-600">
                                <div class="flex items-center">
                                    <i class="fas fa-money-bill-wave text-green-600 mr-2"></i>
                                    <span class="text-green-800 dark:text-green-200 font-medium">💵 PEMBAYARAN TUNAI</span>
                                </div>
                                <p class="text-xs text-green-600 dark:text-green-300 mt-1">Hanya menerima pembayaran tunai langsung</p>
                            </div>
                        </div>
                    </div>

                    <!-- Transaction Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="transaction_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nomor Struk Pembayaran
                            </label>
                            <input type="text" name="transaction_id" id="transaction_id" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="Akan otomatis dibuatkan jika kosong"
                                   value="CASH-{{ date('Ymd') }}-{{ str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT) }}">
                            @error('transaction_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Status Pembayaran *
                            </label>
                            <select name="status" id="status" required 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="pending">Menunggu Verifikasi</option>
                                <option value="confirmed" selected>Terkonfirmasi</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Payment Notes -->
                    <div class="mb-6">
                        <label for="payment_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Catatan Pembayaran
                        </label>
                        <textarea name="payment_notes" id="payment_notes" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                  placeholder="Catatan tambahan untuk pembayaran ini..."></textarea>
                        @error('payment_notes')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Revenue Sharing -->
                    <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-chart-pie text-blue-600 mr-2"></i>
                            <h4 class="text-sm font-medium text-blue-800 dark:text-blue-200">Bagi Hasil Otomatis</h4>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="owner_percentage" class="block text-sm font-medium text-blue-700 dark:text-blue-300 mb-1">
                                    Persentase Pemilik Motor (%)
                                </label>
                                <input type="number" name="owner_percentage" id="owner_percentage" value="70" min="0" max="100" step="1"
                                       class="w-full px-3 py-2 border border-blue-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-blue-800 dark:border-blue-600 dark:text-blue-100">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-blue-700 dark:text-blue-300 mb-1">
                                    Persentase Platform
                                </label>
                                <input type="text" id="platform_percentage" value="30" readonly 
                                       class="w-full px-3 py-2 border border-blue-300 rounded-md bg-blue-100 dark:bg-blue-800 dark:border-blue-600 dark:text-blue-800 dark:text-blue-200">
                            </div>
                        </div>
                        
                        <p class="text-xs text-blue-600 dark:text-blue-300 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Bagi hasil akan dihitung otomatis berdasarkan persentase yang ditentukan.
                        </p>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit" name="action" value="save_and_receipt"
                                class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors shadow-lg">
                            <i class="fas fa-receipt mr-2"></i>
                            💰 Proses Pembayaran Tunai & Cetak Struk
                        </button>
                        
                        <a href="{{ route('admin.payments.index') }}" 
                           class="flex-1 text-center bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Auto-fill amount when rental is selected
        document.getElementById('rental_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const amount = selectedOption.getAttribute('data-amount');
            if (amount) {
                document.getElementById('amount').value = amount;
            }
        });

        // Auto-calculate platform percentage
        document.getElementById('owner_percentage').addEventListener('input', function() {
            const ownerPercentage = parseInt(this.value) || 0;
            const platformPercentage = 100 - ownerPercentage;
            document.getElementById('platform_percentage').value = platformPercentage;
        });
    </script>
</body>
</html>
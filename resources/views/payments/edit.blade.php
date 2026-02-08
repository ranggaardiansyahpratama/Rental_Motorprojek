<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Pembayaran - RentMotor</title>
    
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
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Pembayaran</h1>
                        <p class="text-gray-600 dark:text-gray-400">Update data pembayaran penyewaan</p>
                    </div>
                    
                    <a href="{{ route('admin.payments.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Payment Info Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Penyewaan</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Motor</label>
                            <p class="text-gray-900 dark:text-white font-medium">
                                {{ $payment->rental->motor->brand }} {{ $payment->rental->motor->type }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $payment->rental->motor->license_plate }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Penyewa</label>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $payment->rental->renter->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $payment->rental->renter->email }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Periode Sewa</label>
                            <p class="text-gray-900 dark:text-white font-medium">
                                {{ \Carbon\Carbon::parse($payment->rental->start_date)->format('d M Y') }} - 
                                {{ \Carbon\Carbon::parse($payment->rental->end_date)->format('d M Y') }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $payment->rental->duration }} hari</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form Card -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Data Pembayaran</h3>
                </div>
                
                <form method="POST" action="{{ route('admin.payments.update', $payment) }}" class="p-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Amount & Payment Method -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Jumlah Pembayaran *
                            </label>
                            <input type="number" name="amount" id="amount" required min="1" step="1000"
                                   value="{{ old('amount', $payment->amount) }}"
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
                            <select name="payment_method" id="payment_method" required 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="">-- Pilih Metode --</option>
                                <option value="cash" {{ old('payment_method', $payment->payment_method) === 'cash' ? 'selected' : '' }}>Tunai</option>
                                <option value="bank_transfer" {{ old('payment_method', $payment->payment_method) === 'bank_transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="e_wallet" {{ old('payment_method', $payment->payment_method) === 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                            </select>
                            @error('payment_method')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Transaction Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="transaction_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                ID Transaksi / Referensi
                            </label>
                            <input type="text" name="transaction_id" id="transaction_id" 
                                   value="{{ old('transaction_id', $payment->transaction_id) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                   placeholder="Nomor referensi pembayaran">
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
                                <option value="pending" {{ old('status', $payment->status) === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                <option value="confirmed" {{ old('status', $payment->status) === 'confirmed' ? 'selected' : '' }}>Terkonfirmasi</option>
                                <option value="cancelled" {{ old('status', $payment->status) === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
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
                                  placeholder="Catatan tambahan untuk pembayaran ini...">{{ old('payment_notes', $payment->payment_notes) }}</textarea>
                        @error('payment_notes')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Revenue Sharing Info (if exists) -->
                    @if($payment->revenueShares->isNotEmpty())
                        <div class="mb-6 p-4 bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 rounded-lg">
                            <div class="flex items-center mb-3">
                                <i class="fas fa-chart-pie text-yellow-600 mr-2"></i>
                                <h4 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Informasi Bagi Hasil</h4>
                            </div>
                            
                            @foreach($payment->revenueShares as $share)
                                <div class="flex justify-between items-center mb-2 last:mb-0">
                                    <span class="text-sm text-yellow-700 dark:text-yellow-300">
                                        {{ $share->payment->rental->motor->owner->name }} ({{ $share->percentage }}%)
                                    </span>
                                    <div class="text-right">
                                        <span class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                            Rp {{ number_format($share->owner_share, 0, ',', '.') }}
                                        </span>
                                        <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($share->is_paid) bg-green-100 text-green-800 
                                            @else bg-red-100 text-red-800 @endif">
                                            @if($share->is_paid) Dibayar @else Belum Dibayar @endif
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                            
                            <p class="text-xs text-yellow-600 dark:text-yellow-300 mt-3">
                                <i class="fas fa-info-circle mr-1"></i>
                                Bagi hasil sudah dibuat untuk pembayaran ini. Untuk mengubah bagi hasil, silakan kelola dari menu terpisah.
                            </p>
                        </div>
                    @endif

                    <!-- Status Change Log -->
                    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-800 dark:text-gray-200 mb-3">
                            <i class="fas fa-history mr-2"></i>
                            Riwayat Status
                        </h4>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Dibuat:</span>
                                <span class="text-gray-900 dark:text-white">{{ $payment->created_at->format('d M Y H:i') }}</span>
                            </div>
                            @if($payment->updated_at != $payment->created_at)
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Diupdate:</span>
                                    <span class="text-gray-900 dark:text-white">{{ $payment->updated_at->format('d M Y H:i') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <button type="submit" 
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-save mr-2"></i>
                            Update Pembayaran
                        </button>
                        
                        @if($payment->status === 'pending')
                            <button type="submit" name="action" value="confirm"
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-check-circle mr-2"></i>
                                Konfirmasi Pembayaran
                            </button>
                        @endif
                        
                        <a href="{{ route('admin.payments.show', $payment) }}" 
                           class="flex-1 text-center bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-eye mr-2"></i>
                            Detail
                        </a>
                        
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
</body>
</html>
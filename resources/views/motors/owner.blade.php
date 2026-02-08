<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Motor Saya - RentMotor</title>
    
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('owner.dashboard') }}" class="text-2xl font-bold text-green-600">
                        🏍️ RentMotor
                    </a>
                    <div class="ml-10 flex space-x-8">
                        <a href="{{ route('owner.dashboard') }}" class="text-gray-500 hover:text-gray-700 px-1 pt-1 text-sm font-medium">Dashboard</a>
                        <a href="{{ route('owner.motors.index') }}" class="text-green-600 border-b-2 border-green-600 px-1 pt-1 text-sm font-medium">Motor Saya</a>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-700">{{ Auth::user()->name }}</span>
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">PEMILIK</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Motor Saya</h1>
                <p class="text-gray-600 mt-1">Kelola motor yang telah Anda daftarkan</p>
            </div>
            <a href="{{ route('owner.motors.create') }}" 
               class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                ➕ Daftarkan Motor Baru
            </a>
        </div>

        @if($motors->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($motors as $motor)
                <div class="bg-white rounded-lg shadow-lg">
                    <div class="p-6">
                        <!-- Motor Header -->
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $motor->brand }} {{ $motor->type }}</h3>
                                <p class="text-sm text-gray-600">{{ $motor->license_plate }} • {{ $motor->color }} • {{ $motor->year }}</p>
                            </div>
                            <span class="inline-block px-3 py-1 text-xs rounded-full {{ $motor->status_badge }}">
                                {{ ucfirst(str_replace('_', ' ', $motor->status)) }}
                            </span>
                        </div>

                        <!-- Motor Image -->
                        <div class="mb-4">
                            @if($motor->photo)
                                <img src="{{ asset('storage/' . $motor->photo) }}" alt="Motor" class="w-full h-48 object-cover rounded-lg">
                            @else
                                <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-500">Tidak ada foto</span>
                                </div>
                            @endif
                        </div>

                        <!-- Motor Info -->
                        <div class="space-y-2 mb-4">
                            @if($motor->engine_capacity)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Kapasitas Mesin:</span>
                                <span class="font-medium">{{ $motor->engine_capacity }} CC</span>
                            </div>
                            @endif
                            
                            @if($motor->rental_price)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Harga Sewa:</span>
                                <span class="font-semibold text-green-600">Rp {{ number_format($motor->rental_price, 0, ',', '.') }}/hari</span>
                            </div>
                            @endif
                            
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Didaftarkan:</span>
                                <span class="font-medium">{{ $motor->created_at->format('d M Y') }}</span>
                            </div>
                        </div>

                        @if($motor->description)
                        <div class="mb-4">
                            <p class="text-sm text-gray-700">{{ $motor->description }}</p>
                        </div>
                        @endif

                        <!-- Status Information -->
                        @if($motor->status === 'pending_verification')
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-yellow-800">Menunggu Verifikasi</h4>
                                    <p class="text-sm text-yellow-700 mt-1">Motor sedang diverifikasi admin. Harga sewa akan ditentukan setelah verifikasi.</p>
                                </div>
                            </div>
                        </div>
                        @elseif($motor->status === 'available')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-green-800">Motor Tersedia</h4>
                                    <p class="text-sm text-green-700 mt-1">Motor siap disewakan dengan harga Rp {{ number_format($motor->rental_price, 0, ',', '.') }}/hari</p>
                                    @if($motor->admin_notes)
                                    <p class="text-xs text-green-600 mt-1">Catatan: {{ $motor->admin_notes }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @elseif($motor->status === 'rented')
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 mb-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-blue-800">Sedang Disewa</h4>
                                    <p class="text-sm text-blue-700 mt-1">Motor sedang disewa. Anda akan mendapat bagi hasil setelah penyewaan selesai.</p>
                                </div>
                            </div>
                        </div>
                        @elseif($motor->status === 'rejected')
                        <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="ml-3">
                                    <h4 class="text-sm font-medium text-red-800">Motor Ditolak</h4>
                                    @if($motor->admin_notes)
                                    <p class="text-sm text-red-700 mt-1">Alasan: {{ $motor->admin_notes }}</p>
                                    @endif
                                    <p class="text-xs text-red-600 mt-1">Silakan perbaiki data motor dan daftarkan ulang.</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex space-x-3">
                            <a href="{{ route('owner.motors.show', $motor) }}" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md text-center transition duration-200">
                                👁️ Lihat Detail
                            </a>
                            
                            @if($motor->status === 'pending_verification' || $motor->status === 'rejected')
                            <a href="{{ route('owner.motors.edit', $motor) }}" 
                               class="bg-yellow-600 hover:bg-yellow-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
                                ✏️ Edit
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $motors->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h3M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 8h5a2 2 0 002-2V9a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Motor Terdaftar</h3>
                <p class="text-gray-500 mb-4">Mulai daftarkan motor Anda untuk mendapatkan penghasilan dari penyewaan</p>
                <a href="{{ route('owner.motors.create') }}" 
                   class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                    ➕ Daftarkan Motor Pertama
                </a>
            </div>
        @endif
    </div>
</body>
</html>
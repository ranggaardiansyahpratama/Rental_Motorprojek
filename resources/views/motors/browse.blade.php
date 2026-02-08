<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pilih Motor - RentMotor</title>
    
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('renter.dashboard') }}" class="text-2xl font-bold text-green-600">
                        🏍️ RentMotor
                    </a>
                    <div class="ml-10 flex space-x-8">
                        <a href="{{ route('renter.dashboard') }}" class="text-gray-500 hover:text-gray-700 px-1 pt-1 text-sm font-medium">Dashboard</a>
                        <a href="{{ route('renter.motors.index') }}" class="text-green-600 border-b-2 border-green-600 px-1 pt-1 text-sm font-medium">Pilih Motor</a>
                        <a href="{{ route('renter.rentals.index') }}" class="text-gray-500 hover:text-gray-700 px-1 pt-1 text-sm font-medium">Penyewaan Saya</a>
                        <a href="{{ route('renter.payments.index') }}" class="text-gray-500 hover:text-gray-700 px-1 pt-1 text-sm font-medium">Pembayaran</a>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-700">{{ Auth::user()->name }}</span>
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">PENYEWA</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-500 to-teal-600 rounded-lg shadow-lg mb-6">
            <div class="px-6 py-8">
                <h1 class="text-3xl font-bold text-white">Pilih Motor untuk Disewa</h1>
                <p class="text-green-100 mt-2">Temukan motor yang sesuai dengan kebutuhan perjalanan Anda</p>
            </div>
        </div>

        <!-- Filter & Search -->
        <div class="bg-white rounded-lg shadow-lg mb-6">
            <div class="p-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kapasitas Mesin</label>
                        <select name="engine_capacity" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500">
                            <option value="">Semua Kapasitas</option>
                            <option value="100" {{ request('engine_capacity') === '100' ? 'selected' : '' }}>100 CC</option>
                            <option value="125" {{ request('engine_capacity') === '125' ? 'selected' : '' }}>125 CC</option>
                            <option value="150" {{ request('engine_capacity') === '150' ? 'selected' : '' }}>150 CC</option>
                            <option value="250" {{ request('engine_capacity') === '250' ? 'selected' : '' }}>250 CC</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Rentang Harga/Hari</label>
                        <select name="price_range" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500">
                            <option value="">Semua Harga</option>
                            <option value="0-50000" {{ request('price_range') === '0-50000' ? 'selected' : '' }}>< Rp 50,000</option>
                            <option value="50000-100000" {{ request('price_range') === '50000-100000' ? 'selected' : '' }}>Rp 50,000 - 100,000</option>
                            <option value="100000-150000" {{ request('price_range') === '100000-150000' ? 'selected' : '' }}>Rp 100,000 - 150,000</option>
                            <option value="150000-999999" {{ request('price_range') === '150000-999999' ? 'selected' : '' }}>> Rp 150,000</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                        <select name="year" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500">
                            <option value="">Semua Tahun</option>
                            @for($year = date('Y'); $year >= 2015; $year--)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
                            🔍 Filter Motor
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Motors Grid -->
        @if($motors->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($motors as $motor)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <!-- Motor Image -->
                    <div class="relative">
                        @if($motor->photo)
                            <img src="{{ asset('storage/' . $motor->photo) }}" alt="{{ $motor->brand }} {{ $motor->type }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Price Badge -->
                        <div class="absolute top-4 right-4 focus:ring-4">
                            <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-semibold shadow-lg">
                                Rp {{ number_format($motor->daily_rate ?? $motor->rental_price, 0, ',', '.') }}/hari
                            </span>
                        </div>
                    </div>

                    <!-- Motor Info -->
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $motor->brand }} {{ $motor->type }}</h3>
                                <p class="text-sm text-gray-600">{{ $motor->license_plate }} • {{ $motor->year }}</p>
                            </div>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">
                                TERSEDIA
                            </span>
                        </div>

                        <!-- Motor Details -->
                        <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h3a1 1 0 110 2h-1v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6H3a1 1 0 110-2h4zM9 6v10h6V6H9z"></path>
                                </svg>
                                <span class="text-gray-600">{{ $motor->color }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <span class="text-gray-600">{{ $motor->engine_capacity ?? '-' }} CC</span>
                            </div>
                            <div class="flex items-center col-span-2">
                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="text-gray-600">Pemilik: {{ $motor->owner->name }}</span>
                            </div>
                        </div>

                        <!-- Price Packages -->
                        <div class="mb-4 bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Paket Sewa:</h4>
                            <div class="space-y-1">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Harian:</span>
                                    <span class="font-bold text-green-700">Rp {{ number_format($motor->daily_rate ?? $motor->rental_price, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Mingguan:</span>
                                    <span class="font-semibold text-blue-700">Rp {{ number_format($motor->weekly_rate ?? ($motor->rental_price * 7), 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Bulanan:</span>
                                    <span class="font-semibold text-purple-700">Rp {{ number_format($motor->monthly_rate ?? ($motor->rental_price * 30), 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        @if($motor->description)
                        <p class="text-sm text-gray-700 mb-4 line-clamp-2">{{ $motor->description }}</p>
                        @endif

                        <!-- Action Button -->
                        <div class="flex space-x-3">
                            <button onclick="openRentalModal({{ $motor->id }}, '{{ $motor->brand }} {{ $motor->type }}', {{ $motor->daily_rate ?? $motor->rental_price }}, {{ $motor->weekly_rate ?? ($motor->rental_price * 7) }}, {{ $motor->monthly_rate ?? ($motor->rental_price * 30) }})" 
                                    class="flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
                                🏍️ Sewa Sekarang
                            </button>
                            <a href="{{ route('renter.motors.show', $motor) }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-md transition duration-200">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $motors->appends(request()->query())->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h3M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 8h5a2 2 0 002-2V9a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Motor Tidak Ditemukan</h3>
                <p class="text-gray-500 mb-4">Tidak ada motor yang sesuai dengan kriteria pencarian Anda</p>
                <a href="{{ route('renter.motors.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
                    Lihat Semua Motor
                </a>
            </div>
        @endif
    </div>

    <!-- Rental Modal (Step 3: Pilih Durasi & Hitung Biaya) -->
    <div id="rentalModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-1/2 lg:w-1/3 shadow-lg rounded-lg bg-white">
            <div class="mt-3">
                <!-- Modal Header -->
                <div class="flex justify-between items-center pb-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Sewa Motor</h3>
                    <button onclick="closeRentalModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Rental Form -->
                <form id="rentalForm" method="POST" class="mt-4">
                    @csrf
                    
                    <div class="space-y-4">
                        <!-- Durasi Sewa -->
                        <div>
                            <label for="duration_days" class="block text-sm font-medium text-gray-700 mb-1">
                                Durasi Sewa (Hari) *
                            </label>
                            <select name="duration_days" id="duration_days" required
                                    onchange="calculateTotal()"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500">
                                <option value="">Pilih Durasi</option>
                                <option value="1">1 Hari</option>
                                <option value="2">2 Hari</option>
                                <option value="3">3 Hari</option>
                                <option value="7">1 Minggu (7 Hari)</option>
                                <option value="14">2 Minggu (14 Hari)</option>
                                <option value="30">1 Bulan (30 Hari)</option>
                            </select>
                        </div>

                        <!-- Tanggal Mulai -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                                Tanggal Mulai Sewa *
                            </label>
                            <input type="date" 
                                   name="start_date" 
                                   id="start_date" 
                                   required
                                   min="{{ date('Y-m-d') }}"
                                   onchange="calculateEndDate()"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500">
                        </div>

                        <!-- Tanggal Selesai (Auto Calculate) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Tanggal Selesai
                            </label>
                            <input type="text" 
                                   id="end_date_display" 
                                   readonly
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-700"
                                   placeholder="Otomatis dihitung">
                            <input type="hidden" name="end_date" id="end_date">
                        </div>

                        <!-- Perhitungan Biaya -->
                            <h4 class="font-semibold text-green-800 mb-2">💰 Rincian Biaya:</h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Paket/Harga:</span>
                                    <span class="font-medium" id="priceBadge">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Durasi:</span>
                                    <span class="font-medium" id="durationDisplay">-</span>
                                </div>
                                <div class="border-t border-green-300 pt-2 flex justify-between">
                                    <span class="text-green-800 font-semibold">Total Pokok:</span>
                                    <span class="text-green-800 font-bold" id="baseAmount">Rp 0</span>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500">
                                    <span>Jaminan (50% Harian):</span>
                                    <span id="depositAmount">Rp 0</span>
                                </div>
                                <div class="border-t border-green-400 pt-2 flex justify-between">
                                    <span class="text-green-900 font-extrabold">Total Bayar:</span>
                                    <span class="text-green-900 font-extrabold text-lg" id="totalAmount">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">
                                Catatan Tambahan
                            </label>
                            <textarea name="notes" 
                                      id="notes" 
                                      rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-green-500"
                                      placeholder="Berikan catatan khusus jika ada..."></textarea>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                        <button type="button" 
                                onclick="closeRentalModal()"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-md transition duration-200">
                            Batal
                        </button>
                        <button type="submit" 
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
                            📝 Lanjut ke Pembayaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let motorPricing = { daily: 0, weekly: 0, monthly: 0 };

        function openRentalModal(motorId, motorName, daily, weekly, monthly) {
            motorPricing = { daily, weekly, monthly };
            
            document.getElementById('modalTitle').textContent = `Sewa ${motorName}`;
            document.getElementById('rentalForm').action = `/renter/motors/${motorId}/rent`;
            
            // Reset form
            document.getElementById('rentalForm').reset();
            document.getElementById('end_date_display').value = '';
            document.getElementById('totalAmount').textContent = 'Rp 0';
            document.getElementById('baseAmount').textContent = 'Rp 0';
            document.getElementById('depositAmount').textContent = 'Rp 0';
            document.getElementById('durationDisplay').textContent = '-';
            document.getElementById('priceBadge').textContent = '-';
            
            document.getElementById('rentalModal').classList.remove('hidden');
        }

        function closeRentalModal() {
            document.getElementById('rentalModal').classList.add('hidden');
        }

        function calculateTotal() {
            const duration = parseInt(document.getElementById('duration_days').value) || 0;
            let basePrice = 0;
            let packageName = '';
            
            if (duration >= 30) {
                basePrice = motorPricing.monthly;
                packageName = '(Paket Bulanan)';
            } else if (duration >= 7) {
                basePrice = motorPricing.weekly;
                packageName = '(Paket Mingguan)';
            } else {
                basePrice = motorPricing.daily * duration;
                packageName = '(Paket Harian)';
            }
            
            const deposit = motorPricing.daily * 0.5;
            const total = basePrice + deposit;
            
            document.getElementById('priceBadge').textContent = packageName;
            document.getElementById('durationDisplay').textContent = `${duration} hari`;
            document.getElementById('baseAmount').textContent = `Rp ${basePrice.toLocaleString('id-ID')}`;
            document.getElementById('depositAmount').textContent = `Rp ${deposit.toLocaleString('id-ID')}`;
            document.getElementById('totalAmount').textContent = `Rp ${total.toLocaleString('id-ID')}`;
            
            calculateEndDate();
        }

        function calculateEndDate() {
            const startDate = document.getElementById('start_date').value;
            const duration = parseInt(document.getElementById('duration_days').value) || 0;
            
            if (startDate && duration > 0) {
                const start = new Date(startDate);
                const end = new Date(start);
                end.setDate(start.getDate() + duration);
                
                const endDateStr = end.toISOString().split('T')[0];
                const endDateDisplay = end.toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                document.getElementById('end_date').value = endDateStr;
                document.getElementById('end_date_display').value = endDateDisplay;
            }
        }

        // Close modal when clicking outside
        document.getElementById('rentalModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRentalModal();
            }
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Total Pendapatan - RentMotor</title>
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 dark:bg-gray-900">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white dark:bg-gray-800 shadow-lg">
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">🏍️ RentMotor</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">Reports & Analytics</p>
            </div>
            
            <nav class="mt-6">
                <div class="px-6 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-tachometer-alt mr-3"></i>
                        Dashboard
                    </a>
                    
                    <a href="{{ route('admin.reports.rental-history') }}" 
                       class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-history mr-3"></i>
                        Riwayat Penyewaan
                    </a>
                    
                    <a href="{{ route('admin.reports.registered-motors') }}" 
                       class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-motorcycle mr-3"></i>
                        Motor Terdaftar
                    </a>
                    
                    <a href="{{ route('admin.reports.rented-motors') }}" 
                       class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-calendar-check mr-3"></i>
                        Motor Disewa
                    </a>
                    
                    <a href="{{ route('admin.reports.total-revenue') }}" 
                       class="flex items-center px-4 py-2 bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300 rounded-lg">
                        <i class="fas fa-money-bill-wave mr-3"></i>
                        Total Pendapatan
                    </a>
                    
                    <a href="{{ route('admin.reports.payment-report') }}" 
                       class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-credit-card mr-3"></i>
                        Laporan Pembayaran
                    </a>
                    
                    <a href="{{ route('admin.reports.revenue-sharing') }}" 
                       class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-chart-pie mr-3"></i>
                        Bagi Hasil
                    </a>
                    
                    <a href="{{ route('admin.reports.rental-chart') }}" 
                       class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                        <i class="fas fa-chart-line mr-3"></i>
                        Grafik Penyewaan
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Total Pendapatan</h1>
                <p class="text-gray-600 dark:text-gray-400">Laporan pendapatan komprehensif dari penyewaan motor</p>
            </div>

            <!-- Revenue Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow p-6 text-white">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-20">
                            <i class="fas fa-money-bill-wave text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium opacity-90">Total Pendapatan</p>
                            <p class="text-2xl font-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow p-6 text-white">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-20">
                            <i class="fas fa-calendar-month text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium opacity-90">Bulan Ini</p>
                            <p class="text-2xl font-bold">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg shadow p-6 text-white">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-20">
                            <i class="fas fa-calendar-week text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium opacity-90">Minggu Ini</p>
                            <p class="text-2xl font-bold">Rp {{ number_format($weeklyRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow p-6 text-white">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-20">
                            <i class="fas fa-calendar-day text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium opacity-90">Hari Ini</p>
                            <p class="text-2xl font-bold">Rp {{ number_format($dailyRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter -->
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <form method="GET" action="{{ route('admin.reports.total-revenue') }}" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-48">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Periode</label>
                        <select name="period" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="all" {{ request('period') === 'all' ? 'selected' : '' }}>Semua Waktu</option>
                            <option value="today" {{ request('period') === 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="week" {{ request('period') === 'week' ? 'selected' : '' }}>Minggu Ini</option>
                            <option value="month" {{ request('period') === 'month' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="year" {{ request('period') === 'year' ? 'selected' : '' }}>Tahun Ini</option>
                            <option value="custom" {{ request('period') === 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                    </div>
                    
                    <div class="flex-1 min-w-48" id="custom-dates" style="display: {{ request('period') === 'custom' ? 'block' : 'none' }}">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    
                    <div class="flex-1 min-w-48" id="custom-dates-end" style="display: {{ request('period') === 'custom' ? 'block' : 'none' }}">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Akhir</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    
                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-search mr-1"></i>
                            Filter
                        </button>
                        
                        <a href="{{ route('admin.reports.export.total-revenue', request()->query()) }}" 
                           class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-download mr-1"></i>
                            Export
                        </a>
                    </div>
                </form>
            </div>

            <!-- Revenue by Motor -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Top Performing Motors -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Motor Terlaris</h3>
                    </div>
                    <div class="p-6">
                        @forelse($topMotors as $motor)
                            <div class="flex items-center justify-between mb-4 last:mb-0">
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $motor->brand }} {{ $motor->type }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $motor->license_plate }} • {{ $motor->rentals_count }} penyewaan
                                    </div>
                                </div>
                                <div class="text-sm font-bold text-gray-900 dark:text-white">
                                    Rp {{ number_format($motor->total_revenue, 0, ',', '.') }}
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400 text-center py-8">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>

                <!-- Revenue by Owner -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pendapatan Per Pemilik</h3>
                    </div>
                    <div class="p-6">
                        @forelse($ownerRevenues as $owner)
                            <div class="flex items-center justify-between mb-4 last:mb-0">
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $owner->name }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $owner->motors_count }} motor • {{ $owner->total_rentals }} penyewaan
                                    </div>
                                </div>
                                <div class="text-sm font-bold text-gray-900 dark:text-white">
                                    Rp {{ number_format($owner->total_revenue, 0, ',', '.') }}
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400 text-center py-8">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Monthly Revenue Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-8">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tren Pendapatan Bulanan</h3>
                </div>
                <div class="p-6">
                    <div class="h-64 flex items-end justify-between space-x-2">
                        @foreach($monthlyData as $month => $revenue)
                            <div class="flex-1 flex flex-col items-center">
                                <div class="w-full bg-blue-200 rounded-t" 
                                     style="height: {{ $revenue > 0 ? ($revenue / max($monthlyData) * 200) : 1 }}px">
                                    <div class="w-full bg-blue-600 rounded-t h-full"></div>
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-2 transform -rotate-45">
                                    {{ $month }}
                                </div>
                                <div class="text-xs font-medium text-gray-900 dark:text-white mt-1">
                                    {{ number_format($revenue / 1000000, 1) }}M
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Revenue Details Table -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Pendapatan</h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Motor
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Penyewa
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Durasi
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($recentPayments as $payment)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $payment->created_at->format('d M Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $payment->rental->motor->brand }} {{ $payment->rental->motor->type }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $payment->rental->motor->license_plate }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $payment->rental->renter->name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $payment->rental->duration }} hari
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center">
                                    <div class="text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-money-bill-wave text-4xl mb-4"></i>
                                        <p>Tidak ada data pembayaran</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        document.querySelector('select[name="period"]').addEventListener('change', function() {
            const customDates = document.getElementById('custom-dates');
            const customDatesEnd = document.getElementById('custom-dates-end');
            if (this.value === 'custom') {
                customDates.style.display = 'block';
                customDatesEnd.style.display = 'block';
            } else {
                customDates.style.display = 'none';
                customDatesEnd.style.display = 'none';
            }
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Grafik Penyewaan - RentMotor</title>
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                       class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
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
                       class="flex items-center px-4 py-2 bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300 rounded-lg">
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
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Grafik Penyewaan Per Periode</h1>
                <p class="text-gray-600 dark:text-gray-400">Analisis visual penyewaan motor dalam berbagai periode</p>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow p-6 text-white">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-20">
                            <i class="fas fa-chart-line text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium opacity-90">Total Penyewaan</p>
                            <p class="text-2xl font-bold">{{ $totalRentals }}</p>
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
                            <p class="text-2xl font-bold">{{ $monthlyRentals }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-lg shadow p-6 text-white">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-20">
                            <i class="fas fa-trending-up text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium opacity-90">Rata-rata/Bulan</p>
                            <p class="text-2xl font-bold">{{ $averageRentals }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow p-6 text-white">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-white bg-opacity-20">
                            <i class="fas fa-percentage text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium opacity-90">Tingkat Okupansi</p>
                            <p class="text-2xl font-bold">{{ $occupancyRate }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter -->
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <form method="GET" action="{{ route('admin.reports.rental-chart') }}" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-48">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Periode</label>
                        <select name="period" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="monthly" {{ request('period') === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                            <option value="weekly" {{ request('period') === 'weekly' ? 'selected' : '' }}>Mingguan</option>
                            <option value="daily" {{ request('period') === 'daily' ? 'selected' : '' }}>Harian</option>
                            <option value="yearly" {{ request('period') === 'yearly' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                    </div>
                    
                    <div class="flex-1 min-w-48">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tahun</label>
                        <select name="year" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="flex-1 min-w-48">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipe Grafik</label>
                        <select name="chart_type" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="line" {{ request('chart_type') === 'line' ? 'selected' : '' }}>Line Chart</option>
                            <option value="bar" {{ request('chart_type') === 'bar' ? 'selected' : '' }}>Bar Chart</option>
                            <option value="area" {{ request('chart_type') === 'area' ? 'selected' : '' }}>Area Chart</option>
                        </select>
                    </div>
                    
                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-chart-line mr-1"></i>
                            Update Chart
                        </button>
                        
                        <button type="button" onclick="downloadChart()" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-download mr-1"></i>
                            Download
                        </button>
                    </div>
                </form>
            </div>

            <!-- Main Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Rental Trends Chart -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tren Penyewaan</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="rentalTrendsChart" width="400" height="300"></canvas>
                    </div>
                </div>

                <!-- Revenue vs Rentals -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Penyewaan vs Pendapatan</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="revenueVsRentalsChart" width="400" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Additional Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Motor Usage Distribution -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Distribusi Penggunaan Motor</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="motorUsageChart" width="400" height="300"></canvas>
                    </div>
                </div>

                <!-- Rental Status Distribution -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Distribusi Status Penyewaan</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="statusDistributionChart" width="400" height="300"></canvas>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Data Penyewaan</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Periode
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Jumlah Penyewaan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Total Pendapatan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Rata-rata Durasi
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Motor Aktif
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($chartData as $data)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $data['period'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $data['rentals'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            Rp {{ number_format($data['revenue'], 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $data['avg_duration'] }} hari
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 dark:text-white">
                                            {{ $data['active_motors'] }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-8 text-center">
                                        <div class="text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-chart-line text-4xl mb-4"></i>
                                            <p>Tidak ada data untuk ditampilkan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Chart Data from Controller
        const chartData = @json($chartData);
        const motorUsageData = @json($motorUsageData);
        const statusDistributionData = @json($statusDistributionData);
        
        // Chart Configuration
        const chartConfig = {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };

        // 1. Rental Trends Chart
        const rentalTrendsCtx = document.getElementById('rentalTrendsChart').getContext('2d');
        new Chart(rentalTrendsCtx, {
            type: '{{ request('chart_type', 'line') }}',
            data: {
                labels: chartData.map(item => item.period),
                datasets: [{
                    label: 'Jumlah Penyewaan',
                    data: chartData.map(item => item.rentals),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: {{ request('chart_type') === 'area' ? 'true' : 'false' }}
                }]
            },
            options: chartConfig
        });

        // 2. Revenue vs Rentals Chart
        const revenueVsRentalsCtx = document.getElementById('revenueVsRentalsChart').getContext('2d');
        new Chart(revenueVsRentalsCtx, {
            type: 'bar',
            data: {
                labels: chartData.map(item => item.period),
                datasets: [
                    {
                        label: 'Penyewaan',
                        data: chartData.map(item => item.rentals),
                        backgroundColor: 'rgba(34, 197, 94, 0.8)',
                        yAxisID: 'y'
                    },
                    {
                        label: 'Pendapatan (Jutaan)',
                        data: chartData.map(item => item.revenue / 1000000),
                        backgroundColor: 'rgba(249, 115, 22, 0.8)',
                        yAxisID: 'y1'
                    }
                ]
            },
            options: {
                ...chartConfig,
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        beginAtZero: true
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        beginAtZero: true,
                        grid: {
                            drawOnChartArea: false,
                        }
                    }
                }
            }
        });

        // 3. Motor Usage Chart (Doughnut)
        const motorUsageCtx = document.getElementById('motorUsageChart').getContext('2d');
        new Chart(motorUsageCtx, {
            type: 'doughnut',
            data: {
                labels: motorUsageData.map(item => `${item.brand} ${item.type}`),
                datasets: [{
                    data: motorUsageData.map(item => item.usage_count),
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(249, 115, 22, 0.8)',
                        'rgba(168, 85, 247, 0.8)',
                        'rgba(236, 72, 153, 0.8)',
                        'rgba(14, 165, 233, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // 4. Status Distribution Chart (Pie)
        const statusDistributionCtx = document.getElementById('statusDistributionChart').getContext('2d');
        new Chart(statusDistributionCtx, {
            type: 'pie',
            data: {
                labels: statusDistributionData.map(item => item.status_label),
                datasets: [{
                    data: statusDistributionData.map(item => item.count),
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.8)',   // completed
                        'rgba(59, 130, 246, 0.8)',  // active
                        'rgba(249, 115, 22, 0.8)',  // confirmed
                        'rgba(236, 72, 153, 0.8)',  // paid
                        'rgba(239, 68, 68, 0.8)'    // cancelled
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Download Chart Function
        function downloadChart() {
            const canvas = document.getElementById('rentalTrendsChart');
            const link = document.createElement('a');
            link.download = `rental-chart-${new Date().getTime()}.png`;
            link.href = canvas.toDataURL();
            link.click();
        }
    </script>
</body>
</html>
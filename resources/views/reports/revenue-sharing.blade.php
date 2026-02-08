<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Histori Bagi Hasil - RentMotor</title>
    
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
                       class="flex items-center px-4 py-2 bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300 rounded-lg">
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
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Histori Bagi Hasil</h1>
                <p class="text-gray-600 dark:text-gray-400">Laporan pembagian hasil penyewaan motor kepada pemilik</p>
            </div>

            <!-- Revenue Sharing Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <i class="fas fa-chart-pie text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Bagi Hasil</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                Rp {{ number_format($totalRevenueSharing, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Sudah Dibayar</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                Rp {{ number_format($paidRevenueSharing, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Belum Dibayar</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                Rp {{ number_format($unpaidRevenueSharing, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-users text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pemilik</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalOwners }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter -->
            <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <form method="GET" action="{{ route('admin.reports.revenue-sharing') }}" class="flex flex-wrap gap-4 items-end">
                    <div class="flex-1 min-w-48">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    
                    <div class="flex-1 min-w-48">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanggal Akhir</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    
                    <div class="flex-1 min-w-48">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Semua Status</option>
                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                            <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                        </select>
                    </div>
                    
                    <div class="flex-1 min-w-48">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pemilik</label>
                        <select name="owner_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="">Semua Pemilik</option>
                            @foreach($owners as $owner)
                                <option value="{{ $owner->id }}" {{ request('owner_id') == $owner->id ? 'selected' : '' }}>{{ $owner->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="flex gap-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-search mr-1"></i>
                            Filter
                        </button>
                        
                        <a href="{{ route('admin.reports.export.revenue-sharing', request()->query()) }}" 
                           class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                            <i class="fas fa-download mr-1"></i>
                            Export
                        </a>
                    </div>
                </form>
            </div>

            <!-- Revenue Sharing by Owner -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Owner Summary -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ringkasan Per Pemilik</h3>
                    </div>
                    <div class="p-6">
                        @forelse($ownerSummary as $owner)
                            <div class="flex items-center justify-between mb-4 last:mb-0">
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $owner->name }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $owner->motors_count }} motor • {{ $owner->total_rentals }} penyewaan
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-bold text-gray-900 dark:text-white">
                                        Rp {{ number_format($owner->total_revenue_share, 0, ',', '.') }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $owner->paid_count }}/{{ $owner->total_count }} dibayar
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400 text-center py-8">Tidak ada data</p>
                        @endforelse
                    </div>
                </div>

                <!-- Monthly Revenue Sharing -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Bagi Hasil Bulanan</h3>
                    </div>
                    <div class="p-6">
                        <div class="h-64 flex items-end justify-between space-x-2">
                            @foreach($monthlyRevenueSharing as $month => $amount)
                                <div class="flex-1 flex flex-col items-center">
                                    <div class="w-full bg-green-200 rounded-t" 
                                         style="height: {{ $amount > 0 ? ($amount / max($monthlyRevenueSharing) * 200) : 1 }}px">
                                        <div class="w-full bg-green-600 rounded-t h-full"></div>
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-2 transform -rotate-45">
                                        {{ $month }}
                                    </div>
                                    <div class="text-xs font-medium text-gray-900 dark:text-white mt-1">
                                        {{ number_format($amount / 1000000, 1) }}M
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Sharing Table -->
            <form action="{{ route('payments.mark-revenue-paid') }}" method="POST">
                @csrf
                <div class="mb-4 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Transaksi Bagi Hasil</h3>
                    @if(auth()->user()->isAdmin())
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition transform hover:scale-105">
                            <i class="fas fa-check-double mr-2"></i> Tandai Terpilih Sudah Dibayar
                        </button>
                    @endif
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            @if(auth()->user()->isAdmin())
                                <th class="px-6 py-3 text-left">
                                    <input type="checkbox" onclick="toggleAll(this)" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </th>
                            @endif
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Pemilik Motor
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Motor
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Total Penyewaan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Bagian Pemilik
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($revenueShares as $share)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                @if(auth()->user()->isAdmin())
                                    <td class="px-6 py-4">
                                        @if(!$share->is_paid)
                                            <input type="checkbox" name="revenue_share_ids[]" value="{{ $share->id }}" class="row-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        @endif
                                    </td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $share->created_at->format('d M Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $share->created_at->format('H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $share->payment->rental->motor->owner->name }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $share->payment->rental->motor->owner->phone }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $share->payment->rental->motor->brand }} {{ $share->payment->rental->motor->type }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $share->payment->rental->motor->license_plate }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        Rp {{ number_format($share->payment->amount, 0, ',', '.') }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $share->payment->rental->duration }} hari
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        Rp {{ number_format($share->owner_share, 0, ',', '.') }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $share->percentage }}% dari total
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($share->is_paid) bg-green-100 text-green-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        @if($share->is_paid) Sudah Dibayar @else Belum Dibayar @endif
                                    </span>
                                    @if($share->paid_at)
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $share->paid_at->format('d M Y') }}
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center">
                                    <div class="text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-chart-pie text-4xl mb-4"></i>
                                        <p>Tidak ada data bagi hasil</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            </form>

            <!-- Pagination -->
            @if($revenueShares->hasPages())
                <div class="mt-6">
                    {{ $revenueShares->appends(request()->query())->links() }}
                </div>
            @endif
        </main>
    </div>
    <script>
        function toggleAll(source) {
            const checkboxes = document.querySelectorAll('.row-checkbox');
            for (let checkbox of checkboxes) {
                checkbox.checked = source.checked;
            }
        }
    </script>
</body>
</html>
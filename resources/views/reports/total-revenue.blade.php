@extends('layouts.admin')

@section('title', 'Total Pendapatan')

@section('content')
<h1 class="page-title">Total Pendapatan</h1>

<!-- Revenue Overview Cards -->
<div class="stats-container">
    <div class="stat-card blue">
        <div class="stat-info">
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
    </div>

    <div class="stat-card green">
        <div class="stat-info">
            <div class="stat-label">Bulan Ini</div>
            <div class="stat-value">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
    </div>

    <div class="stat-card yellow">
        <div class="stat-info">
            <div class="stat-label">Minggu Ini</div>
            <div class="stat-value">Rp {{ number_format($weeklyRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-icon"><i class="fas fa-calendar-week"></i></div>
    </div>

    <div class="stat-card indigo">
        <div class="stat-info">
            <div class="stat-label">Hari Ini</div>
            <div class="stat-value">Rp {{ number_format($dailyRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-icon"><i class="fas fa-calendar-day"></i></div>
    </div>
</div>

<!-- Filter Bar -->
<div class="card-table p-6 mb-8">
    <form method="GET" action="{{ route('admin.reports.total-revenue') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Periode</label>
            <select name="period" class="w-full px-4 py-2 border border-gray-100 rounded text-sm focus:outline-none focus:border-blue-500">
                <option value="all" {{ request('period') === 'all' ? 'selected' : '' }}>Semua Waktu</option>
                <option value="today" {{ request('period') === 'today' ? 'selected' : '' }}>Hari Ini</option>
                <option value="week" {{ request('period') === 'week' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="month" {{ request('period') === 'month' ? 'selected' : '' }}>Bulan Ini</option>
                <option value="year" {{ request('period') === 'year' ? 'selected' : '' }}>Tahun Ini</option>
                <option value="custom" {{ request('period') === 'custom' ? 'selected' : '' }}>Custom</option>
            </select>
        </div>
        <div id="custom-dates" style="display: {{ request('period') === 'custom' ? 'block' : 'none' }}">
            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Lahir</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" 
                   class="w-full px-4 py-2 border border-gray-100 rounded text-sm focus:outline-none focus:border-blue-500">
        </div>
        <div id="custom-dates-end" style="display: {{ request('period') === 'custom' ? 'block' : 'none' }}">
            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Sampai</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" 
                   class="w-full px-4 py-2 border border-gray-100 rounded text-sm focus:outline-none focus:border-blue-500">
        </div>
        <div class="flex space-x-2">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition shadow-sm">
                Filter
            </button>
            <a href="{{ route('admin.reports.export.total-revenue', request()->query()) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm transition shadow-sm">
                Export
            </a>
        </div>
    </form>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Top Performing Motors -->
    <div class="card-table">
        <div class="p-6 border-b border-gray-50">
            <h3 class="text-sm font-bold text-gray-800 uppercase">Motor Terlaris</h3>
        </div>
        <div class="p-6">
            @forelse($topMotors as $motor)
                <div class="flex items-center justify-between mb-4 last:mb-0">
                    <div class="flex-1">
                        <div class="text-sm font-bold text-gray-800">
                            {{ $motor->brand }} {{ $motor->type }}
                        </div>
                        <div class="text-[10px] text-gray-400 uppercase">
                            {{ $motor->license_plate }} • {{ $motor->rentals_count }} penyewaan
                        </div>
                    </div>
                    <div class="text-sm font-bold text-blue-600">
                        Rp {{ number_format($motor->total_revenue, 0, ',', '.') }}
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-xs text-center py-4 italic">Tidak ada data</p>
            @endforelse
        </div>
    </div>

    <!-- Revenue by Owner -->
    <div class="card-table">
        <div class="p-6 border-b border-gray-50">
            <h3 class="text-sm font-bold text-gray-800 uppercase">Pendapatan Per Pemilik</h3>
        </div>
        <div class="p-6">
            @forelse($ownerRevenues as $owner)
                <div class="flex items-center justify-between mb-4 last:mb-0">
                    <div class="flex-1">
                        <div class="text-sm font-bold text-gray-800">
                            {{ $owner->name }}
                        </div>
                        <div class="text-[10px] text-gray-400 uppercase">
                            {{ $owner->motors_count }} motor • {{ $owner->total_rentals }} penyewaan
                        </div>
                    </div>
                    <div class="text-sm font-bold text-green-600">
                        Rp {{ number_format($owner->total_revenue, 0, ',', '.') }}
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-xs text-center py-4 italic">Tidak ada data</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Revenue Details Table -->
<div class="card-table">
    <div class="p-6 border-b border-gray-50">
        <h3 class="text-sm font-bold text-gray-800 uppercase">Detail Pendapatan Terbaru</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-50">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Motor</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Penyewa</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Durasi</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 bg-white">
                @forelse($recentPayments as $payment)
                <tr class="hover:bg-blue-50 transition-colors">
                    <td class="px-6 py-4 text-xs text-gray-500">
                        {{ $payment->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-800">{{ $payment->rental->motor->brand }} {{ $payment->rental->motor->type }}</div>
                        <div class="text-[10px] text-gray-500 uppercase">{{ $payment->rental->motor->license_plate }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-800">
                        {{ $payment->rental->renter->name }}
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-600">
                        {{ $payment->rental->duration }} hari
                    </td>
                    <td class="px-6 py-4 font-bold text-sm text-blue-600">
                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="text-gray-300 text-4xl mb-2"><i class="fas fa-money-check-alt"></i></div>
                        <div class="text-gray-500 font-bold">Tidak ada data pembayaran</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
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
@endsection
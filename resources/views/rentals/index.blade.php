@extends('layouts.admin')

@section('title', 'Kelola Penyewaan')

@section('content')
<h1 class="page-title">Kelola Semua Penyewaan</h1>

<!-- Stats Cards -->
<div class="stats-container">
    <div class="stat-card blue">
        <div class="stat-info">
            <div class="stat-label">Total Penyewaan</div>
            <div class="stat-value">{{ $rentals->total() }}</div>
        </div>
        <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
    </div>

    <div class="stat-card green">
        <div class="stat-info">
            <div class="stat-label">Aktif</div>
            <div class="stat-value">{{ $rentals->where('status', 'active')->count() }}</div>
        </div>
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
    </div>

    <div class="stat-card yellow">
        <div class="stat-info">
            <div class="stat-label">Pending</div>
            <div class="stat-value">{{ $rentals->where('status', 'pending_payment')->count() }}</div>
        </div>
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
    </div>

    <div class="stat-card indigo">
        <div class="stat-info">
            <div class="stat-label">Selesai</div>
            <div class="stat-value">{{ $rentals->where('status', 'completed')->count() }}</div>
        </div>
        <div class="stat-icon"><i class="fas fa-flag-checkered"></i></div>
    </div>
</div>

<!-- Filter Box -->
<div class="card-table p-6 mb-8">
    <form method="GET" action="{{ route('admin.rentals.index') }}" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Cari berdasarkan nama penyewa, motor, atau nomor polisi..."
                   class="w-full px-4 py-2 border border-gray-200 rounded text-sm focus:outline-none focus:border-blue-500">
        </div>
        <div class="w-full md:w-48">
            <select name="status" class="w-full px-4 py-2 border border-gray-200 rounded text-sm focus:outline-none focus:border-blue-500">
                <option value="">Semua Status</option>
                <option value="pending_payment" {{ request('status') === 'pending_payment' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Terkonfirmasi</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2 rounded text-sm font-bold transition">
            Filter
        </button>
    </form>
</div>

<!-- Rentals Table -->
<div class="card-table">
    @if($rentals->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50 text-left">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Motor</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Penyewa</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Periode</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($rentals as $rental)
                    <tr class="hover:bg-blue-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-800">{{ $rental->motor->brand }} {{ $rental->motor->type }}</div>
                            <div class="text-xs text-gray-500">{{ $rental->motor->license_plate }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-800">{{ $rental->renter->name }}</div>
                            <div class="text-xs text-gray-500">{{ $rental->renter->phone ?? 'No Phone' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-800">{{ \Carbon\Carbon::parse($rental->start_date)->format('d/m/y') }} - {{ \Carbon\Carbon::parse($rental->end_date)->format('d/m/y') }}</div>
                        </td>
                        <td class="px-6 py-4 font-bold text-sm">
                            Rp {{ number_format($rental->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase
                                @if($rental->status === 'pending_payment') bg-yellow-100 text-yellow-700
                                @elseif($rental->status === 'active') bg-green-100 text-green-700
                                @elseif($rental->status === 'completed') bg-indigo-100 text-indigo-700
                                @else bg-gray-100 text-gray-700
                                @endif">
                                {{ $rental->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.rentals.show', $rental) }}" class="text-blue-500 hover:text-blue-700"><i class="fas fa-eye"></i></a>
                                @if($rental->status === 'pending_payment')
                                <a href="{{ route('admin.payments.create', ['rental_id' => $rental->id]) }}" class="text-green-500 hover:text-green-700"><i class="fas fa-plus-circle"></i></a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4">
            {{ $rentals->links() }}
        </div>
    @else
        <div class="p-12 text-center">
            <div class="text-gray-300 text-4xl mb-4"><i class="fas fa-exchange-alt"></i></div>
            <div class="text-gray-500 font-bold">Belum Ada Penyewaan</div>
            <div class="text-xs text-gray-400">Belum ada transaksi penyewaan motor yang tercatat.</div>
        </div>
    @endif
</div>
@endsection
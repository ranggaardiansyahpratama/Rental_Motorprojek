@extends('layouts.admin')

@section('title', 'Manajemen Pembayaran')

@section('content')
<h1 class="page-title">Manajemen Pembayaran</h1>

<!-- Statistics Cards -->
@if(auth()->user()->isAdmin() && isset($stats))
<div class="stats-container">
    <div class="stat-card green">
        <div class="stat-info">
            <div class="stat-label">Total Pembayaran</div>
            <div class="stat-value">Rp {{ number_format($stats['total_payments'], 0, ',', '.') }}</div>
        </div>
        <div class="stat-icon"><i class="fas fa-money-bill-wave"></i></div>
    </div>

    <div class="stat-card blue">
        <div class="stat-info">
            <div class="stat-label">Terkonfirmasi</div>
            <div class="stat-value">Rp {{ number_format($stats['confirmed_payments'], 0, ',', '.') }}</div>
        </div>
        <div class="stat-icon"><i class="fas fa-check-circle"></i></div>
    </div>

    <div class="stat-card yellow">
        <div class="stat-info">
            <div class="stat-label">Menunggu</div>
            <div class="stat-value">{{ $stats['pending_payments'] }}</div>
        </div>
        <div class="stat-icon"><i class="fas fa-clock"></i></div>
    </div>

    <div class="stat-card red" style="border-left-color: #ef4444;">
        <div class="stat-info">
            <div class="stat-label" style="color: #ef4444;">Ditolak</div>
            <div class="stat-value">{{ $stats['rejected_payments'] }}</div>
        </div>
        <div class="stat-icon" style="color: #fee2e2;"><i class="fas fa-times-circle"></i></div>
    </div>
</div>
@endif

<!-- Filter Bar -->
<div class="card-table p-6 mb-8">
    <form method="GET" action="{{ route(auth()->user()->role . '.payments.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Status</label>
            <select name="status" class="w-full px-4 py-2 border border-gray-100 rounded text-sm focus:outline-none focus:border-blue-500">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Terkonfirmasi</option>
                <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>
        <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Dari Tanggal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" 
                   class="w-full px-4 py-2 border border-gray-100 rounded text-sm focus:outline-none focus:border-blue-500">
        </div>
        <div>
            <label class="block text-[10px] font-bold text-gray-400 uppercase mb-1">Sampai Tanggal</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" 
                   class="w-full px-4 py-2 border border-gray-100 rounded text-sm focus:outline-none focus:border-blue-500">
        </div>
        <div class="flex space-x-2">
            <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-sm transition shadow-sm">
                Filter
            </button>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.payments.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm transition shadow-sm">
                Entri Baru
            </a>
            @endif
        </div>
    </form>
</div>

<!-- Payments Table -->
<div class="card-table">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-50">
            <thead class="bg-gray-50 text-left">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Penyewaan</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Jumlah</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Metode</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Tanggal</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 bg-white">
                @forelse($payments as $payment)
                <tr class="hover:bg-blue-50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-800">
                            {{ $payment->rental->motor->brand }} {{ $payment->rental->motor->type }}
                        </div>
                        <div class="text-[10px] text-gray-500">
                            {{ $payment->rental->renter->name }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-blue-600">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-xs text-gray-600 capitalize">
                            {{ str_replace('_', ' ', $payment->payment_method) }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                            @if($payment->status === 'confirmed') bg-green-100 text-green-700
                            @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-700
                            @else bg-red-100 text-red-700 @endif">
                            {{ $payment->status === 'confirmed' ? 'Terkonfirmasi' : ($payment->status === 'pending' ? 'Menunggu' : 'Ditolak') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-xs text-gray-500">
                        {{ $payment->created_at->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex space-x-2 text-sm text-gray-400">
                            <a href="{{ route(auth()->user()->role . '.payments.show', $payment) }}" class="hover:text-blue-600 transition">
                                <i class="fas fa-eye"></i>
                            </a>
                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.payments.edit', $payment) }}" class="hover:text-green-600 transition">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data pembayaran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="hover:text-red-600 transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="text-gray-300 text-4xl mb-2"><i class="fas fa-credit-card"></i></div>
                        <div class="text-gray-500 font-bold">Belum ada data pembayaran</div>
                        <div class="text-[10px] text-gray-400 uppercase">Data transaksi akan muncul di sini</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($payments->hasPages())
    <div class="px-6 py-4 border-t border-gray-50">
        {{ $payments->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<h1 class="page-title">Dashboard</h1>

<!-- Stats Cards -->
<div class="stats-container">
    <!-- Customer -->
    <div class="stat-card blue">
        <div class="stat-info">
            <div class="stat-label">Penyewa (Customer)</div>
            <div class="stat-value">{{ \App\Models\User::where('role', 'renter')->count() }}</div>
        </div>
        <div class="stat-icon">
            <i class="fas fa-users"></i>
        </div>
    </div>

    <!-- Motor -->
    <div class="stat-card indigo">
        <div class="stat-info">
            <div class="stat-label">Motor</div>
            <div class="stat-value">{{ $totalMotors }}</div>
        </div>
        <div class="stat-icon">
            <i class="fas fa-motorcycle"></i>
        </div>
    </div>

    <!-- Masa Sewa -->
    <div class="stat-card yellow">
        <div class="stat-info">
            <div class="stat-label">Masa Sewa</div>
            <div class="stat-value">{{ $activeRentals }}</div>
        </div>
        <div class="stat-icon">
            <i class="fas fa-arrows-alt-h"></i>
        </div>
    </div>

    <!-- Total Transaksi -->
    <div class="stat-card mint">
        <div class="stat-info">
            <div class="stat-label">Total Transaksi</div>
            <div class="stat-value">{{ \App\Models\Rental::count() }}</div>
        </div>
        <div class="stat-icon">
            <i class="fas fa-clipboard-list"></i>
        </div>
    </div>
</div>

<div class="stats-container" style="justify-content: flex-start;">
    <!-- Total Pendapatan -->
    <div class="stat-card green" style="max-width: 300px;">
        <div class="stat-info">
            <div class="stat-label">Total Pendapatan (Admin)</div>
            <div class="stat-value">Rp. {{ number_format($adminRevenue, 0, ',', '.') }}</div>
        </div>
        <div class="stat-icon">
            <i class="fas fa-dollar-sign"></i>
        </div>
    </div>
</div>

<!-- Active Management Section -->
<div class="mt-8">
    <div class="card-table p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Manajemen Aktif</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @if($pendingMotors > 0)
            <div class="bg-yellow-50 p-4 rounded border border-yellow-200 flex justify-between items-center">
                <div>
                    <div class="font-bold text-yellow-800">{{ $pendingMotors }} Motor</div>
                    <div class="text-xs text-yellow-600">Menunggu Verifikasi</div>
                </div>
                <a href="{{ route('admin.motors.index') }}" class="text-xs bg-yellow-600 text-white px-3 py-1 rounded">Verifikasi</a>
            </div>
            @endif

            @if($pendingPayments > 0)
            <div class="bg-blue-50 p-4 rounded border border-blue-200 flex justify-between items-center">
                <div>
                    <div class="font-bold text-blue-800">{{ $pendingPayments }} Pembayaran</div>
                    <div class="text-xs text-blue-600">Menunggu Konfirmasi</div>
                </div>
                <a href="{{ route('admin.payments.index') }}" class="text-xs bg-blue-600 text-white px-3 py-1 rounded">Cek</a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
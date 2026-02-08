@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    @if(auth()->user()->isAdmin())
                        Kelola Semua Penyewaan
                    @elseif(auth()->user()->isOwner())
                        Penyewaan Motor Anda
                    @else
                        Riwayat Penyewaan Saya
                    @endif
                </h1>
                <p class="text-gray-600 mt-1">
                    @if(auth()->user()->isAdmin())
                        Pantau dan kelola semua transaksi penyewaan motor
                    @elseif(auth()->user()->isOwner())
                        Pantau penyewaan motor yang Anda miliki
                    @else
                        Lihat semua penyewaan motor yang pernah Anda lakukan
                    @endif
                </p>
            </div>
            
            @if(!auth()->user()->isAdmin() && !auth()->user()->isOwner())
            <a href="{{ route('renter.motors.index') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                <i class="fas fa-plus mr-2"></i>
                Sewa Motor Baru
            </a>
            @endif
        </div>
    </div>

    <!-- Stats Cards (for Admin and Owner) -->
    @if(auth()->user()->isAdmin() || auth()->user()->isOwner())
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Penyewaan</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $rentals->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Aktif</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $rentals->where('status', 'active')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Pending</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $rentals->where('status', 'pending_payment')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <i class="fas fa-flag-checkered text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Selesai</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $rentals->where('status', 'completed')->count() }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow mb-8 p-6">
        <form method="GET" action="{{ route(auth()->user()->role . '.rentals.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari berdasarkan nama penyewa, motor, atau nomor polisi..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="pending_payment" {{ request('status') === 'pending_payment' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                    <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Terkonfirmasi</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                <i class="fas fa-search mr-2"></i>Filter
            </button>
        </form>
    </div>

    <!-- Rentals List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if($rentals->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motor</th>
                            @if(auth()->user()->isAdmin() || auth()->user()->isOwner())
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyewa</th>
                            @endif
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($rentals as $rental)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($rental->motor->photo)
                                    <img class="h-12 w-12 rounded-lg object-cover mr-4" 
                                         src="{{ asset('storage/' . $rental->motor->photo) }}" 
                                         alt="{{ $rental->motor->brand }}">
                                    @else
                                    <div class="h-12 w-12 bg-gray-300 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-motorcycle text-gray-500"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $rental->motor->brand }} {{ $rental->motor->type }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $rental->motor->license_plate }} • {{ $rental->motor->year }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            @if(auth()->user()->isAdmin() || auth()->user()->isOwner())
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $rental->renter->name }}</div>
                                <div class="text-sm text-gray-500">{{ $rental->renter->email }}</div>
                            </td>
                            @endif
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($rental->start_date)->format('d M Y') }} - 
                                    {{ \Carbon\Carbon::parse($rental->end_date)->format('d M Y') }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($rental->start_date)->diffInDays(\Carbon\Carbon::parse($rental->end_date)) + 1 }} hari
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    Rp {{ number_format($rental->total_amount, 0, ',', '.') }}
                                </div>
                                @if($rental->payments->where('status', 'confirmed')->count() > 0)
                                <div class="text-sm text-green-600">
                                    <i class="fas fa-check-circle mr-1"></i>Terbayar
                                </div>
                                @else
                                <div class="text-sm text-red-600">
                                    <i class="fas fa-times-circle mr-1"></i>Belum Bayar
                                </div>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    @if($rental->status === 'pending_payment') bg-yellow-100 text-yellow-800
                                    @elseif($rental->status === 'confirmed') bg-blue-100 text-blue-800
                                    @elseif($rental->status === 'active') bg-green-100 text-green-800
                                    @elseif($rental->status === 'completed') bg-purple-100 text-purple-800
                                    @elseif($rental->status === 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    @if($rental->status === 'pending_payment') Menunggu Pembayaran
                                    @elseif($rental->status === 'confirmed') Terkonfirmasi
                                    @elseif($rental->status === 'active') Sedang Berjalan
                                    @elseif($rental->status === 'completed') Selesai
                                    @elseif($rental->status === 'cancelled') Dibatalkan
                                    @else {{ ucfirst($rental->status) }}
                                    @endif
                                </span>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route(auth()->user()->role . '.rentals.show', $rental) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if(auth()->user()->isAdmin() && $rental->status === 'pending_payment')
                                    <a href="{{ route('admin.payments.create', ['rental_id' => $rental->id]) }}" 
                                       class="text-green-600 hover:text-green-900" title="Buat Pembayaran">
                                        <i class="fas fa-plus-circle"></i>
                                    </a>
                                    @endif
                                    
                                    @if($rental->status === 'active' && (auth()->user()->isAdmin() || $rental->motor->owner_id === auth()->id()))
                                    <button onclick="completeRental({{ $rental->id }})" 
                                            class="text-purple-600 hover:text-purple-900" title="Selesaikan Rental">
                                        <i class="fas fa-flag-checkered"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $rentals->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-calendar-times text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Penyewaan</h3>
                <p class="text-gray-600 mb-4">
                    @if(auth()->user()->isAdmin())
                        Belum ada transaksi penyewaan motor yang tercatat dalam sistem.
                    @elseif(auth()->user()->isOwner())
                        Belum ada yang menyewa motor Anda.
                    @else
                        Anda belum pernah menyewa motor. Mulai cari motor yang ingin Anda sewa!
                    @endif
                </p>
                @if(!auth()->user()->isAdmin() && !auth()->user()->isOwner())
                <a href="{{ route('renter.motors.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                    <i class="fas fa-search mr-2"></i>
                    Cari Motor Untuk Disewa
                </a>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Complete Rental Modal -->
<div id="completeRentalModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <h3 class="text-lg font-medium text-gray-900">Selesaikan Penyewaan</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin menandai penyewaan ini sebagai selesai? Motor akan kembali tersedia untuk disewakan.
                </p>
            </div>
            <div class="flex px-4 py-3 space-x-2">
                <button onclick="closeCompleteModal()" 
                        class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-lg">
                    Batal
                </button>
                <form id="completeRentalForm" method="POST" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <button type="submit" 
                            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg">
                        Ya, Selesaikan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function completeRental(rentalId) {
    const role = "{{ auth()->user()->role }}";
    document.getElementById('completeRentalForm').action = `/${role}/rentals/${rentalId}/complete`;
    document.getElementById('completeRentalModal').classList.remove('hidden');
}

function closeCompleteModal() {
    document.getElementById('completeRentalModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('completeRentalModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCompleteModal();
    }
});
</script>
@endsection
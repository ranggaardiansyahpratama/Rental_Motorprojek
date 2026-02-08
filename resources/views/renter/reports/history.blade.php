@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                        {{ __('Riwayat Penyewaan Saya') }}
                    </h2>
                </div>
                
                @if($rentals->count() > 0)
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">Tanggal Sewa</th>
                                <th scope="col" class="py-3 px-6">Motor</th>
                                <th scope="col" class="py-3 px-6">Durasi</th>
                                <th scope="col" class="py-3 px-6">Total Biaya</th>
                                <th scope="col" class="py-3 px-6">Status</th>
                                <th scope="col" class="py-3 px-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rentals as $rental)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="py-4 px-6">
                                    {{ \Carbon\Carbon::parse($rental->start_date)->format('d M Y') }}
                                </td>
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $rental->motor->brand }} {{ $rental->motor->type }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ $rental->duration }} Hari
                                </td>
                                <td class="py-4 px-6 font-bold">
                                    Rp {{ number_format($rental->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-2 py-1 font-semibold leading-tight rounded-full
                                        {{ $rental->status === 'active' ? 'text-green-700 bg-green-100 dark:bg-green-700 dark:text-green-100' : '' }}
                                        {{ $rental->status === 'pending' ? 'text-yellow-700 bg-yellow-100 dark:bg-yellow-700 dark:text-yellow-100' : '' }}
                                        {{ $rental->status === 'completed' ? 'text-gray-700 bg-gray-100 dark:bg-gray-700 dark:text-gray-100' : '' }}
                                        {{ $rental->status === 'cancelled' ? 'text-red-700 bg-red-100 dark:bg-red-700 dark:text-red-100' : '' }}">
                                        {{ ucfirst($rental->status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <a href="{{ route('renter.rentals.show', $rental) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $rentals->links() }}
                </div>
                @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Anda belum memiliki riwayat penyewaan.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

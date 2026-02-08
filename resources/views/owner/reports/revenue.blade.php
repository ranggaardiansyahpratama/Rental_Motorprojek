@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                        {{ __('Riwayat Bagi Hasil') }}
                    </h2>
                </div>
                
                @if($revenueShares->count() > 0)
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">Tanggal</th>
                                <th scope="col" class="py-3 px-6">Motor</th>
                                <th scope="col" class="py-3 px-6">Penyewa</th>
                                <th scope="col" class="py-3 px-6">Pendapatan Bersih</th>
                                <th scope="col" class="py-3 px-6">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($revenueShares as $share)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="py-4 px-6">
                                    {{ $share->created_at->format('d M Y') }}
                                </td>
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $share->rental->motor->brand }} {{ $share->rental->motor->type }}
                                </td>
                                <td class="py-4 px-6">{{ $share->rental->renter->name }}</td>
                                <td class="py-4 px-6 font-bold text-green-600">
                                    Rp {{ number_format($share->owner_share, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6">
                                    @if($share->status === 'paid')
                                        <span class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">
                                            Dibayar
                                        </span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-200 dark:text-yellow-900">
                                            Pending
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="font-semibold text-gray-900 dark:text-white">
                                <th scope="row" class="py-3 px-6 text-base" colspan="3">Total Pendapatan</th>
                                <td class="py-3 px-6 text-base">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $revenueShares->links() }}
                </div>
                @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Belum ada riwayat bagi hasil.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

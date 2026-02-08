@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
                        {{ __('Daftar Motor Disewa') }}
                    </h2>
                </div>
                
                @if($motors->count() > 0)
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">Motor</th>
                                <th scope="col" class="py-3 px-6">Plat Nomor</th>
                                <th scope="col" class="py-3 px-6">Penyewa</th>
                                <th scope="col" class="py-3 px-6">Periode Sewa</th>
                                <th scope="col" class="py-3 px-6">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($motors as $motor)
                            @php $rental = $motor->rentals->first(); @endphp
                            @if($rental)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $motor->brand }} {{ $motor->type }}
                                </td>
                                <td class="py-4 px-6">{{ $motor->license_plate }}</td>
                                <td class="py-4 px-6">{{ $rental->renter->name }}</td>
                                <td class="py-4 px-6">
                                    {{ \Carbon\Carbon::parse($rental->start_date)->format('d M Y') }} - 
                                    {{ \Carbon\Carbon::parse($rental->end_date)->format('d M Y') }}
                                </td>
                                <td class="py-4 px-6">
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">
                                        {{ ucfirst($rental->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $motors->links() }}
                </div>
                @else
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h3M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 8h5a2 2 0 002-2V9a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Tidak ada motor Anda yang sedang disewa saat ini.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

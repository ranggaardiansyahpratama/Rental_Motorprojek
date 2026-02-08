@extends('layouts.app')

@section('title', 'Detail Motor')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
                <a href="{{ route(auth()->user()->role . '.motors.index') }}" class="hover:text-blue-600">Motor</a>
                <span>/</span>
                <span class="text-gray-900">{{ $motor->name }}</span>
            </nav>
            
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold text-gray-900">{{ $motor->name }}</h1>
                
                @if(auth()->user()->isAdmin() || (auth()->user()->isOwner() && $motor->owner_id == auth()->id()))
                <div class="flex space-x-3">
                    <a href="{{ route(auth()->user()->role . '.motors.edit', $motor) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    
                    @if(auth()->user()->isAdmin())
                    <form action="{{ route('admin.motors.destroy', $motor) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus motor ini?')">
                            <i class="fas fa-trash mr-2"></i>Hapus
                        </button>
                    </form>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Motor Image -->
            <div class="space-y-4">
                <div class="aspect-w-16 aspect-h-12 bg-gray-100 rounded-lg overflow-hidden">
                    @if($motor->photo)
                        <img src="{{ Storage::url($motor->photo) }}" 
                             alt="{{ $motor->name }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="flex items-center justify-center h-full">
                            <div class="text-center">
                                <i class="fas fa-motorcycle text-6xl text-gray-400 mb-4"></i>
                                <p class="text-gray-500">Belum ada foto</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Motor Details -->
            <div class="space-y-6">
                <!-- Status Badge -->
                <div>
                    @if($motor->status === 'available')
                        <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-check-circle mr-1"></i>Tersedia
                        </span>
                    @elseif($motor->status === 'rented')
                        <span class="inline-block bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-clock mr-1"></i>Disewa
                        </span>
                    @elseif($motor->status === 'pending_verification')
                        <span class="inline-block bg-orange-100 text-orange-800 px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-hourglass-half mr-1"></i>Menunggu Verifikasi
                        </span>
                    @else
                        <span class="inline-block bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-ban mr-1"></i>Tidak Tersedia
                        </span>
                    @endif
                </div>

                <!-- Basic Info -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Informasi Dasar</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Merk</label>
                            <p class="text-gray-900 font-medium">{{ $motor->brand }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Model</label>
                            <p class="text-gray-900 font-medium">{{ $motor->model }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Tahun</label>
                            <p class="text-gray-900 font-medium">{{ $motor->year }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Plat Nomor</label>
                            <p class="text-gray-900 font-medium">{{ $motor->license_plate }}</p>
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Harga Sewa</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Per Hari</span>
                            <span class="text-lg font-bold text-blue-600">Rp {{ number_format($motor->daily_rate) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Per Minggu</span>
                            <span class="text-lg font-bold text-blue-600">Rp {{ number_format($motor->weekly_rate) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Per Bulan</span>
                            <span class="text-lg font-bold text-blue-600">Rp {{ number_format($motor->monthly_rate) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Owner Info -->
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Pemilik</h3>
                    
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $motor->owner->name }}</p>
                            <p class="text-sm text-gray-500">{{ $motor->owner->email }}</p>
                            @if($motor->owner->phone)
                                <p class="text-sm text-gray-500">{{ $motor->owner->phone }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Description -->
                @if($motor->description)
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Deskripsi</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $motor->description }}</p>
                </div>
                @endif

                <!-- Admin Actions -->
                @if(auth()->user()->isAdmin() && $motor->status === 'pending_verification')
                <div class="bg-orange-50 border border-orange-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-orange-800 mb-4">Aksi Admin</h3>
                    
                    <form action="{{ route('admin.motors.verify', $motor) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition-colors">
                            <i class="fas fa-check mr-2"></i>Verifikasi Motor
                        </button>
                    </form>
                </div>
                @endif

                <!-- Rent Actions for Renters -->
                @if(auth()->user()->isRenter() && $motor->status === 'available')
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-blue-800 mb-4">Sewa Motor Ini</h3>
                    
                    <a href="{{ route('renter.rentals.create', $motor) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors inline-block">
                        <i class="fas fa-calendar-alt mr-2"></i>Sewa Sekarang
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
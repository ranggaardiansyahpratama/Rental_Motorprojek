@extends('layouts.app')

@section('title', 'Verifikasi Motor - RentMotor Admin')

@section('content')

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg mb-6">
            <div class="px-6 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Manajemen Data Motor</h1>
                        <p class="text-gray-600 mt-1">Kelola semua data motor, verifikasi, dan tentukan harga sewa</p>
                    </div>
                    @auth
                        @if(auth()->user()->isOwner())
                        <a href="{{ route('owner.motors.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Motor Baru
                        </a>
                        @elseif(auth()->user()->isAdmin())
                        <div class="flex gap-2">
                            <a href="{{ route('admin.motors.create') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Motor
                            </a>
                            <button onclick="exportData()" 
                                    class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Export Data
                            </button>
                        </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>

        <!-- Statistics Summary -->
        @if(auth()->user()->isAdmin())
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Motor</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Motor::count() }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-orange-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Pending</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $pendingCount }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Tersedia</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Motor::where('status', 'available')->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center">
                    <div class="bg-red-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Disewa</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Motor::where('status', 'rented')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Filter Tabs -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="px-6 py-4">
                <div class="flex space-x-8">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'pending_verification']) }}" 
                       class="pb-4 {{ request('status') !== 'verified' && request('status') !== 'rejected' ? 'border-b-2 border-orange-500 text-orange-600' : 'text-gray-500 hover:text-gray-700' }}">
                        🔍 Menunggu Verifikasi
                        @if($pendingCount > 0)
                            <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded-full text-xs font-semibold ml-2">{{ $pendingCount }}</span>
                        @endif
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'verified']) }}" 
                       class="pb-4 {{ request('status') === 'verified' ? 'border-b-2 border-green-500 text-green-600' : 'text-gray-500 hover:text-gray-700' }}">
                        ✅ Sudah Diverifikasi
                    </a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'rejected']) }}" 
                       class="pb-4 {{ request('status') === 'rejected' ? 'border-b-2 border-red-500 text-red-600' : 'text-gray-500 hover:text-gray-700' }}">
                        ❌ Ditolak
                    </a>
                </div>
            </div>
        </div>

        <!-- Motors List -->
        @if($motors->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($motors as $motor)
                <div class="bg-white rounded-lg shadow-lg">
                    <div class="p-6">
                        <!-- Motor Header -->
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $motor->brand }} {{ $motor->type }}</h3>
                                <p class="text-sm text-gray-600">{{ $motor->license_plate }} • {{ $motor->color }} • {{ $motor->year }}</p>
                                <p class="text-xs text-gray-500 mt-1">Didaftarkan: {{ $motor->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <span class="inline-block px-3 py-1 text-xs rounded-full {{ $motor->status_badge }}">
                                {{ ucfirst(str_replace('_', ' ', $motor->status)) }}
                            </span>
                        </div>

                        <!-- CRUD Action Buttons -->
                        <div class="flex gap-2 mb-4 pb-4 border-b border-gray-200">
                            <a href="{{ route(auth()->user()->role . '.motors.show', $motor) }}" 
                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 hover:bg-blue-200 rounded-md transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View
                            </a>
                            
                            @can('update', $motor)
                            <a href="{{ route(auth()->user()->role . '.motors.edit', $motor) }}" 
                               class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-green-700 bg-green-100 hover:bg-green-200 rounded-md transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                            @endcan

                            @can('delete', $motor)
                            <button type="button" 
                                    onclick="deleteMotor({{ $motor->id }})"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-700 bg-red-100 hover:bg-red-200 rounded-md transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete
                            </button>
                            @endcan

                            @if($motor->status === 'available' && auth()->user()->isAdmin())
                            <button type="button" 
                                    onclick="changeStatus({{ $motor->id }}, 'maintenance')"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-yellow-700 bg-yellow-100 hover:bg-yellow-200 rounded-md transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Maintenance
                            </button>
                            @elseif($motor->status === 'maintenance' && auth()->user()->isAdmin())
                            <button type="button" 
                                    onclick="changeStatus({{ $motor->id }}, 'available')"
                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 hover:bg-blue-200 rounded-md transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Activate
                            </button>
                            @endif
                        </div>

                        <!-- Motor Images -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Foto Motor</label>
                                @if($motor->photo)
                                    <img src="{{ asset('storage/' . $motor->photo) }}" alt="Motor" class="w-full h-32 object-cover rounded-lg border">
                                @else
                                    <div class="w-full h-32 bg-gray-200 rounded-lg border flex items-center justify-center">
                                        <span class="text-gray-500 text-sm">Tidak ada foto</span>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Dokumen</label>
                                @if($motor->documents)
                                    <a href="{{ asset('storage/' . $motor->documents) }}" target="_blank" class="w-full h-32 bg-blue-50 rounded-lg border-2 border-dashed border-blue-300 flex items-center justify-center hover:bg-blue-100">
                                        <div class="text-center">
                                            <svg class="w-8 h-8 text-blue-600 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span class="text-blue-600 text-xs">Lihat Dokumen</span>
                                        </div>
                                    </a>
                                @else
                                    <div class="w-full h-32 bg-gray-200 rounded-lg border flex items-center justify-center">
                                        <span class="text-gray-500 text-sm">Tidak ada dokumen</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Motor Details -->
                        <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                            <div>
                                <span class="text-gray-500">Pemilik:</span>
                                <span class="font-medium ml-1">{{ $motor->owner->name }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Kapasitas:</span>
                                <span class="font-medium ml-1">{{ $motor->engine_capacity ?? '-' }} CC</span>
                            </div>
                        </div>

                        @if($motor->description)
                        <div class="mb-4">
                            <span class="text-gray-500 text-sm">Deskripsi:</span>
                            <p class="text-sm text-gray-700 mt-1">{{ $motor->description }}</p>
                        </div>
                        @endif

                        @if($motor->status === 'pending_verification')
                        <!-- Verification Form -->
                        <form method="POST" action="{{ route('admin.motors.verify', $motor) }}" class="mt-4 border-t pt-4">
                            @csrf
                            
                            <div class="grid grid-cols-3 gap-4 mb-4">
                                <div>
                                    <label for="daily_rate_{{ $motor->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                        Harga Harian (Rp)
                                    </label>
                                    <input type="number" 
                                           name="daily_rate" 
                                           id="daily_rate_{{ $motor->id }}" 
                                           required
                                           min="10000"
                                           step="1000"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="50000"
                                           onchange="calculateRates({{ $motor->id }})">
                                </div>
                                
                                <div>
                                    <label for="weekly_rate_{{ $motor->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                        Harga Mingguan (Rp)
                                    </label>
                                    <input type="number" 
                                           name="weekly_rate" 
                                           id="weekly_rate_{{ $motor->id }}" 
                                           required
                                           min="10000"
                                           step="1000"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="300000">
                                </div>

                                <div>
                                    <label for="monthly_rate_{{ $motor->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                        Harga Bulanan (Rp)
                                    </label>
                                    <input type="number" 
                                           name="monthly_rate" 
                                           id="monthly_rate_{{ $motor->id }}" 
                                           required
                                           min="10000"
                                           step="1000"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="1200000">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="action_{{ $motor->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                    Status Verifikasi
                                </label>
                                <select name="action" 
                                        id="action_{{ $motor->id }}" 
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Aksi</option>
                                    <option value="approve">✅ Setujui & Aktifkan</option>
                                    <option value="reject">❌ Tolak</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="admin_notes_{{ $motor->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                    Catatan Admin
                                </label>
                                <textarea name="admin_notes" 
                                          id="admin_notes_{{ $motor->id }}" 
                                          rows="2"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Berikan catatan atau alasan penolakan (opsional)"></textarea>
                            </div>

                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
                                Proses Verifikasi
                            </button>
                        </form>
                        @elseif($motor->status === 'available')
                        <!-- Verified Status -->
                        <div class="mt-4 border-t pt-4">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-green-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-green-800">Motor Telah Diverifikasi</h4>
                                        <div class="text-sm text-green-700 mt-1">
                                            <strong>Harga Sewa:</strong><br>
                                            • Harian: Rp {{ number_format($motor->daily_rate ?? $motor->rental_price, 0, ',', '.') }}<br>
                                            • Mingguan: Rp {{ number_format($motor->weekly_rate ?? ($motor->rental_price * 7), 0, ',', '.') }}<br>
                                            • Bulanan: Rp {{ number_format($motor->monthly_rate ?? ($motor->rental_price * 30), 0, ',', '.') }}
                                        </div>
                                        @if($motor->admin_notes)
                                        <p class="text-xs text-green-600 mt-1">Catatan: {{ $motor->admin_notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @elseif($motor->status === 'rejected')
                        <!-- Rejected Status -->
                        <div class="mt-4 border-t pt-4">
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-red-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-red-800">Motor Ditolak</h4>
                                        @if($motor->admin_notes)
                                        <p class="text-sm text-red-700 mt-1">Alasan: {{ $motor->admin_notes }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $motors->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h3M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 8h5a2 2 0 002-2V9a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">
                    @if(request('status') === 'verified')
                        Belum Ada Motor yang Diverifikasi
                    @elseif(request('status') === 'rejected')
                        Belum Ada Motor yang Ditolak
                    @else
                        Belum Ada Motor yang Perlu Diverifikasi
                    @endif
                </h3>
                <p class="text-gray-500">
                    @if(request('status') === 'verified')
                        Motor yang sudah diverifikasi akan muncul di sini
                    @elseif(request('status') === 'rejected')
                        Motor yang ditolak akan muncul di sini
                    @else
                        Motor yang didaftarkan pemilik akan muncul di sini untuk diverifikasi
                    @endif
                </p>
            </div>
        @endif
    </div>

<script>
function calculateRates(motorId) {
    const dailyRate = parseFloat(document.getElementById(`daily_rate_${motorId}`).value) || 0;
    
    if (dailyRate > 0) {
        // Calculate with discount for longer periods
        const weeklyRate = Math.round(dailyRate * 7 * 0.9); // 10% discount for weekly
        const monthlyRate = Math.round(dailyRate * 30 * 0.8); // 20% discount for monthly
        
        document.getElementById(`weekly_rate_${motorId}`).value = weeklyRate;
        document.getElementById(`monthly_rate_${motorId}`).value = monthlyRate;
    }
}

function deleteMotor(motorId) {
    if (confirm('Apakah Anda yakin ingin menghapus motor ini? Tindakan ini tidak dapat dibatalkan.')) {
        // Create form and submit delete request
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/' + '{{ auth()->user()->role }}' + '/motors/' + motorId;
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add method override for DELETE
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        document.body.appendChild(form);
        form.submit();
    }
}

function changeStatus(motorId, newStatus) {
    const statusText = {
        'maintenance': 'maintenance',
        'available': 'tersedia'
    };
    
    if (confirm(`Apakah Anda yakin ingin mengubah status motor menjadi ${statusText[newStatus]}?`)) {
        // Create form for status update
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/motors/${motorId}`;
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add method override for PATCH
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PATCH';
        form.appendChild(methodField);
        
        // Add status field
        const statusField = document.createElement('input');
        statusField.type = 'hidden';
        statusField.name = 'status';
        statusField.value = newStatus;
        form.appendChild(statusField);
        
        document.body.appendChild(form);
        form.submit();
    }
}

function exportData() {
    window.open('{{ route("admin.motors.export") }}', '_blank');
}
</script>
@endsection
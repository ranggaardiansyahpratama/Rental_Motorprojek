@extends('layouts.app')

@section('title', 'Profil Pengguna - ' . $user->name)

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="space-y-8">
        <!-- Profile Header Section -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100">
            <div class="bg-gradient-to-r from-blue-700 via-indigo-600 to-purple-700 px-6 py-12 sm:px-12 relative overflow-hidden">
                <!-- Decorative background elements -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-blue-400 opacity-20 rounded-full blur-2xl"></div>

                <div class="relative z-10 flex flex-col md:flex-row items-center">
                    <div class="w-32 h-32 bg-white/20 backdrop-blur-xl border border-white/30 rounded-3xl flex items-center justify-center text-4xl font-extrabold text-white shadow-2xl">
                        {{ strtoupper(substr($user->name, 0, 1)) }}{{ strtoupper(substr($user->name, -1)) }}
                    </div>
                    <div class="mt-6 md:mt-0 md:ml-8 text-center md:text-left">
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-2">
                            <h1 class="text-4xl font-black text-white tracking-tight">{{ $user->name }}</h1>
                            <span class="inline-flex items-center px-4 py-1 rounded-full text-xs font-bold bg-white/20 border border-white/30 text-white backdrop-blur-md uppercase tracking-widest">
                                <i class="fas fa-user-shield mr-2"></i>
                                {{ $user->role }}
                            </span>
                        </div>
                        <p class="text-blue-100 text-lg flex items-center justify-center md:justify-start">
                            <i class="fas fa-envelope mr-3 opacity-70"></i>
                            {{ $user->email }}
                        </p>
                    </div>
                    <div class="mt-8 md:mt-0 md:ml-auto">
                        <a href="{{ route('profile.edit') }}" class="group flex items-center bg-white hover:bg-gray-50 text-blue-700 px-6 py-3 rounded-2xl font-bold shadow-lg shadow-blue-900/20 transition-all duration-300 transform hover:-translate-y-1">
                            <i class="fas fa-edit mr-3 group-hover:rotate-12 transition-transform"></i>
                            Edit Profil
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Content Body -->
            <div class="p-8 sm:p-12">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Left Column: Primary Stats/Info -->
                    <div class="lg:col-span-2 space-y-10">
                        <section>
                            <div class="flex items-center mb-8">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 mr-4">
                                    <i class="fas fa-info-circle text-xl"></i>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900">Informasi Pribadi</h2>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 transition-colors hover:bg-gray-100">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Lengkap</label>
                                    <p class="text-lg font-semibold text-gray-800">{{ $user->name }}</p>
                                </div>
                                
                                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 transition-colors hover:bg-gray-100">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Email</label>
                                    <p class="text-lg font-semibold text-gray-800">{{ $user->email }}</p>
                                </div>
                                
                                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 transition-colors hover:bg-gray-100">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Nomor Telepon</label>
                                    <p class="text-lg font-semibold text-gray-800">{{ $user->phone ?? 'Belum ditambahkan' }}</p>
                                </div>
                                
                                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 transition-colors hover:bg-gray-100">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Bergabung Sejak</label>
                                    <p class="text-lg font-semibold text-gray-800">{{ $user->created_at->translatedFormat('d F Y') }}</p>
                                </div>
                            </div>

                            <div class="mt-8 p-4 rounded-2xl bg-gray-50 border border-gray-100 transition-colors hover:bg-gray-100">
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Alamat Lengkap</label>
                                <p class="text-lg font-semibold text-gray-800">{{ $user->address ?? 'Belum ditambahkan' }}</p>
                            </div>
                        </section>

                        <!-- Role Specific Insights -->
                        @if($user->isOwner())
                        <section>
                            <div class="flex items-center mb-8 pt-6 border-t border-gray-100">
                                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center text-green-600 mr-4">
                                    <i class="fas fa-motorcycle text-xl"></i>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900">Statistik Pemilik</h2>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="bg-gradient-to-br from-green-50 to-green-100 p-8 rounded-3xl border border-green-200">
                                    <div class="text-4xl font-black text-green-700 mb-2">{{ $user->ownedMotors()->count() }}</div>
                                    <div class="text-sm font-bold text-green-600 uppercase tracking-widest">Total Kendaraan</div>
                                </div>
                                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-3xl border border-blue-200">
                                    <div class="text-4xl font-black text-blue-700 mb-2">{{ $user->ownedMotors()->where('status', 'available')->count() }}</div>
                                    <div class="text-sm font-bold text-blue-600 uppercase tracking-widest">Motor Tersedia</div>
                                </div>
                            </div>
                        </section>
                        @elseif($user->isRenter())
                        <section>
                            <div class="flex items-center mb-8 pt-6 border-t border-gray-100">
                                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 mr-4">
                                    <i class="fas fa-receipt text-xl"></i>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900">Statistik Penyewa</h2>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-8 rounded-3xl border border-purple-200">
                                    <div class="text-4xl font-black text-purple-700 mb-2">{{ $user->rentals()->count() }}</div>
                                    <div class="text-sm font-bold text-purple-600 uppercase tracking-widest">Total Penyewaan</div>
                                </div>
                                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-8 rounded-3xl border border-indigo-200">
                                    <div class="text-4xl font-black text-indigo-700 mb-2">{{ $user->rentals()->where('status', 'active')->count() }}</div>
                                    <div class="text-sm font-bold text-indigo-600 uppercase tracking-widest">Sewaan Aktif</div>
                                </div>
                            </div>
                        </section>
                        @endif
                    </div>

                    <!-- Right Column: Quick Navigation/Profile Summary -->
                    <div class="space-y-8">
                        <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100">
                            <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-6">Aksi Cepat</h3>
                            <div class="space-y-4">
                                <a href="{{ route($user->role . '.dashboard') }}" class="flex items-center p-4 bg-white hover:bg-blue-50 rounded-2xl border border-gray-200 hover:border-blue-200 transition-all group">
                                    <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mr-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                        <i class="fas fa-th-large"></i>
                                    </div>
                                    <span class="font-bold text-gray-700">Dashboard</span>
                                    <i class="fas fa-chevron-right ml-auto text-gray-300 group-hover:text-blue-500 transition-colors"></i>
                                </a>
                                
                                @if($user->isOwner())
                                <a href="{{ route('owner.motors.create') }}" class="flex items-center p-4 bg-white hover:bg-green-50 rounded-2xl border border-gray-200 hover:border-green-200 transition-all group">
                                    <div class="w-10 h-10 bg-green-50 text-green-600 rounded-xl flex items-center justify-center mr-4 group-hover:bg-green-600 group-hover:text-white transition-colors">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                    <span class="font-bold text-gray-700">Tambah Motor</span>
                                    <i class="fas fa-chevron-right ml-auto text-gray-300 group-hover:text-green-500 transition-colors"></i>
                                </a>
                                @endif
                                
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center p-4 bg-white hover:bg-red-50 rounded-2xl border border-gray-200 hover:border-red-200 transition-all group">
                                        <div class="w-10 h-10 bg-red-50 text-red-600 rounded-xl flex items-center justify-center mr-4 group-hover:bg-red-600 group-hover:text-white transition-colors">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </div>
                                        <span class="font-bold text-gray-700">Keluar Sistem</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Account Security Card -->
                        <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-3xl p-8 text-white relative overflow-hidden shadow-2xl">
                            <div class="relative z-10">
                                <h3 class="text-sm font-black text-gray-400 uppercase tracking-widest mb-6">Keamanan Akun</h3>
                                <div class="space-y-4">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-lock text-sm text-green-400"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold">Kata Sandi</p>
                                            <p class="text-xs text-gray-400">Terakhir diubah 30 hari lalu</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-shield-alt text-sm text-blue-400"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold">Autentikasi 2FA</p>
                                            <p class="text-xs text-gray-400">Belum diaktifkan</p>
                                        </div>
                                    </div>
                                </div>
                                <button onclick="alert('Fitur keamanan akan segera hadir!')" class="w-full mt-6 py-3 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl text-sm font-bold transition-colors">
                                    Kelola Keamanan
                                </button>
                            </div>
                            <i class="fas fa-fingerprint absolute -right-6 -bottom-6 text-white/5 text-9xl transform -rotate-12"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
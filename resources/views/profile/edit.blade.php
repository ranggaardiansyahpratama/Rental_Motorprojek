@extends('layouts.app')

@section('title', 'Edit Profile - RentMotor')

@section('content')
<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-8 sm:px-10">
                <div class="flex items-center">
                    <div class="w-16 h-16 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-3xl text-white shadow-inner">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div class="ml-6">
                        <h2 class="text-3xl font-extrabold text-white">
                            Pengaturan Profil
                        </h2>
                        <p class="text-blue-100 mt-1">
                            Kelola informasi akun dan preferensi keamanan Anda
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-white">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Left Sidebar - Navigation -->
                    <div class="md:col-span-1 space-y-4">
                        <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100">
                            <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider mb-4">Navigasi</h3>
                            <nav class="space-y-1">
                                <a href="#profile-info" class="group flex items-center px-4 py-3 text-sm font-medium text-blue-700 bg-blue-50 rounded-xl transition-all duration-200">
                                    <i class="fas fa-id-card w-5 mr-3 text-blue-500"></i>
                                    Informasi Profil
                                </a>
                                <a href="#danger-zone" class="group flex items-center px-4 py-3 text-sm font-medium text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all duration-200">
                                    <i class="fas fa-exclamation-triangle w-5 mr-3 text-gray-400 group-hover:text-red-500 transition-colors"></i>
                                    Zona Berbahaya
                                </a>
                            </nav>
                        </div>

                        <!-- User Summary Card -->
                        <div class="p-6 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl text-white shadow-lg overflow-hidden relative">
                            <div class="relative z-10">
                                <p class="text-indigo-100 text-xs font-semibold uppercase tracking-widest">Status Akun</p>
                                <h4 class="text-xl font-bold mt-1">{{ ucfirst($user->role) }}</h4>
                                <div class="mt-4 flex items-center">
                                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse mr-2"></div>
                                    <span class="text-xs text-indigo-100">Aktif & Terverifikasi</span>
                                </div>
                            </div>
                            <i class="fas fa-shield-alt absolute -right-4 -bottom-4 text-white/10 text-8xl transform -rotate-12"></i>
                        </div>
                    </div>

                    <!-- Main Form Section -->
                    <div class="md:col-span-2 space-y-8">
                        <!-- Profile Information Form -->
                        <section id="profile-info" class="scroll-mt-24">
                            <div class="flex items-center mb-6">
                                <div class="h-8 w-1 bg-blue-600 rounded-full mr-4"></div>
                                <h3 class="text-xl font-bold text-gray-900">Informasi Pribadi</h3>
                            </div>

                            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                                @csrf
                                @method('patch')

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <!-- Name -->
                                    <div class="space-y-1">
                                        <label for="name" class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                                <i class="fas fa-user text-xs"></i>
                                            </div>
                                            <input id="name" name="name" type="text" 
                                                class="block w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                                value="{{ old('name', $user->name) }}" required autofocus />
                                        </div>
                                        @error('name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="space-y-1">
                                        <label for="email" class="block text-sm font-semibold text-gray-700">Alamat Email</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                                <i class="fas fa-envelope text-xs"></i>
                                            </div>
                                            <input id="email" name="email" type="email" 
                                                class="block w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                                value="{{ old('email', $user->email) }}" required />
                                        </div>
                                        @error('email') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <!-- Phone -->
                                    <div class="space-y-1">
                                        <label for="phone" class="block text-sm font-semibold text-gray-700">Nomor Telepon</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                                <i class="fas fa-phone text-xs"></i>
                                            </div>
                                            <input id="phone" name="phone" type="text" 
                                                class="block w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                                placeholder="Contoh: 08123456789"
                                                value="{{ old('phone', $user->phone) }}" />
                                        </div>
                                        @error('phone') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                                    </div>

                                    <!-- Role (Read Only) -->
                                    <div class="space-y-1">
                                        <label class="block text-sm font-semibold text-gray-700">Role Pengguna</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                                <i class="fas fa-user-tag text-xs"></i>
                                            </div>
                                            <input type="text" disabled 
                                                class="block w-full pl-10 pr-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-gray-500 cursor-not-allowed" 
                                                value="{{ ucfirst($user->role) }}" />
                                        </div>
                                        <p class="text-[10px] text-gray-400 mt-1">Role tidak dapat diubah oleh pengguna</p>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="space-y-1">
                                    <label for="address" class="block text-sm font-semibold text-gray-700">Alamat Lengkap</label>
                                    <div class="relative">
                                        <div class="absolute top-3 left-3 flex items-center pointer-events-none text-gray-400">
                                            <i class="fas fa-map-marker-alt text-xs"></i>
                                        </div>
                                        <textarea id="address" name="address" rows="3"
                                            class="block w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200"
                                            placeholder="Masukkan alamat lengkap Anda...">{{ old('address', $user->address) }}</textarea>
                                    </div>
                                    @error('address') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-100">
                                    <button type="submit" 
                                        class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-200 transition-all duration-200 active:scale-95">
                                        Simpan Perubahan
                                    </button>

                                    @if (session('status') === 'profile-updated')
                                        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
                                            class="bg-green-50 text-green-700 px-4 py-2 rounded-lg text-sm flex items-center border border-green-100">
                                            <i class="fas fa-check-circle mr-2"></i>
                                            Berhasil diperbarui
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </section>

                        <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>

                        <!-- Danger Zone Section -->
                        <section id="danger-zone" class="scroll-mt-24">
                            <div class="flex items-center mb-6">
                                <div class="h-8 w-1 bg-red-600 rounded-full mr-4"></div>
                                <div class="space-y-1">
                                    <h3 class="text-xl font-bold text-gray-900">Hapus Akun</h3>
                                    <p class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan</p>
                                </div>
                            </div>

                            <div class="p-6 bg-red-50 rounded-2xl border border-red-100">
                                <p class="text-sm text-red-700 mb-6 leading-relaxed">
                                    Setelah akun Anda dihapus, semua sumber daya dan data di dalamnya akan dihapus secara permanen. Pastikan Anda telah mengunduh data penting apa pun sebelum melanjutkan.
                                </p>

                                <div x-data="{ confirmingUserDeletion: false }">
                                    <button @click="confirmingUserDeletion = true" 
                                        class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-200 transition-all duration-200">
                                        <i class="fas fa-trash-alt mr-2"></i>
                                        Hapus Akun Secara Permanen
                                    </button>

                                    <!-- Deletion Modal Overlay -->
                                    <div x-show="confirmingUserDeletion" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                                        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                            <div x-show="confirmingUserDeletion" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 transition-opacity" aria-hidden="true">
                                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                            </div>

                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                            <div x-show="confirmingUserDeletion" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                                <form method="post" action="{{ route('profile.destroy') }}" class="p-8">
                                                    @csrf
                                                    @method('delete')

                                                    <h3 class="text-2xl font-bold text-gray-900 mb-4">
                                                        Konfirmasi Penghapusan
                                                    </h3>

                                                    <p class="text-gray-600 mb-6 leading-relaxed">
                                                        Apakah Anda yakin ingin menghapus akun Anda? Masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun secara permanen.
                                                    </p>

                                                    <div class="space-y-4">
                                                        <input id="password" name="password" type="password" 
                                                            class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200" 
                                                            placeholder="Kata Sandi Anda" />
                                                        @error('password', 'userDeletion') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                                                    </div>

                                                    <div class="mt-8 flex flex-col sm:flex-row-reverse gap-3">
                                                        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all">
                                                            Hapus Akun
                                                        </button>
                                                        <button type="button" @click="confirmingUserDeletion = false" class="w-full sm:w-auto px-8 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-all">
                                                            Batalkan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    [x-cloak] { display: none !important; }
    input:focus, textarea:focus {
        outline: none;
    }
</style>
@endpush
@endsection
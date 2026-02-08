@extends('layouts.app')

@section('title', 'Edit Motor')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
                <a href="{{ route(auth()->user()->role . '.motors.index') }}" class="hover:text-blue-600">Motor</a>
                <span>/</span>
                <a href="{{ route(auth()->user()->role . '.motors.show', $motor) }}" class="hover:text-blue-600">{{ $motor->brand }} {{ $motor->type }}</a>
                <span>/</span>
                <span class="text-gray-900">Edit</span>
            </nav>
            
            <h1 class="text-3xl font-bold text-gray-900">Edit Motor</h1>
            <p class="text-gray-600 mt-2">Update informasi motor Anda</p>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <i class="fas fa-exclamation-triangle text-red-400 mr-3 mt-1"></i>
                    <div>
                        <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan:</h3>
                        <ul class="mt-2 list-disc list-inside text-sm text-red-600">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Edit Form -->
        <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
            <form action="{{ route(auth()->user()->role . '.motors.update', $motor) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Current Photo Display -->
                @if($motor->photo)
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Foto Saat Ini</label>
                    <div class="w-32 h-32 bg-gray-100 rounded-lg overflow-hidden">
                        <img src="{{ Storage::url($motor->photo) }}" 
                             alt="{{ $motor->brand }} {{ $motor->type }}" 
                             class="w-full h-full object-cover">
                    </div>
                </div>
                @endif

                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">
                            Merk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="brand" 
                               name="brand" 
                               value="{{ old('brand', $motor->brand) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               required>
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis/Tipe <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="type" 
                               name="type" 
                               value="{{ old('type', $motor->type) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               required>
                    </div>

                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                            Warna <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="color" 
                               name="color" 
                               value="{{ old('color', $motor->color) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               required>
                    </div>

                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-2">
                            Tahun <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="year" 
                               name="year" 
                               value="{{ old('year', $motor->year) }}"
                               min="1990" 
                               max="{{ date('Y') + 1 }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               required>
                    </div>

                    <div>
                        <label for="license_plate" class="block text-sm font-medium text-gray-700 mb-2">
                            Plat Nomor <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="license_plate" 
                               name="license_plate" 
                               value="{{ old('license_plate', $motor->license_plate) }}"
                               placeholder="B 1234 ABC"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                               required>
                    </div>

                    <div>
                        <label for="engine_capacity" class="block text-sm font-medium text-gray-700 mb-2">
                            Kapasitas Mesin (CC)
                        </label>
                        <input type="number" 
                               id="engine_capacity" 
                               name="engine_capacity" 
                               value="{{ old('engine_capacity', $motor->engine_capacity) }}"
                               min="50" 
                               max="1000"
                               placeholder="150"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Pricing (Admin Only) -->
                @if(auth()->user()->isAdmin())
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Harga Sewa (Admin)</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="daily_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                Harga per Hari (Rp)
                            </label>
                            <input type="number" 
                                   id="daily_rate" 
                                   name="daily_rate" 
                                   value="{{ old('daily_rate', $motor->daily_rate) }}"
                                   min="0" 
                                   step="1000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="weekly_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                Harga per Minggu (Rp)
                            </label>
                            <input type="number" 
                                   id="weekly_rate" 
                                   name="weekly_rate" 
                                   value="{{ old('weekly_rate', $motor->weekly_rate) }}"
                                   min="0" 
                                   step="1000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div>
                            <label for="monthly_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                Harga per Bulan (Rp)
                            </label>
                            <input type="number" 
                                   id="monthly_rate" 
                                   name="monthly_rate" 
                                   value="{{ old('monthly_rate', $motor->monthly_rate) }}"
                                   min="0" 
                                   step="1000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                </div>
                @endif

                <!-- Photo Upload -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Foto Motor</h3>
                    
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                            Update Foto Motor (Opsional)
                        </label>
                        <input type="file" 
                               id="photo" 
                               name="photo" 
                               accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <p class="mt-1 text-sm text-gray-500">
                            Upload foto baru untuk mengganti foto saat ini. Format: JPG, PNG, GIF. Maksimal 5MB.
                        </p>
                    </div>
                </div>

                <!-- Description -->
                <div class="border-t pt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi (Opsional)
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4"
                              placeholder="Deskripsikan kondisi motor, fitur khusus, atau informasi tambahan lainnya..."
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description', $motor->description) }}</textarea>
                </div>

                <!-- Admin Status Update -->
                @if(auth()->user()->isAdmin())
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Status Motor (Admin)</h3>
                    
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" 
                                name="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                required>
                            <option value="pending_verification" {{ old('status', $motor->status) === 'pending_verification' ? 'selected' : '' }}>
                                Menunggu Verifikasi
                            </option>
                            <option value="available" {{ old('status', $motor->status) === 'available' ? 'selected' : '' }}>
                                Tersedia
                            </option>
                            <option value="rented" {{ old('status', $motor->status) === 'rented' ? 'selected' : '' }}>
                                Sedang Disewa
                            </option>
                            <option value="maintenance" {{ old('status', $motor->status) === 'maintenance' ? 'selected' : '' }}>
                                Maintenance
                            </option>
                            <option value="unavailable" {{ old('status', $motor->status) === 'unavailable' ? 'selected' : '' }}>
                                Tidak Tersedia
                            </option>
                        </select>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex justify-between pt-6 border-t">
                    <a href="{{ route(auth()->user()->role . '.motors.show', $motor) }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Batal
                    </a>
                    
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                        <i class="fas fa-save mr-2"></i>Update Motor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Auto-calculate weekly and monthly rates based on daily rate
document.getElementById('daily_rate').addEventListener('input', function() {
    const dailyRate = parseInt(this.value) || 0;
    const weeklyRate = dailyRate * 6; // 1 week discount (6 days price for 7 days)
    const monthlyRate = dailyRate * 25; // 1 month discount (25 days price for 30 days)
    
    document.getElementById('weekly_rate').value = weeklyRate;
    document.getElementById('monthly_rate').value = monthlyRate;
});
</script>
@endsection
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftarkan Motor - RentMotor</title>
    
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        .btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.3);
        }
        
        .upload-area {
            transition: all 0.3s ease;
        }
        
        .upload-area:hover {
            border-color: #10b981;
            background-color: #f0fdf4;
        }
        
        .form-step {
            opacity: 0.6;
        }
        
        .form-step.active {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-green-50 to-blue-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('owner.dashboard') }}" class="text-2xl font-bold text-green-600">
                        Pemilik Motor
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('owner.dashboard') }}" class="text-gray-500 hover:text-green-600 px-3 py-2 rounded-lg text-sm transition">
                        <i class="fas fa-arrow-left mr-1"></i>Kembali ke Dashboard
                    </a>
                    <span class="text-sm text-gray-700">{{ Auth::user()->name }}</span>
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">PEMILIK</span>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg border border-gray-200">
            <!-- Header -->
            <div class="px-6 py-6 border-b border-gray-200 bg-gradient-to-r from-green-500 to-blue-600 rounded-t-xl">
                <div class="flex items-center">
                    <div class="p-3 bg-white/20 rounded-lg mr-4">
                        <i class="fas fa-motorcycle text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-white">Daftarkan Motor Baru</h1>
                        <p class="text-green-100 mt-1">Lengkapi semua data motor yang akan didaftarkan untuk disewakan</p>
                    </div>
                </div>
                
                <!-- Progress Steps -->
                <div class="mt-6 flex items-center space-x-4">
                    <div class="flex items-center form-step active">
                        <div class="w-8 h-8 bg-white text-green-600 rounded-full flex items-center justify-center font-bold text-sm">1</div>
                        <span class="ml-2 text-white font-medium">Data Motor</span>
                    </div>
                    <div class="w-8 h-px bg-white/30"></div>
                    <div class="flex items-center form-step">
                        <div class="w-8 h-8 bg-white/20 text-white rounded-full flex items-center justify-center font-bold text-sm">2</div>
                        <span class="ml-2 text-white/70 font-medium">Verifikasi Admin</span>
                    </div>
                    <div class="w-8 h-px bg-white/30"></div>
                    <div class="flex items-center form-step">
                        <div class="w-8 h-8 bg-white/20 text-white rounded-full flex items-center justify-center font-bold text-sm">3</div>
                        <span class="ml-2 text-white/70 font-medium">Siap Disewakan</span>
                    </div>
                </div>
            </div>

            <!-- Info Alert -->
            <div class="p-6 border-b border-gray-200">
                <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400 text-lg"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                Mengapa tidak ada input harga sewa?
                            </h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Harga sewa motor akan ditentukan oleh admin setelah proses verifikasi berdasarkan:</p>
                                <ul class="list-disc list-inside mt-1 space-y-1">
                                    <li>Kondisi fisik motor</li>
                                    <li>Tahun pembuatan dan merk</li>
                                    <li>Kelengkapan dokumen</li>
                                    <li>Harga pasar saat ini</li>
                                </ul>
                                <p class="mt-2 font-medium">Fokus saja pada data motor yang lengkap dan akurat! 📝</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('owner.motors.store') }}" enctype="multipart/form-data" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Merk Motor -->
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">
                            Merk Motor *
                        </label>
                        <select name="brand" 
                                id="brand" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Pilih Merk Motor</option>
                            <option value="Honda" {{ old('brand') == 'Honda' ? 'selected' : '' }}>Honda</option>
                            <option value="Yamaha" {{ old('brand') == 'Yamaha' ? 'selected' : '' }}>Yamaha</option>
                            <option value="Suzuki" {{ old('brand') == 'Suzuki' ? 'selected' : '' }}>Suzuki</option>
                            <option value="Kawasaki" {{ old('brand') == 'Kawasaki' ? 'selected' : '' }}>Kawasaki</option>
                            <option value="TVS" {{ old('brand') == 'TVS' ? 'selected' : '' }}>TVS</option>
                            <option value="Benelli" {{ old('brand') == 'Benelli' ? 'selected' : '' }}>Benelli</option>
                            <option value="Viar" {{ old('brand') == 'Viar' ? 'selected' : '' }}>Viar</option>
                            <option value="other">Lainnya</option>
                        </select>
                        <input type="text" 
                               name="brand_custom" 
                               id="brand_custom" 
                               value="{{ old('brand_custom') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 mt-2 hidden"
                               placeholder="Masukkan merk motor lainnya">
                        @error('brand')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Motor -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenis Motor *
                        </label>
                        <input type="text" 
                               name="type" 
                               id="type" 
                               value="{{ old('type') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="Contoh: Vario 150, Beat, PCX">
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Polisi -->
                    <div>
                        <label for="license_plate" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Polisi *
                        </label>
                        <input type="text" 
                               name="license_plate" 
                               id="license_plate" 
                               value="{{ old('license_plate') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="Contoh: B 1234 XYZ"
                               style="text-transform: uppercase;">
                        @error('license_plate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kapasitas Mesin -->
                    <div>
                        <label for="engine_capacity" class="block text-sm font-medium text-gray-700 mb-2">
                            Kapasitas Mesin (CC) *
                        </label>
                        <select name="engine_capacity" 
                                id="engine_capacity" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Pilih Kapasitas</option>
                            <option value="100" {{ old('engine_capacity') == '100' ? 'selected' : '' }}>100 CC</option>
                            <option value="125" {{ old('engine_capacity') == '125' ? 'selected' : '' }}>125 CC</option>
                            <option value="150" {{ old('engine_capacity') == '150' ? 'selected' : '' }}>150 CC</option>
                            <option value="250" {{ old('engine_capacity') == '250' ? 'selected' : '' }}>250 CC</option>
                        </select>
                        @error('engine_capacity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tahun -->
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 mb-2">
                            Tahun Pembuatan *
                        </label>
                        <select name="year" 
                                id="year" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Pilih Tahun</option>
                            @for($i = date('Y'); $i >= 2010; $i--)
                                <option value="{{ $i }}" {{ old('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        @error('year')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Warna -->
                    <div>
                        <label for="color" class="block text-sm font-medium text-gray-700 mb-2">
                            Warna Motor *
                        </label>
                        <input type="text" 
                               name="color" 
                               id="color" 
                               value="{{ old('color') }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="Contoh: Merah, Hitam, Putih">
                        @error('color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kapasitas Mesin -->
                    <div>
                        <label for="engine_capacity" class="block text-sm font-medium text-gray-700 mb-2">
                            Kapasitas Mesin (CC) *
                        </label>
                        <select name="engine_capacity" 
                                id="engine_capacity" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Pilih Kapasitas Mesin</option>
                            <option value="100" {{ old('engine_capacity') == '100' ? 'selected' : '' }}>100cc</option>
                            <option value="110" {{ old('engine_capacity') == '110' ? 'selected' : '' }}>110cc</option>
                            <option value="125" {{ old('engine_capacity') == '125' ? 'selected' : '' }}>125cc</option>
                            <option value="150" {{ old('engine_capacity') == '150' ? 'selected' : '' }}>150cc</option>
                            <option value="160" {{ old('engine_capacity') == '160' ? 'selected' : '' }}>160cc</option>
                            <option value="250" {{ old('engine_capacity') == '250' ? 'selected' : '' }}>250cc</option>
                            <option value="other">Lainnya</option>
                        </select>
                        <input type="number" 
                               name="engine_capacity_custom" 
                               id="engine_capacity_custom" 
                               value="{{ old('engine_capacity_custom') }}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 mt-2 hidden"
                               placeholder="Masukkan kapasitas mesin (CC)"
                               min="50" max="1000">
                        @error('engine_capacity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Motor
                    </label>
                    <textarea name="description" 
                              id="description" 
                              rows="4"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                              placeholder="Berikan deskripsi tambahan tentang kondisi motor, fitur khusus, dll.">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Foto Motor -->
                <div class="mt-6">
                    <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-camera mr-2"></i>Foto Motor *
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center upload-area">
                        <input type="file" 
                               name="photo" 
                               id="photo" 
                               accept="image/*"
                               required
                               class="hidden"
                               onchange="previewImage(this)">
                        <label for="photo" class="cursor-pointer">
                            <div id="image-preview" class="mb-4">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                            </div>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium text-green-600">Klik untuk upload</span> atau drag foto ke sini
                            </p>
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG maksimal 5MB • Foto bagus meningkatkan peluang sewa</p>
                        </label>
                    </div>
                    @error('photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dokumen Motor -->
                <div class="mt-6">
                    <label for="documents" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-file-alt mr-2"></i>Dokumen Motor (STNK/BPKB) *
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center upload-area">
                        <input type="file" 
                               name="documents" 
                               id="documents" 
                               accept="image/*,application/pdf"
                               required
                               class="hidden"
                               onchange="previewDocument(this)">
                        <label for="documents" class="cursor-pointer">
                            <div id="document-preview" class="mb-4">
                                <i class="fas fa-file-upload text-4xl text-gray-400 mb-3"></i>
                            </div>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium text-green-600">Klik untuk upload</span> dokumen STNK/BPKB
                            </p>
                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG, PDF maksimal 10MB • Dokumen harus jelas dan valid</p>
                        </label>
                    </div>
                    @error('documents')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Tambahan -->
                <div class="mt-8 bg-gradient-to-r from-blue-50 to-green-50 border border-blue-200 rounded-xl p-6">
                    <div class="flex">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <i class="fas fa-info-circle text-blue-600"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">📋 Proses Pendaftaran Motor</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="flex items-center p-3 bg-white rounded-lg">
                                    <div class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">1</div>
                                    <div>
                                        <p class="font-medium text-gray-900">Daftar Motor</p>
                                        <p class="text-xs text-gray-600">Isi form lengkap</p>
                                    </div>
                                </div>
                                <div class="flex items-center p-3 bg-white rounded-lg">
                                    <div class="w-8 h-8 bg-yellow-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">2</div>
                                    <div>
                                        <p class="font-medium text-gray-900">Verifikasi Admin</p>
                                        <p class="text-xs text-gray-600">Penentuan harga sewa</p>
                                    </div>
                                </div>
                                <div class="flex items-center p-3 bg-white rounded-lg">
                                    <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-3">3</div>
                                    <div>
                                        <p class="font-medium text-gray-900">Siap Disewa</p>
                                        <p class="text-xs text-gray-600">Mulai terima pesanan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 space-y-3">
                                <div class="p-3 bg-yellow-100 rounded-lg border border-yellow-300">
                                    <p class="text-sm text-yellow-800">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        <strong>Informasi Penting:</strong> Harga sewa akan ditentukan oleh admin setelah verifikasi dokumen dan kondisi motor. Anda tidak perlu mengisi harga sewa saat pendaftaran.
                                    </p>
                                </div>
                                <div class="p-3 bg-green-100 rounded-lg">
                                    <p class="text-sm text-green-800">
                                        <i class="fas fa-lightbulb mr-2"></i>
                                        <strong>Tips:</strong> Foto yang berkualitas dan deskripsi yang detail akan meningkatkan peluang motor Anda untuk disewa!
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-8 flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('owner.dashboard') }}" 
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-xl transition duration-200 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <button type="submit" 
                            class="btn-primary text-white font-semibold py-3 px-8 rounded-xl flex items-center">
                        <i class="fas fa-motorcycle mr-2"></i>Daftarkan Motor Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Preview image function
        function previewImage(input) {
            const preview = document.getElementById('image-preview');
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                
                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 5MB.');
                    input.value = '';
                    return;
                }
                
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <div class="relative">
                            <img src="${e.target.result}" alt="Preview" class="max-w-full h-48 object-cover rounded-lg mx-auto border-2 border-green-200">
                            <div class="absolute top-2 right-2 bg-green-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                                <i class="fas fa-check mr-1"></i>Foto Terupload
                            </div>
                        </div>
                    `;
                };
                
                reader.readAsDataURL(file);
            }
        }

        // Preview document function
        function previewDocument(input) {
            const preview = document.getElementById('document-preview');
            
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileName = file.name;
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                
                // Validate file size (10MB)
                if (file.size > 10 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 10MB.');
                    input.value = '';
                    return;
                }
                
                preview.innerHTML = `
                    <div class="flex items-center justify-center p-4 bg-green-50 rounded-lg border-2 border-green-200">
                        <div class="p-2 bg-green-500 rounded-full mr-3">
                            <i class="fas fa-file-check text-white"></i>
                        </div>
                        <div class="text-left flex-1">
                            <p class="text-sm font-medium text-gray-900">${fileName}</p>
                            <p class="text-xs text-gray-500">${fileSize} MB • Dokumen siap diupload</p>
                        </div>
                        <div class="text-green-600">
                            <i class="fas fa-check-circle text-lg"></i>
                        </div>
                    </div>
                `;
            }
        }

        // Auto uppercase license plate
        document.getElementById('license_plate').addEventListener('input', function(e) {
            e.target.value = e.target.value.toUpperCase();
        });

        // Handle brand selection
        document.getElementById('brand').addEventListener('change', function(e) {
            const customInput = document.getElementById('brand_custom');
            if (e.target.value === 'other') {
                customInput.classList.remove('hidden');
                customInput.required = true;
            } else {
                customInput.classList.add('hidden');
                customInput.required = false;
                customInput.value = '';
            }
        });

        // Handle engine capacity selection
        document.getElementById('engine_capacity').addEventListener('change', function(e) {
            const customInput = document.getElementById('engine_capacity_custom');
            if (e.target.value === 'other') {
                customInput.classList.remove('hidden');
                customInput.required = true;
            } else {
                customInput.classList.add('hidden');
                customInput.required = false;
                customInput.value = '';
            }
        });

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const brand = document.getElementById('brand').value;
            const brandCustom = document.getElementById('brand_custom').value;
            const engineCapacity = document.getElementById('engine_capacity').value;
            const engineCapacityCustom = document.getElementById('engine_capacity_custom').value;

            // Set the actual values for submission
            if (brand === 'other' && brandCustom) {
                document.getElementById('brand').value = brandCustom;
            }
            
            if (engineCapacity === 'other' && engineCapacityCustom) {
                document.getElementById('engine_capacity').value = engineCapacityCustom;
            }
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RentMotor - Sewa Motor Premium</title>
    
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
        }

        .bg-mesh {
            background-color: #f8fafc;
            background-image: 
                radial-gradient(at 0% 0%, hsla(210,100%,94%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,100%,94%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(210,100%,94%,1) 0, transparent 50%);
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        }

        .hero-gradient {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        }

        .motor-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(229, 231, 235, 0.5);
        }
        
        .motor-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            border-color: #3b82f6;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="bg-mesh min-h-screen text-gray-800">
    <!-- Navigation -->
    <nav class="glass-nav sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <a href="/" class="flex items-center space-x-2">
                        <div class="bg-blue-600 p-2 rounded-lg">
                            <i class="fas fa-motorcycle text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-black text-gray-900 tracking-tighter">RENTMOTOR</span>
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#koleksi" class="text-gray-600 hover:text-blue-600 font-medium transition">Koleksi Motor</a>
                    <a href="{{ route('about') }}" class="text-gray-600 hover:text-blue-600 font-medium transition">Tentang Kami</a>
                    <a href="{{ route('contact') }}" class="text-gray-600 hover:text-blue-600 font-medium transition">Kontak</a>
                    
                    <a href="{{ route('login') }}" class="btn-primary px-6 py-2.5 rounded-xl text-white font-bold text-sm shadow-md">
                        Login Sekarang
                    </a>
                </div>

                <div class="md:hidden flex items-center">
                    <a href="{{ route('login') }}" class="btn-primary px-5 py-2 rounded-lg text-white font-bold text-sm">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative overflow-hidden pt-16 pb-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-50 text-blue-600 text-sm font-bold mb-6">
                        <span class="flex h-2 w-2 rounded-full bg-blue-600 mr-2"></span>
                        Solusi Rental Motor Terpercaya
                    </div>
                    <h1 class="text-5xl md:text-6xl font-black text-gray-900 leading-tight mb-6">
                        Sewa Motor Impian <br>
                        <span class="text-blue-600">Lebih Mudah & Cepat.</span>
                    </h1>
                    <p class="text-lg text-gray-600 mb-10 max-w-lg">
                        Pilih dari ratusan motor tersedia dengan kondisi terbaik. Mulai perjalanan Anda hari ini dengan sistem penyewaan paling modern.
                    </p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="#koleksi" class="btn-primary px-8 py-4 rounded-2xl text-white font-bold text-lg text-center flex items-center justify-center">
                            Cari Motor <i class="fas fa-search ml-2"></i>
                        </a>
                        <a href="{{ route('login.owner') }}" class="bg-white border-2 border-gray-100 px-8 py-4 rounded-2xl text-gray-700 font-bold text-lg text-center hover:bg-gray-50 transition">
                            Jadi Partner
                        </a>
                    </div>
                    
                    <div class="mt-12 grid grid-cols-3 gap-6">
                        <div>
                            <p class="text-3xl font-black text-gray-900">500+</p>
                            <p class="text-sm text-gray-500">Motor Tersedia</p>
                        </div>
                        <div>
                            <p class="text-3xl font-black text-gray-900">10k+</p>
                            <p class="text-sm text-gray-500">Penyewa Puas</p>
                        </div>
                        <div>
                            <p class="text-3xl font-black text-gray-900">4.9/5</p>
                            <p class="text-sm text-gray-500">Rating Google</p>
                        </div>
                    </div>
                </div>
                
                <div class="relative hidden lg:block">
                    <div class="absolute -top-4 -right-4 w-64 h-64 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse"></div>
                    <div class="absolute -bottom-4 -left-4 w-64 h-64 bg-indigo-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-pulse"></div>
                    
                    <div class="relative bg-white p-6 rounded-3xl shadow-2xl skew-y-1 animate-float">
                        <img src="https://images.unsplash.com/photo-1558981403-c5f91cbba527?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Motor Premium" class="rounded-2xl shadow-lg mb-6 w-full h-80 object-cover">
                        <div class="flex justify-between items-center">
                            <div>
                                <h4 class="font-bold text-xl">Premium Cruiser</h4>
                                <p class="text-gray-500">Mulai dari Rp 150.000/hari</p>
                            </div>
                            <span class="bg-green-100 text-green-700 font-bold px-3 py-1 rounded-full text-xs">TERSEDIA LUXURY</span>
                        </div>
                    </div>
                    

                </div>
            </div>
        </div>
    </header>

    <!-- Content / Motor List -->
    <main id="koleksi" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12">
            <div>
                <h2 class="text-4xl font-black text-gray-900 mb-4 tracking-tight">Koleksi Motor Terbaru</h2>
                <p class="text-gray-500 max-w-xl">Pilih motor yang sesuai dengan gaya dan kebutuhan perjalanan Anda. Semua unit dalam kondisi prima dan siap tempur.</p>
            </div>
            <a href="{{ route('login') }}" class="text-blue-600 font-bold mt-4 md:mt-0 hover:underline">
                Lihat Semua Koleksi <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>

        <!-- Filter Placeholder -->
        <div class="flex overflow-x-auto pb-4 mb-8 space-x-3 no-scrollbar">
            <button class="bg-blue-600 text-white px-6 py-2 rounded-full font-bold shadow-md whitespace-nowrap">Semua Tipe</button>
            <button class="bg-white text-gray-600 px-6 py-2 rounded-full font-bold border border-gray-100 hover:bg-white transition whitespace-nowrap">Scooter</button>
            <button class="bg-white text-gray-600 px-6 py-2 rounded-full font-bold border border-gray-100 hover:bg-white transition whitespace-nowrap">Sport</button>
            <button class="bg-white text-gray-600 px-6 py-2 rounded-full font-bold border border-gray-100 hover:bg-white transition whitespace-nowrap">Manual</button>
            <button class="bg-white text-gray-600 px-6 py-2 rounded-full font-bold border border-gray-100 hover:bg-white transition whitespace-nowrap">Luxury</button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($availableMotors as $motor)
                <div class="motor-card bg-white rounded-3xl overflow-hidden flex flex-col">
                    <div class="relative h-64 bg-gray-100">
                        @if($motor->photo)
                            <img src="{{ asset('storage/' . $motor->photo) }}" alt="{{ $motor->brand }} {{ $motor->type }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <i class="fas fa-motorcycle text-6xl"></i>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="bg-white bg-opacity-90 backdrop-filter blur-sm text-gray-900 font-bold px-3 py-1 rounded-full text-xs shadow-sm">
                                <i class="fas fa-star text-yellow-400 mr-1"></i> Baru
                            </span>
                        </div>
                        <div class="absolute bottom-4 right-4">
                            <span class="bg-blue-600 text-white font-bold px-3 py-1 rounded-full text-xs shadow-lg">
                                Rp {{ number_format($motor->rental_price, 0, ',', '.') }}/hari
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-8 flex-1 flex flex-col">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-2xl font-black text-gray-900">{{ $motor->brand }} {{ $motor->type }}</h3>
                                <p class="text-gray-500 text-sm">{{ $motor->year }} • {{ $motor->color }}</p>
                            </div>
                        </div>
                        
                        <p class="text-gray-600 text-sm mb-6 flex-1 italic">
                            {{ Str::limit($motor->description, 100) }}
                        </p>
                        
                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="bg-gray-50 p-3 rounded-2xl flex items-center space-x-3">
                                <i class="fas fa-gas-pump text-blue-500"></i>
                                <span class="text-xs font-bold text-gray-600">Hemat BBM</span>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-2xl flex items-center space-x-3">
                                <i class="fas fa-tools text-blue-500"></i>
                                <span class="text-xs font-bold text-gray-600">Service Rutin</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('login') }}" class="btn-primary w-full py-4 rounded-2xl text-white font-bold text-center">
                            Sewa Sekarang
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center">
                    <div class="bg-blue-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-blue-600">
                        <i class="fas fa-motorcycle text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum ada motor tersedia</h3>
                    <p class="text-gray-500">Silahkan kembali lagi nanti atau hubungi admin kami.</p>
                </div>
            @endforelse
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white py-20 border-t border-gray-100 shadow-2xl skew-y-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="col-span-1 md:col-span-2">
                    <a href="/" class="flex items-center space-x-2 mb-6">
                        <div class="bg-blue-600 p-2 rounded-lg">
                            <i class="fas fa-motorcycle text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-black text-gray-900 tracking-tighter">RENTMOTOR</span>
                    </a>
                    <p class="text-gray-500 mb-8 max-w-sm">
                        RentMotor adalah platform penyewaan motor terbaik di Indonesia yang menghubungkan pemilik motor dan penyewa dengan aman dan mudah.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h4 class="font-black text-gray-900 mb-6 uppercase tracking-wider text-sm">Navigasi</h4>
                    <ul class="space-y-4">
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Beranda</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Koleksi Motor</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Daftar Jadi Owner</a></li>
                        <li><a href="#" class="text-gray-600 hover:text-blue-600 transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="font-black text-gray-900 mb-6 uppercase tracking-wider text-sm">Hubungi Kami</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-map-marker-alt text-blue-600 mt-1"></i>
                            <span class="text-gray-600 text-sm">Jl. Raya Rental No. 123, Jakarta Selatan</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fas fa-phone text-blue-600"></i>
                            <span class="text-gray-600 text-sm">+62 821 1234 5678</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-blue-600"></i>
                            <span class="text-gray-600 text-sm">support@rentmotor.id</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="mt-20 pt-10 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0 text-sm text-gray-500">
                <p>&copy; 2026 RentMotor. Seluruh hak cipta dilindungi undang-undang.</p>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-blue-600">Kebijakan Privasi</a>
                    <a href="#" class="hover:text-blue-600">Ketentuan Layanan</a>
                    <a href="#" class="hover:text-blue-600">Bantuan</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>

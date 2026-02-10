<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Portal Akses') }} - RentMotor</title>
    
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background-color: #f8fafc;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #3b5bdb 0%, #2b46b9 100%);
            border-bottom: 5px solid rgba(255, 255, 255, 0.1);
        }

        .login-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(229, 231, 235, 0.5);
            background: white;
            border-radius: 24px;
        }

        .login-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(59, 91, 219, 0.15);
        }

        .motor-card {
            transition: all 0.3s ease;
            border-radius: 20px;
            overflow: hidden;
            background: white;
            border: 1px solid #f1f5f9;
        }

        .motor-card:hover {
            transform: scale(1.02);
            box-shadow: 0 15px 30px -10px rgba(0, 0, 0, 0.1);
        }

        .btn-renter { background-color: #3b5bdb; }
        .btn-owner { background-color: #4f46e5; }

        .stat-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }

        .floating { animation: float 6s ease-in-out infinite; }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top Nav Simulation -->
    <nav class="bg-white border-b border-gray-100 py-4 px-8 flex justify-between items-center sticky top-0 z-50">
        <div class="flex items-center space-x-2">
            <div class="bg-blue-600 p-2 rounded-lg">
                <i class="fas fa-motorcycle text-white text-lg"></i>
            </div>
            <span class="text-xl font-black text-gray-900 tracking-tighter">RENTMOTOR</span>
        </div>
        <div class="flex space-x-4">
            <a href="{{ route('login.renter') }}" class="text-sm font-bold text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-xl transition">Masuk Penyewa</a>
            <a href="{{ route('login.owner') }}" class="text-sm font-bold text-indigo-600 border border-indigo-100 px-4 py-2 rounded-xl hover:bg-indigo-50 transition">Masuk Pemilik</a>
        </div>
    </nav>

    <!-- Header Section -->
    <header class="dashboard-header py-16 px-8 relative overflow-hidden">
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 leading-tight">
                        Portal Layanan <br><span class="opacity-80">Sewa Motor Terpadu</span>
                    </h1>
                    <p class="text-blue-100 text-lg mb-8 opacity-90 max-w-md">
                        Pilih jenis akun Anda untuk mulai menjelajahi ribuan motor berkualitas atau mulai hasilkan pendapatan dari armada Anda.
                    </p>
                    
                    <div class="flex flex-wrap gap-4">
                        <div class="bg-white bg-opacity-10 backdrop-filter blur-sm rounded-2xl p-4 flex items-center space-x-3 text-white">
                            <i class="fas fa-check-circle text-blue-300"></i>
                            <span class="text-sm font-bold">500+ Unit Tersedia</span>
                        </div>
                        <div class="bg-white bg-opacity-10 backdrop-filter blur-sm rounded-2xl p-4 flex items-center space-x-3 text-white">
                            <i class="fas fa-shield-check text-blue-300"></i>
                            <span class="text-sm font-bold">Terverifikasi & Aman</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <a href="{{ route('login.owner') }}" class="login-card p-8 flex flex-col items-center text-center group">
                        <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center mb-6 text-indigo-600 transition-transform group-hover:scale-110">
                            <i class="fas fa-building text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-extrabold text-gray-900 mb-2">Pemilik Motor</h3>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-widest mb-6">Owner Access</p>
                        <span class="w-full py-3 rounded-xl bg-indigo-600 text-white font-bold text-sm shadow-lg shadow-indigo-200">
                            Masuk Dashboard
                        </span>
                    </a>

                    <a href="{{ route('login.renter') }}" class="login-card p-8 flex flex-col items-center text-center group">
                        <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mb-6 text-blue-600 transition-transform group-hover:scale-110">
                            <i class="fas fa-user-tag text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-extrabold text-gray-900 mb-2">Penyewa Motor</h3>
                        <p class="text-xs text-gray-400 font-medium uppercase tracking-widest mb-6">Renter Access</p>
                        <span class="w-full py-3 rounded-xl bg-blue-600 text-white font-bold text-sm shadow-lg shadow-blue-200">
                            Pesan Sekarang
                        </span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Abstract Shapes -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-white opacity-5 rounded-full -mr-48 -mt-48"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white opacity-5 rounded-full -ml-32 -mb-32"></div>
    </header>

    <!-- Content Area (Dashboard Simulation) -->
    <main class="max-w-7xl mx-auto px-8 py-16">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12">
            <div>
                <h2 class="text-3xl font-black text-gray-900 mb-2">Katalog Motor Unggulan</h2>
                <div class="flex items-center text-gray-400 text-sm font-bold">
                    <span class="stat-dot bg-green-500"></span> Live Monitoring • Update Real-time
                </div>
            </div>
            <p class="text-gray-400 text-sm max-w-xs mt-4 md:mt-0 text-right">
                Unit terbaru yang baru saja didaftarkan oleh mitra pemilik kami di seluruh kota.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($availableMotors as $motor)
                <div class="motor-card group">
                    <div class="relative h-56 bg-gray-200">
                        @if($motor->photo)
                            <img src="{{ asset('storage/' . $motor->photo) }}" alt="{{ $motor->brand }} {{ $motor->type }}" class="w-full h-full object-cover grayscale-[0.2] group-hover:grayscale-0 transition-all duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-100">
                                <i class="fas fa-motorcycle text-5xl"></i>
                            </div>
                        @endif
                        <div class="absolute bottom-4 left-4">
                            <span class="bg-white font-bold px-3 py-1 rounded-lg text-xs shadow-md text-gray-900 ring-1 ring-black ring-opacity-5">
                                {{ $motor->year }}
                            </span>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="bg-blue-600 text-white font-black px-4 py-2 rounded-xl text-sm shadow-xl">
                                Rp {{ number_format($motor->rental_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition">{{ $motor->brand }} {{ $motor->type }}</h3>
                                <div class="flex items-center mt-1">
                                    <i class="fas fa-map-marker-alt text-[10px] text-gray-400 mr-1"></i>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">Lokasi Terdekat</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4 mb-6 pt-4 border-t border-gray-50">
                            <div class="flex flex-col">
                                <span class="text-[9px] font-bold text-gray-400 uppercase">Warna</span>
                                <span class="text-xs font-bold text-gray-700">{{ $motor->color }}</span>
                            </div>
                            <div class="w-px h-6 bg-gray-100"></div>
                            <div class="flex flex-col">
                                <span class="text-[9px] font-bold text-gray-400 uppercase">Plat</span>
                                <span class="text-xs font-bold text-gray-700">{{ strtoupper($motor->license_plate) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('login.renter') }}" class="w-full block py-3 rounded-xl border-2 border-gray-50 text-center text-sm font-bold text-gray-600 hover:bg-blue-600 hover:border-blue-600 hover:text-white transition">
                            Detail Selengkapnya
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Footer Simulation -->
        <div class="mt-24 pt-12 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center bg-white rounded-3xl p-12 shadow-sm">
            <div>
                <h4 class="text-xl font-black text-gray-900 mb-1">Butuh Bantuan Akses?</h4>
                <p class="text-gray-400 text-sm">Hubungi tim support kami jika Anda mengalami kesulitan masuk.</p>
            </div>
            <div class="flex space-x-4 mt-6 md:mt-0">
                <a href="{{ route('register') }}" class="bg-gray-900 text-white px-8 py-3 rounded-2xl font-bold text-sm hover:bg-gray-800 transition shadow-xl">Daftar Akun Baru</a>
            </div>
        </div>
    </main>

    <footer class="py-12 text-center text-gray-400 text-xs font-bold uppercase tracking-[4px] opacity-40">
        © {{ date('Y') }} RENTMOTOR PORTAL GATEWAY
    </footer>
</body>
</html>
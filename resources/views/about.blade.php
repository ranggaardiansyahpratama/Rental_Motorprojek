<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tentang Kami - RentMotor</title>
    
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

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        }

        .feature-card {
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
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
                    <a href="/" class="text-gray-600 hover:text-blue-600 font-medium transition">Beranda</a>
                    <a href="/#koleksi" class="text-gray-600 hover:text-blue-600 font-medium transition">Koleksi Motor</a>
                    <a href="{{ route('about') }}" class="text-blue-600 font-bold transition">Tentang Kami</a>
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
    <section class="relative overflow-hidden py-20 bg-gradient-to-br from-blue-600 to-indigo-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-5xl md:text-6xl font-black text-white mb-6">Tentang RentMotor</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                Platform penyewaan motor terpercaya yang menghubungkan pemilik motor dengan penyewa di seluruh Indonesia
            </p>
        </div>
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <div class="absolute w-96 h-96 bg-white rounded-full -top-20 -left-20"></div>
            <div class="absolute w-96 h-96 bg-white rounded-full -bottom-20 -right-20"></div>
        </div>
    </section>

    <!-- Mission Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="text-4xl font-black text-gray-900 mb-6">Misi Kami</h2>
                    <p class="text-lg text-gray-600 mb-6">
                        RentMotor hadir untuk memberikan solusi penyewaan motor yang aman, nyaman, dan terpercaya. Kami berkomitmen untuk:
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-600 text-xl mr-3 mt-1"></i>
                            <span class="text-gray-700">Menyediakan motor berkualitas dengan harga terjangkau</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-600 text-xl mr-3 mt-1"></i>
                            <span class="text-gray-700">Memberikan pelayanan terbaik kepada setiap pengguna</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-600 text-xl mr-3 mt-1"></i>
                            <span class="text-gray-700">Membantu pemilik motor mengoptimalkan aset mereka</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-blue-600 text-xl mr-3 mt-1"></i>
                            <span class="text-gray-700">Menciptakan ekosistem sharing economy yang berkelanjutan</span>
                        </li>
                    </ul>
                </div>
                <div class="bg-white p-8 rounded-3xl shadow-xl">
                    <img src="https://images.unsplash.com/photo-1449426468159-d96dbf08f19f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Team" class="rounded-2xl w-full h-96 object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-black text-gray-900 mb-4">Nilai-Nilai Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Nilai-nilai yang menjadi landasan kami dalam memberikan layanan terbaik
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="feature-card bg-gradient-to-br from-blue-50 to-indigo-50 p-8 rounded-3xl">
                    <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Kepercayaan</h3>
                    <p class="text-gray-600">
                        Kami membangun kepercayaan melalui transparansi, keamanan, dan layanan yang konsisten
                    </p>
                </div>

                <div class="feature-card bg-gradient-to-br from-green-50 to-emerald-50 p-8 rounded-3xl">
                    <div class="w-16 h-16 bg-green-600 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Komunitas</h3>
                    <p class="text-gray-600">
                        Membangun komunitas yang saling mendukung antara pemilik dan penyewa motor
                    </p>
                </div>

                <div class="feature-card bg-gradient-to-br from-purple-50 to-pink-50 p-8 rounded-3xl">
                    <div class="w-16 h-16 bg-purple-600 rounded-2xl flex items-center justify-center mb-6">
                        <i class="fas fa-lightbulb text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Inovasi</h3>
                    <p class="text-gray-600">
                        Terus berinovasi untuk memberikan pengalaman penyewaan yang lebih baik
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-12 text-white">
                <h2 class="text-4xl font-black text-center mb-12">Pencapaian Kami</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 text-center">
                    <div>
                        <p class="text-5xl font-black mb-2">500+</p>
                        <p class="text-blue-100">Motor Terdaftar</p>
                    </div>
                    <div>
                        <p class="text-5xl font-black mb-2">10K+</p>
                        <p class="text-blue-100">Penyewa Aktif</p>
                    </div>
                    <div>
                        <p class="text-5xl font-black mb-2">50+</p>
                        <p class="text-blue-100">Kota Tersedia</p>
                    </div>
                    <div>
                        <p class="text-5xl font-black mb-2">4.9/5</p>
                        <p class="text-blue-100">Rating Pengguna</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-black text-gray-900 mb-6">Siap Bergabung?</h2>
            <p class="text-lg text-gray-600 mb-8">
                Mulai perjalanan Anda bersama RentMotor hari ini
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="btn-primary px-8 py-4 rounded-2xl text-white font-bold text-lg">
                    Daftar Sekarang
                </a>
                <a href="{{ route('contact') }}" class="bg-white border-2 border-gray-200 px-8 py-4 rounded-2xl text-gray-700 font-bold text-lg hover:bg-gray-50 transition">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex items-center justify-center space-x-2 mb-4">
                <div class="bg-blue-600 p-2 rounded-lg">
                    <i class="fas fa-motorcycle text-white text-xl"></i>
                </div>
                <span class="text-2xl font-black tracking-tighter">RENTMOTOR</span>
            </div>
            <p class="text-gray-400 mb-6">Platform penyewaan motor terpercaya di Indonesia</p>
            <div class="flex justify-center space-x-6">
                <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-twitter"></i></a>
            </div>
            <p class="text-gray-500 text-sm mt-8">&copy; 2026 RentMotor. Seluruh hak cipta dilindungi undang-undang.</p>
        </div>
    </footer>
</body>
</html>

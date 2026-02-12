<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kontak Kami - RentMotor</title>
    
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

        .contact-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .contact-card:hover {
            border-color: #3b82f6;
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .input-field {
            width: 100%;
            padding: 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 1rem;
            transition: all 0.3s ease;
            outline: none;
        }

        .input-field:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
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
                    <a href="{{ route('about') }}" class="text-gray-600 hover:text-blue-600 font-medium transition">Tentang Kami</a>
                    <a href="{{ route('contact') }}" class="text-blue-600 font-bold transition">Kontak</a>
                    
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
            <h1 class="text-5xl md:text-6xl font-black text-white mb-6">Hubungi Kami</h1>
            <p class="text-xl text-blue-100 max-w-3xl mx-auto">
                Ada pertanyaan? Tim kami siap membantu Anda 24/7
            </p>
        </div>
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <div class="absolute w-96 h-96 bg-white rounded-full -top-20 -left-20"></div>
            <div class="absolute w-96 h-96 bg-white rounded-full -bottom-20 -right-20"></div>
        </div>
    </section>

    <!-- Contact Info Cards -->
    <section class="py-20 -mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20">
                <div class="contact-card bg-white p-8 rounded-3xl shadow-lg text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-map-marker-alt text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Alamat Kantor</h3>
                    <p class="text-gray-600">
                        Jl. Raya Rental No. 123<br>
                        Jakarta Selatan, DKI Jakarta<br>
                        12345
                    </p>
                </div>

                <div class="contact-card bg-white p-8 rounded-3xl shadow-lg text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-phone text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Telepon</h3>
                    <p class="text-gray-600">
                        <a href="tel:+6282112345678" class="hover:text-blue-600">+62 821 1234 5678</a><br>
                        <a href="tel:+6282187654321" class="hover:text-blue-600">+62 821 8765 4321</a><br>
                        <span class="text-sm text-gray-500">Senin - Minggu (24 Jam)</span>
                    </p>
                </div>

                <div class="contact-card bg-white p-8 rounded-3xl shadow-lg text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-envelope text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Email</h3>
                    <p class="text-gray-600">
                        <a href="mailto:support@rentmotor.id" class="hover:text-blue-600">support@rentmotor.id</a><br>
                        <a href="mailto:info@rentmotor.id" class="hover:text-blue-600">info@rentmotor.id</a><br>
                        <span class="text-sm text-gray-500">Respon dalam 1-2 jam</span>
                    </p>
                </div>
            </div>

            <!-- Contact Form & Map -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Contact Form -->
                <div class="bg-white p-10 rounded-3xl shadow-xl">
                    <h2 class="text-3xl font-black text-gray-900 mb-2">Kirim Pesan</h2>
                    <p class="text-gray-600 mb-8">Isi form di bawah ini dan kami akan segera menghubungi Anda</p>
                    
                    @if(session('success'))
                        <div class="bg-green-50 border-2 border-green-200 text-green-800 px-6 py-4 rounded-2xl mb-6">
                            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}" class="space-y-6">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" id="name" name="name" required 
                                   class="input-field" placeholder="Masukkan nama lengkap Anda">
                            @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                            <input type="email" id="email" name="email" required 
                                   class="input-field" placeholder="nama@email.com">
                            @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-bold text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="tel" id="phone" name="phone" required 
                                   class="input-field" placeholder="+62 xxx xxxx xxxx">
                            @error('phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-bold text-gray-700 mb-2">Subjek</label>
                            <input type="text" id="subject" name="subject" required 
                                   class="input-field" placeholder="Subjek pesan Anda">
                            @error('subject') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-bold text-gray-700 mb-2">Pesan</label>
                            <textarea id="message" name="message" rows="5" required 
                                      class="input-field" placeholder="Tulis pesan Anda di sini..."></textarea>
                            @error('message') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit" class="btn-primary w-full py-4 rounded-2xl text-white font-bold text-lg">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim Pesan
                        </button>
                    </form>
                </div>

                <!-- Map & Social Media -->
                <div class="space-y-8">
                    <!-- Map -->
                    <div class="bg-white p-6 rounded-3xl shadow-xl overflow-hidden">
                        <h3 class="text-2xl font-black text-gray-900 mb-6">Lokasi Kami</h3>
                        <div class="w-full h-96 bg-gray-200 rounded-2xl overflow-hidden">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.2649425279357!2d106.8229675!3d-6.2294147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5371bf0fdad786a2!2sJakarta!5e0!3m2!1sid!2sid!4v1234567890"
                                width="100%" 
                                height="100%" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy">
                            </iframe>
                        </div>
                    </div>

                    <!-- Social Media -->
                    <div class="bg-white p-8 rounded-3xl shadow-xl">
                        <h3 class="text-2xl font-black text-gray-900 mb-6">Ikuti Kami</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="#" class="flex items-center space-x-3 p-4 bg-blue-50 rounded-2xl hover:bg-blue-100 transition">
                                <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center">
                                    <i class="fab fa-facebook-f text-white text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">Facebook</p>
                                    <p class="text-sm text-gray-500">@rentmotor</p>
                                </div>
                            </a>

                            <a href="#" class="flex items-center space-x-3 p-4 bg-pink-50 rounded-2xl hover:bg-pink-100 transition">
                                <div class="w-12 h-12 bg-pink-600 rounded-xl flex items-center justify-center">
                                    <i class="fab fa-instagram text-white text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">Instagram</p>
                                    <p class="text-sm text-gray-500">@rentmotor</p>
                                </div>
                            </a>

                            <a href="#" class="flex items-center space-x-3 p-4 bg-blue-50 rounded-2xl hover:bg-blue-100 transition">
                                <div class="w-12 h-12 bg-blue-400 rounded-xl flex items-center justify-center">
                                    <i class="fab fa-twitter text-white text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">Twitter</p>
                                    <p class="text-sm text-gray-500">@rentmotor</p>
                                </div>
                            </a>

                            <a href="#" class="flex items-center space-x-3 p-4 bg-green-50 rounded-2xl hover:bg-green-100 transition">
                                <div class="w-12 h-12 bg-green-600 rounded-xl flex items-center justify-center">
                                    <i class="fab fa-whatsapp text-white text-xl"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">WhatsApp</p>
                                    <p class="text-sm text-gray-500">+62 821 1234</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-black text-gray-900 mb-4">Pertanyaan Umum</h2>
                <p class="text-gray-600">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
            </div>

            <div class="space-y-4">
                <details class="bg-gray-50 p-6 rounded-2xl">
                    <summary class="font-bold text-gray-900 cursor-pointer">Bagaimana cara menyewa motor?</summary>
                    <p class="mt-4 text-gray-600">Anda dapat mendaftar terlebih dahulu, kemudian pilih motor yang tersedia, tentukan durasi sewa, dan lakukan pembayaran. Motor siap digunakan!</p>
                </details>

                <details class="bg-gray-50 p-6 rounded-2xl">
                    <summary class="font-bold text-gray-900 cursor-pointer">Apakah ada jaminan keamanan?</summary>
                    <p class="mt-4 text-gray-600">Ya, semua transaksi dilindungi dan motor diasuransikan. Kami juga melakukan verifikasi untuk semua pengguna.</p>
                </details>

                <details class="bg-gray-50 p-6 rounded-2xl">
                    <summary class="font-bold text-gray-900 cursor-pointer">Bagaimana cara menjadi pemilik motor di platform ini?</summary>
                    <p class="mt-4 text-gray-600">Daftar sebagai Owner, upload informasi motor Anda, tunggu verifikasi admin, dan mulai terima penghasilan pasif!</p>
                </details>

                <details class="bg-gray-50 p-6 rounded-2xl">
                    <summary class="font-bold text-gray-900 cursor-pointer">Metode pembayaran apa saja yang tersedia?</summary>
                    <p class="mt-4 text-gray-600">Kami menerima transfer bank, e-wallet, dan berbagai metode pembayaran digital lainnya.</p>
                </details>
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

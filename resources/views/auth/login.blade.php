    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="csrf-token" content="{{ csrf_token() }}">

            <title>{{ __('Login Selection') }} - RentMotor</title>

            <!-- Fonts -->
            <link rel="preconnect" href="https://fonts.bunny.net">
            <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            <!-- Font Awesome for icons -->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

            <!-- Scripts -->
            <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
            
            <style>
                .selection-card {
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                    border: 1px solid rgba(229, 231, 235, 0.5);
                }
                .selection-card:hover {
                    transform: translateY(-8px);
                    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                    border-color: #3b82f6;
                }
                .icon-box {
                    transition: all 0.3s ease;
                }
                .selection-card:hover .icon-box {
                    transform: scale(1.1) rotate(5deg);
                }
                .bg-mesh {
                    background-color: #f8fafc;
                    background-image: 
                        radial-gradient(at 0% 0%, hsla(210,100%,94%,1) 0, transparent 50%), 
                        radial-gradient(at 50% 0%, hsla(225,100%,94%,1) 0, transparent 50%), 
                        radial-gradient(at 100% 0%, hsla(210,100%,94%,1) 0, transparent 50%);
                }
            </style>
        </head>
        <body class="bg-mesh min-h-screen flex flex-col items-center justify-center p-6 text-gray-800">
            <div class="max-w-4xl w-full">
                <!-- Header -->
                <div class="text-center mb-12">
                    <div class="inline-flex items-center text-4xl font-black text-blue-600 mb-4 tracking-tighter">
                        <i class="fas fa-motorcycle mr-3"></i>
                        RENTMOTOR
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang Kembali</h1>
                    <p class="text-gray-600">Silahkan pilih tipe akun anda untuk melanjutkan ke sistem</p>
                </div>

                <!-- Selection Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">


                    <!-- Owner Selection -->
                    <a href="{{ route('login.owner') }}" class="selection-card bg-white p-8 rounded-2xl flex flex-col items-center text-center">
                        <div class="icon-box w-20 h-20 bg-indigo-50 rounded-2xl flex items-center justify-center mb-6 text-indigo-600">
                            <i class="fas fa-building text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Pemilik Motor</h3>
                        <p class="text-gray-500 text-sm mb-6">Daftarkan motor anda dan pantau pendapatan harian.</p>
                        <span class="mt-auto inline-flex items-center text-indigo-600 font-semibold group">
                            Masuk Dashboard <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                        </span>
                    </a>

                    <!-- Renter Selection -->
                    <a href="{{ route('login.renter') }}" class="selection-card bg-white p-8 rounded-2xl flex flex-col items-center text-center">
                        <div class="icon-box w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center mb-6 text-blue-600">
                            <i class="fas fa-user text-3xl"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Penyewa Motor</h3>
                        <p class="text-gray-500 text-sm mb-6">Cari motor impian dan lakukan penyewaan dengan mudah.</p>
                        <span class="mt-auto inline-flex items-center text-blue-600 font-semibold group">
                            Pesan Sekarang <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                        </span>
                    </a>
                </div>

                <!-- Footer Info -->
                <div class="mt-16 text-center">
                    <p class="text-gray-500 text-sm underline underline-offset-4 decoration-blue-200">
                        Belum punya akun? <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:text-blue-800">Daftar sebagai Pemilik/Penyewa</a>
                    </p>
                    <div class="mt-8 flex justify-center space-x-6 text-xs text-gray-400">
                        <a href="#" class="hover:text-gray-600">Syarat & Ketentuan</a>
                        <span>•</span>
                        <a href="#" class="hover:text-gray-600">Kebijakan Privasi</a>
                        <span>•</span>
                        <a href="#" class="hover:text-gray-600">Bantuan</a>
                    </div>
                </div>
            </div>
        </body>
    </html>
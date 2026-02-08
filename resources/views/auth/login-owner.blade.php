<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login Pemilik - RentMotor</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <!-- Font Awesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        
        <style>
            .btn-owner {
                background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
                box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
                transition: all 0.3s ease;
            }
            .btn-owner:hover {
                background: linear-gradient(135deg, #4338ca 0%, #312e81 100%);
                transform: translateY(-1px);
            }
            .card {
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
                border-radius: 12px;
            }
            .logo-float {
                animation: float 3s ease-in-out infinite;
            }
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-5px); }
                100% { transform: translateY(0px); }
            }
        </style>
    </head>
    <body class="bg-indigo-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Logo -->
            <div class="mb-8 text-center">
                <div class="inline-flex items-center text-4xl font-bold text-indigo-600 dark:text-indigo-400 mb-2 logo-float">
                    <i class="fas fa-building mr-3"></i>
                    Partner Area
                </div>
                <p class="text-gray-600 dark:text-gray-400">Kelola Motor & Pendapatan Anda</p>
            </div>

            <!-- Login Card -->
            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white dark:bg-gray-800 card overflow-hidden">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Login Pemilik</h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Masuk ke dashboard mitra</p>
                </div>

                @if (session('status'))
                    <div class="mb-4 p-3 rounded-md bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="intended_role" value="owner">

                    <div class="mb-4">
                        <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring focus:ring-indigo-200 dark:bg-gray-700 dark:text-white">
                        @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Password</label>
                        <input id="password" type="password" name="password" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring focus:ring-indigo-200 dark:bg-gray-700 dark:text-white">
                        @error('password') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <button type="submit" class="btn-owner w-full py-3 px-4 rounded-lg font-semibold text-white uppercase tracking-wider">
                            <i class="fas fa-sign-in-alt mr-2"></i> Masuk Dashboard
                        </button>
                    </div>

                    <div class="text-center pt-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Belum menjadi mitra?</p>
                        <a href="{{ route('register') }}" class="text-indigo-600 dark:text-indigo-400 font-bold hover:underline">
                            Daftar sebagai Pemilik Motor
                        </a>
                    </div>
                </form>
            </div>
            
            <div class="mt-4 text-center">
                <a href="{{ url('/') }}" class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
                </a>
            </div>
        </div>
    </body>
</html>

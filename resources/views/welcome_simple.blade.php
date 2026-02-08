<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel Authentication</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Scripts -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="bg-gray-50 dark:bg-gray-900">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Logo -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-[#f53003] dark:text-[#FF4433]">
                    Laravel
                </h1>
                <p class="text-center text-gray-600 dark:text-gray-400 mt-2">
                    Sistem Autentikasi
                </p>
            </div>

            @guest
                <!-- Authentication Card for Guests -->
                <div class="w-full sm:max-w-md px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Selamat Datang</h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Pilih opsi di bawah untuk melanjutkan
                        </p>
                    </div>

                    <div class="space-y-4">
                        <!-- Login Button -->
                        <a href="{{ route('login') }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-[#f53003] dark:bg-[#FF4433] border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-wider hover:bg-[#e02800] dark:hover:bg-[#FF3322] focus:bg-[#e02800] dark:focus:bg-[#FF3322] active:bg-[#d02500] dark:active:bg-[#FF2211] focus:outline-none focus:ring-2 focus:ring-[#f53003] focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Masuk (Login)
                        </a>

                        <!-- Register Button -->
                        <a href="{{ route('register') }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-white dark:bg-gray-700 border-2 border-[#f53003] dark:border-[#FF4433] rounded-md font-semibold text-base text-[#f53003] dark:text-[#FF4433] uppercase tracking-wider hover:bg-[#f53003] hover:text-white dark:hover:bg-[#FF4433] dark:hover:text-white focus:bg-[#f53003] focus:text-white dark:focus:bg-[#FF4433] dark:focus:text-white active:bg-[#e02800] dark:active:bg-[#FF3322] focus:outline-none focus:ring-2 focus:ring-[#f53003] focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Daftar (Register)
                        </a>
                    </div>
                </div>
            @else
                <!-- Dashboard Access for Authenticated Users -->
                <div class="w-full sm:max-w-md px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
                            Halo, {{ Auth::user()->name }}!
                        </h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Anda sudah berhasil login
                        </p>
                    </div>

                    <div class="space-y-4">
                        <!-- Dashboard Button -->
                        <a href="{{ route(Auth::user()->role . '.dashboard') }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-[#f53003] dark:bg-[#FF4433] border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-wider hover:bg-[#e02800] dark:hover:bg-[#FF3322] focus:bg-[#e02800] dark:focus:bg-[#FF3322] active:bg-[#d02500] dark:active:bg-[#FF2211] focus:outline-none focus:ring-2 focus:ring-[#f53003] focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            Dashboard
                        </a>

                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center justify-center px-4 py-3 bg-gray-600 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-wider hover:bg-gray-700 dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endguest

            <!-- Footer Information -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Laravel {{ app()->version() }} - {{ php_sapi_name() }} {{ phpversion() }}
                </p>
            </div>
        </div>
    </body>
</html>
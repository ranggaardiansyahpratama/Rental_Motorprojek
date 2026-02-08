<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login Pemilik - RentMotor</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
        <!-- Font Awesome for icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
            }

            .btn-login {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
                transition: all 0.3s ease;
            }
            
            .btn-login:hover {
                background: linear-gradient(135deg, #5568d3 0%, #6a4291 100%);
                transform: translateY(-2px);
                box-shadow: 0 15px 30px rgba(102, 126, 234, 0.4);
            }
            
            .card {
                background: white;
                box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
                border-radius: 20px;
                backdrop-filter: blur(10px);
            }
            
            .logo-container {
                animation: float 3s ease-in-out infinite;
            }
            
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }

            .input-field {
                transition: all 0.3s ease;
                border: 2px solid #e5e7eb;
            }
            
            .input-field:focus {
                border-color: #667eea;
                box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
                outline: none;
            }

            .icon-wrapper {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                width: 80px;
                height: 80px;
                border-radius: 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2.5rem;
                box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
                margin: 0 auto 1.5rem;
            }

            .link-register {
                color: #667eea;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .link-register:hover {
                color: #5568d3;
                text-decoration: underline;
            }
        </style>
    </head>
    <body>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
            <!-- Logo -->
            <div class="mb-8 text-center logo-container">
                <div class="icon-wrapper">
                    <i class="fas fa-building"></i>
                </div>
                <h1 class="text-4xl font-bold text-white mb-2">Partner Area</h1>
                <p class="text-blue-100">Kelola Motor & Pendapatan Anda</p>
            </div>

            <!-- Login Card -->
            <div class="w-full sm:max-w-md card overflow-hidden p-8">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900">Login Pemilik Motor</h2>
                    <p class="mt-2 text-sm text-gray-600">Masuk untuk mengelola motor Anda</p>
                </div>

                @if (session('status'))
                    <div class="mb-4 p-4 rounded-lg bg-green-50 text-green-700 text-sm border border-green-200">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="intended_role" value="owner">

                    <div class="mb-5">
                        <label for="email" class="block font-medium text-sm text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-blue-600"></i>Email
                        </label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                               class="input-field w-full px-4 py-3 rounded-lg">
                        @error('email') <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password" class="block font-medium text-sm text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-blue-600"></i>Password
                        </label>
                        <input id="password" type="password" name="password" required 
                               class="input-field w-full px-4 py-3 rounded-lg">
                        @error('password') <p class="mt-2 text-sm text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <button type="submit" class="btn-login w-full py-4 px-4 rounded-lg font-semibold text-white text-lg">
                            <i class="fas fa-sign-in-alt mr-2"></i>Masuk Dashboard
                        </button>
                    </div>

                    <div class="text-center pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-3">Belum menjadi mitra?</p>
                        <a href="{{ route('register') }}" class="link-register text-base">
                            <i class="fas fa-user-plus mr-1"></i>Daftar sebagai Pemilik Motor
                        </a>
                    </div>
                </form>
            </div>
            
            <div class="mt-6 text-center">
                <a href="{{ url('/') }}" class="text-sm text-white hover:text-blue-100 transition">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </body>
</html>

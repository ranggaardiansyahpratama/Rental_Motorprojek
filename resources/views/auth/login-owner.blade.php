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
                background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1.5rem;
            }

            .auth-card {
                display: flex;
                width: 100%;
                max-width: 900px;
                background: white;
                border-radius: 2rem;
                overflow: hidden;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            }

            .left-pane {
                flex: 1;
                background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
                position: relative;
                overflow: hidden;
                display: none;
                align-items: center;
                justify-content: center;
                color: white;
                padding: 3rem;
            }

            @media (min-width: 1024px) {
                .left-pane {
                    display: flex;
                }
            }

            .left-pane::before {
                content: '';
                position: absolute;
                width: 150%;
                height: 150%;
                background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
                top: -25%;
                left: -25%;
                animation: rotate 20s linear infinite;
            }

            @keyframes rotate {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }

            .right-pane {
                flex: 1;
                background: white;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 3rem 2.5rem;
            }

            .form-container {
                width: 100%;
                max-width: 350px;
            }

            .input-group {
                margin-bottom: 1.25rem;
            }

            .input-label {
                display: block;
                font-size: 0.875rem;
                color: #6b7280;
                margin-bottom: 0.5rem;
                font-weight: 500;
            }

            .input-control {
                width: 100%;
                padding: 0.75rem 1rem;
                border: 1.5px solid #e5e7eb;
                border-radius: 0.75rem;
                transition: all 0.3s ease;
                outline: none;
                background-color: #f9fafb;
            }

            .input-control:focus {
                background-color: white;
                border-color: #6366f1;
                box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            }

            .btn-submit {
                width: 100%;
                padding: 0.85rem;
                background-color: #7c3aed;
                color: white;
                font-weight: 600;
                border-radius: 0.75rem;
                transition: all 0.3s ease;
                margin-top: 1rem;
            }

            .btn-submit:hover {
                background-color: #6d28d9;
                transform: translateY(-1px);
                box-shadow: 0 10px 15px -3px rgba(124, 58, 237, 0.4);
            }

            .welcome-text {
                font-size: 3.5rem;
                font-weight: 800;
                line-height: 1.1;
                z-index: 10;
                text-align: center;
            }

            .brand-logo {
                position: absolute;
                top: 2rem;
                left: 2rem;
                font-size: 1.25rem;
                font-weight: 700;
                display: flex;
                align-items: center;
                z-index: 20;
            }

            /* Custom Checkbox */
            .custom-checkbox {
                appearance: none;
                width: 1.15rem;
                height: 1.15rem;
                border: 2px solid #d1d5db;
                border-radius: 0.375rem;
                cursor: pointer;
                position: relative;
                transition: all 0.2s;
            }

            .custom-checkbox:checked {
                background-color: #7c3aed;
                border-color: #7c3aed;
            }

            .custom-checkbox:checked::after {
                content: '✓';
                position: absolute;
                color: white;
                font-size: 0.75rem;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
        </style>
    </head>
    <body>
        <div class="auth-card">
            <!-- Left Pane (Large Text & Gradient) -->
            <div class="left-pane">
                <div class="brand-logo">
                    <i class="fas fa-building mr-2"></i> OwnerPortal
                </div>
                <div class="welcome-text">
                    Selamat<br>Datang!
                </div>
                
                <!-- Simple Wave Shapes Mockup -->
                <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none z-0 opacity-20">
                    <svg viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block h-64 w-[200%]">
                        <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5,73.84-4.36,147.54,16.88,218.2,35.26,69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113,-1.14,1200,0.43V120H0Z" fill="#FFFFFF"></path>
                    </svg>
                </div>
            </div>

            <!-- Right Pane (Form) -->
            <div class="right-pane">
                <div class="form-container">
                    <div class="mb-8 text-center">
                        <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Masuk</h1>
                        <p class="text-gray-500 text-sm">Selamat datang kembali! Silakan masuk ke akun Anda.</p>
                    </div>

                    @if (session('status'))
                        <div class="mb-4 text-sm font-medium text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <input type="hidden" name="intended_role" value="owner">

                        <div class="input-group">
                            <label for="email" class="input-label">Email / Nama Pengguna</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                                   class="input-control" placeholder="username@gmail.com">
                            @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="input-group">
                            <label for="password" class="input-label">Kata Sandi</label>
                            <input id="password" type="password" name="password" required 
                                   class="input-control" placeholder="••••••••">
                            @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-between mb-8">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="custom-checkbox mr-2">
                                <span class="text-sm text-gray-500">Ingat Saya</span>
                            </label>
                            <span class="text-sm text-gray-400">Lupa Kata Sandi?</span>
                        </div>

                        <button type="submit" class="btn-submit">
                            Masuk
                        </button>

                        <div class="mt-8 text-center">
                            <p class="text-sm text-gray-500">
                                Pengguna Baru? <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline">Daftar</a>
                            </p>
                        </div>

                        <div class="mt-6 text-center">
                            <a href="{{ url('/') }}" class="text-xs text-gray-400 hover:text-gray-600 transition">
                                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>


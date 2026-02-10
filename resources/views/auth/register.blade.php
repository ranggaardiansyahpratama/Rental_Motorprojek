<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Daftar - Rental Motor</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Scripts -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        
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
                max-width: 450px;
            }

            .input-group {
                margin-bottom: 1rem;
            }

            .input-label {
                display: block;
                font-size: 0.875rem;
                color: #6b7280;
                margin-bottom: 0.4rem;
                font-weight: 500;
            }

            .input-control {
                width: 100%;
                padding: 0.65rem 1rem;
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

            .join-text {
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

            .role-option {
                transition: all 0.2s ease;
                border: 2px solid #e5e7eb;
                border-radius: 1rem;
            }
            
            .role-option:hover {
                border-color: #c7d2fe;
                background-color: #f9fafb;
            }
            
            .role-option.selected {
                border-color: #6366f1;
                background-color: #f5f3ff;
            }
        </style>
    </head>
    <body>
        <div class="auth-card">
            <!-- Left Pane (Large Text & Gradient) -->
            <div class="left-pane">
                <div class="brand-logo">
                    <i class="fas fa-motorcycle mr-2"></i> RentMotor
                </div>
                <div class="join-text">
                    Mari<br>Bergabung!
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
                    <div class="mb-6 text-center">
                        <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Daftar</h1>
                        <p class="text-gray-500 text-sm">Buat akun Anda untuk memulai.</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
                            <!-- Name -->
                            <div class="input-group">
                                <label for="name" class="input-label">Nama Lengkap</label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="input-control" placeholder="Nama Lengkap">
                                @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="input-group">
                                <label for="email" class="input-label">Email</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required class="input-control" placeholder="email@contoh.com">
                                @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Role Selection -->
                        <div class="input-group">
                            <label class="input-label">Saya ingin mendaftar sebagai:</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="role-option p-2 cursor-pointer flex flex-col items-center">
                                    <input type="radio" name="role" value="renter" class="hidden" {{ old('role') == 'renter' ? 'checked' : '' }} required>
                                    <span class="text-xl mb-1">🏍️</span>
                                    <span class="text-xs font-bold">Penyewa</span>
                                </label>
                                <label class="role-option p-2 cursor-pointer flex flex-col items-center">
                                    <input type="radio" name="role" value="owner" class="hidden" {{ old('role') == 'owner' ? 'checked' : '' }}>
                                    <span class="text-xl mb-1">🏢</span>
                                    <span class="text-xs font-bold">Pemilik</span>
                                </label>
                            </div>
                            @error('role') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
                            <!-- Phone -->
                            <div class="input-group">
                                <label for="phone" class="input-label">Nomor Telepon</label>
                                <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" class="input-control" placeholder="08xxxxxxxxxx">
                                @error('phone') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Address -->
                            <div class="input-group">
                                <label for="address" class="input-label">Alamat</label>
                                <input id="address" type="text" name="address" value="{{ old('address') }}" class="input-control" placeholder="Alamat Anda">
                                @error('address') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4">
                            <!-- Password -->
                            <div class="input-group">
                                <label for="password" class="input-label">Kata Sandi</label>
                                <input id="password" type="password" name="password" required class="input-control" placeholder="••••••••">
                                @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="input-group">
                                <label for="password_confirmation" class="input-label">Konfirmasi Kata Sandi</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" required class="input-control" placeholder="••••••••">
                            </div>
                        </div>

                        <button type="submit" class="btn-submit">
                            Daftar Sekarang
                        </button>

                        <div class="mt-4 text-center">
                            <p class="text-sm text-gray-500">
                                Sudah punya akun? <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">Masuk Sekarang</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const roleOptions = document.querySelectorAll('.role-option');
                
                function updateSelection() {
                    roleOptions.forEach(opt => {
                        const radio = opt.querySelector('input[type="radio"]');
                        if (radio.checked) {
                            opt.classList.add('selected');
                        } else {
                            opt.classList.remove('selected');
                        }
                    });
                }

                roleOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        const radio = this.querySelector('input[type="radio"]');
                        radio.checked = true;
                        updateSelection();
                    });
                });

                updateSelection(); // Initial check
            });
        </script>
    </body>
</html>
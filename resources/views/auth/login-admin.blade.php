<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Login Admin - RentMotor</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f8fafc;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                background-image: 
                    radial-gradient(at 0% 0%, rgba(59, 91, 219, 0.15) 0, transparent 50%), 
                    radial-gradient(at 100% 100%, rgba(59, 91, 219, 0.1) 0, transparent 50%);
            }

            .login-container {
                display: flex;
                width: 100%;
                max-width: 900px;
                background: white;
                border-radius: 32px;
                box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.15);
                overflow: hidden;
                margin: 20px;
            }

            .login-aside {
                flex: 1;
                background-color: #3b5bdb;
                background-image: url('https://images.unsplash.com/photo-1558981806-ec527fa84c39?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');
                background-size: cover;
                background-position: center;
                position: relative;
                display: none;
            }

            @media (min-width: 768px) {
                .login-aside { display: block; }
            }

            .aside-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(225deg, rgba(59, 91, 219, 0.8) 0%, rgba(59, 91, 219, 0.95) 100%);
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding: 3rem;
                color: white;
            }

            .login-form-area {
                flex: 1;
                padding: 3.5rem;
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .form-input {
                border: 2px solid #f1f5f9;
                background-color: #f8fafc;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                border-radius: 16px;
                padding: 0.875rem 1.25rem;
                font-size: 0.95rem;
            }

            .form-input:focus {
                border-color: #3b5bdb;
                background-color: white;
                box-shadow: 0 10px 20px -5px rgba(59, 91, 219, 0.15);
                outline: none;
            }

            .btn-submit {
                background-color: #3b5bdb;
                color: white;
                font-weight: 700;
                padding: 1rem;
                border-radius: 16px;
                transition: all 0.3s;
                letter-spacing: 0.5px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }

            .btn-submit:hover {
                background-color: #2d46b9;
                transform: translateY(-2px);
                box-shadow: 0 20px 40px -10px rgba(59, 91, 219, 0.4);
            }

            .password-toggle {
                position: absolute;
                right: 1.25rem;
                top: 50%;
                transform: translateY(-50%);
                color: #94a3b8;
                cursor: pointer;
                padding: 5px;
            }

            .brand-dot {
                width: 8px;
                height: 8px;
                background-color: white;
                border-radius: 50%;
                display: inline-block;
                margin-right: 8px;
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <!-- Left Side: Visual -->
            <div class="login-aside">
                <div class="aside-overlay">
                    <div class="mb-12">
                        <div class="flex items-center text-sm font-bold tracking-widest uppercase mb-4 opacity-80">
                            <span class="brand-dot"></span> Admin Control
                        </div>
                        <h2 class="text-4xl font-extrabold leading-tight">Kelola Sistem<br>dengan Lebih Baik.</h2>
                    </div>
                    <p class="text-blue-100 opacity-70 text-sm leading-relaxed max-w-xs">
                        Akses dashboard administrator untuk memantau trafik, keuangan, dan manajemen armada secara real-time.
                    </p>
                </div>
            </div>

            <!-- Right Side: Form -->
            <div class="login-form-area">
                <div class="mb-10">
                    <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Selamat Datang</h1>
                    <p class="text-gray-400 font-medium">Silakan masuk ke akun administrator Anda.</p>
                </div>

                @if (session('status'))
                    <div class="mb-6 p-4 rounded-2xl bg-green-50 text-green-700 text-sm font-medium border border-green-100">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <input type="hidden" name="intended_role" value="admin">

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 ml-1">Alamat Email</label>
                        <div class="relative">
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus 
                                   placeholder="email@admin.com"
                                   class="form-input w-full pl-5">
                        </div>
                        @error('email') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-3 ml-1">Kata Sandi</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required 
                                   placeholder="••••••••"
                                   class="form-input w-full pl-5 pr-12">
                            <span class="password-toggle" onclick="togglePassword()">
                                <i id="eye-icon" class="fas fa-eye"></i>
                            </span>
                        </div>
                        @error('password') <p class="mt-2 text-xs font-bold text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="btn-submit w-full mt-4">
                        Masuk Dashboard <i class="fas fa-arrow-right text-xs"></i>
                    </button>
                </form>
            </div>
        </div>

        <script>
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const eyeIcon = document.getElementById('eye-icon');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.remove('fa-eye');
                    eyeIcon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('fa-eye-slash');
                    eyeIcon.classList.add('fa-eye');
                }
            }
        </script>
    </body>
</html>

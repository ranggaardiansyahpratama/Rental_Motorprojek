<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ __('Register') }} - Rental Motor</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Scripts -->
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        
        <style>
            .btn-primary {
                background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3), 0 2px 4px -1px rgba(59, 130, 246, 0.2);
                transition: all 0.3s ease;
            }
            
            .btn-primary:hover {
                background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
                transform: translateY(-1px);
                box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3), 0 4px 6px -2px rgba(59, 130, 246, 0.2);
            }
            
            .btn-primary:active {
                transform: translateY(0);
            }
            
            .focus-blue:focus {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            }
            
            .card {
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                border-radius: 12px;
            }
            
            .input-field {
                transition: all 0.2s ease;
            }
            
            .input-field:focus {
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }
            
            .dark .card {
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
            }
            
            .role-option {
                transition: all 0.2s ease;
            }
            
            .role-option:hover {
                background-color: rgba(59, 130, 246, 0.05);
            }
            
            .role-option.selected {
                background-color: rgba(59, 130, 246, 0.1);
                border-color: #3b82f6;
            }
        </style>
    </head>
    <body class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-200">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Logo -->
            <div class="mb-8 text-center">
                <div class="inline-flex items-center text-3xl font-bold text-blue-600 dark:text-blue-400 mb-2">
                  Rental Motor
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Sistem Penyewaan Motor
                </p>
            </div>

            <!-- Register Card -->
            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white dark:bg-gray-800 card overflow-hidden">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Daftar Akun') }}</h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Buat akun baru Anda') }}
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('Name') }}
                        </label>
                        <input id="name" 
                               class="input-field w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white" 
                               type="text" 
                               name="name" 
                               value="{{ old('name') }}" 
                               required 
                               autofocus 
                               autocomplete="name"
                               placeholder="Your full name" />
                        @error('name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="mb-4">
                        <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('Email') }}
                        </label>
                        <input id="email" 
                               class="input-field w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autocomplete="email"
                               placeholder="your@email.com" />
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">
                            Daftar Sebagai
                        </label>
                        <div class="grid grid-cols-1 gap-2">
                            <label class="role-option flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer">
                                <input type="radio" name="role" value="renter" class="text-blue-600 focus:ring-blue-500" {{ old('role') == 'renter' ? 'checked' : '' }} required>
                                <span class="ml-3 text-sm">
                                    <span class="font-medium">🏍️ Penyewa Motor</span>
                                    <span class="block text-xs text-gray-500 mt-1">Menyewa motor untuk kebutuhan transportasi</span>
                                </span>
                            </label>
                            
                            <label class="role-option flex items-center p-3 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer">
                                <input type="radio" name="role" value="owner" class="text-blue-600 focus:ring-blue-500" {{ old('role') == 'owner' ? 'checked' : '' }}>
                                <span class="ml-3 text-sm">
                                    <span class="font-medium">🏢 Pemilik Motor</span>
                                    <span class="block text-xs text-gray-500 mt-1">Memiliki motor untuk disewakan</span>
                                </span>
                            </label>
                        </div>
                        @error('role')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="mb-4">
                        <label for="phone" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">
                            Nomor Telepon
                        </label>
                        <input id="phone" 
                               class="input-field w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white" 
                               type="tel" 
                               name="phone" 
                               value="{{ old('phone') }}" 
                               autocomplete="tel"
                               placeholder="08xxxxxxxxxx" />
                        @error('phone')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="mb-4">
                        <label for="address" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">
                            Alamat
                        </label>
                        <textarea id="address" 
                                  name="address" 
                                  rows="3" 
                                  class="input-field w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white"
                                  placeholder="Your complete address">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('Password') }}
                        </label>
                        <input id="password" 
                               class="input-field w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white"
                               type="password"
                               name="password"
                               required 
                               autocomplete="new-password"
                               placeholder="••••••••" />
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label for="password_confirmation" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">
                            {{ __('Confirm Password') }}
                        </label>
                        <input id="password_confirmation" 
                               class="input-field w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-white"
                               type="password"
                               name="password_confirmation" 
                               required 
                               autocomplete="new-password"
                               placeholder="••••••••" />
                        @error('password_confirmation')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Register Button -->
                    <div class="mb-6">
                        <button type="submit" 
                                class="btn-primary w-full py-3 px-4 rounded-lg font-semibold text-white uppercase tracking-wider focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800">
                            {{ __('Register') }}
                        </button>
                    </div>

                    <!-- Login Link -->
                    <div class="text-center pt-4 border-t border-gray-200 dark:border-gray-700">
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                            Sudah mempunyai akun?
                        </p>
                        <a href="{{ route('login') }}" 
                           class="inline-block w-full bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 dark:focus:ring-offset-gray-800">
                            {{ __('Login Sekarang') }}
                        </a>
                    </div>
                </form>
            </div>

            
            </div>
        </div>

        <script>
            // Script untuk styling radio button role
            document.addEventListener('DOMContentLoaded', function() {
                const roleOptions = document.querySelectorAll('.role-option');
                
                roleOptions.forEach(option => {
                    const radio = option.querySelector('input[type="radio"]');
                    
                    // Set initial state
                    if (radio.checked) {
                        option.classList.add('selected');
                    }
                    
                    // Add event listener for change
                    radio.addEventListener('change', function() {
                        roleOptions.forEach(opt => {
                            opt.classList.remove('selected');
                        });
                        
                        if (this.checked) {
                            option.classList.add('selected');
                        }
                    });
                    
                    // Make the whole option clickable
                    option.addEventListener('click', function(e) {
                        if (e.target !== radio) {
                            radio.checked = true;
                            roleOptions.forEach(opt => {
                                opt.classList.remove('selected');
                            });
                            option.classList.add('selected');
                        }
                    });
                });
            });
        </script>
    </body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Credentials - RentMotor</title>
    
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-200">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <!-- Logo -->
        <div class="mb-8 text-center">
            <div class="inline-flex items-center text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">
                🏍️ RentMotor
            </div>
            <p class="text-gray-600 dark:text-gray-400">Login Credentials Information</p>
        </div>

        <!-- Credentials Card -->
        <div class="w-full max-w-2xl bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Login Credentials</h2>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Gunakan credentials berikut untuk testing sistem
                </p>
            </div>

            <!-- Admin Credentials -->
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full mr-4">
                        <i class="fas fa-user-shield text-purple-600 dark:text-purple-300 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Admin Account</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Kelola sistem, verifikasi motor, dan user management</p>
                    </div>
                </div>
                
                <div class="bg-purple-50 dark:bg-purple-900/20 p-4 rounded-lg border border-purple-200 dark:border-purple-800">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-purple-800 dark:text-purple-300">Email:</label>
                            <div class="flex items-center mt-1">
                                <code class="text-purple-900 dark:text-purple-200 bg-purple-100 dark:bg-purple-800 px-2 py-1 rounded text-sm font-mono">admin@rentmotor.com</code>
                                <button onclick="copyToClipboard('admin@rentmotor.com')" class="ml-2 text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-purple-800 dark:text-purple-300">Password:</label>
                            <div class="flex items-center mt-1">
                                <code class="text-purple-900 dark:text-purple-200 bg-purple-100 dark:bg-purple-800 px-2 py-1 rounded text-sm font-mono">password</code>
                                <button onclick="copyToClipboard('password')" class="ml-2 text-purple-600 dark:text-purple-400 hover:text-purple-800 dark:hover:text-purple-300">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Owner Credentials -->
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full mr-4">
                        <i class="fas fa-motorcycle text-blue-600 dark:text-blue-300 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Owner Account</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Pemilik motor untuk mendaftarkan kendaraan</p>
                    </div>
                </div>
                
                <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-blue-800 dark:text-blue-300">Email:</label>
                            <div class="flex items-center mt-1">
                                <code class="text-blue-900 dark:text-blue-200 bg-blue-100 dark:bg-blue-800 px-2 py-1 rounded text-sm font-mono">budi@example.com</code>
                                <button onclick="copyToClipboard('budi@example.com')" class="ml-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-blue-800 dark:text-blue-300">Password:</label>
                            <div class="flex items-center mt-1">
                                <code class="text-blue-900 dark:text-blue-200 bg-blue-100 dark:bg-blue-800 px-2 py-1 rounded text-sm font-mono">password</code>
                                <button onclick="copyToClipboard('password')" class="ml-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Renter Credentials -->
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full mr-4">
                        <i class="fas fa-user text-green-600 dark:text-green-300 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Renter Account</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Penyewa motor untuk mencari kendaraan</p>
                    </div>
                </div>
                
                <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-800">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-green-800 dark:text-green-300">Email:</label>
                            <div class="flex items-center mt-1">
                                <code class="text-green-900 dark:text-green-200 bg-green-100 dark:bg-green-800 px-2 py-1 rounded text-sm font-mono">sari@example.com</code>
                                <button onclick="copyToClipboard('sari@example.com')" class="ml-2 text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-green-800 dark:text-green-300">Password:</label>
                            <div class="flex items-center mt-1">
                                <code class="text-green-900 dark:text-green-200 bg-green-100 dark:bg-green-800 px-2 py-1 rounded text-sm font-mono">password</code>
                                <button onclick="copyToClipboard('password')" class="ml-2 text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-300">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info -->
            <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg border border-yellow-200 dark:border-yellow-800 mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-yellow-600 dark:text-yellow-400 mr-2"></i>
                    <div>
                        <p class="text-sm font-medium text-yellow-800 dark:text-yellow-300">Informasi Penting:</p>
                        <p class="text-xs text-yellow-700 dark:text-yellow-400 mt-1">
                            • Admin tidak bisa daftar melalui form register<br>
                            • Hanya Owner dan Renter yang bisa mendaftar<br>
                            • Admin dibuat langsung melalui seeder database
                        </p>
                    </div>
                </div>
            </div>

            <!-- Login Actions -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold text-center text-gray-900 dark:text-white mb-2">Pilih Halaman Login:</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('login.admin') }}" 
                       class="flex flex-col items-center justify-center bg-gray-600 hover:bg-gray-700 text-white p-4 rounded-xl transition-all hover:scale-105">
                        <i class="fas fa-user-shield mb-2 text-2xl"></i>
                        <span class="font-bold whitespace-nowrap">Login Admin</span>
                    </a>
                    <a href="{{ route('login.owner') }}" 
                       class="flex flex-col items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white p-4 rounded-xl transition-all hover:scale-105">
                        <i class="fas fa-building mb-2 text-2xl"></i>
                        <span class="font-bold whitespace-nowrap">Login Pemilik</span>
                    </a>
                    <a href="{{ route('login.renter') }}" 
                       class="flex flex-col items-center justify-center bg-blue-600 hover:bg-blue-700 text-white p-4 rounded-xl transition-all hover:scale-105">
                        <i class="fas fa-motorcycle mb-2 text-2xl"></i>
                        <span class="font-bold whitespace-nowrap">Login Penyewa</span>
                    </a>
                </div>
                
                <div class="text-center pt-4">
                    <p class="text-sm text-gray-500 mb-2">Atau jika ingin mendaftar:</p>
                    <a href="{{ route('register') }}" 
                       class="inline-block bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors">
                        <i class="fas fa-user-plus mr-2"></i>
                        Daftar Akun Baru (Pemilik/Penyewa)
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Create temporary notification
                const notification = document.createElement('div');
                notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                notification.textContent = 'Copied to clipboard!';
                document.body.appendChild(notification);
                
                // Remove after 2 seconds
                setTimeout(() => {
                    notification.remove();
                }, 2000);
            });
        }
    </script>
</body>
</html>
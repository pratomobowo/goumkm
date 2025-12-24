<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>GO UMKM - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex">
            <!-- Left Side - Branding -->
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 p-12 flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="px-3 py-1.5 bg-white/20 backdrop-blur rounded-lg">
                            <span class="text-white font-bold text-xl">GO</span>
                        </div>
                        <span class="text-white text-2xl font-bold">UMKM</span>
                    </div>
                </div>
                
                <div class="space-y-6">
                    <h1 class="text-4xl font-bold text-white leading-tight">
                        Kelola Keuangan<br>Bisnis Anda dengan<br>Mudah & Akurat
                    </h1>
                    <p class="text-blue-100 text-lg max-w-md">
                        Solusi lengkap untuk UMKM: transaksi, jurnal, stok, pajak, dan laporan keuangan dalam satu aplikasi.
                    </p>
                    <div class="flex items-center gap-8 pt-4">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">500+</div>
                            <div class="text-blue-200 text-sm">UMKM Aktif</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">10jt+</div>
                            <div class="text-blue-200 text-sm">Transaksi/Bulan</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">99.9%</div>
                            <div class="text-blue-200 text-sm">Uptime</div>
                        </div>
                    </div>
                </div>

                <div class="text-blue-200 text-sm">
                    © {{ date('Y') }} GO UMKM. All rights reserved.
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
                <div class="w-full max-w-md">
                    <!-- Mobile Logo -->
                    <div class="lg:hidden flex items-center justify-center gap-2 mb-8">
                        <div class="px-3 py-1.5 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg">
                            <span class="text-white font-bold text-xl">GO</span>
                        </div>
                        <span class="text-gray-900 text-2xl font-bold">UMKM</span>
                    </div>

                    <div class="bg-white rounded-2xl shadow-xl p-8">
                        <div class="text-center mb-8">
                            <h2 class="text-2xl font-bold text-gray-900">Selamat Datang</h2>
                            <p class="text-gray-500 mt-1">Masuk ke akun Anda</p>
                        </div>

                        {{ $slot }}
                    </div>

                    <p class="text-center text-gray-500 text-sm mt-6">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-700 font-medium">Daftar sekarang</a>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Rent Drive - Sistem Sewa Kendaraan</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['Inter', 'sans-serif'],
                            },
                            colors: {
                                slate: {
                                    50: '#f8fafc',
                                    100: '#f1f5f9',
                                    200: '#e2e8f0',
                                    800: '#1e293b',
                                    900: '#0f172a',
                                },
                                navy: {
                                    DEFAULT: '#1e3a8a', /* Biru utama yang elegan/tua */
                                    light: '#dbeafe',
                                }
                            }
                        }
                    }
                }
            </script>
        @endif
    </head>
    <body class="bg-slate-50 text-slate-900 antialiased min-h-screen flex flex-col font-sans selection:bg-navy selection:text-white">
        
        <header class="w-full border-b border-slate-200 bg-white">
            <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-4 h-4 bg-navy"></div>
                    <span class="text-sm font-semibold tracking-[0.2em] text-slate-900">Rent-Drive</span>
                </div>
                
                @if (Route::has('login'))
                    <nav class="flex items-center gap-8 text-sm font-medium">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-slate-500 hover:text-navy transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-slate-500 hover:text-navy transition-colors">Masuk</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="text-slate-500 hover:text-navy hover:text-navy transition-colors">
                                    Daftar Akun
                                </a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </div>
        </header>

        <main class="flex-1 w-full max-w-7xl mx-auto flex flex-col md:flex-row border-x border-slate-200 bg-white">
            
            <div class="w-full md:w-3/5 p-10 lg:p-20 flex flex-col justify-center border-b md:border-b-0 md:border-r border-slate-200">
                
                <h1 class="text-5xl lg:text-7xl font-light tracking-tight text-slate-900 leading-[1.1] mb-8">
                    Mobilitas <br>
                    <span class="font-semibold text-navy">Tanpa Batas</span>
                </h1>
                
                <p class="text-slate-500 text-lg leading-relaxed mb-12 max-w-md font-light">
                    Platform manajemen penyewaan kendaraan yang dirancang untuk efisiensi perjalanan Anda
                </p>
                
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('login') }}" class="px-8 py-4 bg-navy text-white text-sm font-medium hover:bg-slate-900 transition-colors">
                        Mulai Reservasi
                    </a>
                    <a href="{{ route('login') }}" class="px-8 py-4 border border-slate-300 text-slate-700 text-sm font-medium hover:bg-slate-50 transition-colors">
                        Lihat Armada
                    </a>
                </div>
            </div>

            <div class="w-full md:w-2/5 bg-slate-50 relative flex flex-col justify-between">
                
                <div class="p-10 border-b border-slate-200">
                    <p class="text-xs font-semibold text-slate-400 tracking-widest uppercase mb-2">Status Sistem</p>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-navy"></div>
                        <p class="text-sm text-slate-700 font-medium">Operasional 24/7</p>
                    </div>
                </div>

                <div class="p-10 flex-1 flex items-center justify-center relative overflow-hidden">
                    <div class="absolute inset-0 bg-[linear-gradient(to_right,#e2e8f0_1px,transparent_1px),linear-gradient(to_bottom,#e2e8f0_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_60%_at_50%_50%,#000_70%,transparent_100%)] opacity-50"></div>
                    
                    <div class="relative z-10 w-full p-8 bg-white border border-slate-200">
                        <!-- <div class="text-xs text-slate-400 mb-4 font-mono">01 // ARMADA</div> -->
                        <h3 class="text-2xl font-medium text-slate-900 mb-2">Pilih, Pesan, Jalan.</h3>
                        <p class="text-sm text-slate-500 font-light">
                            Biaya Transparan tanpa Tambahan
                        </p>
                    </div>
                </div>

            </div>
            
        </main>

        <footer class="w-full border-t border-slate-200 bg-white">
            <div class="max-w-7xl mx-auto px-6 py-8 flex justify-between items-center">
                <p class="text-xs text-slate-400">&copy; {{ date('Y') }} RentDrive. All rights reserved.</p>
                <p class="text-xs text-slate-400">V.1.0.0</p>
            </div>
        </footer>
    </body>
</html>
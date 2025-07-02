<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Zizz Shop') }} - Hosting Store</title>
    <link rel="icon" href="https://files.catbox.moe/5z7z6d.png">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>

        .text-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #667eea 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;

        /* Tambahkan ini untuk membuat gradien lebih besar dari teksnya */
            background-size: 300% 300%;

        /* Terapkan animasi */
            animation: gradient-flow 4s ease-in-out infinite;
        }

        /* Keyframes untuk menganimasikan posisi gradien */
        @keyframes gradient-flow {
            0% {
                background-position: 0% 50%;
                }
            50% {
                background-position: 100% 50%;
                }
            100% {
                background-position: 0% 50%;
                }
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .glass-morphism {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        
        .pulse-glow {
            animation: pulse-glow 2s infinite;
        }
        
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(102, 126, 234, 0.4); }
            50% { box-shadow: 0 0 30px rgba(102, 126, 234, 0.8); }
        }
        
        .ios-navbar {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }
        
        .nav-item {
            position: relative;
            padding: 12px 24px;
            border-radius: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(10px);
        }
        
        .nav-item:hover {
            background: rgba(59, 130, 246, 0.15);
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.3);
            transform: translateY(-2px);
        }
        
        .nav-item::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 20px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(147, 51, 234, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .nav-item:hover::before {
            opacity: 1;
        }
        
        @media (min-width: 768px) {
            .desktop-nav {
                position: fixed;
                left: 24px;
                top: 50%;
                transform: translateY(-50%);
                z-index: 50;
                width: auto;
                border-radius: 32px;
                padding: 16px;
                transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1); /* Transisi untuk hide/show */
            }
            
            /* Style baru untuk menyembunyikan navbar */
            .desktop-nav-hidden {
                transform: translateY(-50%) translateX(-150%);
            }
            
            .desktop-nav .nav-content {
                flex-direction: column;
                gap: 8px;
            }
            
            .desktop-nav .nav-item {
                width: 60px;
                height: 60px;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 0;
                border-radius: 20px;
            }
            
            .desktop-nav .nav-text {
                display: none;
            }
            
            .desktop-nav .brand {
                writing-mode: vertical-rl;
                text-orientation: mixed;
                font-size: 18px;
                font-weight: 900;
                padding: 20px 0;
                margin-bottom: 20px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }
        }
        
        @media (max-width: 767px) {
            .mobile-nav {
                position: fixed;
                bottom: 20px;
                left: 50%;
                transform: translateX(-50%);
                z-index: 50;
                width: calc(100% - 40px);
                max-width: 400px;
                border-radius: 32px;
                padding: 16px 20px;
            }
            
            .mobile-nav .nav-content {
                flex-direction: row;
                justify-content: space-between;
                align-items: center;
            }
            
            .mobile-nav .nav-item {
                width: 50px;
                height: 50px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 8px;
                border-radius: 16px;
            }
            
            .mobile-nav .nav-text {
                font-size: 10px;
                margin-top: 2px;
                font-weight: 600;
            }
            
            .mobile-nav .brand {
                display: none;
            }
            
            .mobile-nav .auth-buttons {
                position: absolute;
                top: -60px;
                right: 0;
                display: flex;
                gap: 8px;
            }
        }
        
        .nav-icon {
            width: 20px;
            height: 20px;
            transition: all 0.3s ease;
        }
        
        .nav-item:hover .nav-icon {
            transform: scale(1.1);
            filter: drop-shadow(0 0 8px rgba(59, 130, 246, 0.6));
        }
        
        .auth-btn {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .auth-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }
        
        .section-divider {
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.5), transparent);
        }
    </style>
</head>
<body class="bg-gray-900 text-white font-sans antialiased overflow-x-hidden">
    
    <button id="nav-toggle-btn" class="hidden md:block fixed top-1/2 -translate-y-1/2 left-4 z-[51] w-10 h-10 bg-gray-800/80 backdrop-blur-sm rounded-full flex items-center justify-center transition-all duration-500">
        <svg id="hide-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        <svg id="show-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>
    
    <nav id="desktop-nav" class="desktop-nav ios-navbar hidden md:block">
        <div class="nav-content flex">
            <a href="#home" class="nav-item group">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
            </a>
            
            <a href="#about" class="nav-item group">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </a>
            <a href="#pterodactyl-plans" class="nav-item group">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                </svg>
            </a>
            
            <a href="#products" class="nav-item group">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
            </a>
            
            <a href="#contact" class="nav-item group">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </a>
        </div>
    </nav>

    <nav class="mobile-nav ios-navbar md:hidden">
        <div class="nav-content flex">
            <a href="#home" class="nav-item group">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="nav-text">Home</span>
            </a>
            
            <a href="#about" class="nav-item group">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="nav-text">About</span>
            </a>
            
            <a href="#pterodactyl-plans" class="nav-item group">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                </svg>
                <span class="nav-text">Panel</span>
            </a>

            <a href="#products" class="nav-item group">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="nav-text">Products</span>
            </a>
            
            <a href="#contact" class="nav-item group">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                <span class="nav-text">Contact</span>
            </a>
        </div>
    </nav>
    <section id="home" class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-gray-900 via-purple-900/20 to-blue-900/20"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23667eea" fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
        
        <div class="absolute top-1/4 left-1/4 w-72 h-72 bg-purple-500/10 rounded-full blur-3xl floating-animation"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl floating-animation" style="animation-delay: -3s;"></div>
        
        <div class="relative z-10 max-w-6xl mx-auto px-4 text-center">
            <div class="mb-6">
                <span class="inline-block px-4 py-2 bg-gradient-to-r from-purple-500/20 to-blue-500/20 rounded-full text-sm font-medium border border-purple-500/30 glass-morphism">
                    ✨ Welcome to Hosting Store
                </span>
            </div>
            
            <h1 class="text-5xl md:text-8xl font-black mb-8 leading-tight">
                Welcome to <br>
                <span class="text-gradient">{{ config('app.name', 'Zizz Shop') }}</span>
            </h1>
            
            <p class="text-xl md:text-2xl text-gray-300 mb-12 max-w-3xl mx-auto leading-relaxed">
                Temukan produk premium dengan kualitas terbaik.
Rasakan pengalaman belanja yang berbeda bersama koleksi pilihan kami, mulai dari layanan hosting, sewa bot, hingga script WhatsApp siap pakai.
            </p>


            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                @auth
                <a href="{{ route('dashboard') }}" class="group relative overflow-hidden px-8 py-4 bg-gradient-to-r from-purple-500 to-blue-500 rounded-full text-lg font-bold transition-all duration-300 hover:scale-105 pulse-glow">
                    <span class="relative z-10 flex items-center">
                        Dashboard
                        <svg class="w-5 h-5 ml-2 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </span>
                </a>
                @else
                <a href="{{ route('login') }}" class="group relative overflow-hidden px-8 py-4 bg-gradient-to-r from-purple-500 to-blue-500 rounded-full text-lg font-bold transition-all duration-300 hover:scale-105 pulse-glow">
                    <span class="relative z-10 flex items-center">
                        Log-in
                        </span>
                </a>
                
                <a href="{{ route('register') }}" class="group px-8 py-4 glass-morphism rounded-full text-lg font-semibold transition-all duration-300 hover:scale-105">
                    <span class="flex items-center">
                        Daftar
                        </span>
                </a>
            </div>
            @endauth
        </div>
    </section>

    <div class="section-divider h-px"></div>

    <section id="about" class="py-24 bg-gradient-to-br from-gray-800 to-gray-900 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-5xl md:text-6xl font-black text-gradient mb-6">About Us</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Kami hadir untuk memberikan layanan terbaik — mulai dari hosting, sewa bot, hingga jasa script premium dengan kualitas unggulan.
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="group text-center p-8 rounded-3xl glass-morphism card-hover">
                    <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div class="text-4xl font-black text-blue-400 mb-2">{{ $totalUsers }}+</div>
                    <div class="text-gray-300 font-medium">Happy Customers</div>
                    <p class="text-gray-400 text-sm mt-2">Dipercaya banyak pelanggan lokal dan pembeli online — bukti kualitas layanan kami!</p>
                </div>
                
                <div class="group text-center p-8 rounded-3xl glass-morphism card-hover">
                    <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-purple-400 to-purple-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="text-4xl font-black text-purple-400 mb-2">{{ $totalProducts }}+</div>
                    <div class="text-gray-300 font-medium">Products Listed</div>
                    <p class="text-gray-400 text-sm mt-2">Layanan premium, dipilih khusus buat kamu!</p>
                </div>
                
                <div class="group text-center p-8 rounded-3xl glass-morphism card-hover">
                    <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-cyan-400 to-cyan-600 rounded-2xl flex items-center justify-center">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <div class="text-4xl font-black text-cyan-400 mb-2">5+</div>
                    <div class="text-gray-300 font-medium">Tahun pengalaman</div>
                    <p class="text-gray-400 text-sm mt-2">Proven track record</p>
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider h-px"></div>

      <section id="pterodactyl-plans" class="py-24 bg-gray-900 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-5xl md:text-6xl font-black text-gradient mb-6">Pterodactyl Plans</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Performa tinggi, anti ribet, dan langsung siap pakai!
                </p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($pterodactylPlans as $plan)
                <div class="group bg-gray-800/50 rounded-3xl overflow-hidden card-hover glass-morphism flex flex-col">
                    <div class="p-6 flex-grow">
                        <div class="mb-4">
                            <span class="inline-block px-3 py-1 bg-blue-500/20 text-blue-300 text-xs font-medium rounded-full">
                                Panel Pterodactyl Server
                            </span>
                        </div>
                        
                        <h3 class="font-bold text-lg text-white mb-2 group-hover:text-blue-300 transition-colors">
                            {{ $plan->name }}
                        </h3>

                        <ul class="text-sm text-gray-300 space-y-2 mb-6">
                            <li class="flex items-center"><svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>CPU: {{ $plan->cpu }}%</li>
                            <li class="flex items-center"><svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>RAM: {{ $plan->ram }} MB</li>
                            <li class="flex items-center"><svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Disk: {{ $plan->disk }} MB</li>
                        </ul>
                        
                        <p class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400 mb-6">
                            Rp {{ number_format($plan->price, 0, ',', '.') }}
                        </p>
                    </div>
                    
                    
                    <div class="p-6 pt-0">
                        <a href="{{ route('dashboard') }}" class="block text-center w-full bg-gradient-to-r from-blue-500 to-cyan-500 hover:from-blue-600 hover:to-cyan-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105">
                            Order Now
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-20">
                    <div class="w-32 h-32 mx-auto mb-6 bg-gray-800 rounded-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                           <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-400 mb-2">Tidak Ada Plan Hosting yang tersedia</h3>
                    <p class="text-gray-500">Solusi hosting terbaik segera hadir! Pantau terus ya!.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <div class="section-divider h-px"></div>

    <section id="products" class="py-24 bg-gray-900 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-5xl md:text-6xl font-black text-gradient mb-6">Products Kami</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                   Jelajahi koleksi layanan digital pilihan — dari hosting hingga script premium — semua dirancang untuk memenuhi kebutuhanmu secara maksimal.
                </p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($products as $product)
                <div class="group bg-gray-800/50 rounded-3xl overflow-hidden card-hover glass-morphism">
                    <div class="relative overflow-hidden">
                        @php
                            $imageUrl = Str::startsWith($product->image_url, 'http') 
                                ? $product->image_url 
                                : asset('storage/' . $product->image_url);
                        @endphp
                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    
                    <div class="p-6">
                        <div class="mb-4">
                            <span class="inline-block px-3 py-1 bg-purple-500/20 text-purple-300 text-xs font-medium rounded-full">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </span>
                        </div>
                        
                        <h3 class="font-bold text-lg text-white mb-2 group-hover:text-purple-300 transition-colors">
                            {{ $product->name }}
                        </h3>
                        
                        <p class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400 mb-6">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>
                        
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-blue-500 hover:from-purple-600 hover:to-blue-600 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105">
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-20">
                    <div class="w-32 h-32 mx-auto mb-6 bg-gray-800 rounded-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-400 mb-2">Tidak ada products yang tersedia</h3>
                    <p class="text-gray-500">Check back soon for amazing products!</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <div class="section-divider h-px"></div>

    <section id="contact" class="py-24 bg-gradient-to-br from-gray-800 to-gray-900 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20">
                <h2 class="text-5xl md:text-6xl font-black text-gradient mb-6">Contact Us</h2>
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                   Tertarik menggunakan layanan kami?
Hubungi kami sekarang, dan kami akan segera merespons pesan Anda.
                </p>
            </div>
            
            <div class="max-w-6xl mx-auto grid lg:grid-cols-1 lg:justify-items-center gap-16">
                <div class="space-y-8">
                    <div class="glass-morphism rounded-3xl p-8">
                        <h3 class="text-2xl font-bold mb-6 text-gradient">Get in Touch</h3>
                        <div class="space-y-6">
                            @if($settings->support_email)
                            <div class="flex items-center space-x-4 group">
                                <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg">Email</h4>
                                    <a href="mailto:{{ $settings->support_email }}" class="text-gray-300 hover:text-blue-400 transition-colors">{{ $settings->support_email }}</a>
                                </div>
                            </div>
                            @endif
                            
                            @if($settings->support_whatsapp_number)
                            <div class="flex items-center space-x-4 group">
                                <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-lg">WhatsApp</h4>
                                    <a href="https://wa.me/{{ $settings->support_whatsapp_number }}" target="_blank" class="text-gray-300 hover:text-green-400 transition-colors">{{ $settings->support_whatsapp_number }}</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                </div>
        </div>
    </section>

    <footer class="border-t border-gray-800/50 py-12 bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-400 mb-6">
                    Copyright © {{ date('Y') }} {{ config('app.name', 'Zizz Shop') }}. All Rights Reserved.
                </p>
                
                <div class="flex justify-center space-x-6">
                    @if($settings->support_instagram_url)
                    <a href="{{ $settings->support_instagram_url }}" target="_blank" class="w-12 h-12 bg-gradient-to-br from-pink-400 to-purple-500 rounded-xl flex items-center justify-center hover:scale-110 transition-transform">
                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>
                    @endif
                    
                    @if($settings->support_facebook_url)
                    <a href="{{ $settings->support_facebook_url }}" target="_blank" class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-xl flex items-center justify-center hover:scale-110 transition-transform">
                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.407.593 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116c.732 0 1.325-.593 1.325-1.325V1.325C24 .593 23.407 0 22.675 0z"/>
                        </svg>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </footer>

     <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Enhanced navbar interactions
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05) translateY(-2px)';
            });
            
            item.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1) translateY(0)';
            });
        });

        // Active navigation highlighting
        const sections = document.querySelectorAll('section[id]');
        const navItems = document.querySelectorAll('.nav-item[href^="#"]');

        window.addEventListener('scroll', () => {
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (window.scrollY >= (sectionTop - 200)) {
                    current = section.getAttribute('id');
                }
            });

            navItems.forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('href') === `#${current}`) {
                    item.classList.add('active');
                    item.style.background = 'rgba(59, 130, 246, 0.25)';
                    item.style.boxShadow = '0 0 25px rgba(59, 130, 246, 0.4)';
                } else {
                    item.style.background = '';
                    item.style.boxShadow = '';
                }
            });
        });

        // iOS-style haptic feedback simulation (visual)
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function() {
                this.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    this.style.transform = '';
                }, 150);
            });
        });

        // Add intersection observer for fade-in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe all sections
        document.querySelectorAll('section').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });

        // === SCRIPT BARU UNTUK HIDE/SHOW NAVBAR ===
        document.addEventListener('DOMContentLoaded', () => {
            const nav = document.getElementById('desktop-nav');
            const toggleBtn = document.getElementById('nav-toggle-btn');
            const hideIcon = document.getElementById('hide-icon');
            const showIcon = document.getElementById('show-icon');

            if (!nav || !toggleBtn || !hideIcon || !showIcon) return;

            const updateNavState = (isHidden) => {
                if (isHidden) {
                    nav.classList.add('desktop-nav-hidden');
                    hideIcon.classList.add('hidden');
                    showIcon.classList.remove('hidden');
                    // Geser tombol ke kiri agar menempel di tepi layar
                    toggleBtn.style.left = '1rem'; 
                } else {
                    nav.classList.remove('desktop-nav-hidden');
                    hideIcon.classList.remove('hidden');
                    showIcon.classList.add('hidden');
                    // Kembalikan posisi tombol di samping navbar
                    toggleBtn.style.left = '6.5rem'; // Sesuaikan nilai ini jika lebar navbar berubah
                }
            };

            // Cek localStorage saat halaman dimuat
            const isNavHidden = localStorage.getItem('isNavHidden') === 'true';
            updateNavState(isNavHidden);

            // Tambahkan event listener ke tombol
            toggleBtn.addEventListener('click', () => {
                const currentState = nav.classList.contains('desktop-nav-hidden');
                // Simpan state baru ke localStorage
                localStorage.setItem('isNavHidden', !currentState);
                // Update tampilan
                updateNavState(!currentState);
            });
        });
    </script>
</body>
</html>
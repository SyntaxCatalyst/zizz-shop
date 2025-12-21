<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Zizz Shop') }} - Premium Hosting & Digital Store</title>
    <link rel="icon" href="https://files.catbox.moe/5z7z6d.png">
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 text-white font-sans antialiased overflow-x-hidden relative selection:bg-purple-500/30 selection:text-purple-200">

    <!-- Background Accents -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-500/10 rounded-full blur-[100px] animate-pulse"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-[100px] animate-pulse delay-700"></div>
    </div>

    <!-- Navigation -->
    <nav x-data="{ mobileMenuOpen: false, scrolled: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 20)"
         :class="{ 'glass-panel': scrolled, 'bg-transparent py-6': !scrolled }"
         class="fixed top-0 w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="#" class="text-2xl font-black tracking-tighter text-white">
                        {{ config('app.name', 'Zizz Shop') }}
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">Home</a>
                    <a href="#about" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">About</a>
                    <a href="#pterodactyl-plans" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">Hosting</a>
                    <a href="#products" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">Products</a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="glass-btn px-6 py-2 rounded-full text-sm font-bold hover:scale-105">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">Log In</a>
                        <a href="{{ route('register') }}" class="bg-white text-gray-900 px-6 py-2 rounded-full text-sm font-bold hover:bg-gray-100 transition-all hover:scale-105 shadow-lg shadow-white/10">Sign Up</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-300 hover:text-white focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-5"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-5"
             class="md:hidden glass-panel absolute w-full group">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a href="#home" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-white/5">Home</a>
                <a href="#about" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-white/5">About</a>
                <a href="#pterodactyl-plans" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-white/5">Hosting</a>
                <a href="#products" @click="mobileMenuOpen = false" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-white/5">Products</a>
                <div class=" my-2 pt-2">
                     @auth
                        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-300 hover:text-white hover:bg-white/5">Log In</a>
                        <a href="{{ route('register') }}" class="block mt-2 px-3 py-2 rounded-md text-base font-bold bg-white text-gray-900 text-center">Sign Up</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative min-h-screen flex items-center justify-center pt-20">
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-panel mb-8 animate-fade-in-up">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <span class="text-xs font-medium text-gray-300 tracking-wide uppercase">New Servers Available</span>
            </div>
            
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black mb-8 leading-tight tracking-tight">
                Level Up Your <br />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 via-blue-400 to-purple-400 animate-gradient-x">Digital Experience</span>
            </h1>
            
            <p class="text-xl text-gray-400 mb-10 max-w-2xl mx-auto leading-relaxed">
                Premium Pterodactyl hosting, high-quality game servers, and exclusive digital products. Fast, reliable, and 24/7 active support.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="#about" class="px-8 py-4 bg-white text-gray-950 rounded-full font-bold text-lg hover:bg-gray-200 transition-all hover:scale-105 shadow-lg shadow-white/10 w-full sm:w-auto">
                    Explore Now
                </a>
                <a href="#pterodactyl-plans" class="px-8 py-4 glass-btn rounded-full font-bold text-lg w-full sm:w-auto">
                    View Pricing
                </a>
            </div>

            <!-- Stats -->
            <div class="mt-20 grid grid-cols-2 md:grid-cols-4 gap-8 border-t border-white/5 pt-12">
                <div>
                    <div class="text-3xl font-black text-white mb-1">{{ $totalUsers }}+</div>
                    <div class="text-sm text-gray-500 font-medium">Happy Clients</div>
                </div>
                <div>
                    <div class="text-3xl font-black text-white mb-1">{{ $totalProducts }}+</div>
                    <div class="text-sm text-gray-500 font-medium">Products</div>
                </div>
                 <div>
                    <div class="text-3xl font-black text-white mb-1">99.9%</div>
                    <div class="text-sm text-gray-500 font-medium">Uptime</div>
                </div>
                 <div>
                    <div class="text-3xl font-black text-white mb-1">24/7</div>
                    <div class="text-sm text-gray-500 font-medium">Support</div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-32 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-blue-500 rounded-3xl blur-2xl opacity-20 transform rotate-6"></div>
                    <div class="glass-panel rounded-3xl p-8 relative grayscale hover:grayscale-0 transition-all duration-500">
                         <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-800/50 h-32 rounded-2xl"></div>
                            <div class="bg-gray-800/50 h-32 rounded-2xl"></div>
                            <div class="bg-gray-800/50 h-32 rounded-2xl col-span-2"></div>
                         </div>
                    </div>
                </div>
                <div>
                    <h2 class="text-4xl font-bold mb-6">Why Choose Zizz Shop?</h2>
                    <p class="text-gray-400 text-lg mb-8 leading-relaxed">
                        Kami tidak hanya menjual produk, kami memberikan solusi. Dengan infrastruktur server yang kuat dan koleksi produk digital yang terkurasi, kami memastikan kepuasan Anda adalah prioritas utama kami.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <span class="text-gray-300 font-medium">High Performance Servers</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-purple-500/10 flex items-center justify-center text-purple-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <span class="text-gray-300 font-medium">Secure Transactions</span>
                        </li>
                         <li class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-green-500/10 flex items-center justify-center text-green-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <span class="text-gray-300 font-medium">Instant Activation</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pterodactyl-plans" class="py-32 bg-gray-900/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-20 max-w-3xl mx-auto">
                <h2 class="text-4xl font-bold mb-6">Pterodactyl Hosting Plans</h2>
                <p class="text-gray-400">Pilih paket hosting yang sesuai dengan kebutuhan server Anda. Upgrade kapan saja dengan mudah.</p>
            </div>
            
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($pterodactylPlans as $plan)
                    <div class="glass-card rounded-3xl p-8 relative flex flex-col group hover:bg-white/10">
                        <div class="mb-6">
                            <h3 class="text-lg font-bold text-white mb-2">{{ $plan->name }}</h3>
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl font-black text-white">Rp {{ number_format($plan->price / 1000, 0) }}k</span>
                                <span class="text-gray-500 text-sm">/month</span>
                            </div>
                        </div>
                        
                        <div class="space-y-4 mb-8 flex-grow">
                            <div class="flex items-center justify-between text-sm text-gray-400 border-b border-white/5 pb-2">
                                <span>Memory</span>
                                <span class="text-white font-medium">{{ $plan->ram }} MB</span>
                            </div>
                             <div class="flex items-center justify-between text-sm text-gray-400 border-b border-white/5 pb-2">
                                <span>CPU Core</span>
                                <span class="text-white font-medium">{{ $plan->cpu }}%</span>
                            </div>
                             <div class="flex items-center justify-between text-sm text-gray-400 border-b border-white/5 pb-2">
                                <span>Disk Space</span>
                                <span class="text-white font-medium">{{ $plan->disk }} MB</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('dashboard') }}" class="w-full block text-center py-3 rounded-xl border border-white/20 text-white font-bold text-sm hover:bg-white hover:text-gray-900 transition-colors">
                            Deploy Now
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                         <p class="text-gray-500">No hosting plans available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section id="products" class="py-32 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-16">
                <div>
                   <h2 class="text-4xl font-bold mb-4">Latest Products</h2>
                   <p class="text-gray-400">Script, Source Code, and Tools.</p>
                </div>
                <a href="{{ route('dashboard') }}" class="hidden md:flex items-center gap-2 text-sm font-bold text-blue-400 hover:text-blue-300 transition-colors">
                    View All
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($products as $product)
                    <div class="glass-card rounded-2xl overflow-hidden group">
                        <div class="aspect-video bg-gray-800 relative overflow-hidden">
                             @php
                                $imageUrl = Str::startsWith($product->image_url, 'http') ? $product->image_url : asset('storage/' . $product->image_url);
                            @endphp
                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-white text-gray-900 px-6 py-2 rounded-full font-bold text-sm transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="text-xs font-bold text-blue-400 mb-2 uppercase tracking-wider">{{ $product->category->name ?? 'Digital' }}</div>
                            <h3 class="font-bold text-white text-lg mb-2 leading-tight">{{ $product->name }}</h3>
                            <p class="text-xl font-black text-gray-300">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @empty
                     <div class="col-span-full text-center py-12">
                         <p class="text-gray-500">No products available.</p>
                    </div>
                @endforelse
            </div>
             <div class="mt-12 text-center md:hidden">
                <a href="{{ route('dashboard') }}" class="glass-btn px-8 py-3 rounded-full font-bold text-sm inline-block">View All Products</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="glass-panel border-t border-white/5 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-2">
                    <a href="#" class="text-2xl font-black tracking-tighter text-white block mb-6">
                        {{ config('app.name', 'Zizz Shop') }}
                    </a>
                    <p class="text-gray-400 max-w-sm mb-6">
                        Providing the best digital products and hosting services to help you build your dream project.
                    </p>
                    <div class="flex gap-4">
                        @if($settings->support_instagram_url)
                            <a href="{{ $settings->support_instagram_url }}" class="w-10 h-10 rounded-full glass-btn flex items-center justify-center hover:bg-white hover:text-black hover:border-white">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            </a>
                        @endif
                         @if($settings->support_whatsapp_number)
                            <a href="https://wa.me/{{ $settings->support_whatsapp_number }}" target="_blank" class="w-10 h-10 rounded-full glass-btn flex items-center justify-center hover:bg-green-500 hover:text-white hover:border-green-500">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.592 2.654-.696c1.029.662 1.977 1.216 3.248 1.216 3.181 0 5.768-2.587 5.768-5.766a5.772 5.772 0 00-5.768-5.768zm-9.2 6.17c0-4.935 3.996-8.991 8.93-8.991 4.934 0 8.93 4.056 8.93 8.991 0 4.935-3.996 8.99 8.93 8.99-1.63 0-3.136-.454-4.41-1.235l-4.755 1.248 1.274-4.636c-.96-1.428-1.528-3.13-1.528-4.967z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
                <div>
                     <h4 class="font-bold text-white mb-4">Navigation</h4>
                     <ul class="space-y-2 text-sm text-gray-400">
                         <li><a href="#home" class="hover:text-white transition-colors">Home</a></li>
                         <li><a href="#about" class="hover:text-white transition-colors">About Us</a></li>
                         <li><a href="#pterodactyl-plans" class="hover:text-white transition-colors">Hosting</a></li>
                         <li><a href="#products" class="hover:text-white transition-colors">Products</a></li>
                     </ul>
                </div>
                <div>
                     <h4 class="font-bold text-white mb-4">Support</h4>
                     <ul class="space-y-2 text-sm text-gray-400">
                         <li><a href="#" class="hover:text-white transition-colors">Contact Support</a></li>
                         <li><a href="#" class="hover:text-white transition-colors">Terms of Service</a></li>
                         <li><a href="#" class="hover:text-white transition-colors">Privacy Policy</a></li>
                         @if($settings->support_email)
                            <li><a href="mailto:{{ $settings->support_email }}" class="text-blue-400 hover:text-blue-300">{{ $settings->support_email }}</a></li>
                         @endif
                     </ul>
                </div>
            </div>
            <div class="border-t border-white/5 pt-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'Zizz Shop') }}. All rights reserved.</p>
                <p>Made with ❤️ for Gamers & Developers.</p>
            </div>
        </div>
    </footer>
</body>
</html>
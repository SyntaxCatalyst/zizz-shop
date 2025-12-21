<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Orders -->
        <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-purple-500/20 rounded-full blur-xl group-hover:bg-purple-500/30 transition-all duration-300"></div>
            <div class="relative z-10">
                <p class="text-sm font-medium text-purple-300 mb-1">Total Orders</p>
                <h3 class="text-3xl font-black text-white">{{ $stats['total_orders'] }}</h3>
            </div>
            <div class="mt-4 flex items-center text-xs text-gray-400">
                <span class="text-purple-400 font-bold mr-1">{{ $stats['pending_orders'] }}</span> pending
            </div>
        </div>

        <!-- Total Spent -->
        <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-blue-500/20 rounded-full blur-xl group-hover:bg-blue-500/30 transition-all duration-300"></div>
            <div class="relative z-10">
                <p class="text-sm font-medium text-blue-300 mb-1">Total Spent</p>
                <h3 class="text-3xl font-black text-white">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</h3>
            </div>
            <div class="mt-4 text-xs text-gray-400">
                Lifetime value
            </div>
        </div>

        <!-- Active Services (Placeholder) -->
        <div class="glass-panel p-6 rounded-2xl relative overflow-hidden group">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-cyan-500/20 rounded-full blur-xl group-hover:bg-cyan-500/30 transition-all duration-300"></div>
            <div class="relative z-10">
                <p class="text-sm font-medium text-cyan-300 mb-1">Current Balance</p>
                <h3 class="text-3xl font-black text-white">Rp 0</h3>
            </div>
            <div class="mt-4" >
               <a href="#" class="text-xs text-cyan-400 hover:text-cyan-300 flex items-center gap-1">
                   Top Up Balance <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
               </a>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="mb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-white">Produk Unggulan</h2>
            <a href="#" class="text-sm text-purple-400 hover:text-purple-300">Lihat Semua →</a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($products as $product)
                <div class="group glass-card rounded-3xl overflow-hidden relative">
                    <!-- Image -->
                    <div class="relative h-48 overflow-hidden cursor-pointer" onclick="openImageModal('{{ $product->id }}')">
                        @php
                            $imageUrl = Str::startsWith($product->image_url, 'http') 
                                ? $product->image_url 
                                : asset('storage/' . $product->image_url);
                        @endphp
                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" id="product-image-{{ $product->id }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-60"></div>
                        
                        <!-- Category Badge -->
                        <div class="absolute top-4 right-4">
                            <span class="px-3 py-1 bg-black/50 backdrop-blur-md rounded-full text-xs font-bold text-white border border-white/10">
                                {{ $product->category->name ?? 'Digital' }}
                            </span>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-white mb-2 line-clamp-1 group-hover:text-purple-400 transition-colors">
                            {{ $product->name }}
                        </h3>
                        
                        <div class="text-sm text-gray-400 mb-4 line-clamp-2 min-h-[2.5em]">
                             {!! strip_tags($product->description) !!}
                        </div>
                        
                        <div class="flex items-end justify-between">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">Harga</p>
                                <p class="text-xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                            </div>
                            
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-600 to-blue-600 flex items-center justify-center text-white shadow-lg shadow-purple-500/20 hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-gray-400 glass-panel rounded-2xl">
                    Nothing here yet.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pterodactyl Plans -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-white mb-6">Pterodactyl Servers</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($pterodactylPlans as $plan)
                <div class="glass-panel p-1 rounded-[2rem] relative group">
                    <div class="absolute inset-0 bg-gradient-to-r from-cyan-500 to-blue-500 rounded-[2rem] opacity-0 group-hover:opacity-100 transition-opacity duration-300 blur-xl -z-10"></div>
                    
                    <div class="bg-gray-900/90 backdrop-blur-xl rounded-[1.9rem] p-8 h-full flex flex-col relative overflow-hidden">
                        <!-- Decorative Header -->
                        <div class="absolute top-0 right-0 w-32 h-32 bg-cyan-500/10 rounded-full blur-2xl -mr-16 -mt-16"></div>
                        
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $plan->name }}</h3>
                            <div class="flex items-baseline gap-1">
                                <span class="text-3xl font-black text-cyan-400">Rp {{ number_format($plan->price, 0, ',', '.') }}</span>
                                <span class="text-sm text-gray-500">/bulan</span>
                            </div>
                        </div>
                        
                        <ul class="space-y-4 mb-8 flex-grow">
                            <li class="flex items-center gap-3 text-gray-300 text-sm">
                                <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-cyan-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <span class="font-bold text-white">{{ $plan->ram }} MB</span> RAM
                            </li>
                            <li class="flex items-center gap-3 text-gray-300 text-sm">
                                <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-blue-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                                </div>
                                <span class="font-bold text-white">{{ $plan->disk }} MB</span> Storage
                            </li>
                            <li class="flex items-center gap-3 text-gray-300 text-sm">
                                <div class="w-8 h-8 rounded-full bg-gray-800 flex items-center justify-center text-purple-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                                </div>
                                <span class="font-bold text-white">{{ $plan->cpu }}%</span> CPU
                            </li>
                        </ul>
                        
                        <form action="{{ route('pterodactyl.order.process') }}" method="POST" class="mt-auto">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                            <div class="mb-4">
                                <input type="text" name="panel_username" placeholder="Desired Username" class="w-full bg-gray-800 border border-gray-700 text-white text-sm rounded-xl px-4 py-3 focus:ring-cyan-500 focus:border-cyan-500 outline-none transition-colors" required>
                            </div>
                            <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 rounded-xl text-white font-bold shadow-lg shadow-cyan-500/25 transition-all transform hover:scale-[1.02]">
                                Deploy Server
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-gray-400 glass-panel rounded-2xl">
                    No server plans available.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="absolute inset-0 bg-black/90 backdrop-blur-sm transition-opacity" onclick="closeImageModal()"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4"  onclick="closeImageModal()">
            <div class="relative max-w-4xl w-full max-h-[90vh] flex flex-col items-center">
                 <button onclick="closeImageModal()" class="absolute -top-12 right-0 text-white/50 hover:text-white transition-colors">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <img id="modalImage" src="" alt="" class="rounded-2xl shadow-2xl max-w-full max-h-full object-contain ring-1 ring-white/10" onclick="event.stopPropagation()">
            </div>
        </div>
    </div>

    <script>
        function openImageModal(productId) {
            const originalImage = document.getElementById('product-image-' + productId);
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            
            if (originalImage && modal && modalImage) {
                // Preload high-res if available
                modalImage.src = originalImage.src; 
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                
                // Animate entry
                modalImage.style.transform = 'scale(0.95)';
                modalImage.style.opacity = '0';
                setTimeout(() => {
                    modalImage.style.transition = 'all 0.3s cubic-bezier(0.16, 1, 0.3, 1)';
                    modalImage.style.transform = 'scale(1)';
                    modalImage.style.opacity = '1';
                }, 10);
            }
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
             if (modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
             }
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') closeImageModal();
        });
    </script>
</x-app-layout>
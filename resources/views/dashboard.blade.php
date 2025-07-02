<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <x-alert type="success" message="You're logged in!" timeout="3000"/>


{{-- Section Produk Biasa --}}
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h2 class="text-2xl font-semibold mb-6">Produk Kami</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                @forelse ($products as $product)
                    <div class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl overflow-hidden transform hover:scale-[1.02] transition-all duration-300 border border-gray-200 dark:border-gray-700 max-w-sm mx-auto">
                        {{-- Image Container dengan ukuran tetap --}}
                        <div class="relative w-full h-52 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 overflow-hidden cursor-pointer" onclick="openImageModal('{{ $product->id }}')">
                            @php
                                $imageUrl = Str::startsWith($product->image_url, 'http') 
                                    ? $product->image_url 
                                    : asset('storage/' . $product->image_url);
                            @endphp
                            <img src="{{ $imageUrl }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                 id="product-image-{{ $product->id }}">
                            
                            {{-- Overlay untuk hover effect --}}
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-opacity duration-300 flex items-center justify-center">
                                <div class="text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Content Container --}}
                        <div class="p-5 flex flex-col h-auto space-y-3">
                            {{-- Product Name --}}
                            <h3 class="font-bold text-lg text-gray-900 dark:text-white truncate group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors duration-200" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h3>
                            
                            {{-- Category --}}
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                    {{ $product->category->name ?? 'Umum' }}
                                </span>
                            </div>
                            
                            {{-- Description --}}
                            @if($product->description)
                                <div class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed overflow-hidden description-container" 
                                     style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;" 
                                     title="{{ strip_tags($product->description) }}">
                                    <div class="prose-reset">
                                        {!! $product->description !!}
                                    </div>
                                </div>
                            @endif
                            
                            {{-- Price --}}
                            <div class="flex items-center justify-between pt-2 border-t border-gray-200 dark:border-gray-600">
                                <div>
                                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                            
                            {{-- Add to Cart Button --}}
                            <div class="pt-3">
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold py-3 px-4 rounded-lg transform hover:scale-[1.02] transition-all duration-200 shadow-md hover:shadow-lg flex items-center justify-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0L4 5M7 13h10m0 0l1.5 6H7"></path>
                                        </svg>
                                        <span>Tambah ke Keranjang</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p>Belum ada produk yang tersedia saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Modal untuk Image Popup --}}
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-4xl max-h-full">
        {{-- Close Button --}}
        <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white text-2xl hover:text-gray-300 z-10">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        {{-- Image Container --}}
        <div class="bg-white rounded-lg overflow-hidden" onclick="event.stopPropagation()">
            <img id="modalImage" src="" alt="" class="max-w-full max-h-[80vh] object-contain">
        </div>
    </div>
</div>

        {{-- ========================================================== --}}
        {{-- SECTION BARU UNTUK PANEL PTERODACTYL --}}
        {{-- ========================================================== --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-semibold mb-6">Beli Panel Pterodactyl</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($pterodactylPlans as $plan)
                            <div class="bg-gray-100 dark:bg-gray-900 rounded-lg shadow-md p-6 flex flex-col">
                                <h3 class="text-xl font-bold text-indigo-500">{{ $plan->name }}</h3>
                                <p class="text-3xl font-extrabold text-gray-800 dark:text-white my-4">Rp{{ number_format($plan->price, 0, ',', '.') }}<span class="text-base font-medium text-gray-500">/bulan</span></p>
                                <ul class="space-y-2 text-gray-600 dark:text-gray-400 mb-6 flex-grow">
                                    <li class="flex items-center"><svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"></path></svg>RAM: {{ $plan->ram }} MB</li>
                                    <li class="flex items-center"><svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"></path></svg>Disk: {{ $plan->disk }} MB</li>
                                    <li class="flex items-center"><svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"></path></svg>CPU: {{ $plan->cpu }}%</li>
                                </ul>
                                <form action="{{ route('pterodactyl.order.process') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                    <div class="mb-4">
                                        <label for="panel_username_{{ $plan->id }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Username Panel</label>
                                        <input type="text" name="panel_username" id="panel_username_{{ $plan->id }}" class="mt-1 block w-full bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-700 rounded-md shadow-sm" required>
                                    </div>
                                    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg font-bold hover:bg-indigo-700 transition-colors">
                                        Pesan Sekarang
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-12">
                                <p>Belum ada paket panel yang tersedia saat ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <script>
function openImageModal(productId) {
    const originalImage = document.getElementById('product-image-' + productId);
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    
    modalImage.src = originalImage.src;
    modalImage.alt = originalImage.alt;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden'; // Prevent scrolling
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto'; // Restore scrolling
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeImageModal();
    }
});
</script>

<style>
/* Reset styling untuk HTML tags dalam description */
.description-container .prose-reset p {
    margin: 0 !important;
    padding: 0 !important;
    font-size: inherit !important;
    line-height: inherit !important;
    color: inherit !important;
}

.description-container .prose-reset * {
    margin: 0 !important;
    padding: 0 !important;
    font-size: inherit !important;
    line-height: inherit !important;
    color: inherit !important;
}
</style>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-panel rounded-3xl overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">
                    <!-- Product Image -->
                    <div class="relative h-96 md:h-[500px] rounded-2xl overflow-hidden group">
                        @php
                            $imageUrl = Str::startsWith($product->image_url, 'http') 
                                ? $product->image_url 
                                : asset('storage/' . $product->image_url);
                        @endphp
                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent opacity-60"></div>
                        
                        <div class="absolute top-4 left-4">
                            <span class="px-4 py-2 bg-black/50 backdrop-blur-md rounded-full text-sm font-bold text-white border border-white/10">
                                {{ $product->category->name ?? 'Digital Product' }}
                            </span>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="flex flex-col justify-center space-y-6">
                        <div>
                            <h1 class="text-4xl font-black text-white mb-2">{{ $product->name }}</h1>
                            <div class="flex items-center gap-2 mb-4">
                                <span class="bg-green-500/20 text-green-400 text-xs px-2 py-1 rounded-full border border-green-500/20 font-bold">In Stock</span>
                                <span class="bg-blue-500/20 text-blue-400 text-xs px-2 py-1 rounded-full border border-blue-500/20 font-bold">Instant Delivery</span>
                            </div>
                            <p class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        <div class="text-gray-300 leading-relaxed space-y-4">
                            <div class="prose prose-invert max-w-none">
                                {!! $product->description !!}
                            </div>
                        </div>

                        <div class="pt-8 border-t border-gray-700/50">
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <div class="flex items-center gap-4">
                                    <button type="submit" class="flex-1 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-500 hover:to-blue-500 text-white font-bold py-4 px-8 rounded-xl shadow-lg shadow-purple-500/25 transform hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6M7 13l-1.5-6m0 0L4 5M7 13h10m0 0l1.5 6H7"></path></svg>
                                        Add to Cart
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 pt-6">
                            <div class="flex items-center gap-3 text-gray-400 text-sm">
                                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                Secure Payment
                            </div>
                             <div class="flex items-center gap-3 text-gray-400 text-sm">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Fast Process
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-white mb-8">Related Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($relatedProducts as $related)
                        <a href="{{ route('products.show', $related) }}" class="group glass-card rounded-2xl overflow-hidden block">
                            <div class="relative h-40 overflow-hidden">
                                @php
                                    $img = Str::startsWith($related->image_url, 'http') ? $related->image_url : asset('storage/' . $related->image_url);
                                @endphp
                                <img src="{{ $img }}" alt="{{ $related->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-white mb-1 truncate">{{ $related->name }}</h3>
                                <p class="text-purple-400 font-bold">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>

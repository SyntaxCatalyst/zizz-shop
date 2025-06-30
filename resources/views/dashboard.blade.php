<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        {{-- Pesan Selamat Datang --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>

        {{-- Section Produk Biasa --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h2 class="text-2xl font-semibold mb-6">Produk Kami</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @forelse ($products as $product)
                            <div class="bg-gray-100 dark:bg-gray-900 rounded-lg shadow-md overflow-hidden transform hover:scale-105 transition-transform duration-300">
                                <div class="aspect-video bg-gray-700 dark:bg-gray-800">
                                    @php
                                        $imageUrl = Str::startsWith($product->image_url, 'http') 
                                            ? $product->image_url 
                                            : asset('storage/' . $product->image_url);
                                    @endphp
                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="p-4 flex flex-col flex-grow">
                                    <h3 class="font-bold text-lg truncate">{{ $product->name }}</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $product->category->name ?? '-' }}</p>
                                    <p class="text-lg font-semibold text-indigo-600 dark:text-indigo-400 mt-2">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                    <div class="mt-auto pt-4">
                                        <form action="{{ route('cart.add', $product) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition-colors">
                                                Tambah ke Keranjang
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
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Keranjang Belanja') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="mb-4 bg-green-500/20 text-green-500 p-3 rounded-lg">{{ session('success') }}</div>
                    @endif

                    @if (Cart::count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full table-auto">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 text-left">Produk</th>
                                        <th class="px-4 py-2">Jumlah</th>
                                        <th class="px-4 py-2 text-right">Harga</th>
                                        <th class="px-4 py-2 text-right">Subtotal</th>
                                        <th class="px-4 py-2"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::content() as $item)
                                        <tr class="border-t border-gray-200 dark:border-gray-700">
                                            <td class="px-4 py-2">
                                                <div class="flex items-center">
                                                    {{-- BLOK GAMBAR YANG SUDAH DIPERBAIKI --}}
                                                    @php
                                                        $imageUrl = Str::startsWith($item->options->image_url, 'http')
                                                            ? $item->options->image_url
                                                            : asset('storage/' . $item->options->image_url);
                                                    @endphp
                                                    <img src="{{ $imageUrl }}" class="w-16 h-16 mr-4 rounded object-cover flex-shrink-0">
                                                    
                                                    <span class="font-medium">{{ $item->name }}</span>
                                                </div>
                                            </td>
                                            <td class="px-4 py-2 text-center">
                                                <form action="{{ route('cart.update', $item->rowId) }}" method="POST">
                                                    @csrf
                                                    <input type="number" name="quantity" value="{{ $item->qty }}" min="1" class="w-20 text-center rounded bg-gray-100 dark:bg-gray-900 border-gray-300 dark:border-gray-700">
                                                    {{-- Anda bisa menambahkan tombol submit kecil di sini jika mau --}}
                                                </form>
                                            </td>
                                            <td class="px-4 py-2 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td class="px-4 py-2 text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                            <td class="px-4 py-2 text-center">
                                                <a href="{{ route('cart.remove', $item->rowId) }}" class="text-red-500 hover:text-red-700 font-semibold">Hapus</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-8 flex justify-between items-center flex-wrap gap-4">
                            {{-- TOMBOL KEMBALI BARU --}}
                            <a href="{{ route('home') }}" class="inline-flex items-center text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                  <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                </svg>
                                Kembali Belanja
                            </a>

                            <div class="text-right">
                                <p class="text-xl font-bold">Total: <span class="text-indigo-600 dark:text-indigo-400">Rp {{ Cart::total(0, ',', '.') }}</span></p>
                                <form action="{{ route('checkout.process') }}" method="POST" class="mt-2">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white py-2 px-6 rounded-lg font-bold hover:bg-green-700 transition-colors">
                                        Lanjutkan ke Checkout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-16">
                            <p class="text-xl mb-4">Keranjang Anda kosong.</p>
                            <a href="{{ route('dashboard') }}" class="bg-indigo-600 text-white py-2 px-6 rounded-lg font-bold hover:bg-indigo-700 transition-colors">
                                Mulai Belanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
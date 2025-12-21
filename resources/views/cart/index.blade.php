<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-panel rounded-3xl overflow-hidden p-8">
                @if (session('success'))
                    <div class="mb-6 bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-xl flex items-center gap-3">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if (Cart::count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-gray-400 border-b border-gray-700/50 text-sm uppercase tracking-wider">
                                    <th class="px-4 py-4 font-semibold">Product</th>
                                    <th class="px-4 py-4 font-semibold text-center">Quantity</th>
                                    <th class="px-4 py-4 font-semibold text-right">Price</th>
                                    <th class="px-4 py-4 font-semibold text-right">Total</th>
                                    <th class="px-4 py-4"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700/50">
                                @foreach (Cart::content() as $item)
                                    <tr class="group hover:bg-white/5 transition-colors">
                                        <td class="px-4 py-6">
                                            <div class="flex items-center gap-4">
                                                @php
                                                    $imageUrl = Str::startsWith($item->options->image_url, 'http')
                                                        ? $item->options->image_url
                                                        : asset('storage/' . $item->options->image_url);
                                                @endphp
                                                <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-800 flex-shrink-0 border border-gray-700">
                                                    <img src="{{ $imageUrl }}" class="w-full h-full object-cover">
                                                </div>
                                                <div>
                                                    <h3 class="font-bold text-white text-lg">{{ $item->name }}</h3>
                                                    <!-- Optional: Category or other details if available in options -->
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-6">
                                            <form action="{{ route('cart.update', $item->rowId) }}" method="POST" class="flex justify-center">
                                                @csrf
                                                <div class="relative flex items-center max-w-[8rem]">
                                                    <input type="number" name="quantity" value="{{ $item->qty }}" min="1" 
                                                           class="bg-gray-900 border border-gray-700 text-gray-100 text-center text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5" 
                                                           onchange="this.form.submit()">
                                                </div>
                                            </form>
                                        </td>
                                        <td class="px-4 py-6 text-right font-medium text-gray-300">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-6 text-right font-bold text-white">
                                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-6 text-right">
                                            <a href="{{ route('cart.remove', $item->rowId) }}" class="text-gray-500 hover:text-red-400 transition-colors p-2 rounded-full hover:bg-white/5 inline-block">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-8 border-t border-gray-700/50 pt-8 flex flex-col md:flex-row justify-between items-center gap-6">
                        <a href="{{ route('home') }}" class="text-gray-400 hover:text-white flex items-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Continue Shopping
                        </a>

                        <div class="glass-card p-6 rounded-2xl w-full md:w-auto min-w-[300px]">
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-gray-400">Total Amount</span>
                                <span class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400">
                                    Rp {{ Cart::total(0, ',', '.') }}
                                </span>
                            </div>
                            
                            <form action="{{ route('checkout.process') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-400 hover:to-emerald-500 text-white font-bold py-3 px-6 rounded-xl shadow-lg shadow-green-500/20 transform hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2">
                                    Proceed to Checkout
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="text-center py-20 flex flex-col items-center justify-center">
                        <div class="w-24 h-24 bg-gray-800 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M8 11v6h8v-6M8 11H6a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2h-2"></path></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Your Cart is Empty</h3>
                        <p class="text-gray-400 mb-8 max-w-sm">Looks like you haven't added anything to your cart yet.</p>
                        <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all hover:scale-105">
                            Browse Products
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
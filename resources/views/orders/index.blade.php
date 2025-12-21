<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-panel rounded-3xl overflow-hidden p-8">
                
                @if(request()->get('error') === 'ptero_failed')
                    <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl flex items-center gap-3">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div>
                            <p class="font-bold">Setup Failed</p>
                            <p class="text-sm">Automatic server setup failed. Please contact support.</p>
                        </div>
                    </div>
                @endif
                
                @if(session('success'))
                    <div class="mb-6 bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-xl flex items-center gap-3">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="space-y-6">
                    @forelse ($orders as $order)
                        <div class="glass-card rounded-2xl p-6 transition-all duration-300 hover:bg-white/5 border border-white/5">
                            <!-- Header -->
                            <div class="flex flex-wrap justify-between items-start gap-4 mb-6">
                                <div>
                                    <div class="flex items-center gap-3 mb-1">
                                        <h3 class="font-bold text-white text-lg">Order #{{ $order->order_number }}</h3>
                                        @php
                                            $statusColors = match($order->status) {
                                                'pending' => 'bg-yellow-500/10 text-yellow-400 border-yellow-500/20',
                                                'processing', 'paid' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                                'completed' => 'bg-green-500/10 text-green-400 border-green-500/20',
                                                'failed', 'canceled' => 'bg-red-500/10 text-red-400 border-red-500/20',
                                                default => 'bg-gray-500/10 text-gray-400 border-gray-500/20',
                                            };
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusColors }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-400">{{ $order->created_at->format('d F Y, H:i') }}</p>
                                </div>
                                
                                <div class="flex items-center gap-3">
                                    @if($order->status === 'pending')
                                        <a href="{{ route('checkout.payment', $order) }}" class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-400 hover:to-emerald-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-green-500/20 transition-all hover:scale-105">
                                            Pay Now
                                        </a>
                                        <form action="{{ route('checkout.cancel', $order) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            <button type="submit" class="px-4 py-2 bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/20 text-sm font-bold rounded-xl transition-colors">
                                                Cancel
                                            </button>
                                        </form>
                                    @elseif($order->status === 'completed' && isset($order->payment_details['metadata']['is_pterodactyl_order']))
                                         <a href="{{ route('orders.panel-details', $order) }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-500/20 transition-all hover:scale-105">
                                            View Server Details
                                        </a>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Items -->
                            <div class="border-t border-gray-700/50 pt-4">
                                @if(isset($order->payment_details['metadata']['is_pterodactyl_order']))
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-lg bg-gray-800 flex items-center justify-center text-cyan-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                                        </div>
                                        <div>
                                            <p class="font-bold text-white">{{ $order->payment_details['metadata']['plan_name'] ?? 'Pterodactyl Server' }}</p>
                                            <p class="text-sm text-gray-400">Cloud Hosting Service</p>
                                        </div>
                                    </div>
                                @else
                                    @foreach ($order->items as $item)
                                        <div class="flex justify-between items-center py-2 last:pb-0">
                                            <div class="flex items-center gap-3">
                                                 <div class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center text-purple-400">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M8 11v6h8v-6M8 11H6a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2h-2"></path></svg>
                                                </div>
                                                <div>
                                                    <p class="text-white font-medium">{{ $item->product->name }}</p>
                                                    <p class="text-xs text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                                </div>
                                            </div>
                                            <p class="text-gray-300 font-medium">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <!-- Footer -->
                            <div class="mt-4 pt-4 border-t border-gray-700/50 flex justify-between items-center">
                                <span class="text-sm text-gray-400">Total Payment</span>
                                <span class="text-xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20">
                            <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-white mb-2">No Orders Yet</h3>
                            <p class="text-gray-400 mb-6">You haven't placed any orders yet.</p>
                            <a href="{{ route('dashboard') }}" class="inline-block px-6 py-3 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                                Start Shopping
                            </a>
                        </div>
                    @endforelse
                </div>
                
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
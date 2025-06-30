<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Riwayat Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    {{-- Menampilkan pesan error jika pembuatan panel gagal --}}
                    @if(request()->get('error') === 'ptero_failed')
                        <div class="mb-4 bg-red-500/20 text-red-400 p-4 rounded-lg">
                            <p class="font-bold">Terjadi Kesalahan</p>
                            <p class="text-sm">Gagal membuat server panel secara otomatis. Silakan hubungi admin untuk bantuan.</p>
                        </div>
                    @endif

                    @forelse ($orders as $order)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 mb-4">
                            <div class="flex flex-wrap justify-between items-center gap-2">
                                <div>
                                    <p class="font-bold">Order #{{ $order->order_number }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->created_at->format('d F Y H:i') }}</p>
                                </div>
                                <div>
                                    @php
                                        $statusClass = match($order->status) {
                                            'pending' => 'bg-yellow-500/20 text-yellow-400',
                                            'processing' => 'bg-blue-500/20 text-blue-400',
                                            'completed' => 'bg-green-500/20 text-green-400',
                                            'failed' => 'bg-red-500/20 text-red-400',
                                            default => 'bg-gray-500/20 text-gray-400',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 text-sm rounded-full {{ $statusClass }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                                
                                {{-- LOGIKA UNTUK MEMBEDAKAN TAMPILAN ORDER --}}
                                @if(isset($order->payment_details['metadata']['is_pterodactyl_order']))
                                    {{-- TAMPILAN UNTUK ORDER PANEL PTERODACTYL --}}
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="font-semibold">{{ $order->payment_details['metadata']['plan_name'] ?? 'Paket Panel' }}</p>
                                            <p class="text-sm text-gray-500">Layanan Pterodactyl Panel</p>
                                        </div>
                                        <div>
                                            @if($order->status === 'completed')
                                                <a href="{{ route('orders.panel-details', $order) }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition-colors">
                                                    Lihat Detail Panel
                                                </a>
                                            @elseif($order->status === 'failed')
                                                <span class="px-4 py-2 rounded-lg text-sm font-semibold bg-red-500/20 text-red-400">Pembuatan Gagal</span>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    {{-- TAMPILAN UNTUK ORDER PRODUK BIASA --}}
                                    @foreach ($order->items as $item)
                                        <div class="flex justify-between items-center text-sm mb-2">
                                            <p>{{ $item->product->name }} ({{ $item->quantity }}x)</p>
                                            <p>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                        </div>
                                    @endforeach
                                @endif

                                <div class="flex justify-between items-center font-bold text-base mt-3 border-t border-gray-200 dark:border-gray-700 pt-2">
                                    <p>Total</p>
                                    <p>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center py-8">Anda belum memiliki riwayat pesanan.</p>
                    @endforelse

                    {{-- Link untuk pagination jika ada --}}
                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
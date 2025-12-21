<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-white leading-tight">
            {{ __('Complete Payment') }}
        </h2>
    </x-slot>

    <div class="py-12 flex justify-center">
        <div x-data="paymentGateway('{{ $order->payment_details['expirationTime'] ?? now()->addMinutes(10)->toIso8601String() }}', '{{ route('checkout.status', $order) }}')"
             x-init="startTimer(); startPolling();"
             class="w-full max-w-md">
            
            <div class="glass-panel rounded-3xl overflow-hidden p-8 relative">
                <!-- Decorative Glow -->
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-32 bg-purple-500/20 rounded-full blur-3xl pointer-events-none"></div>

                <div x-show="!paymentSuccess && !paymentExpired" class="relative z-10">
                    <div class="text-center mb-8">
                        <h2 class="text-2xl font-bold text-white mb-2">Scan QRIS</h2>
                        <p class="text-gray-400">Complete payment within</p>
                        <div class="mt-2 inline-block px-4 py-1 bg-red-500/10 border border-red-500/20 rounded-full">
                            <span x-text="timer.display" class="font-mono font-bold text-red-400 text-lg">10:00</span>
                        </div>
                    </div>

                    <!-- QR Code Area -->
                    <div class="bg-white p-6 rounded-2xl shadow-xl mb-6 mx-auto max-w-[280px]">
                        @if(isset($order->payment_details['qrImageUrl']))
                            <img src="{{ $order->payment_details['qrImageUrl'] }}" alt="QRIS Code" class="w-full aspect-square object-contain">
                        @else
                            <div class="w-full aspect-square flex items-center justify-center text-red-500 text-center text-sm">
                                Failed to load QR Code
                            </div>
                        @endif
                         <div class="mt-3 flex justify-between items-center border-t pt-3">
                             <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/Logo_Qris.svg/1200px-Logo_Qris.svg.png" class="h-6 opacity-80 decoration-slate-400 grayscale hover:grayscale-0 transition-all">
                             <span class="text-xs font-bold text-gray-500">NMD</span>
                         </div>
                    </div>

                    <!-- Support Note -->
                    <div class="bg-blue-500/5 border border-blue-500/10 rounded-xl p-4 text-center mb-6">
                        <p class="text-xs text-blue-200 mb-1">Need help or faster confirmation?</p>
                        <p class="text-sm font-bold text-blue-400">WhatsApp: {{ $settings->support_whatsapp_number }}</p>
                    </div>

                    <!-- Order Details -->
                    <div class="border-t border-dashed border-gray-700 pt-4 mb-6">
                        <div class="flex justify-between text-sm text-gray-400 mb-2">
                            <span>Order ID</span>
                            <span class="font-mono text-white">#{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400">Total Amount</span>
                            <span class="text-xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-blue-400">
                                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                            </span>
                        </div>
                         @if($settings->receipt_footer_text)
                            <p class="text-[10px] text-gray-600 mt-4 text-center">{{ $settings->receipt_footer_text }}</p>
                        @endif
                    </div>

                    <!-- Actions -->
                    <form action="{{ route('checkout.cancel', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-3 px-4 rounded-xl border border-gray-700 text-gray-400 text-sm font-semibold hover:bg-white/5 hover:text-white transition-all">
                            Cancel Order
                        </button>
                    </form>
                </div>

                <!-- Payment Success -->
                <div x-show="paymentSuccess" style="display: none;" class="text-center py-12 relative z-10">
                    <div class="w-20 h-20 bg-green-500/20 rounded-full flex items-center justify-center mx-auto mb-6 animate-pulse">
                        <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2">Payment Successful!</h2>
                    <p class="text-gray-400">Redirecting you to order details...</p>
                </div>

                <!-- Payment Expired -->
                <div x-show="paymentExpired" style="display: none;" class="text-center py-12 relative z-10">
                     <div class="w-20 h-20 bg-red-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2">Payment Expired</h2>
                    <p class="text-gray-400 mb-6">The payment window provided has elapsed.</p>
                    <a href="{{ route('home') }}" class="inline-block py-2 px-6 rounded-xl bg-gray-800 text-white font-medium hover:bg-gray-700 transition-colors">
                        Return to Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js Logic -->
    <script>
        function paymentGateway(expirationTime, statusUrl) {
            return {
                paymentSuccess: false,
                paymentExpired: false,
                pollingInterval: null,
                isProcessing: false,
                timer: {
                    interval: null,
                    expiry: new Date(expirationTime).getTime(),
                    display: '10:00'
                },
                startTimer() {
                    this.timer.interval = setInterval(() => {
                        const now = new Date().getTime();
                        const distance = this.timer.expiry - now;

                        if (distance < 0) {
                            clearInterval(this.timer.interval);
                            this.timer.display = '00:00';
                            this.paymentExpired = true;
                            if (this.pollingInterval) {
                                clearInterval(this.pollingInterval);
                                this.pollingInterval = null;
                            }
                            return;
                        }

                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        this.timer.display = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    }, 1000);
                },
                startPolling() {
                    this.pollingInterval = setInterval(() => {
                        if (this.isProcessing || this.paymentSuccess || this.paymentExpired) return;

                        this.isProcessing = true;

                        fetch(statusUrl)
                            .then(response => {
                                if (!response.ok) throw new Error('Network response was not ok');
                                return response.json();
                            })
                            .then(data => {
                                if (data.status === 'paid') {
                                    this.paymentSuccess = true;

                                    if (this.pollingInterval) clearInterval(this.pollingInterval);
                                    if (this.timer.interval) clearInterval(this.timer.interval);

                                    setTimeout(() => {
                                        window.location.href = data.redirect_url || '{{ route('orders.index') }}';
                                    }, 2000);
                                }
                            })
                            .catch(error => {
                                console.error('Polling Error:', error);
                            })
                            .finally(() => {
                                this.isProcessing = false;
                            });
                    }, 5000);
                }
            }
        }
    </script>
</x-app-layout>
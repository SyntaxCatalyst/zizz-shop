<x-guest-layout>
    <div x-data="paymentGateway('{{ $order->payment_details['expirationTime'] ?? now()->addMinutes(10)->toIso8601String() }}', '{{ route('checkout.status', $order) }}')"
         x-init="startTimer(); startPolling();"
         class="max-w-md mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg my-10">

        <div x-show="!paymentSuccess">
            <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-gray-100 mb-2">Selesaikan Pembayaran</h2>
            <p class="text-center text-gray-600 dark:text-gray-400 mb-6">Pindai QR Code di bawah ini dalam <span x-text="timer.display" class="font-bold text-red-500">10:00</span></p>

            <div class="text-center mb-4 p-4 bg-white rounded-lg">
                @if(isset($order->payment_details['qrImageUrl']))
                    <img src="{{ $order->payment_details['qrImageUrl'] }}" alt="QRIS Code" class="mx-auto">
                @else
                    <p class="text-red-500">Gagal memuat gambar QRIS.</p>
                @endif
            </div>

            <div class="border-t border-dashed border-gray-300 dark:border-gray-600 pt-4 mt-6">
                <h3 class="font-bold text-center mb-2 text-gray-700 dark:text-gray-300">STRUK PEMBELIAN</h3>
                <div class="space-y-1 text-sm text-gray-600 dark:text-gray-400">
                    <p class="flex justify-between"><span>ORDER ID:</span> <span class="font-mono">#{{ $order->order_number }}</span></p>
                    <p class="flex justify-between"><span>TOTAL:</span> <span class="font-bold text-base text-gray-800 dark:text-gray-200">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span></p>
                </div>
                @if($settings->receipt_footer_text)
                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-4 text-center">{{ $settings->receipt_footer_text }}</p>
                @endif
            </div>
        </div>

        <div x-show="paymentSuccess" style="display: none;" class="text-center py-8">
             <svg class="w-16 h-16 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h2 class="text-2xl font-bold text-green-500 mt-4">Pembayaran Berhasil!</h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Mengarahkan Anda ke WhatsApp...</p>
        </div>
    </div>

    <script>
        function paymentGateway(expirationTime, statusUrl) {
            return {
                paymentSuccess: false,
                pollingInterval: null,
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
                            this.timer.display = 'EXPIRED';
                            if(this.pollingInterval) clearInterval(this.pollingInterval);
                            return;
                        }
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        this.timer.display = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    }, 1000);
                },
                startPolling() {
                    this.pollingInterval = setInterval(() => {
                        fetch(statusUrl)
                            .then(response => {
                                if (!response.ok) throw new Error('Network response was not ok');
                                return response.json();
                            })
                            .then(data => {
                                if (data.status === 'paid') {
                                    this.paymentSuccess = true;
                                    clearInterval(this.pollingInterval);
                                    clearInterval(this.timer.interval);
                                    setTimeout(() => {
                                        window.location.href = data.redirect_url;
                                    }, 1500);
                                }
                            })
                            .catch(error => {
                                console.error('Polling Error:', error);
                            });
                    }, 5000);
                }
            }
        }
    </script>
</x-guest-layout>
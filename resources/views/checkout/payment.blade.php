<x-app-layout>
    <div x-data="paymentGateway('{{ $order->payment_details['expirationTime'] ?? now()->addMinutes(10)->toIso8601String() }}', '{{ route('checkout.status', $order) }}')"
        x-init="startTimer(); startPolling();"
        class="max-w-md mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg my-10">

        <div x-show="!paymentSuccess && !paymentExpired">
            <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-gray-100 mb-2">Selesaikan Pembayaran</h2>
            <p class="text-center text-gray-600 dark:text-gray-400 mb-6">
                Pindai QR Code di bawah ini dalam <span x-text="timer.display" class="font-bold text-red-500">10:00</span>
            </p>

            <div class="text-center mb-4 p-4 bg-white rounded-lg">
                @if(isset($order->payment_details['qrImageUrl']))
                <img src="{{ $order->payment_details['qrImageUrl'] }}" alt="QRIS Code" class="mx-auto">
                @else
                <p class="text-red-500">Gagal memuat gambar QRIS.</p>
                @endif
            </div>

            {{-- Tambahkan bagian ini --}}
            <div class="text-center text-sm text-gray-700 dark:text-gray-300 mt-4">
                <p><span class="font-semibold">Catatan:</span> Kirim bukti transfer beserta detail order (ORDER ID dan nominal) ke nomor berikut untuk mempercepat konfirmasi admin:</p>
                <p class="mt-1 font-bold text-blue-600 dark:text-blue-400">{{ $settings->support_whatsapp_number }}</p>
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

            {{-- Tombol Batal --}}
            <div class="mt-6 text-center">
                <form action="{{ route('checkout.cancel', $order) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Batal Pembelian
                    </button>
                </form>
            </div>
        </div>

        {{-- Pembayaran Berhasil --}}
        <div x-show="paymentSuccess" style="display: none;" class="text-center py-8">
            <svg class="w-16 h-16 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h2 class="text-2xl font-bold text-green-500 mt-4">Pembayaran Berhasil!</h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Mengarahkan Anda...</p>
        </div>

        {{-- Pembayaran Kadaluarsa --}}
        <div x-show="paymentExpired" style="display: none;" class="text-center py-8">
            <svg class="w-16 h-16 mx-auto text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h2 class="text-2xl font-bold text-red-500 mt-4">Pembayaran Kadaluarsa</h2>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Waktu pembayaran telah habis.</p>
            <a href="{{ route('home') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Kembali ke Beranda</a>
        </div>
    </div>

    {{-- Alpine.js Logic --}}
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
                            this.timer.display = 'EXPIRED';
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
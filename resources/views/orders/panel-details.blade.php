<x-app-layout>
    @php
        $serverDetails = $order->payment_details['server_details'] ?? [];
    @endphp
    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg my-10 text-white">
        <div class="text-center mb-8">
            <svg class="w-16 h-16 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h1 class="text-3xl font-bold text-green-400 mt-4">Pembelian Panel Berhasil!</h1>
            <p class="text-gray-400 mt-2">Simpan detail login Anda di tempat yang aman.</p>
        </div>

        <div class="space-y-4 bg-gray-900/50 p-6 rounded-lg">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-2">
                <span class="text-gray-400 whitespace-nowrap">Link Panel:</span>
                <a href="{{ $settings->pterodactyl_domain }}" target="_blank" class="font-mono text-blue-400 hover:underline break-all text-left md:text-right">{{ $settings->pterodactyl_domain }}</a>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-2">
                <span class="text-gray-400 whitespace-nowrap">Username:</span>
                <span class="font-mono break-all">{{ $serverDetails['username'] }}</span>
            </div>
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-2">
                <span class="text-gray-400 whitespace-nowrap">Password:</span>
                {{-- Kita gunakan Alpine.js untuk fitur copy-paste --}}
                <div x-data="{ password: '{{ $serverDetails['password'] }}', copied: false }" class="flex items-center space-x-2 w-full md:w-auto justify-between md:justify-end">
                    <span x-text="copied ? 'Tersalin!' : password" class="font-mono break-all"></span>
                    <button @click="navigator.clipboard.writeText(password); copied = true; setTimeout(() => copied = false, 2000)" title="Salin Password" class="shrink-0 ml-2">
                        <svg class="w-5 h-5 text-gray-400 hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    </button>
                </div>
            </div>
        </div>
         <div class="mt-8 text-center">
            <a href="{{ route('orders.index') }}" class="inline-block bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition-colors">
                Kembali ke Riwayat Order
            </a>
        </div>
    </div>
</x-app-layout>
<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-900 via-purple-900 to-gray-900 px-6">
        <div class="text-center text-white max-w-lg animate-fadeIn">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">🚧 Website Sedang Maintenance</h1>
            <p class="text-lg mb-6 text-gray-300">
                Kami sedang melakukan perbaikan sistem untuk memberikan layanan yang lebih baik.
                Silakan kembali beberapa saat lagi.
            </p>

            <div class="text-sm text-gray-400" id="clock"></div>
        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.8s ease-in-out both;
        }
    </style>

    <script>
        function updateClock() {
            const now = new Date();
            document.getElementById('clock').innerText =
                now.toLocaleString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</x-guest-layout>

<footer class="bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center text-gray-600 dark:text-gray-400">
        <p>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All Rights Reserved.</p>
        <div class="mt-4">
            <p class="font-semibold">Butuh Bantuan?</p>
            <a href="https://wa.me/{{ $settings->support_whatsapp_number }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                Hubungi CS via WhatsApp
            </a>
        </div>
    </div>
</footer>
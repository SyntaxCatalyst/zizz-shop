<footer class="glass-panel border-t border-white/5 mt-auto py-8 relative z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-center md:text-left">
                <p class="text-sm text-gray-500">&copy; {{ date('Y') }} <span class="font-bold text-gray-300">{{ config('app.name', 'Zizz Shop') }}</span>. All rights reserved.</p>
            </div>
            
            <div class="flex items-center gap-6">
                @if(isset($settings) && $settings->support_whatsapp_number)
                    <a href="https://wa.me/{{ $settings->support_whatsapp_number }}" target="_blank" class="text-sm text-gray-400 hover:text-green-400 flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.711 2.592 2.654-.696c1.029.662 1.977 1.216 3.248 1.216 3.181 0 5.768-2.587 5.768-5.766a5.772 5.772 0 00-5.768-5.768zm-9.2 6.17c0-4.935 3.996-8.991 8.93-8.991 4.934 0 8.93 4.056 8.93 8.991 0 4.935-3.996 8.99 8.93 8.99-1.63 0-3.136-.454-4.41-1.235l-4.755 1.248 1.274-4.636c-.96-1.428-1.528-3.13-1.528-4.967z"/></svg>
                        WhatsApp Support
                    </a>
                @endif
                <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Terms</a>
                <a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Privacy</a>
            </div>
        </div>
    </div>
</footer>
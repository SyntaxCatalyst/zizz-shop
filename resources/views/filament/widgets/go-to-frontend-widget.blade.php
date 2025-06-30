<x-filament::widget>
    {{-- Kita bungkus semuanya dengan link ke halaman utama --}}
    <a href="{{ route('home') }}" 
       target="_blank" 
       rel="noopener noreferrer"
       class="block transition-all duration-300 hover:scale-[1.02]">

        <x-filament::card>
            <div class="flex items-center space-x-4 rtl:space-x-reverse">
                {{-- Ikon --}}
                <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-lg bg-primary-500/10 text-primary-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </div>

                {{-- Teks --}}
                <div class="flex-1">
                    <h2 class="text-lg font-bold tracking-tight text-gray-950 dark:text-white">
                        Buka Halaman User
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Lihat tampilan depan website yang dilihat oleh pengunjung.
                    </p>
                </div>

                {{-- Tanda Panah di Kanan --}}
                <div>
                     <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </x-filament::card>
    </a>
</x-filament::widget>
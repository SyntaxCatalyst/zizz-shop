@props([
    'type' => 'success', // success, warning, danger, info
    'message' => '',
    'timeout' => 5000,
])

@php
    $config = [
        'success' => [
            'container' => 'bg-green-500 text-white',
            'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'button_hover' => 'hover:bg-green-600',
            'focus_ring' => 'focus:ring-green-400',
        ],
        'warning' => [
            'container' => 'bg-amber-400 text-amber-900',
            'icon' => 'M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z',
            'button_hover' => 'hover:bg-amber-500',
            'focus_ring' => 'focus:ring-amber-300',
        ],
        'danger' => [
            'container' => 'bg-red-500 text-white',
            'icon' => 'M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z',
            'button_hover' => 'hover:bg-red-600',
            'focus_ring' => 'focus:ring-red-400',
        ],
        'info' => [
            'container' => 'bg-blue-500 text-white',
            'icon' => 'M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z',
            'button_hover' => 'hover:bg-blue-600',
            'focus_ring' => 'focus:ring-blue-400',
        ],
    ];

    $current = $config[$type];
    $alertId = 'alert-' . uniqid();
@endphp

<div
    id="{{ $alertId }}"
    x-data="{ show: true }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform translate-y-2"
    x-transition:enter-end="opacity-100 transform translate-y-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform translate-y-0"
    x-transition:leave-end="opacity-0 transform translate-y-2"
    class="alert w-full max-w-sm rounded-lg shadow-lg p-4 flex items-center space-x-4 {{ $current['container'] }}"
    role="alert"
>
    <div class="flex-shrink-0">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $current['icon'] }}" />
        </svg>
    </div>

    <div class="flex-1 text-sm font-medium">
        {{ $message }}
    </div>

    <div class="flex-shrink-0">
        <button
            @click="show = false; setTimeout(() => $el.closest('.alert').remove(), 300)"
            type="button"
            class="p-1.5 rounded-full text-current transition-colors duration-200 {{ $current['button_hover'] }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-current {{ $current['focus_ring'] }}"
            aria-label="Tutup"
        >
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
</div>

@if($timeout > 0)
<script>
    // Skrip ini akan bekerja dengan baik karena dieksekusi setelah elemennya ada di DOM
    setTimeout(() => {
        const el = document.getElementById('{{ $alertId }}');
        // Kita cari tombol tutup di dalam elemen dan 'klik' secara programatik
        // untuk memicu transisi keluar dari Alpine.js dengan mulus.
        if (el) {
            el.querySelector('button[aria-label="Tutup"]')?.click();
        }
    }, {{ $timeout }});
</script>
@endif
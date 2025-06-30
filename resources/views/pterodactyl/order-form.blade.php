<x-guest-layout>
    <div class="container mx-auto px-6 py-12">
        <h1 class="text-3xl font-bold text-center text-white mb-8">Pilih Paket Panel Anda</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($plans as $plan)
                <div class="bg-slate-800 rounded-lg p-6 flex flex-col">
                    <h2 class="text-2xl font-bold text-white">{{ $plan->name }}</h2>
                    <p class="text-4xl font-extrabold text-blue-400 my-4">Rp{{ number_format($plan->price, 0, ',', '.') }}</p>
                    <ul class="space-y-2 text-slate-300 mb-6 flex-grow">
                        <li>RAM: {{ $plan->ram }} MB</li>
                        <li>Disk: {{ $plan->disk }} MB</li>
                        <li>CPU: {{ $plan->cpu }}%</li>
                    </ul>
                    <form action="{{ route('pterodactyl.order.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                        <div class="mb-4">
                            <label for="panel_username_{{ $plan->id }}" class="block text-sm font-medium text-slate-200">Username Panel</label>
                            <input type="text" name="panel_username" id="panel_username_{{ $plan->id }}" class="mt-1 block w-full bg-slate-900 border-slate-700 rounded-md shadow-sm" required>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold">Pesan Sekarang</button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</x-guest-layout>
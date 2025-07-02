<nav x-data="{ open: false }" class="glass-morphism sticky top-4 z-50 mx-auto mt-4 max-w-7xl rounded-2xl border border-cyan-500/20 bg-gradient-to-r from-gray-900/80 via-gray-800/80 to-purple-900/80 shadow-2xl backdrop-blur-xl">
    <!-- Animated gradient border -->
    <div class="absolute inset-0 rounded-2xl bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 opacity-20 blur-sm"></div>
    
    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('dashboard') }}" class="group">
                        <div class="relative">
                            <div class="absolute -inset-1 rounded-lg bg-gradient-to-r from-cyan-400 to-purple-600 opacity-75 blur transition duration-300 group-hover:opacity-100"></div>
                            <img class="relative block h-10 w-auto rounded-lg" src="https://files.catbox.moe/5z7z6d.png" alt="Logo">
                        </div>
                    </a>
                </div>

                <div class="hidden space-x-1 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" 
                        class="group relative px-4 py-2 text-sm font-medium transition-all duration-300 hover:text-cyan-300">
                        <span class="relative z-10">{{ __('Dashboard') }}</span>
                        <div class="absolute inset-0 scale-0 rounded-lg bg-gradient-to-r from-cyan-500/20 to-blue-500/20 transition-transform duration-300 group-hover:scale-100"></div>
                    </x-nav-link>
                    
                    <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')"
                        class="group relative px-4 py-2 text-sm font-medium transition-all duration-300 hover:text-cyan-300">
                        <span class="relative z-10 flex items-center">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M8 11v6h8v-6M8 11H6a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2h-2"></path>
                            </svg>
                            {{ __('My Orders') }}
                        </span>
                        <div class="absolute inset-0 scale-0 rounded-lg bg-gradient-to-r from-blue-500/20 to-purple-500/20 transition-transform duration-300 group-hover:scale-100"></div>
                    </x-nav-link>
                    
                    <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')"
                        class="group relative px-4 py-2 text-sm font-medium transition-all duration-300 hover:text-cyan-300">
                        <span class="relative z-10 flex items-center">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 10-4 0v4.01"></path>
                            </svg>
                            {{ __('Cart') }}
                        </span>
                        <div class="absolute inset-0 scale-0 rounded-lg bg-gradient-to-r from-purple-500/20 to-pink-500/20 transition-transform duration-300 group-hover:scale-100"></div>
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="group inline-flex items-center rounded-xl border border-cyan-500/30 bg-gradient-to-r from-gray-800/60 to-purple-800/60 px-4 py-2 text-sm font-medium leading-4 text-cyan-100 backdrop-blur-sm transition-all duration-300 hover:border-cyan-400/50 hover:from-gray-700/80 hover:to-purple-700/80 hover:text-white hover:shadow-lg hover:shadow-cyan-500/25 focus:outline-none focus:ring-2 focus:ring-cyan-500/50">
                            <div class="flex items-center">
                                <div class="relative mr-3">
                                    <div class="absolute -inset-0.5 rounded-full bg-gradient-to-r from-cyan-400 to-purple-600 opacity-60 blur transition duration-300 group-hover:opacity-100"></div>
                                    <div class="relative flex h-7 w-7 items-center justify-center rounded-full bg-gradient-to-r from-cyan-500 to-blue-600">
                                        <svg class="h-4 w-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    </div>
                                </div>
                                <span class="font-semibold">{{ Auth::user()->name }}</span>
                            </div>

                            <div class="ml-2 transition-transform duration-300 group-hover:rotate-180">
                                <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="rounded-xl border border-cyan-500/20 bg-gradient-to-b from-gray-800/95 to-gray-900/95 backdrop-blur-xl">
                            <x-dropdown-link :href="route('profile.edit')" 
                                class="flex items-center px-4 py-3 text-sm text-cyan-100 transition-all duration-200 hover:bg-gradient-to-r hover:from-cyan-500/10 hover:to-blue-500/10 hover:text-white">
                                <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <div class="border-t border-gray-700/50"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="flex items-center px-4 py-3 text-sm text-red-300 transition-all duration-200 hover:bg-gradient-to-r hover:from-red-500/10 hover:to-pink-500/10 hover:text-red-200">
                                    <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile menu button -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-lg border border-cyan-500/30 bg-gray-800/60 p-2 text-cyan-300 backdrop-blur-sm transition-all duration-300 hover:bg-gray-700/80 hover:text-cyan-200 focus:bg-gray-700/80 focus:text-cyan-200 focus:outline-none focus:ring-2 focus:ring-cyan-500/50">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="border-t border-gray-700/50 bg-gradient-to-b from-gray-800/80 to-gray-900/80 backdrop-blur-xl">
            <div class="space-y-1 px-4 pb-3 pt-4">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                    class="flex items-center rounded-lg px-3 py-2 text-base font-medium text-cyan-100 transition-all duration-200 hover:bg-gradient-to-r hover:from-cyan-500/20 hover:to-blue-500/20 hover:text-white">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                    </svg>
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')"
                    class="flex items-center rounded-lg px-3 py-2 text-base font-medium text-cyan-100 transition-all duration-200 hover:bg-gradient-to-r hover:from-blue-500/20 hover:to-purple-500/20 hover:text-white">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M8 11v6h8v-6M8 11H6a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2h-2"></path>
                    </svg>
                    {{ __('My Orders') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')"
                    class="flex items-center rounded-lg px-3 py-2 text-base font-medium text-cyan-100 transition-all duration-200 hover:bg-gradient-to-r hover:from-purple-500/20 hover:to-pink-500/20 hover:text-white">
                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 11-4 0v-6m4 0V9a2 2 0 10-4 0v4.01"></path>
                    </svg>
                    {{ __('Cart') }}
                </x-responsive-nav-link>
            </div>

            <div class="border-t border-gray-700/50 pb-3 pt-4">
                <div class="px-4">
                    <div class="flex items-center">
                        <div class="relative mr-3">
                            <div class="absolute -inset-0.5 rounded-full bg-gradient-to-r from-cyan-400 to-purple-600 opacity-75 blur"></div>
                            <div class="relative flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-r from-cyan-500 to-blue-600">
                                <svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <div class="text-base font-semibold text-white">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium text-cyan-300">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 space-y-1 px-4">
                    <x-responsive-nav-link :href="route('profile.edit')"
                        class="flex items-center rounded-lg px-3 py-2 text-base font-medium text-cyan-100 transition-all duration-200 hover:bg-gradient-to-r hover:from-cyan-500/20 hover:to-blue-500/20 hover:text-white">
                        <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="flex items-center rounded-lg px-3 py-2 text-base font-medium text-red-300 transition-all duration-200 hover:bg-gradient-to-r hover:from-red-500/20 hover:to-pink-500/20 hover:text-red-200">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
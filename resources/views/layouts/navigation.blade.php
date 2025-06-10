<!-- NAVBAR -->
<nav x-data="{
        open: false,
        cartOpen: false,
        cartItems: [
            { id: 1, name: 'Produk A', qty: 2, price: 50000 },
            { id: 2, name: 'Produk B', qty: 1, price: 75000 }
        ]
    }"
    class="bg-white/20 backdrop-blur-md border-b border-white/10 text-white transition duration-300 ease-in-out fixed w-full z-50 top-0 left-0 shadow-md">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="{{ url('Jualans.png') }}" class="h-8 justify-center mb-2"/>
                    </a>
                </div>
            </div>

            <!-- Settings & Cart -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                <!-- Icon Keranjang -->
                <div class="flex items-center">
                    <a href="{{ route('cart.index') }}" class="relative p-2 hover:scale-110 focus:outline-none">
                        <svg class="h-6 w-6 text-blue-700 hover:text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 001.95-1.54L23 6H6"></path>
                        </svg>

                        @php
                            $cartItems = session()->get('cart', []);
                            $cartCount = array_sum(array_column($cartItems, 'quantity'));
                        @endphp

                        @if($cartCount > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                </div>

                <!-- Dropdown User -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-800 hover:bg-blue-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        <x-dropdown-link :href="route('dashboard')">Dashboard</x-dropdown-link>
                        <x-dropdown-link :href="route('admin.index')">Masuk Admin</x-dropdown-link>
                        <x-dropdown-link :href="route('product.index')">Product</x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gray-200 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-blue-800 bg-opacity-90">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-white hover:bg-blue-700">Dashboard</a>
            <a href="{{ route('admin.index') }}" class="block px-4 py-2 text-white hover:bg-blue-700">Masuk Admin</a>
            <a href="{{ route('product.index') }}" class="block px-4 py-2 text-white hover:bg-blue-700">Product</a>
            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-white hover:bg-blue-700">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" class="block px-4 py-2 text-white hover:bg-blue-700" onclick="event.preventDefault(); this.closest('form').submit();">
                    Log Out
                </a>
            </form>
        </div>
    </div>
</nav>

<!-- KONTEN UTAMA -->
<main class="pt-16">
    <!-- Komponen seperti carousel, produk, dsb -->
</main>

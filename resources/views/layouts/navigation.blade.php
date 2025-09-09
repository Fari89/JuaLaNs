@php
    // pastikan total quantity diambil di awal agar bisa dipakai di seluruh template
    $totalQty = Session::get('cart_total_quantity', 0);
@endphp

<style>
    /* sembunyikan elemen dengan x-cloak sampai Alpine siap */
    [x-cloak] { display: none !important; }
</style>

<nav x-data="{
        open: false,
        showCartPopup: false,
    }"
    class="bg-white border-b border-gray-200 text-gray-800 transition duration-300 ease-in-out fixed w-full z-50 top-0 left-0 shadow-md">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('dashboard') }}">
                    <img src="{{ url('Jualans.png') }}" alt="Jualans Logo" class="h-8"/>
                </a>
            </div>

            <div class="hidden sm:flex sm:items-center sm:space-x-6 mt-2 mb-1">
                <a href="/product" class="text-blue-800 hover:text-blue-600 font-medium btn-animate transition-colors duration-200">
                     Semua Produk >
                </a>

                @auth
                <div class="relative ">
                    <a href="{{ route('cart.index') }}"
                       class="text-blue-800 hover:text-blue-600 transition-colors duration-200 cursor-pointer ">
                        {{--  MENGUBAH SVG DI SINI --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 " fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>

                        @if($totalQty > 0)
                            <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full px-1.5 py-0.5 animate-pulse">{{ $totalQty }}</span>
                        @endif
                    </a>
                </div>
                <a href="{{ route('profile.edit') }}" class="flex items-center space-x-2 text-blue-800 hover:text-blue-600 font-medium transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>{{ Auth::user()->name }}</span>
                </a>
                @endauth

                @guest
                <div class="relative">
                    <button @click="showCartPopup = true" type="button"
                            class="text-blue-800 hover:text-blue-600 transition-colors duration-200 cursor-pointer">
                        {{--  MENGUBAH SVG DI SINI --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </button>
                </div>
                <a href="{{ route('login') }}" class="px-4 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-blue-800 hover:bg-blue-700 btn-animate transition duration-150 ease-in-out mb-2 mt-1">
                    Login
                </a>
                @endguest
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                @auth
                <div class="relative">
                    <a href="{{ route('cart.index') }}" class="text-blue-800 hover:text-blue-600 mr-2 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        @if($totalQty > 0)
                            <span class="absolute -top-2 -right-0 bg-red-600 text-white text-xs rounded-full px-1.5 py-0.5 animate-pulse">{{ $totalQty }}</span>
                        @endif
                    </a>
                </div>
                @endauth

                @guest
                <div class="relative">
                    <button @click="showCartPopup = true" type="button" class="text-blue-800 hover:text-blue-600 mr-2 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </button>
                </div>
                @endguest

                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-blue-700 hover:text-blue-600 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="sm:hidden bg-white shadow-lg">
        <div class="pt-2 pb-3 space-y-1">
            <a href="/product" class="block px-4 py-2 text-blue-800 hover:bg-gray-100 font-medium">Lihat Produk</a>
            @auth
            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-blue-800 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span>{{ Auth::user()->name }}</span>
            </a>
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-blue-800 hover:bg-gray-100">Dashboard</a>
            {{-- <a href="{{ route('admin.index') }}" class="block px-4 py-2 text-blue-800 hover:bg-gray-100">Masuk Admin</a> --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}" class="block px-4 py-2 text-blue-800 hover:bg-gray-100" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a>
            </form>
            @endauth

            @guest
            <a href="{{ route('login') }}" class="block px-4 py-2 text-blue-800 hover:bg-gray-100">Login</a>
            <a href="{{ route('register') }}" class="block px-4 py-2 text-blue-800 hover:bg-gray-100">Register</a>
            @endguest
        </div>
    </div>

    <div x-show="showCartPopup" x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[100]">
        <div class="bg-white p-6 rounded-lg shadow-xl w-11/12 max-w-xs md:max-w-sm text-center relative">
            <button @click="showCartPopup = false" class="absolute top-2 right-4 text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
            <img src="{{ url('jualans.png') }}" alt="Jualans Logo" class="h-12  mb-6 mx-auto "/>
            <p class="text-gray-700 my-3">
                <b>Login</b> dulu yuk biar bisa ngakses menu keranjang kamu.
            </p>
            <div class="flex flex-col space-y-3">
                <a href="{{ route('login') }}" @click="showCartPopup = false" class="bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">Login Sekarang</a>
                <a href="{{ route('register') }}" @click="showCartPopup = false" class="text-blue-600 py-2 rounded-md hover:text-blue-800 transition">Belum Punya Akun? Register</a>
            </div>
        </div>
    </div>

</nav>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
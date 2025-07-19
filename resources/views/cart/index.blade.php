<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="{{ asset('JuaLans.icon.png') }}" type="image/png" />
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Alpine.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Custom font family for Inter, applied globally */
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Ensure table borders are visible with Tailwind's border-collapse */
        table {
            border-collapse: collapse;
        }
        /* Custom styling for table cells if needed, though Tailwind handles most */
        th, td {
            border: 1px solid #e5e7eb; /* Tailwind's border-gray-200 equivalent */
        }
        /* Custom scrollbar for zoom modal */
        #zoomImageModal .max-h-\[90vh\]::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        #zoomImageModal .max-h-\[90vh\]::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        #zoomImageModal .max-h-\[90vh\]::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        #zoomImageModal .max-h-\[90vh\]::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

    </style>
</head>
<body class="bg-gray-50 text-gray-800 font-inter antialiased">

    <!-- NAVBAR -->
    <nav x-data="{ open: false }"
        class="bg-white border-b border-gray-200 text-gray-800 transition duration-300 ease-in-out fixed w-full z-50 top-0 left-0 shadow-md">

        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}">
                            <img src="{{ url('Jualans.png') }}" class="h-8 justify-center mb-0"/>
                        </a>
                    </div>
                </div>
                <div>
                </div>
                <!-- Settings & Cart -->
                <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                    <a href="{{ route('product.index') }}" class="text-blue-800 hover:text-blue-600 font-medium">Lihat Produk</a>

                    <!-- Cart Icon -->
                    <div class="relative">
                        <a href="{{ route('cart.index') }}" class="text-blue-800 hover:text-blue-600">
                            <!-- Kart mirip Shopee: stroke minimal + kontur bundar -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 23 23" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                                <circle cx="6" cy="19" r="2" />
                                <circle cx="17" cy="19" r="2" />
                                <path d="M17 17h-11v-14h-2" />
                                <path d="M6 5l6.005 .429m7.138 6.573l-.143 .998h-13" />
                                <path d="M15 6h6m-3-3v6" />
                            </svg>

                            <!-- Badge item count -->
                            @php
                                // Mengambil data cart dari sesi untuk badge, ini terpisah dari cartItems dari DB
                                $cartSession = session('cart', []);
                                $totalQtyInSession = 0;
                                foreach ($cartSession as $cartItemSession) {
                                    $totalQtyInSession += $cartItemSession['jumlah'] ?? 0;
                                }
                            @endphp
                            @if($totalQtyInSession > 0)
                                <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full px-1.5 py-0.5">{{ $totalQtyInSession }}</span>
                            @endif
                        </a>
                    </div>

                    {{-- Dropdown User (Menggunakan logika @guest/@else) --}}
                    @guest
                        <a href="{{ route('login') }}" class="text-blue-800 hover:text-blue-600 font-medium">Login</a>
                        <a href="{{ route('register') }}" class="text-blue-800 hover:text-blue-600 font-medium">Register</a>
                    @else
                        {{-- Contoh sederhana untuk menampilkan nama user dan logout --}}
                        <div class="relative" x-data="{ openUserMenu: false }">
                            <button @click="openUserMenu = !openUserMenu" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-800 hover:bg-blue-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name ?? 'Pengguna' }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                            <div x-show="openUserMenu" @click.away="openUserMenu = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-0">Profile</a>
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-1">Dashboard</a>
                                <a href="{{ route('admin.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-2">Masuk Admin</a>
                                <a href="{{ route('product.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-3">Product</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-4">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                <!-- Hamburger (Mobile) -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-800 hover:text-gray-600 focus:outline-none transition duration-150 ease-in-out">
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
                @guest
                    <a href="{{ route('login') }}" class="block px-4 py-2 text-white hover:bg-blue-700">Login</a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 text-white hover:bg-blue-700">Register</a>
                @else
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-white hover:bg-blue-700">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-white hover:bg-blue-700">
                            Log Out
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>

    <!-- KONTEN UTAMA KERANJANG -->
    <main class="pt-24"> <!-- Adjusted padding-top to account for fixed navbar height -->
        <div class="container mx-auto mt-12 p-8 bg-white rounded-2xl shadow-xl border border-gray-100">
            <h1 class="text-4xl font-extrabold text-center text-gray-900 leading-tight">Keranjang Belanja Anda</h1>
            <p class="text-left text-red-500  mt-10 mb-10 text-xs">* Semua produk yang tertera adalah produk yang tersedia *</p>

            <!-- Success and Error Messages -->
            @if(session('success'))
                <div id="success-message" class="bg-green-100 border border-green-400 text-green-700 px-6 py-4 rounded-xl mb-8 text-center font-medium shadow-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-6 py-4 rounded-xl mb-8 text-center font-medium shadow-sm">
                    {{ session('error') }}
                </div>
            @endif


            <!-- Cart Items Table -->
            @if(count($cartItems) > 0)
                <div class="overflow-x-auto rounded-2xl shadow-lg border border-gray-200">

                    <table class="w-full bg-white">
                        <thead class="bg-blue-800 text-white">
                            <tr>
                                <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wide rounded-tl-2xl">Produk</th>
                                <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wide"></th>
                                <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wide">Jumlah</th>
                                <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wide">Total</th>
                                <th class="py-4 px-6 text-left text-sm font-semibold uppercase tracking-wide rounded-tr-2xl">Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition duration-150">
                                    <td class="py-4 px-6 flex items-center space-x-4">
                                        @if($item->product && $item->product->foto)
                                            <img src="{{ asset('storage/' . $item->product->foto) }}" alt="{{ $item->product->nama }}" class="w-20 h-20 object-cover rounded-lg shadow-sm flex-shrink-0 border border-gray-200">
                                        @else
                                            <img src="https://placehold.co/80x80/f0f0f0/888888?text=No+Image" alt="No Image" class="w-20 h-20 object-cover rounded-lg shadow-sm flex-shrink-0 border border-gray-200">
                                        @endif
                                        <div class="flex flex-col">
                                            <div class="text-base font-semibold text-gray-800">{{ $item->product->nama ?? 'Produk Tidak Ditemukan' }}</div>
                                            @if($item->product && $item->product->deskripsi)
                                                <div class="text-xs text-gray-500 mt-1 leading-snug">{{ Str::limit($item->product->deskripsi, 70) }}</div>
                                            @endif
                                            @if($item->product && $item->product->kode)
                                                <div class="text-xs text-gray-400 mt-1">Kode: {{ $item->product->kode }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    {{-- Menggunakan $item->price dari model Cart --}}
                                    <td class="py-4 px-6 text-gray-700 font-medium"></td>
                                    <td class="py-4 px-6 text-gray-700 font-medium">{{ $item->jumlah }}</td>
                                    {{-- Menggunakan $item->subtotal yang sudah dihitung di controller --}}
                                    <td class="py-4 px-6 font-semibold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    <td class="py-4 px-6">
                                        <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-semibold transition duration-200 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-100 border-t border-gray-200 font-bold">
                                <td colspan="3" class="py-4 px-6 text-right text-lg font-bold text-gray-800">Total Keranjang:</td>
                                {{-- Menggunakan $total yang sudah dihitung di controller --}}
                                <td class="py-4 px-6 text-lg font-bold text-gray-800">Rp {{ number_format($total, 0, ',', '.') }}</td>
                                <td class="py-4 px-6"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Buttons Section -->
                <div class="flex flex-col sm:flex-row justify-between items-center mt-10 space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="#" class="w-full sm:w-auto bg-blue-800 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:ring-opacity-50">Lanjutkan ke Checkout</a>
                    <a href="{{ route('product.index') }}" class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-3 px-8 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-opacity-50">Lanjutkan Belanja</a>
                </div>
            @else
                <div class="text-center py-16 bg-gray-50 rounded-2xl border border-gray-200 shadow-sm">
                    <svg class="mx-auto h-28 w-28 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p class="mt-6 text-2xl font-semibold text-gray-600">Keranjang belanja Anda kosong.</p>
                    <p class="mt-2 text-gray-500 max-w-md mx-auto">Sepertinya Anda belum menambahkan apa pun ke keranjang Anda. Jelajahi produk kami dan temukan yang Anda suka!</p>
                </div>
            @endif
{{-- BAGIAN PRODUK LAINNYA YANG MUNGKIN ANDA SUKA --}}
<div class="mt-20">
    <h2 class="text-3xl font-extrabold text-center text-gray-900 leading-tight mb-1">Produk Lainnya yang Mungkin Anda Suka</h2>
    <p class="text-center text-gray-700 mb-8">Belanjanya udah semua ? lihat lagi yuk barang kali ada yang kelupaan...</p>
    @if(count($allProducts) > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($allProducts as $product) {{-- Iterating over $allProducts, and using $product as the item variable --}}
                <div class="bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col transition transform hover:scale-105 duration-300">
                    <div class="w-full mt-3 h-48 bg-white flex items-center justify-center relative group overflow-hidden">
                        <img
                            onclick="openModal({{ $product->id }}, 'detail')" {{-- Use $product->id here --}}
                            src="{{ asset('storage/' . $product->foto) }}" {{-- Use $product->foto here --}}
                            alt="Foto Produk"
                            class="max-h-full max-w-full object-contain transition duration-300 ease-in-out group-hover:blur-[1px] cursor-pointer"
                        >

                        <!-- <div
                            class="absolute inset-0 rounded-t-lg bg-black bg-opacity-40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer"
                            onclick="openModal({{ $product->id }}, 'detail')" {{-- Use $product->id here --}}
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white mb-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>

                            <p class="text-white text-sm font-semibold">Lihat Detail</p>
                        </div> -->
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 truncate">{{ $product->nama }}</h3>
                        <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $product->deskripsi }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-blue-800">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="jumlah" value="1">
                                {{-- Menggunakan Session::get untuk detail pembeli yang disimpan --}}
                                <input type="hidden" name="nama_pembeli" value="{{ Session::get('cart_nama_pembeli') ?? 'Guest' }}">
                                <input type="hidden" name="alamat" value="{{ Session::get('cart_alamat') ?? 'Unknown' }}">
                                <input type="hidden" name="no_hp" value="{{ Session::get('cart_no_hp') ?? '0000' }}">

                                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition duration-200 shadow-md">
                                    <i class="fas fa-plus-circle mr-1"></i> Tambah
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">Tidak ada produk lain yang tersedia saat ini.</p>
            @endforelse
        </div>
    @else
        <p class="text-center text-gray-500">Tidak ada produk lain yang tersedia saat ini.</p>
    @endif
    </div>
       </div>
        <footer class="mt-16 bg-blue-800 text-white py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <a href="{{ route('dashboard') }}" class="inline-block">
                        <img src="{{ url('FaRs_logo.png') }}" alt="FaRs Logo" class="h-10 md:h-14 object-contain mb-3 mx-auto" />
                    </a>
                    <p class="text-sm text-gray-300">
                        Platform jual beli produk pilihan terbaik dengan layanan terpercaya dan responsif.
                    </p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-2">Navigasi</h4>
                    <ul class="space-y-1 text-sm text-gray-300">
                        <li><a href="{{ route('dashboard') }}" class="hover:underline">Beranda</a></li>
                        <li><a href="{{ route('product.index') }}" class="hover:underline">Produk</a></li>
                        <li><a href="#" class="hover:underline">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-2">Komponen</h4>
                    <ul class="space-y-1 text-sm text-gray-300">
                         <li>Gemini Ai</li>
                        <li>Laravel 10</li>
                        <li>Tailwind CSS</li>
                        <li>Alpine.js</li>
                        <li>Font Awesome</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-2">Developer</h4>
                    <p class="text-sm text-gray-300">
                        <strong>Muhammad Farihin Mushawwir</strong><br>
                        Email: <a href="mailto:support@jualans.com" class="hover:underline">support@jualans.com</a><br>
                        &copy; {{ date('Y') }} All rights reserved.
                    </p>
                    <div class="flex space-x-4 mt-3 text-xl">
                        <a href="#" class="hover:text-blue-400"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="hover:text-sky-400"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="hover:text-pink-400"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="hover:text-gray-400"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>
            <div class="mt-10 pt-4 text-center text-sm text-gray-400">
                &copy; {{ date('Y') }} <strong>JuaLaNs</strong>. All rights reserved. <br>
                All Images &copy; IKEA.
            </div>
        </footer>
    </main>
<script>
    // Data produk dari backend ke frontend (pastikan ini ada di view)
    // PENTING: Akses data produk melalui properti 'data' dari objek paginator
   const allProducts = @json($allProducts ?? []); // Baris ini sangat penting

    function openModal(id, mode) {
        const modal = document.getElementById('buyModal');
        const buyFormSection = document.getElementById('buyFormSection');

        // PERBAIKAN DI SINI: Cari produk di dalam productsData (yang sudah berupa array)
        const product = productsData.find(p => p.id === id);
        if (!product) {
            console.error('Produk dengan ID ' + id + ' tidak ditemukan di data JavaScript.');
            alert('Produk tidak ditemukan. Mungkin ada masalah dalam memuat data.'); // Ganti alert dengan UI yang lebih baik
            return;
        }

        document.getElementById('modalTitle').textContent = product.nama;
        document.getElementById('modalPrice').textContent = 'Rp ' + Number(product.harga).toLocaleString('id-ID');
        document.getElementById('modalDesc').textContent = product.deskripsi;
        document.getElementById('modalImage').src = `/storage/${product.foto}`; // Pastikan path benar
        document.getElementById('modalProductId').value = product.id;

        if (mode === 'beli') {
            buyFormSection.style.display = 'block';
        } else {
            buyFormSection.style.display = 'none';
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('buyModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        closeZoomImage(); // Pastikan modal zoom juga tertutup
    }

    function zoomImage() {
        const src = document.getElementById('modalImage').src;
        const zoomModal = document.getElementById('zoomImageModal');
        const zoomedImage = document.getElementById('zoomedImage');

        zoomedImage.src = src;
        zoomModal.classList.remove('hidden');
        zoomModal.classList.add('flex');
    }

    function closeZoomImage() {
        const zoomModal = document.getElementById('zoomImageModal');
        zoomModal.classList.add('hidden');
        zoomModal.classList.remove('flex');
    }
</script>
<!-- ai bot -->
 <a id="openChatbotButton"
   class="fixed bottom-6 right-6 z-50 bg-blue-800 hover:bg-blue-600 text-white p-3 rounded-full shadow-lg transition duration-300 hover:scale-110 cursor-pointer animate-bounce-custom border-2 border-white"
   title="Buka Chatbot AI">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
         viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
    </svg>
</a>

<div id="chatbotContainer"
     class="fixed bottom-24 right-6 w-80 bg-white rounded-xl shadow-2xl z-50 flex flex-col transform scale-0 opacity-0 transition-all duration-300 ease-out-back origin-bottom-right"
     style="display: none;">
    <div class="bg-gradient-to-r from-blue-800 to-blue-600 text-white p-4 rounded-t-xl flex justify-between items-center shadow-md hover:from-blue-700 hover:to-blue-500 transition-colors duration-200 cursor-pointer">
        <h4 class="font-bold text-xl flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
            Asisten JuaLaNs
        </h4>
        <button id="closeChatbotButton" class="text-white hover:text-gray-200 text-3xl leading-none font-light opacity-80 hover:opacity-100 transition-opacity">&times;</button>
    </div>
    <div id="chatbotMessages" class="flex-grow p-4 overflow-y-auto h-64 bg-gray-50 border-b border-gray-200 custom-scrollbar">
        </div>
    <div id="quickRepliesContainer" class="p-3 bg-gray-100 border-t border-gray-200 flex flex-wrap gap-2 justify-center hidden">
        </div>
    <div class="p-3 flex items-center bg-white border-t border-gray-100">
        <input type="text" id="chatbotInput" placeholder="Ketik pesan Anda..." class="flex-grow border border-gray-300 rounded-lg px-4 py-2 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 mr-2">
        <button id="chatbotSendButton" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 shadow-md transform hover:scale-105 active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l.684-.282m3.541-1.353L9.04 15.532A1.5 1.5 0 0010.166 17h1.472a1.5 1.5 0 001.38-2.228l-.348-.711m-9.697 1.411A1 1 0 006 17h1.472a1.5 1.5 0 001.38-2.228l-.348-.711m9.697 1.411A1 1 0 0014 17h1.472a1.5 1.5 0 001.38-2.228l-.348-.711" />
            </svg>
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const openChatbotButton = document.getElementById('openChatbotButton');
        const closeChatbotButton = document.getElementById('closeChatbotButton');
        const chatbotContainer = document.getElementById('chatbotContainer');
        const chatbotMessages = document.getElementById('chatbotMessages');
        const chatbotInput = document.getElementById('chatbotInput');
        const chatbotSendButton = document.getElementById('chatbotSendButton');
        const quickRepliesContainer = document.getElementById('quickRepliesContainer');

        // Fungsi untuk menampilkan pesan bot
        function displayBotMessage(message, replies = []) {
            const botMessageDiv = document.createElement('div');
            botMessageDiv.className = 'bg-gray-200 text-gray-800 p-3 rounded-xl rounded-bl-none shadow-sm mb-3 max-w-[85%] self-start animate-fade-in-up';
            botMessageDiv.textContent = message;
            chatbotMessages.appendChild(botMessageDiv);

            chatbotMessages.scrollTop = chatbotMessages.scrollHeight;

            // Clear previous quick replies
            quickRepliesContainer.innerHTML = '';
            if (replies.length > 0) {
                quickRepliesContainer.classList.remove('hidden');
                replies.forEach(reply => {
                    const button = document.createElement('button');
                    button.className = 'bg-blue-100 text-blue-700 hover:bg-blue-200 px-3 py-1 rounded-full text-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500';
                    button.textContent = reply;
                    button.onclick = () => handleQuickReply(reply);
                    quickRepliesContainer.appendChild(button);
                });
            } else {
                quickRepliesContainer.classList.add('hidden');
            }
        }

        // Fungsi untuk menampilkan pesan pengguna
        function displayUserMessage(message) {
            const userMessageDiv = document.createElement('div');
            userMessageDiv.className = 'bg-blue-600 text-white p-3 rounded-xl rounded-br-none shadow-sm mb-3 max-w-[85%] self-end animate-fade-in-up';
            userMessageDiv.textContent = message;
            chatbotMessages.appendChild(userMessageDiv);
            chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
        }

        // Fungsi untuk menangani balasan bot yang lebih kompleks
        function getBotResponse(message) {
            const lowerCaseMessage = message.toLowerCase();
            let response = { text: "Maaf, saya belum mengerti. Bisakah Anda lebih spesifik atau pilih opsi di bawah? 🤔", replies: [] };

            if (lowerCaseMessage.includes("halo") || lowerCaseMessage.includes("hai")) {
                response.text = "Halo! Senang bisa membantu. Ada yang bisa saya bantu hari ini? ✨";
                response.replies = ["Lihat Produk", "Status Pesanan", "Bantuan Umum", "Kontak Admin"];
            } else if (lowerCaseMessage.includes("produk") || lowerCaseMessage.includes("barang")) {
                response.text = "Tentu! Anda bisa melihat semua produk kami di halaman 'Lihat Produk'. Kami punya banyak pilihan menarik! 🛍️";
                response.replies = ["Cara Beli", "Produk Terbaru", "Promosi"];
            } else if (lowerCaseMessage.includes("harga")) {
                response.text = "Harga setiap produk tertera jelas di halaman produk masing-masing. Harga di keranjang belanja juga akan otomatis terupdate. 💰";
                response.replies = ["Ada Diskon?", "Metode Pembayaran"];
            } else if (lowerCaseMessage.includes("servis") || lowerCaseMessage.includes("layanan purna jual") || lowerCaseMessage.includes("garansi")) {
                response.text = "Untuk pertanyaan layanan purna jual, garansi, atau perbaikan, silakan hubungi tim dukungan kami. Mereka siap membantu! 🛠️";
                response.replies = ["Nomor Kontak", "Jam Operasional Servis"];
            } else if (lowerCaseMessage.includes("beli") || lowerCaseMessage.includes("cara order")) {
                response.text = "Mudah sekali! Anda bisa menambahkan produk ke keranjang dari halaman produk, lalu ikuti langkah-langkah di halaman checkout. 🛒";
                response.replies = ["Metode Pembayaran", "Biaya Kirim"];
            } else if (lowerCaseMessage.includes("lokasi") || lowerCaseMessage.includes("alamat")) {
                response.text = "JuaLaNs adalah toko online, jadi kami tidak punya lokasi fisik. Kami melayani pengiriman ke seluruh Indonesia! Di mana pun Anda berada, kami siap kirim. 📦";
                response.replies = ["Jangkauan Pengiriman"];
            } else if (lowerCaseMessage.includes("pembayaran") || lowerCaseMessage.includes("bayar")) {
                response.text = "Kami menerima berbagai metode pembayaran seperti transfer bank (BCA, Mandiri), e-wallet (OVO, GoPay), dan kartu kredit. Pilih yang paling nyaman untuk Anda! 💳";
                response.replies = ["Konfirmasi Pembayaran", "Masalah Pembayaran"];
            } else if (lowerCaseMessage.includes("diskon") || lowerCaseMessage.includes("promo")) {
                response.text = "Ya, kami sering ada promo menarik! Cek halaman 'Promosi' atau bagian banner di halaman utama kami untuk penawaran terbaru. Jangan sampai ketinggalan! 🎉";
                response.replies = ["Syarat & Ketentuan Promo"];
            } else if (lowerCaseMessage.includes("status pesanan") || lowerCaseMessage.includes("kiriman")) {
                response.text = "Untuk cek status pesanan, mohon masukkan nomor pesanan Anda. Jika belum ada nomor pesanan, Anda bisa lihat riwayat pembelian di akun Anda. 🚚";
                response.replies = ["Lacak Pesanan", "Pengiriman Lama"];
            } else if (lowerCaseMessage.includes("kontak") || lowerCaseMessage.includes("admin")) {
                response.text = "Anda bisa menghubungi admin kami melalui email di support@jualans.com atau via telepon di +6281234567890 selama jam kerja. Kami siap membantu! 🧑‍💻";
                response.replies = ["Jam Operasional", "Tulis Email"];
            }
            // Add more complex responses as needed
            // Example for specific product query (requires more sophisticated parsing or a real AI)
            else if (lowerCaseMessage.includes("xiaomi") && lowerCaseMessage.includes("redmi note")) {
                response.text = "Ah, Xiaomi Redmi Note! Seri ini sangat populer. Model spesifik mana yang Anda cari? Kami punya beberapa varian. 📱";
                response.replies = ["Redmi Note 12", "Redmi Note 13"];
            } else if (lowerCaseMessage.includes("redmi note 13")) {
                response.text = "Xiaomi Redmi Note 13 adalah pilihan tepat! Harganya mulai dari Rp 2.500.000. Fitur utamanya: Kamera 108MP, layar AMOLED 120Hz, dan baterai 5000mAh. Tertarik? ✨";
                response.replies = ["Lihat Detail Redmi Note 13", "Beli Sekarang Redmi Note 13"];
            }
            return response;
        }

        // Fungsi untuk mengirim pesan (saat tombol Kirim atau Enter ditekan)
        function sendMessage() {
            const messageText = chatbotInput.value.trim();
            if (messageText === '') return;

            displayUserMessage(messageText);
            chatbotInput.value = ''; // Kosongkan input
            chatbotInput.focus();

            // Simulate bot typing
            setTimeout(() => {
                const botResponse = getBotResponse(messageText);
                displayBotMessage(botResponse.text, botResponse.replies);
            }, 700);
        }

        // Fungsi untuk menangani klik tombol quick reply
        function handleQuickReply(replyText) {
            displayUserMessage(replyText);
            // Simulate bot typing
            setTimeout(() => {
                const botResponse = getBotResponse(replyText);
                displayBotMessage(botResponse.text, botResponse.replies);
            }, 700);
        }

        // --- Event Listeners ---
        openChatbotButton.addEventListener('click', function() {
            chatbotContainer.style.display = 'flex'; // Ubah dari none ke flex agar transisi bisa berjalan
            setTimeout(() => {
                chatbotContainer.classList.remove('scale-0', 'opacity-0');
                chatbotContainer.classList.add('scale-100', 'opacity-100');
                chatbotInput.focus();
                // Display initial welcome message with quick replies when chatbot opens
                if (chatbotMessages.children.length === 0) { // Only show initial message if chat is empty
                    displayBotMessage("Halo! Saya Asisten JuaLaNs. Ada yang bisa saya bantu hari ini? 💬", ["Lihat Produk", "Status Pesanan", "Bantuan Umum"]);
                }
            }, 10);
        });

        closeChatbotButton.addEventListener('click', function() {
            chatbotContainer.classList.remove('scale-100', 'opacity-100');
            chatbotContainer.classList.add('scale-0', 'opacity-0');
            setTimeout(() => {
                chatbotContainer.style.display = 'none';
            }, 300);
        });

        chatbotSendButton.addEventListener('click', sendMessage);
        chatbotInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                sendMessage();
            }
        });
    });
    document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                setTimeout(function() {
                    successMessage.style.transition = 'opacity 0.5s ease-out';
                    successMessage.style.opacity = '0';
                    setTimeout(function() {
                        successMessage.remove(); // Remove element after fade out
                    }, 500); // Duration of the fade out
                }, 3000); // 3000 milliseconds = 3 seconds
            }
        });
</script>

<style>
    /* Custom Scrollbar for Chatbot Messages */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Custom Animation for Bounce on the Button */
    @keyframes bounce-custom {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-8px);
        }
    }
    .animate-bounce-custom {
        animation: bounce-custom 1.5s infinite ease-in-out;
    }

    /* Ease-out-back timing function for more dynamic pop-up */
    .ease-out-back {
        transition-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    /* New: Fade In Up Animation for chat messages */
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in-up {
        animation: fade-in-up 0.3s ease-out forwards;
    }

    /* Adjust container border-radius for full modern look */
    #chatbotContainer {
        border-radius: 1rem; /* rounded-xl in Tailwind */
    }
    /* Ensure header also has rounded corners only at top */
    #chatbotContainer .bg-gradient-to-r {
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }
</style>
</body>
</html>

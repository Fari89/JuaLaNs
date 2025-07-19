<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="icon" href="{{ asset('JuaLans.icon.png') }}" type="image/png" />

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 font-inter antialiased">

    <nav x-data="{ open: false }"
        class="bg-white border-b border-gray-200 text-gray-800 transition duration-300 ease-in-out fixed w-full z-50 top-0 left-0 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}">
                            <img src="{{ url('Jualans.png') }}" class="h-8 justify-center mb-0" alt="Jualans Logo" />
                        </a>
                    </div>
                </div>
                <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                    <a href="{{ route('product.index') }}"
                        class="text-blue-800 hover:text-blue-600 font-medium">Lihat Produk</a>
                    <div class="relative">
                        <a href="{{ route('cart.index') }}" class="text-blue-800 hover:text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 23 23"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="h-6 w-6">
                                <circle cx="6" cy="19" r="2" />
                                <circle cx="17" cy="19" r="2" />
                                <path d="M17 17h-11v-14h-2" />
                                <path d="M6 5l6.005 .429m7.138 6.573l-.143 .998h-13" />
                                <path d="M15 6h6m-3-3v6" />
                            </svg>
                            @php
                                $cartSession = session('cart', []);
                                $totalQtyInSession = 0;
                                foreach ($cartSession as $cartItemSession) {
                                    $totalQtyInSession += $cartItemSession['jumlah'] ?? 0;
                                }
                            @endphp
                            @if ($totalQtyInSession > 0)
                                <span
                                    class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full px-1.5 py-0.5">{{ $totalQtyInSession }}</span>
                            @endif
                        </a>
                    </div>
                    @guest
                        <a href="{{ route('login') }}" class="text-blue-800 hover:text-blue-600 font-medium">Login</a>
                        <a href="{{ route('register') }}"
                            class="text-blue-800 hover:text-blue-600 font-medium">Register</a>
                    @else
                        <div class="relative" x-data="{ openUserMenu: false }">
                            <button @click="openUserMenu = !openUserMenu"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-800 hover:bg-blue-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name ?? 'Pengguna' }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                            <div x-show="openUserMenu" @click.away="openUserMenu = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                tabindex="-1">
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"
                                    tabindex="-1" id="user-menu-item-0">Profile</a>
                                <a href="{{ route('dashboard') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"
                                    tabindex="-1" id="user-menu-item-1">Dashboard</a>
                                <a href="{{ route('admin.index') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"
                                    tabindex="-1" id="user-menu-item-2">Masuk Admin</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                        role="menuitem" tabindex="-1" id="user-menu-item-4">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-24 pb-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl border-gray-500 sm:rounded-lg p-10">

                <h2 class="text-2xl font-bold text-gray-900 mb-6">Manajemen Produk</h2>

                @if (session('success'))
                    <div id="success-message"
                        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">Sukses!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">Oops!</strong>
                        <span class="block sm:inline">Terjadi beberapa kesalahan:</span>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mb-8 p-6 bg-gray-50 rounded-lg shadow-inner">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Tambah Produk Baru</h3>
                    <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                                class="mt-1 block w-full rounded-md border-2 border-gray-400 shadow-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-700">
                        </div>

                        <div class="mb-4">
                            <label for="harga" class="block text-sm font-medium text-gray-700">Harga</label>
                            <input type="number" name="harga" id="harga" value="{{ old('harga') }}" required
                                step="0.01"
                                class="mt-1 block w-full rounded-md border-2 border-gray-400 shadow-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-700">
                        </div>

                        <div class="mb-4">
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" rows="3" required
                                class="mt-1 block w-full rounded-md border-2 border-gray-400 shadow-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-700">{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="foto" class="block text-sm font-medium text-gray-700">Foto Produk</label>
                            <input type="file" name="foto" id="foto" required
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-2 file:border-blue-600 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-700">
                        </div>

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Tambah Produk
                        </button>
                    </form>
                </div>


                <h3 class="text-xl font-semibold text-gray-800 mb-4">Daftar Produk</h3>
                <div class="mb-6">
                    <form method="GET" action="{{ route('admin.index') }}" class="flex items-center space-x-2">
                        <input type="text" name="search" placeholder="Cari produk..."
                            value="{{ request('search') }}"
                            class="flex-1 rounded-md border-2 border-gray-400 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-600 p-2">

                        <button type="submit"
                            class="px-4 py-2 bg-gray-700 border-2 border-gray-600 text-white rounded-md hover:bg-gray-600 transition focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-600">
                            Cari
                        </button>

                        @if (request('search'))
                            <a href="{{ route('admin.index') }}"
                                class="px-4 py-2 bg-gray-300 text-gray-800 rounded-md hover:bg-gray-400 transition focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-600">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>


                @if ($products->count() > 0)
                    <div class="overflow-x-auto rounded-lg shadow-md border border-gray-200">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-200 text-gray-700">
                                <tr>
                                    <th class="py-3 px-6 text-left text-xs font-medium uppercase tracking-wider">ID
                                    </th>
                                    <th class="py-3 px-6 text-left text-xs font-medium uppercase tracking-wider">Foto
                                    </th>
                                    <th class="py-3 px-6 text-left text-xs font-medium uppercase tracking-wider">Nama
                                    </th>
                                    <th class="py-3 px-6 text-left text-xs font-medium uppercase tracking-wider">Harga
                                    </th>
                                    <th class="py-3 px-6 text-left text-xs font-medium uppercase tracking-wider">
                                        Deskripsi</th>
                                    <th class="py-3 px-6 text-left text-xs font-medium uppercase tracking-wider">Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($products as $product)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-4 px-6 text-sm text-gray-900">{{ $product->id }}</td>
                                        <td class="py-4 px-6">
                                            @if ($product->foto)
                                                <img src="{{ asset('storage/' . $product->foto) }}"
                                                    alt="{{ $product->nama }}" class="w-16 h-16 object-cover rounded-md">
                                            @else
                                                <img src="https://placehold.co/64x64/f0f0f0/888888?text=No+Image"
                                                    alt="No Image" class="w-16 h-16 object-cover rounded-md">
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-sm text-gray-900">{{ $product->nama }}</td>
                                        <td class="py-4 px-6 text-sm text-gray-900">Rp
                                            {{ number_format($product->harga, 0, ',', '.') }}</td>
                                        <td class="py-4 px-6 text-sm text-gray-900">
                                            {{ Str::limit($product->deskripsi, 50) }}</td>
                                        <td class="py-4 px-6 text-sm font-medium flex space-x-2">
                                            <a href="{{ route('product.edit', $product->id) }}"
                                                class="text-blue-600 hover:text-blue-900">Edit</a>
                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center text-gray-500 mt-8">Tidak ada produk ditemukan.</p>
                @endif
            </div>
        </div>
    </main>

    <footer class="mt-16 bg-blue-800 text-white py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
                <a href="{{ route('dashboard') }}" class="inline-block">
                    <img src="{{ url('FaRs_logo.png') }}" alt="FaRs Logo"
                        class="h-10 md:h-14 object-contain mb-3 mx-auto" />
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.getElementById('success-message');
            if (successMessage) {
                // Set a timeout to start fading out after 3 seconds
                setTimeout(function() {
                    successMessage.style.transition = 'opacity 0.5s ease-out'; // Smooth fade-out transition
                    successMessage.style.opacity = '0'; // Start fading out

                    // After the fade-out completes, remove the element from the DOM
                    setTimeout(function() {
                        successMessage.remove();
                    }, 500); // This should match the CSS transition duration
                }, 3000); // 3000 milliseconds = 3 seconds
            }
        });
    </script>
</body>

</html>
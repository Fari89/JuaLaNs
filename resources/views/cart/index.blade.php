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
                                {{-- <a href="{{ route('admin.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-2">Masuk Admin</a> --}}
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
                {{-- <a href="{{ route('admin.index') }}" class="block px-4 py-2 text-white hover:bg-blue-700">Masuk Admin</a> --}}
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
                <!-- Wrapper untuk Tombol dan Modal Checkout -->
<div x-data="{ openCheckoutModal: false, selectedPaymentMethod: '', formSubmitted: false, validationMessage: '' }"> {{-- Tambahkan formSubmitted dan validationMessage --}}

    <!-- Buttons Section (tetap sama seperti sebelumnya) -->
    <div class="flex flex-col sm:flex-row justify-between items-center mt-10 space-y-4 sm:space-y-0 sm:space-x-4">
        <a href="javascript:void(0)"
           x-on:click="openCheckoutModal = true"
           class="w-full sm:w-auto bg-blue-800 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:ring-opacity-50">
            Lanjutkan ke Checkout
        </a>

        <a href="{{ route('product.index') }}" class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-3 px-8 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-700 focus:ring-opacity-50">Lanjutkan Belanja</a>
    </div>

    {{-- Modal Checkout (Versi Simple & Modern) --}}
    <div x-show="openCheckoutModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="fixed inset-0 z-[999] flex items-center justify-center p-4"
         style="display: none;">

        {{-- Overlay latar belakang --}}
        <div x-on:click="openCheckoutModal = false" class="fixed inset-0 bg-black bg-opacity-50"></div>

        {{-- Konten Modal --}}
        <div class="bg-white rounded-lg shadow-xl p-5 w-full max-w-md z-10 mx-auto transform transition-all duration-300 ease-in-out border border-gray-100"> {{-- max-w-md dan p-5 --}}
            <h3 class="text-xl font-bold text-gray-800 mb-5 text-center">Konfirmasi & Pembayaran</h3> {{-- text-xl dan mb-5 --}}

            <form action="{{ route('checkout.process') }}" method="POST"
                  x-on:submit.prevent="
                      formSubmitted = true;
                      validationMessage = '';
                      let form = $event.target;
                      let isValid = true;

                      // Check general required fields
                      form.querySelectorAll('[required]:not([type=radio])').forEach(input => {
                          if (!input.value.trim()) {
                              isValid = false;
                          }
                      });

                      // Check radio buttons for payment method
                      let paymentMethodSelected = form.querySelector('input[name=payment_method]:checked');
                      if (!paymentMethodSelected) {
                          isValid = false;
                      } else if (paymentMethodSelected.value === 'transfer') {
                          // Check required fields for transfer method
                          if (!form.querySelector('#nama_pengirim_rekening').value.trim() || !form.querySelector('#nomor_rekening_pengirim').value.trim()) {
                              isValid = false;
                          }
                      }

                      // Check terms agreement
                      if (!form.querySelector('#agree_terms').checked) {
                          isValid = false;
                      }

                      if (isValid) {
                          form.submit(); // Submit the form if valid
                      } else {
                          validationMessage = 'Mohon lengkapi semua form yang wajib diisi.';
                          setTimeout(() => validationMessage = '', 2000); // Hilangkan notif setelah 2 detik
                      }
                  ">
                @csrf

                <!-- Notifikasi Validasi -->
                <div x-show="formSubmitted && validationMessage"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform -translate-y-2"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform translate-y-0"
                     x-transition:leave-end="opacity-0 transform -translate-y-2"
                     class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline" x-text="validationMessage"></span>
                </div>

                <!-- Ringkasan Pesanan -->
                <div class="mb-5 border-b border-gray-200 pb-4"> {{-- mb-5 --}}
                    <h4 class="text-base font-semibold text-gray-700 mb-2">Ringkasan Pesanan</h4> {{-- text-base dan mb-2 --}}
                    <ul class="space-y-1 text-gray-600 text-xs"> {{-- text-xs --}}
                        @if($cartItems->isNotEmpty())
                            @foreach($cartItems as $item)
                                <li class="flex justify-between items-center py-1"> {{-- Added items-center and py-1 for alignment --}}
                                    <div class="flex items-center space-x-2"> {{-- Flex container for image and text --}}
                                        <img src="{{ $item->product?->foto ? asset('storage/' . $item->product->foto) : 'https://placehold.co/30x30/cccccc/333333?text=No+Image' }}"
                                             alt="{{ $item->nama_produk ?? ($item->product?->nama ?? 'Produk') }}" {{-- Menggunakan $item->product?->nama --}}
                                             class="w-8 h-8 object-cover rounded"> {{-- Small image size --}}
                                        <span>{{ $item->nama_produk ?? ($item->product?->nama ?? 'Produk Tidak Ditemukan') }} ({{ $item->jumlah }}x)</span> {{-- Menggunakan $item->product?->nama --}}
                                    </div>
                                    <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                            <li class="flex justify-between font-bold text-gray-800 mt-2 pt-2 border-t border-gray-200">
                                <span>Total:</span>
                                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </li>
                        @else
                            <li class="text-red-500">Keranjang kosong. Tidak ada item untuk di-checkout.</li>
                        @endif
                    </ul>
                </div>

                <!-- Detail Pengiriman -->
                <div class="mb-5"> {{-- mb-5 --}}
                    <h4 class="text-base font-semibold text-gray-700 mb-2">Detail Pengiriman</h4> {{-- text-base dan mb-2 --}}
                    <div class="space-y-2"> {{-- space-y-2 --}}
                        <div>
                            <label for="nama_penerima" class="block text-xs font-medium text-gray-700">Nama Penerima</label> {{-- text-xs --}}
                            <input type="text" id="nama_penerima" name="nama_penerima" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" {{-- text-sm --}}
                                   placeholder="Nama Lengkap"
                                   value="{{ Session::get('cart_nama_pembeli') ?? (Auth::check() ? Auth::user()->name : '') }}"> {{-- PRIORITASKAN SESI --}}
                        </div>
                        <div>
                            <label for="no_hp_penerima" class="block text-xs font-medium text-gray-700">Nomor Telepon</label> {{-- text-xs --}}
                            <input type="tel" id="no_hp_penerima" name="no_hp_penerima" required
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" {{-- text-sm --}}
                                   placeholder="Contoh: 081234567890" value="{{ Session::get('cart_no_hp') ?? '' }}">
                        </div>
                        <div>
                            <label for="alamat_lengkap" class="block text-xs font-medium text-gray-700">Alamat Lengkap</label> {{-- text-xs --}}
                            <textarea id="alamat_lengkap" name="alamat_lengkap" rows="2" required
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" {{-- text-sm --}}
                                      placeholder="Jalan, Nomor Rumah, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten, Provinsi, Kode Pos">{{ Session::get('cart_alamat') ?? '' }}</textarea>
                        </div>
                    </div>
                    <p class="text-left text-xs text-red-500">* Mohon periksa kembali detail pengiriman anda *</p>
                </div>

                <!-- Metode Pembayaran -->
                <div class="mb-5"> {{-- mb-5 --}}
                    <h4 class="text-base font-semibold text-gray-700 mb-2">Metode Pembayaran</h4> {{-- text-base dan mb-2 --}}
                    <div class="space-y-2">
                        <label class="flex items-center p-2 border border-gray-200 rounded-md cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="cod" x-model="selectedPaymentMethod" class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-gray-800 text-sm">Cash On Delivery (COD)</span>
                        </label>
                        <label class="flex items-center p-2 border border-gray-200 rounded-md cursor-pointer hover:bg-gray-50">
                            <input type="radio" name="payment_method" value="transfer" x-model="selectedPaymentMethod" class="form-radio h-4 w-4 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-gray-800 text-sm">Transfer Bank</span>
                        </label>
                    </div>

                    <!-- Detail Transfer Bank (Conditional) -->
                    <div x-show="selectedPaymentMethod === 'transfer'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" class="mt-4 p-3 bg-blue-50 rounded-md border border-blue-100 text-xs"> {{-- p-3 dan text-xs --}}
                        <p class="text-blue-700 mb-2">Silakan transfer ke:</p> {{-- mb-2 --}}
                        <ul class="list-disc list-inside text-blue-900 mb-3"> {{-- mb-3 --}}
                            <li>BCA: 234567890 (a.n. PT Jualan Online)</li>
                            <li>Mandiri: 0987654321 (a.n. PT Jualan Online)</li>
                        </ul>
                        <div class="space-y-2"> {{-- space-y-2 --}}
                            <div>
                                <label for="nama_pengirim_rekening" class="block text-xs font-medium text-gray-700">Nama Pengirim (Sesuai Rekening)</label> {{-- text-xs --}}
                                <input type="text" id="nama_pengirim_rekening" name="nama_pengirim_rekening"
                                       x-bind:required="selectedPaymentMethod === 'transfer'"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" {{-- text-sm --}}
                                       placeholder="Nama Anda di rekening">
                            </div>
                            <div>
                                <label for="nomor_rekening_pengirim" class="block text-xs font-medium text-gray-700">Nomor Rekening Pengirim</label> {{-- text-xs --}}
                                <input type="text" id="nomor_rekening_pengirim" name="nomor_rekening_pengirim"
                                       x-bind:required="selectedPaymentMethod === 'transfer'"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" {{-- text-sm --}}
                                       placeholder="Nomor rekening Anda">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Catatan Tambahan (Opsional) -->
                <div class="mb-5"> {{-- mb-5 --}}
                    <label for="catatan_pesanan" class="block text-xs font-medium text-gray-700">Catatan Tambahan (Opsional)</label> {{-- text-xs --}}
                    <textarea id="catatan_pesanan" name="catatan_pesanan" rows="2"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" {{-- text-sm --}}
                              placeholder="Misalnya: Mohon dikirim setelah jam 5 sore"></textarea>
                </div>

                <!-- Persetujuan Syarat & Ketentuan -->
                <div class="mb-6">
                    <label class="flex items-start">
                        <input type="checkbox" id="agree_terms" name="agree_terms" required
                               class="form-checkbox h-4 w-4 text-blue-600 rounded mt-1 focus:ring-blue-500">
                        <span class="ml-2 text-gray-700 text-xs"> {{-- text-xs --}}
                            Saya setuju dengan <a href="#" class="text-blue-600 hover:underline font-medium">Syarat & Ketentuan</a> dan <a href="#" class="text-blue-600 hover:underline font-medium">Kebijakan Privasi</a>.
                        </span>
                    </label>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end space-x-3">
                    <button type="button" x-on:click="openCheckoutModal = false" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-4 rounded-md transition duration-150 ease-in-out"> {{-- px-4 --}}
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition duration-150 ease-in-out"> {{-- px-4 --}}
                        Konfirmasi Pesanan
                    </button>
                </div>
            </form>
        </div>
    </div>
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
                    <h4 class="text-lg font-semibold mb-2">Komponen & Tools</h4>
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
    let response = { text: "Maaf, saya belum mengerti. Bisakah Anda lebih spesifik atau pilih opsi di bawah ini? 🤔", replies: [] };

    // --- Sapaan dan Pembuka ---
    if (lowerCaseMessage.includes("halo") || lowerCaseMessage.includes("hai") || lowerCaseMessage.includes("selamat") || lowerCaseMessage.includes("pagi") || lowerCaseMessage.includes("siang") || lowerCaseMessage.includes("sore") || lowerCaseMessage.includes("malam")) {
        response.text = "Halo! 👋 Senang bisa membantu Anda. Ada yang bisa saya bantu hari ini? ✨";
        response.replies = ["Lihat Produk", "Status Pesanan", "Bantuan Umum", "Kontak Admin"];
    } else if (lowerCaseMessage.includes("terima kasih") || lowerCaseMessage.includes("makasih")) {
        response.text = "Sama-sama! 😊 Ada hal lain yang bisa saya bantu?";
        response.replies = ["Kembali ke Menu Utama", "Tutup Chat"];
    } else if (lowerCaseMessage.includes("apa kabar")) {
        response.text = "Saya bot yang baik-baik saja, siap melayani Anda! Bagaimana dengan Anda? 😊";
        response.replies = ["Lihat Produk", "Bantuan Umum"];
    }

    // --- Informasi Produk ---
    else if (lowerCaseMessage.includes("produk") || lowerCaseMessage.includes("barang") || lowerCaseMessage.includes("katalog")) {
        response.text = "Tentu! Anda bisa melihat semua produk kami di halaman 'Lihat Produk'. Kami punya banyak pilihan menarik dari berbagai kategori! 🛍️";
        response.replies = ["Cara Beli Produk", "Produk Terbaru", "Kategori Produk", "Promosi"];
    } else if (lowerCaseMessage.includes("harga")) {
        response.text = "Harga setiap produk tertera jelas di halaman produk masing-masing. Harga di keranjang belanja juga akan otomatis terupdate. Apakah Anda mencari informasi harga untuk produk tertentu? 💰";
        response.replies = ["Ada Diskon?", "Metode Pembayaran"];
    } else if (lowerCaseMessage.includes("spesifikasi") || lowerCaseMessage.includes("detail produk")) {
        response.text = "Untuk detail dan spesifikasi lengkap produk, silakan kunjungi halaman produk yang bersangkutan. Biasanya kami menyertakan semua informasi teknis di sana. 🔍";
        response.replies = ["Cari Produk", "Cara Cek Spesifikasi"];
    } else if (lowerCaseMessage.includes("stok") || lowerCaseMessage.includes("ketersediaan")) {
        response.text = "Ketersediaan stok produk tertera di halaman produk masing-masing. Jika tertulis 'Stok Habis' atau 'Pre-order', artinya produk tersebut sedang tidak tersedia atau dalam proses restock. 📦";
        response.replies = ["Notifikasi Stok", "Produk Rekomendasi"];
    } else if (lowerCaseMessage.includes("ulasan") || lowerCaseMessage.includes("review")) {
        response.text = "Anda bisa melihat ulasan produk dari pembeli lain di bagian bawah halaman setiap produk. Ulasan membantu Anda membuat keputusan yang lebih baik! ⭐";
        response.replies = ["Cara Memberi Ulasan", "Ulasan Terbaik"];
    }

    // --- Proses Pembelian ---
    else if (lowerCaseMessage.includes("beli") || lowerCaseMessage.includes("cara order") || lowerCaseMessage.includes("pesan")) {
        response.text = "Mudah sekali! 🛒 Cukup tambahkan produk yang Anda inginkan ke keranjang, lalu klik 'Checkout' dan ikuti langkah-langkah pembayaran hingga selesai. Prosesnya cepat dan aman.";
        response.replies = ["Metode Pembayaran", "Biaya Kirim", "Registrasi Akun"];
    } else if (lowerCaseMessage.includes("keranjang") || lowerCaseMessage.includes("masuk keranjang")) {
        response.text = "Produk yang sudah Anda tambahkan bisa dilihat di ikon keranjang belanja Anda di pojok kanan atas. Dari sana, Anda bisa mengatur jumlah atau melanjutkan ke pembayaran. 🛒";
        response.replies = ["Checkout", "Hapus Produk dari Keranjang"];
    } else if (lowerCaseMessage.includes("pembayaran") || lowerCaseMessage.includes("bayar") || lowerCaseMessage.includes("transfer")) {
        response.text = "Kami menerima berbagai metode pembayaran yang nyaman untuk Anda: Transfer Bank (BCA, Mandiri), E-wallet (OVO, GoPay, Dana), dan Kartu Kredit/Debit (Visa, Mastercard). 💳";
        response.replies = ["Konfirmasi Pembayaran", "Masalah Pembayaran", "Cicilan"];
    } else if (lowerCaseMessage.includes("konfirmasi pembayaran")) {
        response.text = "Setelah melakukan pembayaran, biasanya sistem kami akan otomatis mendeteksinya. Jika dalam 1x24 jam pesanan belum terupdate, Anda bisa konfirmasi manual di halaman 'Status Pesanan' dengan menyertakan bukti transfer. ✅";
        response.replies = ["Cek Status Pembayaran", "Hubungi Dukungan Pembayaran"];
    } else if (lowerCaseMessage.includes("cicilan") || lowerCaseMessage.includes("kredit")) {
        response.text = "Kami menyediakan opsi cicilan melalui mitra penyedia layanan finansial tertentu. Informasi lebih lanjut dan syarat & ketentuan bisa Anda lihat di halaman metode pembayaran. 📑";
        response.replies = ["Mitra Cicilan", "Simulasi Cicilan"];
    }

    // --- Pengiriman dan Status Pesanan ---
    else if (lowerCaseMessage.includes("status pesanan") || lowerCaseMessage.includes("kirim") || lowerCaseMessage.includes("dikirim")) {
        response.text = "Untuk cek status pesanan Anda, mohon masukkan **nomor pesanan** Anda. Jika Anda sudah login, Anda juga bisa melihat riwayat pembelian di dashboard akun Anda. 🚚";
        response.replies = ["Lacak Pesanan", "Kapan Dikirim?", "Pengiriman Lama"];
    } else if (lowerCaseMessage.includes("lacak pesanan") || lowerCaseMessage.includes("tracking")) {
        response.text = "Silakan masukkan nomor resi atau nomor pesanan Anda untuk melacak posisi paket Anda secara real-time. Tracking bisa dilihat di halaman Status Pesanan. 📍";
        response.replies = ["Nomor Resi Hilang", "Estimasi Waktu Tiba"];
    } else if (lowerCaseMessage.includes("biaya kirim") || lowerCaseMessage.includes("ongkir")) {
        response.text = "Biaya pengiriman dihitung berdasarkan lokasi tujuan dan berat/volume produk. Anda bisa melihat estimasi biaya kirim saat proses checkout sebelum pembayaran. 💲";
        response.replies = ["Jangkauan Pengiriman", "Kurir yang Digunakan"];
    } else if (lowerCaseMessage.includes("kurir") || lowerCaseMessage.includes("ekspedisi")) {
        response.text = "Kami bekerja sama dengan berbagai jasa pengiriman terpercaya seperti JNE, J&T, SiCepat, dan Pos Indonesia untuk memastikan pesanan Anda sampai dengan aman dan cepat. 🚚💨";
        response.replies = ["Ganti Kurir", "Pengiriman Instan"];
    } else if (lowerCaseMessage.includes("pengiriman lama") || lowerCaseMessage.includes("belum sampai")) {
        response.text = "Mohon maaf atas ketidaknyamanan ini. 🙏 Terkadang ada kendala di luar dugaan. Silakan cek status pesanan Anda dengan nomor resi. Jika masih terkendala, hubungi customer service kami. ";
        response.replies = ["Hubungi CS Pengiriman", "Ajukan Komplain"];
    } else if (lowerCaseMessage.includes("jangkauan pengiriman") || lowerCaseMessage.includes("kirim ke mana")) {
        response.text = "Kami melayani pengiriman ke seluruh wilayah Indonesia! Dari Sabang sampai Merauke, kami siap kirim pesanan Anda. 🇮🇩";
        response.replies = ["Estimasi Waktu Pengiriman", "Pengiriman Internasional"];
    }

    // --- Pengembalian & Penukaran ---
    else if (lowerCaseMessage.includes("retur") || lowerCaseMessage.includes("kembali barang") || lowerCaseMessage.includes("pengembalian")) {
        response.text = "Untuk proses pengembalian barang, pastikan produk masih dalam kondisi baik dan sesuai Syarat & Ketentuan retur kami. Anda bisa mengajukan permohonan retur di halaman Riwayat Pesanan Anda. ↩️";
        response.replies = ["Syarat Retur", "Status Retur"];
    } else if (lowerCaseMessage.includes("tukar barang") || lowerCaseMessage.includes("penukaran")) {
        response.text = "Penukaran barang bisa dilakukan jika ada kesalahan pengiriman dari pihak kami atau cacat produk. Silakan ajukan permohonan penukaran melalui halaman Riwayat Pesanan Anda. 🔄";
        response.replies = ["Syarat Penukaran", "Produk Tidak Sesuai"];
    } else if (lowerCaseMessage.includes("refund") || lowerCaseMessage.includes("dana kembali")) {
        response.text = "Proses refund akan dilakukan setelah barang retur kami terima dan diverifikasi. Dana akan dikembalikan sesuai metode pembayaran awal atau ke rekening Anda. Waktu proses bisa bervariasi. 💸";
        response.replies = ["Berapa Lama Refund?", "Metode Refund"];
    }

    // --- Akun & Keamanan ---
    else if (lowerCaseMessage.includes("akun") || lowerCaseMessage.includes("registrasi") || lowerCaseMessage.includes("daftar")) {
        response.text = "Membuat akun sangat mudah! Cukup klik 'Daftar' di pojok kanan atas, lalu isi data diri Anda. Dengan akun, Anda bisa melacak pesanan dan mendapatkan promo eksklusif. 👤";
        response.replies = ["Lupa Password", "Manfaat Akun"];
    } else if (lowerCaseMessage.includes("lupa password") || lowerCaseMessage.includes("reset password")) {
        response.text = "Jangan khawatir! Klik 'Lupa Password' di halaman login, masukkan email Anda, dan kami akan kirim link untuk reset password Anda. 🔑";
        response.replies = ["Ganti Email Akun", "Masalah Login"];
    } else if (lowerCaseMessage.includes("keamanan akun") || lowerCaseMessage.includes("data pribadi")) {
        response.text = "Keamanan data Anda adalah prioritas kami. JuaLaNs menggunakan enkripsi dan sistem keamanan terkini untuk melindungi informasi pribadi dan transaksi Anda.🔒";
        response.replies = ["Kebijakan Privasi", "Verifikasi 2 Langkah"];
    }

    // --- Promosi & Diskon ---
    else if (lowerCaseMessage.includes("diskon") || lowerCaseMessage.includes("promo") || lowerCaseMessage.includes("voucher")) {
        response.text = "Ya, kami sering ada promo menarik! Cek halaman 'Promosi' atau bagian banner di halaman utama kami untuk penawaran terbaru. Jangan sampai ketinggalan kesempatan! 🎉";
        response.replies = ["Syarat & Ketentuan Promo", "Cara Pakai Voucher"];
    } else if (lowerCaseMessage.includes("kode promo") || lowerCaseMessage.includes("masukkan voucher")) {
        response.text = "Kode promo atau voucher bisa dimasukkan di halaman keranjang belanja atau halaman checkout sebelum Anda melakukan pembayaran. Pastikan kode sudah benar ya! 🎁";
        response.replies = ["Voucher Tidak Berlaku", "Promo Hari Ini"];
    }

    // --- Bantuan Umum & Kontak ---
    else if (lowerCaseMessage.includes("bantuan umum") || lowerCaseMessage.includes("tanya")) {
        response.text = "Silakan sampaikan pertanyaan Anda atau pilih dari topik bantuan umum yang sering ditanyakan. Kami siap membantu! 🙋‍♀️";
        response.replies = ["FAQ", "Hubungi Customer Service", "Tentang JuaLaNs"];
    } else if (lowerCaseMessage.includes("kontak") || lowerCaseMessage.includes("admin") || lowerCaseMessage.includes("customer service") || lowerCaseMessage.includes("cs")) {
        response.text = "Anda bisa menghubungi tim dukungan kami melalui: \n\n📧 Email: **support@jualans.com** \n📞 Telepon: **+6281234567890** (Jam Kerja: Senin-Jumat, 09.00-17.00 WITA) \n\nKami siap membantu Anda dengan senang hati! 🧑‍💻";
        response.replies = ["Jam Operasional", "Kirim Pesan Sekarang"];
    } else if (lowerCaseMessage.includes("jam operasional")) {
        response.text = "Tim Customer Service kami beroperasi dari hari **Senin hingga Jumat, pukul 09.00 - 17.00 WITA**. Kami akan berusaha membalas secepat mungkin di luar jam tersebut. ⏰";
        response.replies = ["Kontak Cepat", "Tulis Email"];
    } else if (lowerCaseMessage.includes("tentang jualans") || lowerCaseMessage.includes("siapa jualans")) {
        response.text = "JuaLaNs adalah platform e-commerce yang berdedikasi menyediakan berbagai produk berkualitas dengan harga kompetitif dan pengalaman belanja yang nyaman serta aman bagi Anda. Kami berkomitmen untuk kepuasan pelanggan! 🌟";
        response.replies = ["Visi & Misi", "Kebijakan Privasi"];
    } else if (lowerCaseMessage.includes("kebijakan privasi") || lowerCaseMessage.includes("privasi data")) {
        response.text = "Kebijakan privasi kami menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi data pribadi Anda. Anda bisa membacanya lengkap di halaman Kebijakan Privasi kami. 📄";
        response.replies = ["Keamanan Akun", "Syarat & Ketentuan"];
    } else if (lowerCaseMessage.includes("syarat dan ketentuan") || lowerCaseMessage.includes("ketentuan layanan")) {
        response.text = "Syarat dan Ketentuan layanan kami mengatur penggunaan platform JuaLaNs. Pastikan Anda membacanya untuk memahami hak dan kewajiban Anda sebagai pengguna. 📜";
        response.replies = ["Kebijakan Pengembalian", "Kebijakan Pengiriman"];
    }

    // --- Contoh Pertanyaan Spesifik Produk (Furniture) ---
    else if (lowerCaseMessage.includes("lemari") || lowerCaseMessage.includes("meja") || lowerCaseMessage.includes("kursi") || lowerCaseMessage.includes("furniture")) {
        response.text = "Anda mencari produk **furniture**? Kami punya berbagai pilihan lemari, meja, kursi, dan set ruang tamu. Furniture jenis apa yang menarik perhatian Anda? 🛋️";
        response.replies = ["Meja Makan", "Sofa Minimalis", "Lemari Pakaian", "Katalog Furniture"];
    } else if (lowerCaseMessage.includes("sofa minimalis")) {
        response.text = "**Sofa minimalis** adalah pilihan tepat untuk ruang keluarga Anda! Harganya mulai dari Rp 3.000.000. Fitur utamanya: Desain modern, bahan berkualitas, dan nyaman. Tertarik? ✨";
        response.replies = ["Lihat Detail Sofa Minimalis", "Beli Sekarang Sofa Minimalis", "Pilihan Warna Sofa"];
    } else if (lowerCaseMessage.includes("desain interior") || lowerCaseMessage.includes("dekorasi rumah")) {
        response.text = "Kami bisa bantu Anda menemukan **furniture** yang cocok dengan gaya desain interior atau dekorasi rumah Anda. Ceritakan lebih banyak tentang preferensi Anda! 🏡";
        response.replies = ["Furniture Modern", "Furniture Klasik", "Tips Dekorasi"];
    }

    // --- Default / Fallback Response ---
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

<x-app-layout>
    <div id="preloader" class="preloader-container">
        <div class="spinner"></div>
    </div>
    
    <section x-data="carousel()" x-init="start()" class="relative h-screen w-full overflow-hidden bg-gray-900 flex flex-col justify-between">
        <div class="absolute inset-0 z-0 flex transition-transform duration-[1000ms] ease-in-out" :style="`transform: translateX(-${currentIndex * 100}%);`">
            <template x-for="(image, index) in images" :key="index">
                <div class="min-w-full h-screen"><img :src="image" alt="Slide" class="w-full h-full object-cover" /></div>
            </template>
        </div>
        <div class="relative z-10 flex-1 flex flex-col justify-center items-center text-center px-4">
            <div class="max-w-4xl text-white animate__animated animate__fadeInDown">
                <img src="{{ url('FaRs_logo.png') }}" alt="Logo" class="h-12 md:h-24 mb-4 mx-auto" />
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 drop-shadow-lg">Selamat Datang</h1>
                <p class="text-lg md:text-2xl mb-6 max-w-2xl mx-auto">Temukan produk terbaik pilihan dengan harga bersahabat!</p>
                <form action="{{ route('dashboard') }}" method="GET" class="flex gap-2 w-full">
                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="flex-auto px-4 py-2 border border-white border-opacity-60
                                bg-white bg-opacity-10 text-white
                                rounded-xl shadow-md
                                placeholder-white
                                focus:outline-none focus:ring-2 focus:ring-white focus:ring-opacity-80 focus:border-transparent
                                transition-all duration-300 ease-in-out w-full"
                        placeholder="Cari produk elegan..."
                    />
                    <button type="submit"
                        aria-label="Cari"
                        class="inline-flex items-center justify-center px-4 py-2
                                bg-white bg-opacity-10 hover:bg-opacity-20
                                text-white border border-white border-opacity-50
                                rounded-lg shadow-sm
                                transition duration-300 ease-in-out
                                focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span class="sr-only">Cari</span>
                    </button>
                </form>
            </div>
        </div>
        <div
            x-data="{ showInfoBar: false }"
            x-init="
                setTimeout(() => { showInfoBar = true; }, 1000);
                setTimeout(() => { showInfoBar = false; }, 8000);
            "
            x-show="showInfoBar"
            x-transition:enter="transition ease-out duration-500 transform translate-y-full opacity-0"
            x-transition:enter-start="opacity-0 translate-y-full"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-300 transform translate-y-0 opacity-100"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-full"
            class="fixed bottom-4 left-4 z-[9999] bg-gray-800 text-white p-3 rounded-lg shadow-xl
                     flex items-center space-x-3 max-w-sm"
            style="display: none;"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <p class="text-sm font-medium leading-tight">
                    Ide & Pengembangan adalah milik <strong class="text-blue-300">JuaLaNs.</strong>
                </p>
                <p class="text-xs text-gray-400 leading-tight mt-1">
                    Dirancang dan dikembangkan oleh Muhammad Farihin Mushawwir.
                </p>
            </div>
            <button
                @click="showInfoBar = false"
                class="flex-shrink-0 bg-blue-600 hover:bg-blue-700 text-white text-xs py-1 px-3 rounded-md transition duration-200"
            >
                OK
            </button>
        </div>
    </section>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-10 fade-in-section">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 text-center leading-tight mb-10">
            Nikmati Kemudahan Berbelanja di JuaLaNs!
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-1 mt-5">
            <div
                class="flex flex-col items-center text-center p-6 rounded-lg shadow-lg
                        transition-all duration-300 ease-in-out transform hover:scale-105 cursor-pointer relative overflow-hidden group"
                x-data="{ open: false }"
                @click="open = !open"
            >
                <div class="w-full h-56 md:h-64 overflow-hidden rounded-lg mb-6 relative">
                    <img src="{{ asset('iklanmudah.png') }}" alt="Belanja Mudah" class="w-full h-full object-cover rounded-lg">
                    <div
                        class="absolute inset-0 bg-black bg-opacity-40 flex items-end justify-start p-4 rounded-lg"
                        x-show="!open"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                    >
                        <span class="text-white text-l font-semibold flex items-center
                                     transform translate-x-0 group-hover:translate-x-2 transition-transform duration-300">
                            Lihat Detail <span class="ml-2">&rarr;</span>
                        </span>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Belanja Semakin Mudah, Kapan Saja Dimana Saja</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Temukan ribuan produk berkualitas dari berbagai kategori. Cukup beberapa klik, barang impian Anda langsung di keranjang. Transaksi aman dan nyaman.
                </p>
                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-4"
                    class="absolute inset-0 bg-white p-6 rounded-lg flex flex-col justify-center items-center text-center z-10"
                    style="display: none;"
                >
                    <h4 class="text-xl font-bold text-gray-900 mb-4">Detail Belanja Mudah</h4>
                    <p class="text-gray-700 text-base mb-6">
                        Nikmati pengalaman berbelanja online yang tak tertandingi dengan antarmuka yang intuitif dan proses checkout yang cepat. Dari fashion hingga elektronik, semua ada di genggaman Anda. Pembayaran aman dengan berbagai pilihan metode, termasuk transfer bank, kartu kredit, dan e-wallet.
                    </p>
                    <button @click.stop="open = false" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                        Tutup Detail
                    </button>
                </div>
            </div>
            <div
                class="flex flex-col items-center text-center p-6 rounded-lg shadow-lg
                        transition-all duration-300 ease-in-out transform hover:scale-105 cursor-pointer relative overflow-hidden group"
                x-data="{ open: false }"
                @click="open = !open"
            >
                <div class="w-full h-56 md:h-64 overflow-hidden rounded-lg mb-6 relative">
                    <img src="{{ asset('kurir.png') }}" alt="Pengiriman Cepat" class="w-full h-full object-cover rounded-lg">
                    <div
                        class="absolute inset-0 bg-black bg-opacity-40 flex items-end justify-start p-4 rounded-lg"
                        x-show="!open"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                    >
                        <span class="text-white text-l font-semibold flex items-center
                                     transform translate-x-0 group-hover:translate-x-2 transition-transform duration-300">
                            Lihat Detail <span class="ml-2">&rarr;</span>
                        </span>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Pengiriman Cepat dan Aman Hingga Depan Pintu Anda</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Kami bekerja sama dengan mitra pengiriman terbaik untuk memastikan pesanan Anda tiba dengan cepat dan selamat. Lacak pesanan Anda secara real-time.
                </p>
                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-4"
                    class="absolute inset-0 bg-white p-6 rounded-lg flex flex-col justify-center items-center text-center z-10"
                    style="display: none;"
                >
                    <h4 class="text-xl font-bold text-gray-900 mb-4">Detail Pengiriman Cepat</h4>
                    <p class="text-gray-700 text-base mb-6">
                        Kami bermitra dengan penyedia logistik terkemuka untuk memastikan setiap paket Anda ditangani dengan hati-hati. Dapatkan notifikasi status pengiriman, perkiraan waktu tiba, dan riwayat pengiriman lengkap. Pengiriman instan juga tersedia di area tertentu!
                    </p>
                    <button @click.stop="open = false" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                        Tutup Detail
                    </button>
                </div>
            </div>

            <div
                class="flex flex-col items-center text-center p-6 rounded-lg shadow-lg
                        transition-all duration-300 ease-in-out transform hover:scale-105 cursor-pointer relative overflow-hidden group"
                x-data="{ open: false }"
                @click="open = !open"
            >
                <div class="w-full h-56 md:h-64 overflow-hidden rounded-lg mb-6 relative">
                    <img src="{{ asset('iklanjalan.png') }}" alt="Penawaran Eksklusif" class="w-full h-full object-cover rounded-lg">
                    <div
                        class="absolute inset-0 bg-black bg-opacity-40 flex items-end justify-start p-4 rounded-lg"
                        x-show="!open"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                    >
                        <span class="text-white text-l font-semibold flex items-center
                                     transform translate-x-0 group-hover:translate-x-2 transition-transform duration-300">
                            Lihat Detail <span class="ml-2">&rarr;</span>
                        </span>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-3">Dapatkan Penawaran dan Voucher Eksklusif!</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    Jadilah bagian dari keluarga JuaLaNs dan nikmati berbagai diskon menarik, promo spesial, serta voucher eksklusif yang hanya tersedia untuk Anda. Jangan lewatkan kesempatan ini!
                </p>
                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-4"
                    class="absolute inset-0 bg-white p-6 rounded-lg flex flex-col justify-center items-center text-center z-10"
                    style="display: none;"
                >
                    <h4 class="text-xl font-bold text-gray-900 mb-4">Detail Penawaran Eksklusif</h4>
                    <p class="text-gray-700 text-base mb-6">
                        Sebagai anggota JuaLaNs, Anda akan mendapatkan akses pertama ke penawaran terbatas, diskon musiman, dan voucher personal yang disesuaikan dengan minat Anda. Pastikan Anda selalu memeriksa notifikasi dan email Anda agar tidak ketinggalan!
                    </p>
                    <button @click.stop="open = false" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                        Tutup Detail
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <div class="max-w-6xl mx-auto p-4 relative">
    <!-- Tombol Prev -->
    <button id="prevBtn" class="absolute left-0 top-1/2 -translate-y-1/2 bg-white border border-gray-300 text-blue-600 p-3 rounded-full shadow hover:bg-blue-50 z-10">
        &#10094;
    </button>

    <!-- Carousel -->
    <div id="carouselContainer" 
         class="flex gap-4 overflow-x-auto scroll-smooth pb-2"
         style="scrollbar-width: thin; scrollbar-color: #bbb transparent;">
         
        <!-- Card 1 -->
        <div class="flex-shrink-0 w-64">
            <div class="h-full bg-white border border-gray-200 rounded-lg p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition-shadow duration-300">
                <div>
                    <h3 class="text-2xl font-bold text-blue-600 mb-2">Diskon 50% </h3>
                    <svg fill="#0071eb" width="77px" height="77px" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" stroke="#0071eb"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g data-name="33 discount ticket" id="_33_discount_ticket"> <path d="M57.46,27.91H59.5a1,1,0,0,0,1-1V18.76a2.027,2.027,0,0,0-2.02-2.02H5.52A2.027,2.027,0,0,0,3.5,18.76v8.15a1,1,0,0,0,1,1H6.54a4.09,4.09,0,1,1,0,8.18H4.5a1,1,0,0,0-1,1v8.15a2.027,2.027,0,0,0,2.02,2.02H58.48a2.027,2.027,0,0,0,2.02-2.02V37.09a1,1,0,0,0-1-1H57.46a4.09,4.09,0,1,1,0-8.18Zm0,10.18H58.5l-.02,7.17L5.5,45.24V38.09H6.54a6.09,6.09,0,0,0,0-12.18H5.5l.02-7.17,52.98.02v7.15H57.46a6.09,6.09,0,0,0,0,12.18Z"></path> <path d="M32,20.814a1,1,0,0,0-1,1v2.038a1,1,0,1,0,2,0V21.814A1,1,0,0,0,32,20.814Z"></path> <path d="M32,39.148a1,1,0,0,0-1,1v2.038a1,1,0,1,0,2,0V40.148A1,1,0,0,0,32,39.148Z"></path> <path d="M32,33.037a1,1,0,0,0-1,1v2.037a1,1,0,0,0,2,0V34.037A1,1,0,0,0,32,33.037Z"></path> <path d="M32,26.926a1,1,0,0,0-1,1v2.037a1,1,0,0,0,2,0V27.926A1,1,0,0,0,32,26.926Z"></path> <path d="M16.722,26.889H20.8a1,1,0,0,0,0-2H16.722a1,1,0,0,0,0,2Z"></path> <path d="M16.722,33h6.111a1,1,0,0,0,0-2H16.722a1,1,0,0,0,0,2Z"></path> <path d="M24.871,37.111H16.722a1,1,0,0,0,0,2h8.149a1,1,0,1,0,0-2Z"></path> <path d="M39.13,24.89a3.035,3.035,0,1,0,3.04,3.04A3.045,3.045,0,0,0,39.13,24.89Zm0,4.07a1.035,1.035,0,1,1,1.04-1.03A1.037,1.037,0,0,1,39.13,28.96Z"></path> <path d="M47.28,33.04a3.035,3.035,0,1,0,3.03,3.03A3.037,3.037,0,0,0,47.28,33.04Zm0,4.07a1.035,1.035,0,1,1,0-2.07,1.035,1.035,0,0,1,0,2.07Z"></path> <path d="M49,26.2a1,1,0,0,0-1.414,0L37.4,36.386A1,1,0,1,0,38.818,37.8L49,27.614A1,1,0,0,0,49,26.2Z"></path> </g> </g></svg>
                    <p class="text-sm text-gray-600">Setiap pembelian di atas 3 Juta</p>  
                    {{-- <img src="{{ asset('iklanjalan.png') }}" alt="Penawaran Eksklusif" class="w-full h-full object-cover rounded-lg"> --}}
                </div>
                <div class="flex items-center justify-end mt-4">
                    <a href="#" class="text-blue-500 hover:text-blue-700 text-xl">➜</a>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="flex-shrink-0 w-64">
            <div class="h-full bg-white border border-gray-200 rounded-lg p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition-shadow duration-300">
                <div>
                    <span class="text-2xl font-semibold text-blue-600 block">Promo Online</span>
                    <span class="text-xs text-gray-400">10 - 20 Agustus 2025</span>
                    <p class="mt-3 text-lg font-bold text-blue-600">Rp90.000</p>
                    <p class="text-xs text-gray-600 mt-2">Terbatas hanya hingga tanggal yang berlaku.</p>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <a href="#" class="text-blue-500 hover:text-blue-700 text-xl">➜</a>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="flex-shrink-0 w-64">
            <div class="h-full bg-white border border-gray-200 rounded-lg p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition-shadow duration-300">
                <div>
                    <h3 class="text-2xl font-bold text-blue-600">Promo terbaik</h3>
                    <p class="text-sm text-gray-600">Promo terbaik di bulan kemerdekaan.</p>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <a href="#" class="text-blue-500 hover:text-blue-700 text-xl">➜</a>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="flex-shrink-0 w-64">
            <div class="h-full bg-white border border-gray-200 rounded-lg p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition-shadow duration-300">
                <div>
                    <h3 class="text-lg font-bold text-blue-600">Produk terbaik</h3>
                    <p class="text-sm text-gray-600">Only Rp500.000</p>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <a href="#" class="text-blue-500 hover:text-blue-700 text-xl">➜</a>
                </div>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="flex-shrink-0 w-64">
            <div class="h-full bg-white border border-gray-200 rounded-lg p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition-shadow duration-300">
                <div>
                    <h3 class="text-lg font-bold text-blue-600">Dessert Special</h3>
                    <p class="text-sm text-gray-600">Free dessert for orders above Rp150.000</p>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <a href="#" class="text-blue-500 hover:text-blue-700 text-xl">➜</a>
                </div>
            </div>
        </div>

        <!-- Card 6 -->
        <div class="flex-shrink-0 w-64">
            <div class="h-full bg-white border border-gray-200 rounded-lg p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition-shadow duration-300">
                <div>
                    <h3 class="text-lg font-bold text-blue-600">Family Combo</h3>
                    <p class="text-sm text-gray-600">4 burgers + fries only Rp200.000</p>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <a href="#" class="text-blue-500 hover:text-blue-700 text-xl">➜</a>
                </div>
            </div>
        </div>

        <!-- Card 7 -->
        <div class="flex-shrink-0 w-64">
            <div class="h-full bg-white border border-gray-200 rounded-lg p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition-shadow duration-300">
                <div>
                    <h3 class="text-lg font-bold text-blue-600">Free Drink</h3>
                    <p class="text-sm text-gray-600">Get a free drink with any pizza</p>
                </div>
                <div class="flex items-center justify-end mt-4">
                    <a href="#" class="text-blue-500 hover:text-blue-700 text-xl">➜</a>
                </div>
            </div>
        </div>

    </div>

    <!-- Tombol Next -->
    <button id="nextBtn" class="absolute right-0 top-1/2 -translate-y-1/2 bg-white border border-gray-300 text-blue-600 p-3 rounded-full shadow hover:bg-blue-50 z-10">
        &#10095;
    </button>
</div>

<script>
    const container = document.getElementById('carouselContainer');
    document.getElementById('prevBtn').addEventListener('click', () => {
        container.scrollBy({ left: -250, behavior: 'smooth' });
    });
    document.getElementById('nextBtn').addEventListener('click', () => {
        container.scrollBy({ left: 250, behavior: 'smooth' });
    });
</script>

</div> 

    <h2 class="text-4xl font-extrabold text-center mt-12 mb-4 text-gray-900 fade-in-section">Produk Unggulan Kami</h2>
    <p class="text-center text-lg text-gray-600 mb-10 fade-in-section">Solusi terbaik untuk kebutuhan rumah tangga hingga perkantoran Anda.</p>

    <div class="max-w-7xl mx-auto px-4 py-8 fade-in-section">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($product as $item)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col transform hover:scale-105 transition-all duration-300 ease-in-out group">
                    <div class="relative h-56 flex items-center justify-center bg-white p-4">
                        <img onclick="openModal({{ $item->id }}, 'detail')" src="{{ url('storage/'.$item->foto) }}" alt="{{ $item->nama }}" class="object-contain max-h-full max-w-full rounded-md cursor-pointer transition-transform duration-300 group-hover:blur-sm" />
                        <div onclick="openModal({{ $item->id }}, 'detail')" class="absolute inset-0 bg-black bg-opacity-50 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white mb-2 transform -translate-y-2 group-hover:translate-y-0 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <p class="text-white text-base font-semibold opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">Lihat Detail</p>
                        </div>
                    </div>
                    <div class="p-5 flex-1 flex flex-col">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $item->nama }}</h3>

                        <div class="flex items-center mb-2">
                            @php
                                $averageRating = rand(41, 50) / 10;
                                $numberOfReviews = rand(10, 200);
                            @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= floor($averageRating))
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.783.57-1.838-.197-1.538-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z" />
                                    </svg>
                                @elseif ($i - 0.5 <= $averageRating)
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.783.57-1.838-.197-1.538-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z" />
                                        <path fill-rule="evenodd" d="M10 17.185l-2.618 1.903a.75.75 0 01-1.173-.807l1.002-3.284a.75.75 0 00-.285-.758L3.33 10.158a.75.75 0 01.312-1.3l3.435-.296a.75.75 0 00.622-.454l1.243-3.036a.75.75 0 011.396 0l1.243 3.036a.75.75 0 00.622.454l3.435.296a.75.75 0 01.312 1.3l-2.604 2.115a.75.75 0 00-.285.758l1.002 3.284a.75.75 0 01-1.173.807L10 17.185zM10 18.25l-3.321 2.417a1.5 1.5 0 01-2.34-1.614l1.28-4.19a1.5 1.5 0 00-.57-1.503L.823 10.38a1.5 1.5 0 01.624-2.58l4.38-1.78a1.5 1.5 0 001.24-1.025l1.62-3.95a1.5 1.5 0 012.78 0l1.62 3.95a1.5 1.5 0 001.24 1.025l4.38 1.78a1.5 1.5 0 01.624 2.58l-3.466 2.812a1.5 1.5 0 00-.57 1.503l1.28 4.19a1.5 1.5 0 01-2.34 1.614L10 18.25z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.538 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.783.57-1.838-.197-1.538-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z" />
                                    </svg>
                                @endif
                            @endfor
                            <span class="ml-2 text-sm text-gray-600 font-medium">({{ number_format($averageRating, 1) }} / 5)</span>
                            <span class="ml-1 text-xs text-gray-500">({{ $numberOfReviews }} ulasan)</span>
                        </div>
                        <p class="text-indigo-600 font-extrabold text-lg mb-3">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        <p class="text-gray-700 text-sm flex-1 leading-relaxed mb-4">{{ Str::limit($item->deskripsi, 120) }}</p>
                        <button onclick="openModal({{ $item->id }}, 'beli')" class="mt-auto bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                            Beli Sekarang
                        </button>
                    </div>
                </div>
                
            @empty
                <div class="col-span-1 sm:col-span-2 lg:col-span-3 xl:col-span-4 text-center py-12">
                    <h1 class="text-3xl font-bold text-gray-700 mb-3">Mohon Maaf...</h1>
                    <p class="text-xl text-gray-500">Produk yang Anda cari saat ini belum tersedia.</p>
                    <p class="text-md text-gray-400 mt-2">Silakan cek kembali nanti atau hubungi kami untuk informasi lebih lanjut.</p>
                </div>
            @endforelse
        </div>
    </div>
        <div class="text-center mb-10 ">
        <a href="/product" class=" mt-10 mb-10 left-4 bg-blue-700  text-white hover:bg-blue-700 px-4 py-2 rounded-lg shadow-md font-medium transition-transform duration-300 z-50 cursor-pointer active:scale-95">
            Lihat semua produk.
        </a>
    </div>
    
     <div id="buyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl p-6 relative overflow-auto max-h-full">
            <button onclick="closeModal()" class="absolute top-3 right-4 text-gray-600 hover:text-red-600 text-3xl font-bold">&times;</button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="text-center mb-2"><p class="text-sm text-gray-500">Klik gambar untuk zoom</p></div>
                    <img id="modalImage" src="" alt="" class="cursor-zoom-in w-full h-64 object-contain bg-white rounded transition duration-300 hover:scale-105" onclick="zoomImage()" />
                </div>
                <div>
                    <h2 id="modalTitle" class="text-2xl font-bold text-gray-800 mb-2"></h2>
                    <p id="modalPrice" class="text-yellow-600 text-xl font-semibold mb-4"></p>
                    <p id="modalDesc" class="text-gray-700 mb-6 text-justify"></p>
                    <div id="buyFormSection">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" id="modalProductId" />
                            @foreach([['Nama Pembeli','nama_pembeli'],['Alamat','alamat'],['Nomor Telepon','no_hp'],['Jumlah','jumlah']] as $field)
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">{{ $field[0] }}</label>
                                    <input type="{{ $field[1]=='no_hp'?'number':'text' }}" name="{{ $field[1] }}" required class="mt-1 p-2 w-full border rounded focus:ring focus:border-blue-300" value="{{ $field[1]=='jumlah'?'1':'' }}">
                                </div>
                            @endforeach
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded text-lg transition">Masukkan Keranjang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="zoomImageModal" class="fixed inset-0 bg-black bg-opacity-80 hidden items-center justify-center z-50 p-4" onclick="closeZoomImage()">
        <img id="zoomedImage" src="" alt="Zoomed" class="max-w-full max-h-full" />
    </div>

    <div x-data="{ showLoginModal: false }" x-show="showLoginModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[100]">
        <div class="bg-white p-6 rounded-lg shadow-xl max-w-sm w-full text-center relative"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90">
            <button @click="showLoginModal = false" class="absolute top-2 right-4 text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
            <img src="{{ url('Jualans.png') }}" alt="Jualans Logo" class="h-12 mx-auto mb-2"/>
            <p class="text-gray-700 mb-4">
                Anda harus **login** terlebih dahulu untuk membeli produk.
            </p>
            <div class="flex flex-col space-y-2">
                <a href="{{ route('login') }}" class="bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">Login Sekarang</a>
                <a href="{{ route('register') }}" class="text-blue-600 py-2 rounded-md hover:text-blue-800 transition">Belum Punya Akun? Register</a>
            </div>
        </div>
    
    <div id="zoomImageModal" class="fixed inset-0 bg-black bg-opacity-80 hidden items-center justify-center z-50 p-4" onclick="closeZoomImage()">
        <img id="zoomedImage" src="" alt="Zoomed" class="max-w-full max-h-full" />
    </div>
    
    </div>
    </section>
    <section class="bg-gray-50 py-16 fade-in-section">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-12 text-gray-800">Mengapa Harus Memilih JuaLaNs?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-6 bg-white rounded-xl shadow-lg border border-gray-200 transform transition-transform duration-300 hover:scale-105">
                    <div class="w-16 h-16 mx-auto bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">Kualitas Terjamin</h3>
                    <p class="text-gray-600">Semua produk kami telah melewati proses seleksi ketat untuk memastikan kualitas terbaik dan daya tahan yang lama.</p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-lg border border-gray-200 transform transition-transform duration-300 hover:scale-105">
                    <div class="w-16 h-16 mx-auto bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 10v2" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21c4.97 0 9-3.582 9-8s-4.03-8-9-8-9 3.582-9 8 4.03 8 9 8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">Harga Bersahabat</h3>
                    <p class="text-gray-600">Kami menawarkan harga yang kompetitif tanpa mengurangi kualitas. Belanja cerdas, hemat maksimal.</p>
                </div>
                <div class="p-6 bg-white rounded-xl shadow-lg border border-gray-200 transform transition-transform duration-300 hover:scale-105">
                    <div class="w-16 h-16 mx-auto bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a2 2 0 01-2-2V8a2 2 0 012-2h6a2 2 0 012 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-800">Layanan Pelanggan Responsif</h3>
                    <p class="text-gray-600">Tim kami selalu siap membantu Anda. Dapatkan jawaban cepat dan solusi terbaik untuk setiap pertanyaan Anda.</p>
                </div>
            </div>
        </div>
        <section class=" rounded-xl mt-10 fade-in-section">
        <div class="max-w-6xl mx-auto px-4">
            
            <div
                x-data="{
                    activeSlide: 0,
                    slides:
                    [
        { image: '/banner1.jpg', title: 'Diskon Besar!', subtitle: 'Hanya hari ini. Jangan lewatkan.' },
        { image: '/banner2.jpg', title: 'Produk Terbaru', subtitle: 'Tersedia sekarang dengan harga terbaik.' },
        { image: '/banner3.jpg', title: 'Beli 2 Gratis 1', subtitle: 'Nikmati penawaran spesial hanya minggu ini.' },
        { image: '/banner4.jpg', title: 'Flash Sale Spesial', subtitle: 'Diskon hingga 70% untuk produk pilihan.' },
        { image: '/banner5.jpg', title: 'Voucher Eksklusif', subtitle: 'Dapatkan voucher hanya di aplikasi kami.' }
    ],
                    init() {
                        setInterval(() => {
                            this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                        }, 3000);
                    }
                }"
                class="relative w-full h-64 sm:h-80 rounded-xl overflow-hidden mb-10 shadow-lg"
            >
                <template x-for="(slide, index) in slides" :key="index">
                    <div
                        x-show="activeSlide === index"
                        x-transition:enter="transition ease-out duration-700"
                        x-transition:enter-start="opacity-0 translate-x-full"
                        x-transition:enter-end="opacity-100 translate-x-0"
                        x-transition:leave="transition ease-in duration-700"
                        x-transition:leave-start="opacity-100 translate-x-0"
                        x-transition:leave-end="opacity-0 -translate-x-full"
                        class="absolute inset-0 w-full h-full"
                    >
                        <img :src="slide.image" class="w-full h-full object-cover" alt="Slide">
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center text-white text-center px-4">
                            <h2 class="text-2xl sm:text-3xl font-bold" x-text="slide.title"></h2>
                            <p class="mt-1 text-sm sm:text-base" x-text="slide.subtitle"></p>
                        </div>
                    </div>
                </template>

                <div class="absolute bottom-3 left-1/2 transform -translate-x-1/2 flex gap-2">
                    <template x-for="(slide, index) in slides" :key="index">
                    </template>
                </div>
            </div>
        </div>
    </section>
    </section>
    
    
    <section class="bg-white text-gray-800 py-12 fade-in-section">
        <div class="max-w-4xl mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8 text-center">Pertanyaan Seputar JuaLaNs.</h2>

            <div class="space-y-4">
                <div x-data="{ open: false }" class="bg-white  rounded-lg shadow-md overflow-hidden">
                    <button @click="open = !open" class="w-full text-left p-3 flex justify-between items-center transition-colors duration-200 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="text-lg font-medium">Apa itu JuaLaNs.?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse.duration.500ms class="px-5 pb-5 text-black border-t border-gray-100">
                        <p class="mt-4">JuaLaNs adalah platform e-commerce yang menyediakan berbagai produk berkualitas, mulai dari peralatan rumah tangga hingga kebutuhan kantor, dengan fokus pada harga terjangkau dan pengalaman belanja yang mudah dan aman.</p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button @click="open = !open" class="w-full text-left p-5 flex justify-between items-center transition-colors duration-200 hover:bg-white-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="text-lg font-medium">Bagaimana cara berbelanja di JuaLaNs.?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse.duration.500ms class="px-5 pb-5 text-black border-t border-gray-100">
                        <p class="mt-4">Sangat mudah! Cukup telusuri produk yang Anda inginkan, klik 'Beli Sekarang', isi detail pengiriman dan pembayaran, lalu selesaikan transaksi. Produk Anda akan segera kami proses.</p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button @click="open = !open" class="w-full text-left p-5 flex justify-between items-center transition-colors duration-200 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="text-lg font-medium">Apa saja metode pembayaran yang tersedia?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse.duration.500ms class="px-5 pb-5 text-black border-t border-gray-100">
                        <p class="mt-4">Kami menerima berbagai metode pembayaran, termasuk transfer bank (BCA, Mandiri), pembayaran melalui e-wallet (OVO, GoPay, DANA), dan kartu kredit/debit.</p>
                    </div>
                </div>
                
                <div x-data="{ open: false }" class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button @click="open = !open" class="w-full text-left p-5 flex justify-between items-center transition-colors duration-200 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="text-lg font-medium">Berapa lama waktu pengiriman?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse.duration.500ms class="px-5 pb-5 text-black border-t border-gray-100">
                        <p class="mt-4">Waktu pengiriman bervariasi tergantung lokasi Anda dan jenis layanan pengiriman yang dipilih. Estimasi waktu akan ditampilkan saat proses checkout.</p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button @click="open = !open" class="w-full text-left p-5 flex justify-between items-center transition-colors duration-200 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="text-lg font-medium">Apakah produk bisa dikembalikan?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse.duration.500ms class="px-5 pb-5 text-black border-t border-gray-700">
                        <p class="mt-4">Ya, kami memiliki kebijakan pengembalian produk jika terdapat kerusakan atau ketidaksesuaian. Silakan baca Syarat & Ketentuan kami untuk informasi lebih lanjut.</p>
                    </div>
                </div>

                <div x-data="{ open: false }" class="bg-white rounded-lg shadow-md overflow-hidden">
                    <button @click="open = !open" class="w-full text-left p-5 flex justify-between items-center transition-colors duration-200 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <span class="text-lg font-medium">Apakah saya perlu membuat akun untuk berbelanja?</span>
                        <svg class="w-6 h-6 transform transition-transform duration-300" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" x-collapse.duration.500ms class="px-5 pb-5 text-black border-t border-gray-100">
                        <p class="mt-4">Sebaiknya buat akun dulu ya.., membuat akun akan memudahkan Anda untuk melacak pesanan, menyimpan alamat, dan mendapatkan promo eksklusif.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-100 fade-in-section" x-data="testimonialSlider()" x-init="start()">
        <div class="max-w-6xl mx-auto text-center px-4">
            <h2 class="text-4xl font-bold mb-10 text-gray-800">Apa Kata Pelanggan?</h2>

            <div class="grid md:grid-cols-2 gap-6 min-h-[240px] ">
                <template x-for="(testimonial, index) in visibleTestimonials" :key="index">
                    <div
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="bg-white p-6 rounded-xl shadow-md border text-left flex flex-col gap-4"
                    >
                    <p class="text-gray-600 italic leading-relaxed" x-text="testimonial.text"></p>
                    <div class="flex items-center gap-4 mt-auto">
                        <img :src="testimonial.avatar" alt="avatar" class="w-12 h-12 rounded-full border" />
                        <div>
                            <p class="text-blue-600 font-semibold" x-text="testimonial.author"></p>
                            <div class="flex text-yellow-400 text-sm">
                                <template x-for="n in 5">
                                    <span x-html="n <= testimonial.rating ? '&#9733;' : '&#9734;'"></span>
                                </template>
                            </div>
                        </div>
                    </div>
                    </div>
                </template>
            </div>

            <div class="flex justify-center mt-8 space-x-2">
                <template x-for="(group, index) in Math.ceil(testimonials.length / 2)" :key="index">
                    <button
                    class="w-3 h-3 rounded-full transition"
                    :class="{
                        'bg-blue-600': currentGroup === index,
                        'bg-gray-300': currentGroup !== index
                    }"
                    @click="currentGroup = index"
                    ></button>
                </template>
            </div>
        </div>
    </section>

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

            function displayBotMessage(message, replies = []) {
                const botMessageDiv = document.createElement('div');
                botMessageDiv.className = 'bg-gray-200 text-gray-800 p-3 rounded-xl rounded-bl-none shadow-sm mb-3 max-w-[85%] self-start animate-fade-in-up';
                botMessageDiv.textContent = message;
                chatbotMessages.appendChild(botMessageDiv);
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;

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

            function displayUserMessage(message) {
                const userMessageDiv = document.createElement('div');
                userMessageDiv.className = 'bg-blue-600 text-white p-3 rounded-xl rounded-br-none shadow-sm mb-3 max-w-[85%] self-end animate-fade-in-up';
                userMessageDiv.textContent = message;
                chatbotMessages.appendChild(userMessageDiv);
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
            }

            function getBotResponse(message) {
                const lowerCaseMessage = message.toLowerCase();
                let response = { text: "Maaf, saya belum mengerti. Bisakah Anda lebih spesifik atau pilih opsi di bawah ini? 🤔", replies: [] };

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

                else if (lowerCaseMessage.includes("diskon") || lowerCaseMessage.includes("promo") || lowerCaseMessage.includes("voucher")) {
                    response.text = "Ya, kami sering ada promo menarik! Cek halaman 'Promosi' atau bagian banner di halaman utama kami untuk penawaran terbaru. Jangan sampai ketinggalan kesempatan! 🎉";
                    response.replies = ["Syarat & Ketentuan Promo", "Cara Pakai Voucher"];
                } else if (lowerCaseMessage.includes("kode promo") || lowerCaseMessage.includes("masukkan voucher")) {
                    response.text = "Kode promo atau voucher bisa dimasukkan di halaman keranjang belanja atau halaman checkout sebelum Anda melakukan pembayaran. Pastikan kode sudah benar ya! 🎁";
                    response.replies = ["Voucher Tidak Berlaku", "Promo Hari Ini"];
                }

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

                return response;
            }
            
            function sendMessage() {
                const messageText = chatbotInput.value.trim();
                if (messageText === '') return;

                displayUserMessage(messageText);
                chatbotInput.value = '';
                chatbotInput.focus();

                setTimeout(() => {
                    const botResponse = getBotResponse(messageText);
                    displayBotMessage(botResponse.text, botResponse.replies);
                }, 700);
            }

            function handleQuickReply(replyText) {
                displayUserMessage(replyText);
                setTimeout(() => {
                    const botResponse = getBotResponse(replyText);
                    displayBotMessage(botResponse.text, botResponse.replies);
                }, 700);
            }

            openChatbotButton.addEventListener('click', function() {
                chatbotContainer.style.display = 'flex';
                setTimeout(() => {
                    chatbotContainer.classList.remove('scale-0', 'opacity-0');
                    chatbotContainer.classList.add('scale-100', 'opacity-100');
                    chatbotInput.focus();
                    if (chatbotMessages.children.length === 0) {
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
    </script>

    <style>
    .preloader-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #fff; /* or your preferred background color */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        transition: opacity 0.3s ease;
    }

    .spinner {
        border: 5px solid #f3f3f3; /* Light grey */
        border-top: 5px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .preloader-hidden {
        opacity: 0;
        pointer-events: none; /* Prevents user from clicking on the hidden preloader */
    }

    .custom-scrollbar::-webkit-scrollbar { width: 8px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #888; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #555; }
    @keyframes bounce-custom { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
    .animate-bounce-custom { animation: bounce-custom 1.5s infinite ease-in-out; }
    .ease-out-back { transition-timing-function: cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    @keyframes fade-in-up { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fade-in-up { animation: fade-in-up 0.3s ease-out forwards; }
    #chatbotContainer { border-radius: 1rem; }
    #chatbotContainer .bg-gradient-to-r { border-top-left-radius: 1rem; border-top-right-radius: 1rem; }

    /* Updated CSS for repeated animation */
    .fade-in-section {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    
    .fade-in-section.is-visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* slider iklan atas produk */
     <style>
        .carousel-track {
            transition: transform 0.5s ease-in-out;
        }
        /* Style untuk tombol navigasi */
        .carousel-nav-btn {
            @apply absolute top-1/2 -translate-y-1/2 p-3 z-10 cursor-pointer rounded-full transition-colors duration-300;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            font-size: 2rem;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .carousel-nav-btn:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }
    </style>


    <script>
    
    window.addEventListener('load', function() {
        const preloader = document.getElementById('preloader');
        if (preloader) {
            preloader.classList.add('preloader-hidden');
            preloader.addEventListener('transitionend', function() {
                preloader.remove();
            });
        }
    });

    function carousel(){
        return {
            currentIndex:0,
            images:["/slide1.png","/slide2.png","/slide3.png"],
            start(){setInterval(()=>this.currentIndex=(this.currentIndex+1)%this.images.length,4000)}
        }
    }
    const products=@json($product);
    function openModal(id,mode){
        const p=products.find(x=>x.id===id);
        if(!p)return alert('Produk tidak ditemukan');
        document.getElementById('modalTitle').textContent=p.nama;
        document.getElementById('modalPrice').textContent='Rp '+Number(p.harga).toLocaleString('id-ID');
        document.getElementById('modalDesc').textContent=p.deskripsi;
        document.getElementById('modalImage').src='/storage/'+p.foto;
        document.getElementById('modalProductId').value=p.id;
        document.getElementById('buyFormSection').style.display = mode==='beli'?'block':'none';
        document.getElementById('buyModal').classList.remove('hidden');document.getElementById('buyModal').classList.add('flex');
    }
    function closeModal(){document.getElementById('buyModal').classList.add('hidden');document.getElementById('buyModal').classList.remove('flex'); closeZoomImage();}
    function zoomImage(){const src=document.getElementById('modalImage').src;document.getElementById('zoomedImage').src=src; const m=document.getElementById('zoomImageModal');m.classList.remove('hidden');m.classList.add('flex');}
    function closeZoomImage(){document.getElementById('zoomImageModal').classList.add('hidden');document.getElementById('zoomImageModal').classList.remove('flex');

    }
    function testimonialSlider() {
        return {
            testimonials: [
                                {
                text: "Pelayanan sangat ramah dan pengiriman cepat. Sangat puas!",
                author: "Dina Rahma",
                avatar: "https://i.pravatar.cc/60?img=1",
                rating: 5,
                },
                {
                text: "Produk sesuai deskripsi dan kualitasnya sangat bagus.",
                author: "Ardi Wijaya",
                avatar: "https://i.pravatar.cc/60?img=2",
                rating: 4,
                },
                {
                text: "Harga terjangkau dengan kualitas premium. Recommended!",
                author: "Ambas nino",
                avatar: "https://i.pravatar.cc/60?img=3",
                rating: 5,
                },
                {
                text: "Respon admin cepat dan sangat membantu. Mantap!",
                author: "Raka Nugroho",
                avatar: "https://i.pravatar.cc/60?img=4",
                rating: 4,
                },
                {
                text: "Website ini sangat mudah digunakan. Proses checkout cepat!",
                author: "Yuni Marlina",
                avatar: "https://i.pravatar.cc/60?img=5",
                rating: 5,
                },
                {
                text: "Sasya berbelanja di sini karna bagus bede.",
                author: "Bayu Firmansyah",
                avatar: "https://i.pravatar.cc/60?img=6",
                rating: 5,
                },
                {
                text: "Pengiriman cepat dan barang dikemas dengan sangat baik.",
                author: "Intan Wulandari",
                avatar: "https://i.pravatar.cc/60?img=7",
                rating: 4,
                },
                {
                text: "Dari awal order hingga produk diterima, semuanya lancar!",
                author: "Rio Saputra",
                avatar: "https://i.pravatar.cc/60?img=8",
                rating: 5,
                },
                {
                text: "Harga terjangkau dengan kualitas premium. Recommended!",
                author: "Ambas nino",
                avatar: "https://i.pravatar.cc/60?img=3",
                rating: 5,
                },
                {
                text: "Respon admin cepat dan sangat membantu. Mantap!",
                author: "Raka Nugroho",
                avatar: "https://i.pravatar.cc/60?img=4",
                rating: 4,
                },
                {
                text: "Website ini sangat mudah digunakan. Proses checkout cepat!",
                author: "Yuni Marlina",
                avatar: "https://i.pravatar.cc/60?img=5",
                rating: 5,
                },
                {
                text: "Sasya berbelanja di sini karna bagus bede.",
                author: "Bayu Firmansyah",
                avatar: "https://i.pravatar.cc/60?img=6",
                rating: 5,
                },
                {
                text: "Pelayanan sangat ramah dan pengiriman cepat. Sangat puas!",
                author: "Dina Rahma",
                avatar: "https://i.pravatar.cc/60?img=1",
                rating: 5,
                },
                {
                text: "Produk sesuai deskripsi dan kualitasnya sangat bagus.",
                author: "Ardi Wijaya",
                avatar: "https://i.pravatar.cc/60?img=2",
                rating: 4,
                },
                {
                text: "Harga terjangkau dengan kualitas premium. Recommended!",
                author: "Ambas nino",
                avatar: "https://i.pravatar.cc/60?img=3",
                rating: 5,
                },
                {
                text: "Respon admin cepat dan sangat membantu. Mantap!",
                author: "Raka Nugroho",
                avatar: "https://i.pravatar.cc/60?img=4",
                rating: 4,
                },
                {
                text: "Website ini sangat mudah digunakan. Proses checkout cepat!",
                author: "Yuni Marlina",
                avatar: "https://i.pravatar.cc/60?img=5",
                rating: 5,
                },
                {
                text: "Sasya berbelanja di sini karna bagus bede.",
                author: "Bayu Firmansyah",
                avatar: "https://i.pravatar.cc/60?img=6",
                rating: 5,
                },
                {
                text: "Pengiriman cepat dan barang dikemas dengan sangat baik.",
                author: "Intan Wulandari",
                avatar: "https://i.pravatar.cc/60?img=7",
                rating: 4,
                },
                {
                text: "Dari awal order hingga produk diterima, semuanya lancar!",
                author: "Rio Saputra",
                avatar: "https://i.pravatar.cc/60?img=8",
                rating: 5,
                },
                {
                text: "Harga terjangkau dengan kualitas premium. Recommended!",
                author: "Ambas nino",
                avatar: "https://i.pravatar.cc/60?img=3",
                rating: 5,
                },
                {
                text: "Respon admin cepat dan sangat membantu. Mantap!",
                author: "Raka Nugroho",
                avatar: "https://i.pravatar.cc/60?img=4",
                rating: 4,
                },
                {
                text: "Website ini sangat mudah digunakan. Proses checkout cepat!",
                author: "Yuni Marlina",
                avatar: "https://i.pravatar.cc/60?img=5",
                rating: 5,
                },
                {
                text: "Sasya berbelanja di sini karna bagus bede.",
                author: "Bayu Firmansyah",
                avatar: "https://i.pravatar.cc/60?img=6",
                rating: 5,
                },
            ],
            currentGroup: 0,
            get visibleTestimonials() {
                const start = this.currentGroup * 2;
                return this.testimonials.slice(start, start + 2);
            },
            start() {
                setInterval(() => {
                    this.currentGroup = (this.currentGroup + 1) % Math.ceil(this.testimonials.length / 3);
                }, 3000);
            }
        }
    }
    
    function searchForm() {
    return {
        keyword: '{{ request('search') }}',
        search() {
            fetch(`{{ route('dashboard') }}?search=${this.keyword}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const productList = doc.querySelector('#product-list');
                document.querySelector('#product-list').innerHTML = productList.innerHTML;
            });
        }
    }
    }
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('search');
        const placeholders = ["Kursi kerja...", "Kasur minimalist...", "Lampu hias...", "Lampu gantung...", "Tanaman hias..."];
        let placeholderIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        let typingSpeed = 100;
        let deletingSpeed = 50;
        let pauseBeforeNext = 1500;

        function typePlaceholder() {
            const currentPlaceholder = placeholders[placeholderIndex];

            if (isDeleting) {
                searchInput.setAttribute("placeholder", currentPlaceholder.substring(0, charIndex - 1));
                charIndex--;
                if (charIndex === 0) {
                    isDeleting = false;
                    placeholderIndex = (placeholderIndex + 1) % placeholders.length;
                    setTimeout(typePlaceholder, 500);
                } else {
                    setTimeout(typePlaceholder, deletingSpeed);
                }
            } else {
                searchInput.setAttribute("placeholder", currentPlaceholder.substring(0, charIndex + 1));
                charIndex++;
                if (charIndex === currentPlaceholder.length) {
                    isDeleting = true;
                    setTimeout(typePlaceholder, pauseBeforeNext);
                } else {
                    setTimeout(typePlaceholder, typingSpeed);
                }
            }
        }

        typePlaceholder();
    });
    
    // Intersection Observer script for fade-in-on-scroll animation
    // Updated logic to re-animate on scroll in and out
    const observerOptions = {
        root: null, // use the viewport as the root
        rootMargin: '0px',
        threshold: 0.1 // trigger when 10% of the element is visible
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // When element enters the viewport, add the visible class
                entry.target.classList.add('is-visible');
            } else {
                // When element leaves the viewport, remove the visible class
                // This allows the animation to be re-triggered when scrolling back
                entry.target.classList.remove('is-visible');
            }
        });
    }, observerOptions);

    const sections = document.querySelectorAll('.fade-in-section');
    sections.forEach(section => {
        observer.observe(section);
    });

    </script>
    <script src="https://kit.fontawesome.com/YOUR_KIT_ID.js" crossorigin="anonymous"></script>
            </div>
            </div>
            <div id="zoomImageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50 p-4">
            <div class="relative max-w-4xl w-full max-h-[90vh] overflow-auto">
                <button onclick="closeZoomImage()" class="absolute top-3 right-4 text-black hover:text-red-600 text-4xl font-bold">&times;</button>
                <img id="zoomedImage" src="" class="w-full h-auto object-contain rounded-lg shadow-lg cursor-zoom-out">
            </div>
        </div>
</x-app-layout>
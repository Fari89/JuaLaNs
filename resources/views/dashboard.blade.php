<x-app-layout>
    <!-- Hero Carousel with Sticky Footer -->
    <section x-data="carousel()" x-init="start()" class="relative h-screen w-full overflow-hidden bg-gray-900 flex flex-col justify-between">
        <!-- Carousel Images -->
        <div class="absolute inset-0 z-0 flex transition-transform duration-[1000ms] ease-in-out will-change-transform"
             :style="`transform: translateX(-${currentIndex * 100}%);`">
            <template x-for="(image, index) in images" :key="index">
                <div class="min-w-full h-screen">
                    <img :src="image" alt="Slide"
                         class="w-full h-full object-cover" />
                </div>
            </template>
        </div>

        <!-- Overlay Content -->
        <div class="relative z-10 flex-1 flex flex-col justify-center items-center text-center px-4 bg-black bg-opacity-30">
            <div class="max-w-4xl text-white">
                <img src="{{ url('FaRs_logo.png') }}" alt="Logo" class="h-10 md:h-20 mb-3 mx-auto" />
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 drop-shadow-md">
                    Selamat Datang
                </h1>
                <p class="text-lg md:text-2xl mb-6 max-w-2xl mx-auto">
                    Temukan produk terbaik pilihan dengan harga bersahabat!
                </p>
                <a href="http://localhost:8000/product"
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-full shadow-lg transition duration-300">
                    Lihat Produk
                </a>
            </div>
        </div>

        <!-- Fixed Footer -->
        <footer class="relative z-10 bg-black bg-opacity-30 text-gray-300 text-sm text-center py-4">
            <div class="max-w-7xl mx-auto px-4">
                <p>&copy; {{ date('Y') }} <strong class="text-white">JuaLaNs</strong>. All rights reserved.</p>
                <p>Developer by: <strong class="text-blue-400">Muhammad Farihin Mushawwir</strong></p>
                <p>All Image From &copy;IKEA</p>
            </div>
        </footer>
    </section>

    <!-- Alpine.js Carousel Script -->
    <script>
        function carousel() {
            return {
                currentIndex: 0,
                images: [
                    "{{ url('slide1.png') }}",
                    "{{ url('slide2.png') }}",
                    "{{ url('slide3.png') }}",
                ],
                start() {
                    setInterval(() => {
                        this.currentIndex = (this.currentIndex + 1) % this.images.length;
                    }, 4000);
                }
            }
        }
    </script>

    <!-- Hide any potential navbar -->
    <style>
        [x-data="navbar"] {
            display: none !important;
        }
        header {
            display: none !important;
        }
    </style>
</x-app-layout>
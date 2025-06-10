<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-5">
        @if (session('success'))
            <div 
                x-data="{ show: true }" 
                x-init="setTimeout(() => show = false, 3000)" 
                x-show="show"
                x-transition:leave="transition ease-in duration-700"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform translate-y-2"
                class="mb-4 px-4 py-3 bg-green-100 text-green-800 border border-green-300 rounded shadow text-center"
            >
                {{ session('success') }}
            </div>
        @endif

        <!-- Search Form -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <form method="GET" action="{{ route('product.index') }}" class="flex flex-1 items-center gap-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari produk..."
                    class="w-full sm:w-90 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring focus:border-blue-300"
                >
                <button type="submit"
                    class="bg-gray-700 hover:bg-gray-500 text-white px-4 py-2 rounded-lg transition">
                    Cari
                </button>
            </form>
        </div>

        <!-- Slider Papan Iklan -->
        <div 
            x-data="{
                activeSlide: 0,
                slides: [
                    { image: '/banner1.jpg', title: 'Diskon Besar!', subtitle: 'Hanya hari ini. Jangan lewatkan.' },
                    { image: '/banner2.jpg', title: 'Produk Terbaru', subtitle: 'Tersedia sekarang dengan harga terbaik.' },
                    { image: '/banner3.jpg', title: 'Gratis Ongkir', subtitle: 'Untuk pembelian di atas Rp 200.000' }
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
                    <button 
                        @click="activeSlide = index"
                        :class="activeSlide === index ? 'bg-white' : 'bg-gray-400'"
                        class="w-3 h-3 rounded-full transition"
                    ></button>
                </template>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($product as $item)
                <div class="bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col transition transform hover:scale-105 duration-300">
                    <div class="w-full mt-3 h-48 bg-white flex items-center justify-center relative group overflow-hidden">
                        <!-- Gambar Produk -->
                        <img
                            onclick="openModal({{ $item->id }}, 'detail')"
                            src="{{ url('storage/' . $item->foto) }}"
                            alt="Foto Produk"
                            class="max-h-full max-w-full object-contain transition duration-300 ease-in-out group-hover:blur-[1px] cursor-pointer"
                        >

                        <!-- Overlay Blur + Ikon Mata + Tulisan -->
                        <div
                            class="absolute inset-0 rounded-t-lg bg-black bg-opacity-40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 cursor-pointer"
                            onclick="openModal({{ $item->id }}, 'detail')"
                        >
                            <!-- Ikon Mata -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white mb-2" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            
                            <!-- Tulisan Lihat Detail -->
                            <p class="text-white text-sm font-semibold">Lihat Detail</p>
                        </div>
                    </div>

                    <div class="p-4 flex-1 flex flex-col">
                        <p class="text-lg font-bold text-gray-800 mb-1">{{ $item->nama }}</p>
                        <p class="text-yellow-600 font-semibold mb-1">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        <p class="text-gray-600 text-sm flex-1">{{ $item->deskripsi }}</p>

                        <div class="pt-2">
                            <button onclick="openModal({{ $item->id }}, 'beli')"
                                class="bg-blue-600 hover:bg-blue-500 text-white py-2 px-4 rounded w-full text-center transition">
                                Beli
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500">Produk tidak ditemukan.</div>
            @endforelse
        </div>
    </div>

    <!-- Modal Detail & Beli -->
    <div id="buyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-4xl p-6 relative">
            <button onclick="closeModal()" class="absolute top-3 right-4 text-gray-600 hover:text-red-600 text-3xl font-bold">&times;</button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="relative text-center">
                        <p class="text-sm text-gray-500 mb-2">Klik gambar untuk melihat lebih besar</p>
                        <img id="modalImage" src="" alt="Produk" 
                            onclick="zoomImage()" 
                            class="cursor-zoom-in w-full h-64 object-contain bg-gray-100 rounded transition duration-300 hover:scale-105">
                    </div>
                    
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2" id="modalTitle">Detail Produk</h2>
                    <p class="text-yellow-600 text-xl font-semibold mb-2" id="modalPrice"></p>
                    <p class="text-gray-700 mb-4 text-justify" id="modalDesc"></p>

                    <div id="buyFormSection">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" id="modalProductId">

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Nama Pembeli</label>
                                <input type="text" name="nama_pembeli" required class="mt-1 p-2 w-full border rounded focus:ring focus:border-blue-300">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                                <input type="text" name="alamat" required class="mt-1 p-2 w-full border rounded focus:ring focus:border-blue-300">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                <input type="number" name="no_hp" required class="mt-1 p-2 w-full border rounded focus:ring focus:border-blue-300">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                                <input type="number" name="jumlah" min="1" value="1" required class="mt-1 p-2 w-full border rounded focus:ring focus:border-blue-300">
                            </div>

                            <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded text-lg transition">
                                Masukkan Keranjang
                            </button>
                            
                        </form>
                        
                    </div>
                    
                </div>
            </div>
             <footer class="relative z-10 bg-white text-gray-600 text-sm text-center py-4">
            <div class="max-w-7xl mx-auto px-4">
                <p>&copy; {{ date('Y') }} <strong class="text-gray-700">JuaLaNs</strong>. All rights reserved.</p>
                <p>Developer by: <strong class="text-blue-400">Muhammad Farihin Mushawwir</strong></p>
                <p>All Image From &copy;IKEA</p>
            </div>
        </footer>
        </div>
    </div>
    <div id="zoomImageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden items-center justify-center z-50 p-4">
    <div class="relative max-w-4xl w-full max-h-[90vh] overflow-auto">
        <button onclick="closeZoomImage()" class="absolute top-3 right-4 text-black hover:text-red-600 text-4xl font-bold">&times;</button>
        <img id="zoomedImage" src="" class="w-full h-auto object-contain rounded-lg shadow-lg cursor-zoom-out">
    </div>
</div>
<footer class="mt-16 bg-blue-700 text-white py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
                <h3 class="text-2xl font-bold mb-2">JuaLaNs</h3>
                <p class="text-sm text-gray-300">
                    Platform jual beli produk pilihan terbaik dengan layanan terpercaya dan responsif.
                </p>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-2">Navigasi</h4>
                <ul class="space-y-1 text-sm text-gray-300">
                    <li><a href="/dashboard" class="hover:underline">Beranda</a></li>
                    <li><a href="{{ route('product.index') }}" class="hover:underline">Produk</a></li>
                    <li><a href="#" class="hover:underline">Kontak</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-2">Komponen</h4>
                <ul class="space-y-1 text-sm text-gray-300">
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
        // Data produk dari backend ke frontend (pastikan ini ada di view)
        const products = @json($product);

        function openModal(id, mode) {
            const modal = document.getElementById('buyModal');
            const buyFormSection = document.getElementById('buyFormSection');

            const product = products.find(p => p.id === id);
            if (!product) return alert('Produk tidak ditemukan');

            document.getElementById('modalTitle').textContent = product.nama;
            document.getElementById('modalPrice').textContent = 'Rp ' + Number(product.harga).toLocaleString('id-ID');
            document.getElementById('modalDesc').textContent = product.deskripsi;
            document.getElementById('modalImage').src = `/storage/${product.foto}`;
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
            closeZoomImage();
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
</x-app-layout>

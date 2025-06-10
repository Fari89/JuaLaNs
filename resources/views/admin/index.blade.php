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
           <!-- Tambah Produk Button -->
            <div class="text-right">
                <a href="{{ route('product.create') }}"
                   class="bg-blue-800 hover:bg-blue-600 text-white font-semibold px-4 py-3 rounded-lg transition whitespace-nowrap">
                    + Tambah Produk
                </a>
            </div>
        </div>
    
        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $item)
                <div class="bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col transition transform hover:scale-105 duration-300">
                    <div class="w-full mt-3 h-48 bg-white flex items-center justify-center">
                        <img src="{{ url('storage/' . $item->foto) }}" alt="Foto Produk"
                             class="max-h-full max-w-full object-contain"> 
                    </div>
                    <div class="p-4 flex-1 flex flex-col">
                        <p class="text-lg font-bold text-gray-800 mb-1">{{ $item->nama }}</p>
                        <p class="text-green-600 font-semibold mb-1">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                        <p class="text-gray-600 text-sm flex-1">{{ $item->deskripsi }}</p>

                        <div class="pt-4">
                            <a href="{{ route('product.edit', $item->id) }}"
                               class="bg-blue-800 hover:bg-blue-600 text-white py-2 px-4 rounded w-full block text-center transition">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center text-gray-500">Produk tidak ditemukan.</div>
            @endforelse
        </div>
    </div>

    <!-- Modal Beli -->
    <div id="buyModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 relative">
            <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-600 hover:text-red-600 text-2xl">&times;</button>
            <h2 class="text-xl font-bold mb-4" id="modalTitle">Detail Produk</h2>

            <div class="mb-4">
                <img id="modalImage" src="" alt="Produk" class="w-full h-48 object-contain bg-gray-100 mb-3 rounded">
                <p class="text-gray-800 font-semibold" id="modalPrice"></p>
                <p class="text-sm text-gray-600" id="modalDesc"></p>
            </div>

            <form method="POST" action="{{ route('cart.add') }}">
                @csrf
                <input type="hidden" name="product_id" id="modalProductId">

                <div class="mb-4">
                    <label for="buyer_name" class="block text-sm font-medium text-gray-700">Nama Pembeli</label>
                    <input type="text" name="buyer_name" required class="mt-1 p-2 w-full border rounded">
                </div>

                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input type="number" name="quantity" min="1" value="1" required class="mt-1 p-2 w-full border rounded">
                </div>

                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded">
                    Tambah ke Keranjang
                </button>
            </form>
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

    <!-- Modal Script -->
    <script>
        const products = @json($products->values());

        function openModal(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;

            document.getElementById('modalTitle').textContent = product.nama;
            document.getElementById('modalImage').src = `/storage/${product.foto}`;
            document.getElementById('modalPrice').textContent = `Harga: Rp ${parseInt(product.harga).toLocaleString('id-ID')}`;
            document.getElementById('modalDesc').textContent = product.deskripsi;
            document.getElementById('modalProductId').value = product.id;

            document.getElementById('buyModal').classList.remove('hidden');
            document.getElementById('buyModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('buyModal').classList.add('hidden');
            document.getElementById('buyModal').classList.remove('flex');
        }
    </script>
</x-app-layout>

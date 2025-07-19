<x-app-layout>
    <link rel="icon" href="{{ asset('JuaLans.icon.png') }}" type="image/png" />
    <div class="max-w-3xl mx-auto p-8 bg-white shadow-xl rounded-lg mt-12 mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-extrabold text-gray-900">Edit Produk 📝</h2>
            <a href="{{ route('admin.index') }}"
               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>

        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama', $product->nama) }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                @error('nama')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                <input type="number" id="harga" name="harga" value="{{ old('harga', $product->harga) }}" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                @error('harga')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="6" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>{{ old('deskripsi', $product->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">Ganti Foto (opsional)</label>
                <input type="file" id="foto" name="foto" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-md file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100"/>
                <p class="mt-2 text-sm text-gray-500">
                    Foto saat ini:
                    @if ($product->foto)
                        <img src="{{ url('storage/' . $product->foto) }}" alt="Current Product Image" class="h-24 w-24 object-cover rounded-md mt-2 border border-gray-200 shadow-sm">
                    @else
                        <span class="text-red-500">Tidak ada foto saat ini.</span>
                    @endif
                </p>
                @error('foto')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="w-full inline-flex justify-center py-3 px-4 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h-1v5.586L7.707 10.293z" />
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                </svg>
                Update Produk
            </button>
        </form>
    </div>
    ---
    <footer class="mt-16 bg-blue-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            <div>
                <img src="{{ url('FaRs_logo.png') }}" alt="JuaLaNs Logo" class="h-8 md:h-12 mb-4" />
                <p class="text-sm text-gray-300 leading-relaxed">
                    Platform jual beli produk pilihan terbaik dengan layanan terpercaya dan responsif. Kami berkomitmen menyediakan pengalaman berbelanja yang aman dan nyaman.
                </p>
            </div>
            <div>
                <h4 class="text-xl font-bold mb-4">Navigasi Utama</h4>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><a href="/dashboard" class="hover:text-blue-300 transition duration-150 ease-in-out">🏠 Beranda</a></li>
                    <li><a href="{{ route('product.index') }}" class="hover:text-blue-300 transition duration-150 ease-in-out">🛍️ Produk</a></li>
                    <li><a href="#" class="hover:text-blue-300 transition duration-150 ease-in-out">📞 Kontak</a></li>
                    <li><a href="#" class="hover:text-blue-300 transition duration-150 ease-in-out">ℹ️ Tentang Kami</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-xl font-bold mb-4">Teknologi</h4>
                <ul class="space-y-2 text-sm text-gray-300">
                     <li>Gemini Ai</li>
                    <li>🚀 Laravel 10</li>
                    <li>🎨 Tailwind CSS</li>
                    <li>✨ Alpine.js</li>
                    <li>🌟 Font Awesome</li>
                </ul>
            </div>
            <div>
                <h4 class="text-xl font-bold mb-4">Hubungi Developer</h4>
                <p class="text-sm text-gray-300 mb-3">
                    <strong>Muhammad Farihin Mushawwir</strong><br>
                    Email: <a href="mailto:support@jualans.com" class="hover:text-blue-300 transition duration-150 ease-in-out">support@jualans.com</a>
                </p>
                <div class="flex space-x-5 mt-4 text-2xl">
                    <a href="#" class="hover:text-blue-400 transition duration-150 ease-in-out" aria-label="Facebook"><i class="fab fa-facebook-square"></i></a>
                    <a href="#" class="hover:text-sky-400 transition duration-150 ease-in-out" aria-label="Twitter"><i class="fab fa-twitter-square"></i></a>
                    <a href="#" class="hover:text-pink-400 transition duration-150 ease-in-out" aria-label="Instagram"><i class="fab fa-instagram-square"></i></a>
                    <a href="#" class="hover:text-gray-400 transition duration-150 ease-in-out" aria-label="GitHub"><i class="fab fa-github-square"></i></a>
                </div>
            </div>
        </div>
        <div class="mt-12 pt-6 text-center text-sm text-gray-400 border-t border-blue-700">
            &copy; {{ date('Y') }} <strong>JuaLaNs</strong>. Hak Cipta Dilindungi Undang-Undang. <br>
            Semua gambar &copy; IKEA.
        </div>
    </footer>
</x-app-layout>
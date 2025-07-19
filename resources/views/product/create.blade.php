<x-app-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg mt-10">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Tambah Produk</h2>
            <a href="{{ route('admin.index') }}"
               class="bg-gray-500 hover:bg-gray-700 text-white px-2 py-1 rounded transition">
                Kembali
            </a>
        </div>
        

        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
  
            @csrf

            <div class="mb-4">
                <label class="block mb-1">Nama Produk</label>
                <input type="text" name="nama" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Harga</label>
                <input type="number" name="harga" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Deskripsi</label>
                <textarea name="deskripsi" class="w-full border px-3 py-2 rounded" required></textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Foto</label>
                <input type="file" name="foto" class="w-full border px-3 py-2 rounded" required>
            </div>
            

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-2 rounded">
                Simpan
            </button>
        </form>
    </div>
      <!-- Footer -->
<footer class="mt-16 bg-blue-800 text-white py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
              <a href="/dashboard" class="inline-block">
  <img src="{{ url('FaRs_logo.png') }}" alt="FaRs Logo" class="h-10 md:h-14 object-contain mb-3 mx-auto" />
</a>
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
</x-app-layout>

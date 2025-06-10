<x-app-layout>
    <div class="max-w-2xl mx-auto p-6 bg-white shadow-md rounded-lg mt-10">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Edit Produk</h2>
            <a href="{{ route('admin.index') }}"
               class="bg-gray-500 hover:bg-gray-700 text-white px-2 py-1 rounded transition">
                Kembali
            </a>
        </div>

        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block mb-1">Nama Produk</label>
                <input type="text" name="nama" value="{{ $product->nama }}" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Harga</label>
                <input type="number" name="harga" value="{{ $product->harga }}" class="w-full border px-3 py-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Deskripsi</label>
                <textarea name="deskripsi" class="w-full border px-3 py-2 rounded" required>{{ $product->deskripsi }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Ganti Foto (jika perlu)</label>
                <input type="file" name="foto" class="w-full border px-3 py-2 rounded">
                <p class="text-sm mt-1">Saat ini: <img src="{{ url('storage/' . $product->foto) }}" class="h-16 mt-2"></p>
            </div>

            <button type="submit"
                    class="bg-blue-800 hover:bg-blue-600 text-white px-4 py-2 rounded">
                Update
            </button>
        </form>
    </div>
  <!-- Footer -->
    <footer class="text-center text-gray-600 text-sm mt-10 mb-4">
        <div>
            &copy; {{ date('Y') }} <strong>JuaLaNs</strong>. All rights reserved.<br>
            Developer by: <strong>Muhammad Farihin Mushawwir</strong>
            <p>All Image From &copy;IKEA</p>
        </div>
    </footer>
</x-app-layout>

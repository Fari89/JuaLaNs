<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage; // Pastikan Storage diimpor untuk menghapus foto lama

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::when($search, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%');
        })->get();

        $cartItems = new Collection();

        return view('admin.index', compact('products', 'cartItems'));
    }

    public function store(Request $request)
    {
        try {
            // Validasi data input
            $data = $request->validate([
                'nama' => 'required|string|max:255',
                'harga' => 'required|numeric',
                'deskripsi' => 'required|string',
                // PERUBAHAN DI SINI: Menghapus validasi 'image' dan 'mimes'
                // Ini memungkinkan semua jenis file untuk diunggah.
                // Batas ukuran file (max:50000 KB = 50 MB) tetap dipertahankan
                // untuk mencegah unggahan file yang terlalu besar.
                'foto' => 'required|file|max:50000', // 'file' hanya memastikan itu adalah file yang valid
            ]);

            // Pastikan file foto ada dan valid sebelum mencoba menyimpannya
            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                // Simpan file ke direktori 'produk' di disk 'public'
                $data['foto'] = $request->file('foto')->store('produk', 'public');
                Log::info('File berhasil diunggah ke: ' . $data['foto']);
            } else {
                Log::error('Gagal mengunggah file: File tidak ditemukan atau tidak valid.');
                return back()->withErrors(['foto' => 'Gagal mengunggah file. Pastikan Anda memilih file yang valid.'])->withInput();
            }
            
            $product = Product::create($data);

            Log::info('Produk berhasil disimpan: ', $product->toArray());

            return redirect()->route('admin.index')->with('success', 'Produk berhasil ditambahkan.');

        } catch (ValidationException $e) {
            Log::error('Error validasi saat menyimpan produk: ' . $e->getMessage(), $e->errors());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error umum saat menyimpan produk: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Terjadi kesalahan umum saat menyimpan produk. Pesan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Menampilkan form untuk mengedit produk tertentu.
     * Asumsi Anda memiliki route seperti 'admin.edit' yang mengarah ke metode ini.
     */
    public function edit(Product $product)
    {
        return view('admin.edit', compact('product')); // Asumsi ada view admin.edit
    }

    /**
     * Memperbarui produk tertentu di database.
     * Metode ini juga perlu validasi untuk foto.
     */
    public function update(Request $request, Product $product)
    {
        try {
            $data = $request->validate([
                'nama' => 'required|string|max:255',
                'harga' => 'required|numeric',
                'deskripsi' => 'required|string',
                // PERUBAHAN DI SINI: Foto opsional saat update, dengan batas ukuran yang sama.
                // Menghapus validasi 'image' dan 'mimes'.
                'foto' => 'nullable|file|max:50000', // 'file' hanya memastikan itu adalah file yang valid
            ]);

            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                // Hapus foto lama jika ada
                if ($product->foto) {
                    Storage::disk('public')->delete($product->foto);
                    Log::info('File lama dihapus: ' . $product->foto);
                }
                // Simpan file baru
                $data['foto'] = $request->file('foto')->store('produk', 'public');
                Log::info('File baru diunggah untuk update: ' . $data['foto']);
            } else {
                // Jika tidak ada file baru diunggah, pertahankan file lama
                unset($data['foto']);
                Log::info('Tidak ada file baru diunggah, mempertahankan file lama.');
            }

            $product->update($data);

            Log::info('Produk berhasil diperbarui: ', $product->toArray());

            return redirect()->route('admin.index')->with('success', 'Produk berhasil diperbarui.');

        } catch (ValidationException $e) {
            Log::error('Error validasi saat memperbarui produk: ' . $e->getMessage(), $e->errors());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error umum saat memperbarui produk: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Terjadi kesalahan umum saat memperbarui produk. Pesan: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Menghapus produk tertentu dari database.
     */
    public function destroy(Product $product)
    {
        try {
            // Hapus foto dari storage
            if ($product->foto) {
                Storage::disk('public')->delete($product->foto);
                Log::info('File produk dihapus: ' . $product->foto);
            }
            $product->delete();
            Log::info('Produk berhasil dihapus: ' . $product->id);
            return redirect()->route('admin.index')->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error saat menghapus produk: ' . $e->getMessage(), ['product_id' => $product->id, 'trace' => $e->getTraceAsString()]);
            return back()->withErrors('Terjadi kesalahan saat menghapus produk.');
        }
    }
}

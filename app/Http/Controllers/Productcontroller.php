<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Mengambil produk dan menerapkan pencarian jika ada, dengan paginasi
        $products = Product::when($search, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%')
                         ->orWhere('deskripsi', 'like', '%' . $search . '%');
        })->paginate(9); // Sesuaikan angka 9 sesuai kebutuhan Anda untuk jumlah produk per halaman

        // Mengambil semua produk (bisa digunakan di tempat lain, misal di halaman keranjang)
        $allProducts = Product::all();

        // PENTING: Pastikan Anda melewatkan variabel 'products' (jamak) ke view 'product.index'
        return view('product.index', compact('products', 'allProducts'));
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Menyimpan produk baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nama' => 'required|string|max:255',
                'harga' => 'required|numeric',
                'deskripsi' => 'required|string',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:10240', // Max 10MB
            ]);

            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                $data['foto'] = $request->file('foto')->store('produk', 'public');
                Log::info('Foto berhasil diunggah ke: ' . $data['foto']);
            } else {
                Log::error('Gagal mengunggah foto: File tidak ditemukan atau tidak valid.');
                return back()->withErrors(['foto' => 'Gagal mengunggah foto. Pastikan Anda memilih file gambar yang valid.'])->withInput();
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
     * Menampilkan detail produk tertentu.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    /**
     * Menampilkan form untuk mengedit produk tertentu.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\View\View
     */
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    /**
     * Memperbarui produk tertentu di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        try {
            $data = $request->validate([
                'nama' => 'required|string|max:255',
                'harga' => 'required|numeric',
                'deskripsi' => 'required|string',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // Foto opsional saat update
            ]);

            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                // Hapus foto lama jika ada
                if ($product->foto) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($product->foto);
                }
                $data['foto'] = $request->file('foto')->store('produk', 'public');
            } else {
                // Jika tidak ada foto baru diunggah, pertahankan foto lama
                unset($data['foto']);
            }

            $product->update($data);

            return redirect()->route('admin.index')->with('success', 'Produk berhasil diperbarui.');

        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat memperbarui produk.');
        }
    }

    /**
     * Menghapus produk tertentu dari database.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        try {
            if ($product->foto) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->foto);
            }
            $product->delete();
            return redirect()->route('admin.index')->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan saat menghapus produk.');
        }
    }

    /**
     * Menambahkan produk ke keranjang.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'jumlah' => 'required|integer|min:1',
            'nama_pembeli' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
        ]);

        $productId = $request->input('product_id');
        $jumlah = $request->input('jumlah');
        $namaPembeli = $request->input('nama_pembeli');
        $alamat = $request->input('alamat');
        $noHp = $request->input('no_hp');

        Session::put('cart_nama_pembeli', $namaPembeli);
        Session::put('cart_alamat', $alamat);
        Session::put('cart_no_hp', $noHp);

        $cartItem = \App\Models\Cart::where('nama_pembeli', $namaPembeli)
                                   ->where('alamat', $alamat)
                                   ->where('no_hp', $noHp)
                                   ->where('product_id', $productId)
                                   ->first();

        if ($cartItem) {
            $cartItem->jumlah += $jumlah;
            $cartItem->save();
            $message = 'Jumlah produk di keranjang berhasil diperbarui!';
        } else {
            $product = Product::findOrFail($productId);
            \App\Models\Cart::create([
                'product_id' => $productId,
                'nama_pembeli' => $namaPembeli,
                'alamat' => $alamat,
                'no_hp' => $noHp,
                'jumlah' => $jumlah,
                'price' => $product->harga,
            ]);
            $message = 'Produk berhasil ditambahkan ke keranjang!';
        }

        return redirect()->back()->with('success', $message);
    }
}

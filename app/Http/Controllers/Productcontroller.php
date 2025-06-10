<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Tampilkan semua produk dengan fitur pencarian
    public function index(Request $request)
    {
        $search = $request->input('search');
        $products = product::paginate(10);

        $product = Product::when($search, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%');
        })->get();

        return view('product.index', compact('product'));
    }
    
    // Tampilkan form tambah produk
    public function create()
    {
        return view('product.create');
    }
public function store(Request $request)
{
    try {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:10240', // 10 MB
        ]);

         // hanya user biasa yang bisa beli
    if (auth()->user()->role !== 'user') {
        abort(403, 'Unauthorized');
    }

    $products = Product::all();
    return view('product.index', compact('products'));
        

        $data['foto'] = $request->file('foto')->store('produk', 'public');

        $product = Product::create($data);

        \Log::info('Produk berhasil disimpan: ', $product->toArray());

        return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan.');
    } catch (\Exception $e) {
        \Log::error('Error saat menyimpan produk: ' . $e->getMessage());
        return back()->withErrors('Terjadi kesalahan saat menyimpan produk. Silakan coba lagi.');
    }
}


    // Tampilkan form edit produk
    public function edit(Product $product)
    {
        return view('product.edit', compact('product'));
    }

    // Proses update produk
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:10048',
        ]);

        // Jika foto baru diupload
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        // Update data produk
        $product->update($data);

        return redirect()->route('product.index')->with('success', 'Produk berhasil diperbarui.');
    }
    public function addToCart(Request $request, $id)
{
    $product = Product::findOrFail($id);
    $cart = session()->get('cart', []);

    if (isset($cart[$id])) {
        $cart[$id]['quantity']++;
    } else {
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => 1,
            "price" => $product->price,
        ];
    }
    
    session()->put('cart', $cart);

    return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
}

}

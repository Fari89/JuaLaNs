<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'nama_pembeli' => 'required|string|max:100',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',
            'jumlah' => 'required|integer|min:1',
        ]);

        Cart::create($validated);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function index()
{
    $carts = Cart::with('product')->latest()->get();
    return view('product.cart', compact('carts'));
}

    public function destroy($id)
    {
        $item = Cart::findOrFail($id);
        $item->delete();

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class adminController extends Controller
{

public function index(Request $request)
{
    $search = $request->input('search');

    $products = Product::when($search, function ($query, $search) {
        return $query->where('nama', 'like', '%' . $search . '%');
    })->get();

    return view('admin.index', compact('products'));
}

public function store(Request $request)
{
    try {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'deskripsi' => 'required|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:10240',
        ]);

        $data['foto'] = $request->file('foto')->store('produk', 'public');

        $product = Product::create($data);

        \Log::info('Produk berhasil disimpan: ', $product->toArray());

        return redirect()->route('admin.index')->with('success', 'Produk berhasil ditambahkan.');
    } catch (\Exception $e) {
        \Log::error('Error saat menyimpan produk: ' . $e->getMessage());
        return back()->withErrors('Terjadi kesalahan saat menyimpan produk. Silakan coba lagi.');
    }
}
}
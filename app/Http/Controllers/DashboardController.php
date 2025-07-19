<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $product = Product::when($search, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%');
        }, function ($query) {
            return $query->take(3); // jika tidak ada search, ambil 4 produk saja
        })->get();

        return view('dashboard', compact('product'));
    }
}

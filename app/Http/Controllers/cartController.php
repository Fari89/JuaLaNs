<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        // Ambil detail pembeli dari sesi untuk mengidentifikasi keranjang
        $namaPembeli = Session::get('cart_nama_pembeli');
        $alamat = Session::get('cart_alamat');
        $noHp = Session::get('cart_no_hp');

        $cartItems = collect(); // Inisialisasi koleksi kosong secara default
        $total = 0; // Variabel untuk menghitung total keranjang

        // Jika detail pembeli ada di sesi, ambil item keranjang dari database
        if ($namaPembeli && $alamat && $noHp) {
            $cartItems = Cart::where('nama_pembeli', $namaPembeli)
                             ->where('alamat', $alamat)
                             ->where('no_hp', $noHp)
                             ->with('product')
                             ->orderBy('created_at', 'asc') // Mengurutkan berdasarkan waktu pembuatan
                             ->get();

            // Menghitung subtotal dan total keranjang
            foreach ($cartItems as $item) {
                // Pastikan $item->product ada sebelum mengakses propertinya
                // Menggunakan $item->price dari model Cart, jika tidak ada, fallback ke product->harga
                $itemPrice = $item->price ?? ($item->product->harga ?? 0); 
                $itemQuantity = $item->jumlah ?? 0;

                $item->subtotal = $itemPrice * $itemQuantity; // Hitung subtotal per item
                $total += $item->subtotal; // Tambahkan ke total keranjang
            }
        }

        // Mengambil semua produk yang tersedia dari database
        $allProducts = Product::all();

        return view('cart.index', [
            'cartItems' => $cartItems,
            'allProducts' => $allProducts,
            'total' => $total // Kirim total keranjang ke view
        ]);
    }

    public function add(Request $request)
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

        // Simpan detail pembeli ke sesi
        Session::put('cart_nama_pembeli', $namaPembeli);
        Session::put('cart_alamat', $alamat);
        Session::put('cart_no_hp', $noHp);

        // Cari apakah produk sudah ada di keranjang untuk kombinasi detail pembeli ini
        $cartItem = Cart::where('nama_pembeli', $namaPembeli)
                         ->where('alamat', $alamat)
                         ->where('no_hp', $noHp)
                         ->where('product_id', $productId)
                         ->first();

        if ($cartItem) {
            // Update jumlah jika produk sudah ada di keranjang
            $cartItem->jumlah += $jumlah;
            $cartItem->save();
            $message = 'Jumlah produk di keranjang berhasil diperbarui!';
        } else {
            // Jika produk belum ada di keranjang, buat item baru
            $product = Product::findOrFail($productId);

            Cart::create([
                'product_id' => $productId,
                'nama_pembeli' => $namaPembeli,
                'alamat' => $alamat,
                'no_hp' => $noHp,
                'jumlah' => $jumlah,
                'price' => $product->harga, // Pastikan ini sesuai dengan kolom di DB Anda (harga atau price)
            ]);
            $message = 'Produk berhasil ditambahkan ke keranjang!';
        }

        return redirect()->back()->with('success', $message);
    }

    public function destroy($id)
    {
        // Ambil detail pembeli dari sesi untuk mengidentifikasi keranjang
        $namaPembeli = Session::get('cart_nama_pembeli');
        $alamat = Session::get('cart_alamat');
        $noHp = Session::get('cart_no_hp');

        if (!$namaPembeli || !$alamat || !$noHp) {
            return redirect()->route('cart.index')->with('error', 'Detail pembeli tidak ditemukan di sesi. Tidak dapat menghapus item.');
        }

        try {
            // Temukan item keranjang berdasarkan ID dan detail pembeli
            $cartItem = Cart::where('id', $id)
                            ->where('nama_pembeli', $namaPembeli)
                            ->where('alamat', $alamat)
                            ->where('no_hp', $noHp)
                            ->firstOrFail();

            $cartItem->delete(); // Hapus item dari keranjang

            return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Cart item not found for deletion: ' . $e->getMessage(), ['id' => $id, 'nama_pembeli' => $namaPembeli]);
            return redirect()->route('cart.index')->with('error', 'Item keranjang tidak ditemukan atau Anda tidak memiliki izin untuk menghapusnya.');
        } catch (\Exception $e) {
            Log::error('Error deleting cart item: ' . $e->getMessage(), ['id' => $id, 'nama_pembeli' => $namaPembeli, 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Gagal menghapus produk. Terjadi kesalahan server.');
        }
    }

    public function clearCart()
    {
        // Ambil detail pembeli dari sesi
        $namaPembeli = Session::get('cart_nama_pembeli');
        $alamat = Session::get('cart_alamat');
        $noHp = Session::get('cart_no_hp');

        if (!$namaPembeli || !$alamat || !$noHp) {
            return redirect()->route('cart.index')->with('error', 'Detail pembeli tidak ditemukan di sesi. Tidak dapat mengosongkan keranjang.');
        }

        try {
            // Hapus semua item keranjang untuk pembeli ini
            Cart::where('nama_pembeli', $namaPembeli)
                ->where('alamat', $alamat)
                ->where('no_hp', $noHp)
                ->delete();

            // Kosongkan sesi detail pembeli
            Session::forget(['cart_nama_pembeli', 'cart_alamat', 'cart_no_hp']);

            return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan!');
        } catch (\Exception $e) {
            Log::error('Error clearing cart: ' . $e->getMessage(), ['nama_pembeli' => $namaPembeli, 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Gagal mengosongkan keranjang. Terjadi kesalahan server.');
        }
    }
}

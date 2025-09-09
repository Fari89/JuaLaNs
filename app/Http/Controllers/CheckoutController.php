<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Models\Cart;
use App\Models\Product; // Pastikan ini ada jika Anda menggunakannya

class CheckoutController extends Controller
{
    public function index()
    {
        // Ambil detail pembeli dari sesi untuk mengidentifikasi keranjang
        $namaPembeli = Session::get('cart_nama_pembeli');
        $alamat = Session::get('cart_alamat');
        $noHp = Session::get('cart_no_hp');

        $cartItems = collect();
        $total = 0;

        if ($namaPembeli && $alamat && $noHp) {
            $cartItems = Cart::where('nama_pembeli', $namaPembeli)
                             ->where('alamat', $alamat)
                             ->where('no_hp', $noHp)
                             ->with('product')
                             ->get();

            foreach ($cartItems as $item) {
                $itemPrice = $item->price ?? ($item->product->harga ?? 0);
                $itemQuantity = $item->jumlah ?? 0;
                $item->subtotal = $itemPrice * $itemQuantity;
                $total += $item->subtotal;
            }
        }

        return view('checkout.index', compact('cartItems', 'total'));
    }

    /**
     * Memproses pesanan dari modal checkout.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process(Request $request)
    {
        $rules = [
            'nama_penerima' => 'required|string|max:255',
            'no_hp_penerima' => 'required|string|max:20',
            'alamat_lengkap' => 'required|string|max:500',
            // 'kota' => 'required|string|max:255', // Jika Anda menambahkan input kota
            // 'kode_pos' => 'required|string|max:10', // Jika Anda menambahkan input kode_pos
            'payment_method' => 'required|string|in:cod,transfer',
            'agree_terms' => 'required|accepted',
            'catatan_pesanan' => 'nullable|string|max:1000',
        ];

        if ($request->input('payment_method') === 'transfer') {
            $rules['nama_pengirim_rekening'] = 'required|string|max:255';
            $rules['nomor_rekening_pengirim'] = 'required|string|max:50';
        }

        try {
            $request->validate($rules);

            // Ambil detail pembeli dari sesi
            $namaPembeli = Session::get('cart_nama_pembeli');
            $alamatPembeli = Session::get('cart_alamat');
            $noHpPembeli = Session::get('cart_no_hp');

            if (!$namaPembeli || !$alamatPembeli || !$noHpPembeli) {
                return redirect()->back()->with('error', 'Detail pembeli tidak ditemukan di sesi. Tidak dapat memproses pesanan.');
            }

            $cartItems = Cart::where('nama_pembeli', $namaPembeli)
                             ->where('alamat', $alamatPembeli)
                             ->where('no_hp', $noHpPembeli)
                             ->with('product')
                             ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Keranjang Anda kosong. Tidak ada yang bisa diproses.');
            }

            // --- LOGIKA PEMROSESAN PESANAN UTAMA DIMULAI DI SINI ---
            // Anda perlu menyimpan pesanan ini ke tabel 'orders' atau sejenisnya.
            // Contoh:
            // $totalOrder = $cartItems->sum(function($item) {
            //     return ($item->price ?? ($item->product->harga ?? 0)) * $item->jumlah;
            // });

            // Simpan ke tabel orders (Anda perlu model Order dan migrasi)
            // \App\Models\Order::create([
            //     'nama_pembeli' => $namaPembeli,
            //     'alamat_pengiriman' => $request->input('alamat_lengkap'),
            //     'no_hp' => $noHpPembeli, // Atau $request->input('no_hp_penerima') jika Anda ingin yang dari form
            //     'total_harga' => $totalOrder,
            //     'metode_pembayaran' => $request->input('payment_method'),
            //     'status' => 'pending',
            //     // Tambahkan kolom lain seperti nama_penerima, kota, kode_pos, catatan_pesanan, dll.
            // ]);

            // Hapus item dari keranjang setelah berhasil diproses
            Cart::where('nama_pembeli', $namaPembeli)
                ->where('alamat', $alamatPembeli)
                ->where('no_hp', $noHpPembeli)
                ->delete();

            // Kosongkan sesi detail pembeli dan total kuantitas keranjang
            Session::forget(['cart_nama_pembeli', 'cart_alamat', 'cart_no_hp', 'cart_total_quantity']);

            // Redirect ke halaman sukses dengan pesan
            return redirect()->route('checkout.success')->with('success', 'Pesanan Anda berhasil dibuat!');

        } catch (ValidationException $e) {
            Log::error('Error validasi saat memproses checkout: ' . $e->getMessage(), $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput()->with('error', 'Validasi gagal. Mohon periksa kembali input Anda.');
        } catch (\Exception $e) {
            Log::error('Error umum saat memproses checkout: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Gagal memproses pesanan. Terjadi kesalahan server.');
        }
    }

    /**
     * Menampilkan halaman sukses setelah checkout.
     *
     * @return \Illuminate\View\View
     */
    public function success()
    {
        return view('checkout.success');
    }
}

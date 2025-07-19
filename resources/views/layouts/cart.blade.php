
@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-bold mb-6 text-gray-800">🛒 Keranjang Belanja</h2>

    @if($carts->count() > 0)
        <div class="overflow-x-auto bg-white rounded-xl shadow">
            <table class="min-w-full table-auto text-sm text-left text-gray-700">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4">Gambar</th>
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">Jumlah</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4">Pembeli</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($carts as $cart)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                @if(!empty($cart->product->image))
                                    <img src="{{ asset('storage/' . $cart->product->image) }}" alt="{{ $cart->product->name }}" class="w-14 h-14 object-cover rounded-md">
                                @else
                                    <div class="w-14 h-14 bg-gray-100 flex items-center justify-center rounded-md text-gray-400">
                                        <span class="text-xs">No Image</span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium">{{ $cart->product->name }}</td>
                            <td class="px-6 py-4">{{ $cart->jumlah }}</td>
                            <td class="px-6 py-4 text-green-600">Rp{{ number_format($cart->product->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">{{ $cart->nama_pembeli }}</td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('cart.destroy', $cart->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 text-sm text-red-600 hover:text-red-800 hover:underline">
                                        ✖ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center text-gray-500 mt-8">
            <p class="text-lg">Keranjang kamu kosong 🧺</p>
            <a href="{{ route('product.index') }}" class="inline-block mt-4 text-blue-600 hover:underline">Belanja Sekarang</a>
        </div>
    @endif
@endsection

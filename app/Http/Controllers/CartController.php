<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart; // <-- Gunakan Facade dari package

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function add(Product $product)
    {
        Cart::add(
            $product->id, 
            $product->name, 
            1, // kuantitas
            $product->price,
            0, // berat (bisa diisi 0 jika tidak digunakan)
            ['image_url' => $product->image_url] // opsi tambahan
        );

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $rowId)
    {
        Cart::update($rowId, $request->quantity);
        return back()->with('success', 'Jumlah produk berhasil diupdate.');
    }

    public function remove($rowId)
    {
        Cart::remove($rowId);
        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
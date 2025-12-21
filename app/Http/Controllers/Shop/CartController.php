<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

/**
 * Controller for handling shopping cart operations.
 */
class CartController extends Controller
{
    /**
     * Display the shopping cart page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('cart.index');
    }

    /**
     * Add a product to the shopping cart.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Product $product)
    {
        Cart::add(
            $product->id,
            $product->name,
            1, // quantity
            $product->price,
            0, // weight (not used)
            ['image_url' => $product->image_url]
        );

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update product quantity in the cart.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, string $rowId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        Cart::update($rowId, $request->quantity);

        return back()->with('success', 'Jumlah produk berhasil diupdate.');
    }

    /**
     * Remove a product from the cart.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(string $rowId)
    {
        Cart::remove($rowId);

        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}

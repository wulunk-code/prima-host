<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN KERANJANG
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $cart = session()->get('cart', []);

        return view(
            'cart',
            compact('cart')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TAMBAH KERANJANG
    |--------------------------------------------------------------------------
    */

    public function add($id)
    {
        $product = Product::findOrFail($id);

        $cart = session()->get('cart', []);

        if(isset($cart[$id]))
        {
            $cart[$id]['qty']++;
        }
        else
        {
            $cart[$id] = [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => $product->price,
                'image' => $product->image,
                'qty'   => 1
            ];
        }

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with(
                'success',
                'Produk berhasil ditambahkan'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE QTY
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id]))
        {
            $cart[$id]['qty'] =
                max(1, (int)$request->qty);

            session()->put('cart', $cart);
        }

        return back();
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS ITEM
    |--------------------------------------------------------------------------
    */

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id]))
        {
            unset($cart[$id]);

            session()->put('cart', $cart);
        }

        return back();
    }
}
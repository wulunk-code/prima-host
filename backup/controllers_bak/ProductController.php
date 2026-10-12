<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();
        return view('produk', compact('products'));
    }

    public function create()
    {
        return view('produk_tambah');
    }

    public function store(Request $request)
    {
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock
        ]);

        return redirect('/produk');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('produk_edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock
        ]);

        return redirect('/produk');
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return redirect('/produk');
    }
}

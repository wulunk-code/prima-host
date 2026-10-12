<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ADMIN LIST PRODUK
    |--------------------------------------------------------------------------
    */
    public function index()
{
    $products = \App\Models\Product::with('category')
        ->latest()
        ->paginate(20);

    return view(
        'admin.products.index',
        compact('products')
    );
}

    /*
    |--------------------------------------------------------------------------
    | FRONTEND LIST PRODUK
    |--------------------------------------------------------------------------
    */
    public function frontend()
    {
        $products = Product::with('category')
            ->where('is_active', 1)
            ->latest()
            ->get();

        return view('produk', compact('products'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH PRODUK
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $categories = Category::where('is_active', 1)
            ->orderBy('name')
            ->get();

        return view(
            'admin.products.create',
            compact('categories')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN PRODUK
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'image'       => 'nullable|image|max:2048'
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'is_active'   => $request->is_active ?? 1,
        ];

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $filename =
                time() . '_' .
                $file->getClientOriginalName();

            $destination = public_path(
                'uploads/products'
            );

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move(
                $destination,
                $filename
            );

            $data['image'] = $filename;
        }

        Product::create($data);

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Produk berhasil ditambahkan'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT PRODUK
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $categories = Category::where(
            'is_active',
            1
        )->orderBy('name')->get();

        return view(
            'admin.products.edit',
            compact(
                'product',
                'categories'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PRODUK
    |--------------------------------------------------------------------------
    */
    public function update(
        Request $request,
        $id
    )
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'        => 'required',
            'category_id' => 'nullable|exists:categories,id',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'image'       => 'nullable|image|max:2048'
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'is_active'   => $request->is_active ?? 1,
        ];

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $filename =
                time() . '_' .
                $file->getClientOriginalName();

            $destination = public_path(
                'uploads/products'
            );

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $file->move(
                $destination,
                $filename
            );

            $data['image'] = $filename;
        }

        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Produk berhasil diperbarui'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS PRODUK
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (
            $product->image &&
            file_exists(
                public_path(
                    'uploads/products/' .
                    $product->image
                )
            )
        ) {
            unlink(
                public_path(
                    'uploads/products/' .
                    $product->image
                )
            );
        }

        $product->delete();

        return back()->with(
            'success',
            'Produk berhasil dihapus'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL PRODUK
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $product = Product::with('category')
            ->findOrFail($id);

        return view(
    'produk_detail',
    compact('product')
);
    }
}
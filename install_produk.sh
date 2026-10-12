#!/bin/bash

echo "================================="
echo " INSTALL MODUL PRODUK PRIMA HOST "
echo "================================="

mkdir -p public/uploads
chmod 755 public/uploads

mkdir -p resources/views

cat > app/Models/Product.php <<'EOF'
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'image',
        'is_active'
    ];
}
EOF

cat > app/Http/Controllers/ProductController.php <<'EOF'
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
        $filename = null;

        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'),$filename);
        }

        Product::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
            'stock'=>$request->stock,
            'image'=>$filename
        ]);

        return redirect('/produk');
    }
}
EOF

cat > resources/views/produk_tambah.blade.php <<'EOF'
<!DOCTYPE html>
<html>
<head>
<title>Tambah Produk</title>
</head>
<body>

<h1>Tambah Produk</h1>

<form method="POST" action="/produk/simpan" enctype="multipart/form-data">
@csrf

<p>Nama Produk</p>
<input type="text" name="name">

<p>Deskripsi</p>
<textarea name="description"></textarea>

<p>Harga</p>
<input type="number" name="price">

<p>Stok</p>
<input type="number" name="stock">

<p>Foto</p>
<input type="file" name="image">

<br><br>

<button type="submit">
Simpan Produk
</button>

</form>

</body>
</html>
EOF

cat > routes/web.php <<'EOF'
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', fn() => view('dashboard'));

Route::get('/produk',[ProductController::class,'index']);
Route::get('/produk/tambah',[ProductController::class,'create']);
Route::post('/produk/simpan',[ProductController::class,'store']);

Route::get('/promo', fn() => view('promo'));
Route::get('/event', fn() => view('event'));
Route::get('/member', fn() => view('member'));
Route::get('/reseller', fn() => view('reseller'));
Route::get('/pesanan', fn() => view('pesanan'));
EOF

php artisan optimize:clear

echo "SELESAI"

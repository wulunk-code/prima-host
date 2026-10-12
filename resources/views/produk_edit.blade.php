<!DOCTYPE html>
<html>
<head>
<title>Edit Produk</title>
</head>
<body>

<h2>Edit Produk</h2>

<form action="/produk/update/{{ $product->id }}" method="POST" enctype="multipart/form-data">
@csrf

<p>Nama Produk</p>
<input type="text" name="name" value="{{ $product->name }}">

<p>Deskripsi</p>
<textarea name="description">{{ $product->description }}</textarea>

<p>Harga</p>
<input type="number" name="price" value="{{ $product->price }}">

<p>Stok</p>
<input type="number" name="stock" value="{{ $product->stock }}">

@if($product->image)
<img src="/uploads/{{ $product->image }}" width="120">
@endif

<p>Ganti Foto</p>
<input type="file" name="image">

<br><br>

<button type="submit">
Update
</button>

</form>

</body>
</html>
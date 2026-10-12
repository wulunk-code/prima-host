<!DOCTYPE html>
<html>
<head>
<title>Edit Produk</title>
</head>
<body>

<h1>Edit Produk</h1>

<form method="POST" action="/produk/update/{{$product->id}}">
@csrf

<p>Nama Produk</p>
<input type="text" name="name" value="{{$product->name}}">

<p>Deskripsi</p>
<textarea name="description">{{$product->description}}</textarea>

<p>Harga</p>
<input type="number" name="price" value="{{$product->price}}">

<p>Stok</p>
<input type="number" name="stock" value="{{$product->stock}}">

<br><br>

<button type="submit">
Update Produk
</button>

</form>

</body>
</html>
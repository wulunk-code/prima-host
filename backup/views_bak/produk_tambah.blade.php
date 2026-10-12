<!DOCTYPE html>
<html>
<head>
<title>Tambah Produk</title>
</head>
<body>

<h1>Tambah Produk Prima Host</h1>

<form method="POST" action="/produk/simpan">

@csrf

<p>Nama Produk</p>
<input type="text" name="name" required>

<p>Deskripsi</p>
<textarea name="description"></textarea>

<p>Harga</p>
<input type="number" name="price" required>

<p>Stok</p>
<input type="number" name="stock" value="0">

<br><br>

<button type="submit">
Simpan Produk
</button>

</form>

<br>

<a href="/produk">
Kembali Produk
</a>

</body>
</html>

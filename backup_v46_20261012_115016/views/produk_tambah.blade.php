<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Tambah Produk</title>

<style>

body{
    font-family:Arial,sans-serif;
    background:#f4f4f4;
    margin:0;
    padding:15px;
}

.header{
    background:#00b140;
    color:white;
    text-align:center;
    padding:18px;
    border-radius:12px;
    font-size:26px;
    font-weight:bold;
    margin-bottom:15px;
}

.card{
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

label{
    display:block;
    margin-top:15px;
    margin-bottom:5px;
    font-weight:bold;
}

input[type=text],
input[type=number],
textarea{
    width:100%;
    box-sizing:border-box;
    padding:12px;
    border:1px solid #ddd;
    border-radius:8px;
    font-size:15px;
}

textarea{
    height:100px;
    resize:none;
}

input[type=file]{
    width:100%;
    margin-top:5px;
}

.btn{
    border:none;
    padding:12px 20px;
    border-radius:8px;
    cursor:pointer;
    text-decoration:none;
    display:inline-block;
    margin-top:20px;
    font-size:15px;
}

.btn-simpan{
    background:#00b140;
    color:white;
}

.btn-kembali{
    background:#666;
    color:white;
    margin-right:10px;
}

</style>
</head>
<body>

<div class="header">
📦 Tambah Produk
</div>

<div class="card">

<form action="/produk/store" method="POST" enctype="multipart/form-data">

@csrf

<label>Nama Produk</label>
<input type="text" name="name" required>

<label>Deskripsi</label>
<textarea name="description"></textarea>

<label>Harga</label>
<input type="number" name="price" required>

<label>Stok</label>
<input type="number" name="stock" required>

<label>Foto Produk</label>
<input type="file" name="image">

<a href="/produk" class="btn btn-kembali">
Kembali
</a>

<button type="submit" class="btn btn-simpan">
Simpan Produk
</button>

</form>

</div>

</body>
</html>
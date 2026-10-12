<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Produk Prima Host</title>

<style>

body{
    font-family:Arial,sans-serif;
    background:#f4f6f9;
    margin:0;
}

.header{
    background:#16a34a;
    color:white;
    padding:20px;
    text-align:center;
}

.container{
    width:90%;
    margin:auto;
    margin-top:20px;
}

.btn{
    background:#16a34a;
    color:white;
    padding:10px 15px;
    text-decoration:none;
    border-radius:5px;
}

.btn:hover{
    background:#15803d;
}

.card{
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#16a34a;
    color:white;
    padding:12px;
}

table td{
    padding:10px;
    border-bottom:1px solid #ddd;
}

.edit{
    color:blue;
    text-decoration:none;
}

.hapus{
    color:red;
    text-decoration:none;
}

.footer{
    margin-top:20px;
}

</style>
</head>

<body>

<div class="header">
    <h1>Prima Host</h1>
    <p>Manajemen Produk</p>
</div>

<div class="container">

<div class="card">

<a href="/produk/tambah" class="btn">
➕ Tambah Produk
</a>

<br><br>

@if($products->count())

<table>

<tr>
<th>Nama Produk</th>
<th>Harga</th>
<th>Stok</th>
<th>Aksi</th>
</tr>

@foreach($products as $p)

<tr>
<td>{{ $p->name }}</td>

<td>
Rp {{ number_format($p->price,0,',','.') }}
</td>

<td>{{ $p->stock }}</td>

<td>
<a class="edit" href="/produk/edit/{{ $p->id }}">
✏ Edit
</a>

|

<a class="hapus"
href="/produk/hapus/{{ $p->id }}"
onclick="return confirm('Hapus produk?')">
🗑 Hapus
</a>
</td>

</tr>

@endforeach

</table>

@else

<h3>Belum ada produk</h3>

@endif

<div class="footer">
<br>
<a href="/">🏠 Dashboard</a>
</div>

</div>

</div>

</body>
</html>
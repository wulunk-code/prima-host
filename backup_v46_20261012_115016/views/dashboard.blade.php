<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Prima Host</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{
background:#f5f5f5;
}

.header{
background:#00b140;
color:white;
padding:25px;
text-align:center;
}

.header h1{
font-size:28px;
}

.banner{
margin:15px;
background:white;
padding:15px;
border-radius:12px;
box-shadow:0 2px 10px rgba(0,0,0,.1);
text-align:center;
}

.menu{
display:grid;
grid-template-columns:repeat(2,1fr);
gap:12px;
padding:15px;
}

.card{
background:white;
border-radius:12px;
padding:20px;
text-align:center;
text-decoration:none;
color:#333;
box-shadow:0 2px 10px rgba(0,0,0,.1);
}

.icon{
font-size:40px;
margin-bottom:10px;
}

.title{
font-size:16px;
font-weight:bold;
}

.footer{
margin-top:20px;
text-align:center;
padding:15px;
color:#666;
}

</style>
</head>
<body>

<div class="header">
<h1>Prima Host</h1>
<p>Belanja Mudah & Cepat</p>
</div>

<div class="banner">
🎉 Promo Hari Ini 🎉
<br><br>
Diskon Produk Pilihan
</div>

<div class="menu">

<a href="/produk" class="card">
<div class="icon">📦</div>
<div class="title">Produk</div>
</a>

<a href="/keranjang" class="card">
<div class="icon">🛒</div>
<div class="title">Keranjang</div>
</a>

<a href="/promo" class="card">
<div class="icon">🎁</div>
<div class="title">Promo</div>
</a>

<a href="/event" class="card">
<div class="icon">📅</div>
<div class="title">Event</div>
</a>

<a href="/member" class="card">
<div class="icon">👤</div>
<div class="title">Member</div>
</a>

<a href="/reseller" class="card">
<div class="icon">🏪</div>
<div class="title">Reseller</div>
</a>

<a href="/admin/pesanan" class="card">
<div class="icon">📋</div>
<div class="title">Admin Pesanan</div>
</a>

<a href="/produk/tambah" class="card">
<div class="icon">➕</div>
<div class="title">Tambah Produk</div>
</a>



</div>

<div class="footer">
Prima Host © 2026
</div>

</body>
</html>
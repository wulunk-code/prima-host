<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Prima Host Admin</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{
background:#f5f6fa;
}

.header{
background:#00b140;
color:white;
padding:20px;
text-align:center;
font-size:30px;
font-weight:bold;
}

.container{
padding:15px;
}

.stats{
display:grid;
grid-template-columns:repeat(2,1fr);
gap:10px;
margin-bottom:20px;
}

.stat{
background:white;
padding:15px;
border-radius:12px;
text-align:center;
box-shadow:0 2px 8px rgba(0,0,0,.08);
}

.stat h3{
font-size:26px;
color:#00b140;
}

.grid{
display:grid;
grid-template-columns:repeat(2,1fr);
gap:15px;
}

.card{
background:white;
padding:15px;
border-radius:15px;
text-decoration:none;
color:#333;
text-align:center;
box-shadow:0 2px 8px rgba(0,0,0,.08);
}

.icon{
font-size:50px;
margin-bottom:10px;
}

.title{
font-weight:bold;
}

</style>
</head>
<body>

<div class="header">
Prima Host Admin
</div>

<div class="container">

<div class="stats">

<div class="stat">
<h3>{{ $totalProduk }}</h3>
Produk
</div>

<div class="stat">
<h3>{{ $totalPesanan }}</h3>
Pesanan
</div>

<div class="stat">
<h3>{{ $totalMember }}</h3>
Member
</div>

<div class="stat">
<h3>
Rp {{ number_format($omzet,0,',','.') }}
</h3>
Omzet
</div>

<div class="stat">
<h3>{{ $pending }}</h3>
Pending
</div>

<div class="stat">
<h3>{{ $verifikasi }}</h3>
Verifikasi
</div>

<div class="stat">
<h3>{{ $diproses }}</h3>
Diproses
</div>

<div class="stat">
<h3>{{ $dikirim }}</h3>
Dikirim
</div>

<div class="stat">
<h3>{{ $selesai }}</h3>
Selesai
</div>

</div>

<div class="grid">

<a href="/produk" class="card">
<div class="icon">📦</div>
<div class="title">Produk</div>
</a>

<a href="/admin/pesanan" class="card">
<div class="icon">🛒</div>
<div class="title">Pesanan</div>
</a>

<a href="/admin/member" class="card">
<div class="icon">👥</div>
<div class="title">Member</div>
</a>

<a href="/admin/verifikasi" class="card">
<div class="icon">💰</div>
<div class="title">Verifikasi</div>
</a>

<a href="/admin/banner" class="card">
<div class="icon">🖼️</div>
<div class="title">Banner</div>
</a>

<a href="/admin/promotion" class="card">
<div class="icon">🎁</div>
<div class="title">Promo</div>
</a>

<a href="/admin/event" class="card">
<div class="icon">📅</div>
<div class="title">Event</div>
</a>

<a href="/admin/laporan" class="card">
<div class="icon">📊</div>
<div class="title">Laporan</div>
</a>

<a href="/admin/setting" class="card">
<div class="icon">⚙️</div>
<div class="title">Pengaturan</div>
</a>

<a href="/" class="card">
<div class="icon">🌐</div>
<div class="title">Website</div>
</a>

</div>

</div>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

@php
$setting = \App\Models\Setting::first();
@endphp

<title>
{{ $setting->store_name ?? 'Prima Host' }}
</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f5f5f5;
    min-height:100vh;
}

.navbar{
    background:#00b140;
}

.navbar-brand{
    color:white !important;
    font-weight:bold;
}

.nav-link{
    color:white !important;
}

.logo{
    height:45px;
    margin-right:10px;
}

.card{
    border:none;
    border-radius:12px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
}

.footer{
    margin-top:50px;
    background:white;
    padding:20px;
    text-align:center;
    border-top:1px solid #ddd;
}
.cart-item{
    background:#fff;
    display:flex;
    margin:10px;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
}

.cart-item img{
    width:90px;
    height:90px;
    object-fit:cover;
}

.info{
    flex:1;
    padding:10px;
}

.price{
    color:#ff6600;
    font-size:20px;
    font-weight:bold;
}

.remove{
    color:red;
    padding:15px;
}

.cart-footer{
    position:fixed;
    bottom:60px;
    left:0;
    width:100%;
    background:#fff;
    padding:10px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 -2px 10px rgba(0,0,0,.1);
}



.checkout-btn{
position:fixed;
bottom:70px;
left:10px;
right:10px;
height:55px;
border:none;
border-radius:12px;
background:#00b140;
color:#fff;
font-size:18px;
font-weight:bold;
z-index:999;
box-shadow:0 4px 15px rgba(0,0,0,.2);
}


.product-detail-card{
    background:#fff;
    border-radius:15px;
    overflow:hidden;
    margin-bottom:15px;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
}

.product-detail-image{
    width:100%;
    height:320px;
    object-fit:cover;
}

.product-detail-body{
    padding:15px;
}

.product-price-big{
    color:#ff6600;
    font-size:30px;
    font-weight:bold;
}

.product-stock{
    color:#666;
    margin-top:5px;
}

.product-desc{
    margin-top:15px;
    line-height:1.7;
    color:#444;
}

.bottom-bar{
    position:fixed;
    bottom:0;
    left:0;
    right:0;
    background:#fff;
    padding:10px;
    display:flex;
    gap:10px;
    box-shadow:0 -2px 15px rgba(0,0,0,.15);
    z-index:9999;
}

.btn-cart{
    flex:1;
    background:#ff9900;
    color:#fff;
    border:none;
    border-radius:12px;
    height:55px;
    font-weight:bold;
}

.btn-buy{
    flex:2;
    background:#00b140;
    color:#fff;
    border:none;
    border-radius:12px;
    height:55px;
    font-weight:bold;
}

.mobile-footer{
position:fixed;
bottom:0;
left:0;
right:0;
background:#fff;
display:flex;
justify-content:space-around;
padding:10px 0;
box-shadow:0 -2px 10px rgba(0,0,0,.15);
z-index:99999;
}

.mobile-footer a{
text-decoration:none;
color:#333;
font-size:12px;
display:flex;
flex-direction:column;
align-items:center;
}

.product-grid{
display:grid;
grid-template-columns:repeat(2,1fr);
gap:12px;
padding:10px;
}

.product-card{
background:#fff;
border-radius:15px;
overflow:hidden;
box-shadow:0 2px 10px rgba(0,0,0,.08);
}

.product-card img{
width:100%;
height:150px;
object-fit:cover;
}

.product-body{
padding:10px;
}

.product-body .product-name{
font-size:14px;
font-weight:600;
height:40px;
overflow:hidden;
}

.product-body .product-price{
font-size:18px;
color:#ff6f00;
font-weight:bold;
}

</style>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark">

<div class="container">

<a class="navbar-brand d-flex align-items-center" href="/">

@if($setting && $setting->store_logo)

<img
src="{{ asset($setting->store_logo) }}"
class="logo">

@endif

<span>
{{ $setting->store_name ?? 'Prima Host' }}
</span>

</a>

<button
class="navbar-toggler"
type="button"
data-bs-toggle="collapse"
data-bs-target="#navbar">

<span class="navbar-toggler-icon"></span>

</button>

<div class="collapse navbar-collapse" id="navbar">

<ul class="navbar-nav ms-auto">

<li class="nav-item">
<a class="nav-link" href="/">
Beranda
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="/produk">
Produk
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="/keranjang">
Keranjang
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="/promo">
Promo
</a>
</li>

<li class="nav-item">
<a class="nav-link" href="/admin">
Admin
</a>
</li>

</ul>

</div>

</div>

</nav>

<div class="container mt-4">

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif

@if(session('error'))

<div class="alert alert-danger">

{{ session('error') }}

</div>

@endif

@yield('content')

</div>

<div class="footer">

@if($setting)

<strong>

{{ $setting->store_name }}

</strong>

<br>

{{ $setting->store_address }}

<br>

WA :
{{ $setting->store_phone }}

<br>

@endif

<small>

© {{ date('Y') }} Prima Host

</small>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



<div class="mobile-footer">

<a href="/">
🏠
<span>Home</span>
</a>

<a href="/cart">
🛒
<span>Cart</span>
</a>

<a href="/riwayat">
📋
<span>Pesanan</span>
</a>

<a href="/admin">
⚙️
<span>Admin</span>
</a>

</div>



</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Checkout - Prima House</title>

<style>
*{
box-sizing:border-box;
font-family:Arial,sans-serif;
}

body{
margin:0;
background:#f5f6f8;
}

.header{
background:#00b140;
color:white;
padding:20px;
font-size:20px;
font-weight:bold;
}

.container{
max-width:650px;
margin:auto;
padding:20px;
}

.card{
background:white;
padding:20px;
border-radius:15px;
box-shadow:0 3px 15px rgba(0,0,0,.08);
}

input,textarea{
width:100%;
padding:13px;
border:1px solid #ddd;
border-radius:9px;
margin:8px 0 15px;
font-size:15px;
}

label{
font-weight:bold;
}

button{
width:100%;
padding:15px;
background:#00b140;
color:white;
border:none;
border-radius:10px;
font-size:16px;
font-weight:bold;
cursor:pointer;
}

.total{
font-size:23px;
font-weight:bold;
color:#ff6600;
margin:20px 0;
}

.back{
display:block;
margin-bottom:15px;
color:#00b140;
text-decoration:none;
}
</style>
</head>

<body>

<div class="header">
Checkout Prima House
</div>

<div class="container">

<a href="{{ url('/cart') }}" class="back">
← Kembali ke Keranjang
</a>

<div class="card">

<h3>Data Pembeli</h3>

@php
$cart = session('cart',[]);
$total = 0;

foreach($cart as $item){
$total += ($item['price'] ?? 0) * ($item['qty'] ?? 1);
}
@endphp

@if(count($cart) === 0)

<p>Keranjang masih kosong.</p>

<a href="{{ url('/') }}">Mulai Belanja</a>

@else

<form method="POST" action="{{ url('/checkout') }}">
@csrf

<label>Nama Pembeli</label>
<input
type="text"
name="name"
value="{{ old('name') }}"
required>

<label>Nomor WhatsApp</label>
<input
type="tel"
name="phone"
value="{{ old('phone') }}"
required>

<label>Alamat Pengiriman</label>
<textarea
name="address"
rows="4"
required>{{ old('address') }}</textarea>

<label>Catatan Pesanan</label>
<textarea
name="notes"
rows="3">{{ old('notes') }}</textarea>

<div class="total">
Total: Rp {{ number_format($total,0,',','.') }}
</div>

<button type="submit">
Buat Pesanan
</button>

</form>

@endif

</div>
</div>
</body>
</html>

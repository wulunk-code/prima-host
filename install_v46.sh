#!/bin/bash

set -e

echo "======================================"
echo " PRIMA HOUSE V4.6 INSTALLER"
echo "======================================"

cd ~/public_html/prima_host_v2 || exit 1

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP="backup_v46_$DATE"

mkdir -p "$BACKUP"

echo "Membuat backup..."

cp -a resources/views "$BACKUP/"
cp -a routes "$BACKUP/"
cp -a app/Http/Controllers "$BACKUP/"

echo "Backup: $BACKUP"

mkdir -p resources/views/cart
mkdir -p public/css
mkdir -p public/js

# ======================================
# 1. HALAMAN KERANJANG
# ======================================

cat > resources/views/cart/index.blade.php <<'EOF'
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Keranjang Belanja - Prima House</title>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
*{
box-sizing:border-box;
margin:0;
padding:0;
font-family:Arial,sans-serif;
}

body{
background:#f5f6f8;
padding-bottom:170px;
}

.header{
background:linear-gradient(135deg,#00b140,#00d757);
padding:20px;
color:white;
display:flex;
align-items:center;
gap:15px;
}

.header a{
color:white;
font-size:22px;
text-decoration:none;
}

.header h2{
font-size:20px;
}

.container{
max-width:800px;
margin:auto;
padding:15px;
}

.cart-item{
background:white;
border-radius:16px;
padding:15px;
display:flex;
gap:15px;
margin-bottom:15px;
box-shadow:0 3px 12px rgba(0,0,0,.07);
}

.cart-image{
width:95px;
height:95px;
object-fit:cover;
border-radius:12px;
}

.cart-info{
flex:1;
min-width:0;
}

.cart-name{
font-size:16px;
font-weight:bold;
margin-bottom:8px;
}

.cart-price{
color:#ff6600;
font-size:19px;
font-weight:bold;
}

.qty-row{
display:flex;
align-items:center;
gap:10px;
margin-top:12px;
}

.qty-btn{
width:32px;
height:32px;
border:none;
border-radius:8px;
background:#00b140;
color:white;
font-size:18px;
cursor:pointer;
}

.qty-number{
font-weight:bold;
font-size:16px;
}

.remove-btn{
background:#fff0f0;
color:red;
border:none;
padding:8px 12px;
border-radius:8px;
margin-left:auto;
cursor:pointer;
}

.subtotal{
margin-top:10px;
font-size:13px;
color:#666;
}

.checkout-box{
position:fixed;
bottom:65px;
left:0;
right:0;
background:white;
padding:15px;
box-shadow:0 -4px 20px rgba(0,0,0,.1);
z-index:100;
}

.checkout-inner{
max-width:800px;
margin:auto;
}

.total-row{
display:flex;
justify-content:space-between;
font-size:18px;
font-weight:bold;
margin-bottom:12px;
}

.total-price{
color:#ff6600;
}

.checkout-btn{
display:block;
width:100%;
padding:15px;
background:linear-gradient(135deg,#00b140,#00d757);
border:none;
border-radius:12px;
color:white;
font-size:16px;
font-weight:bold;
text-align:center;
text-decoration:none;
}

.bottom-nav{
position:fixed;
bottom:0;
left:0;
right:0;
height:65px;
background:white;
display:flex;
justify-content:space-around;
align-items:center;
box-shadow:0 -3px 15px rgba(0,0,0,.1);
z-index:200;
}

.bottom-nav a{
color:#666;
text-decoration:none;
display:flex;
flex-direction:column;
align-items:center;
font-size:12px;
gap:5px;
}

.bottom-nav i{
font-size:21px;
}

.bottom-nav a.active{
color:#00b140;
}

.empty-cart{
background:white;
padding:50px 20px;
text-align:center;
border-radius:18px;
}

.empty-cart i{
font-size:65px;
color:#ccc;
margin-bottom:20px;
}

@media(max-width:400px){
.cart-image{
width:80px;
height:80px;
}
.cart-name{
font-size:14px;
}
}
</style>
</head>

<body>

<div class="header">
<a href="{{ url('/') }}">
<i class="fas fa-arrow-left"></i>
</a>
<h2>Keranjang Belanja</h2>
</div>

<div class="container">

@if(session('success'))
<div style="background:#d1fae5;padding:15px;border-radius:10px;margin-bottom:15px;color:#065f46">
{{ session('success') }}
</div>
@endif

@php
$cart = session('cart', []);
$total = 0;
@endphp

@if(count($cart) > 0)

@foreach($cart as $id => $item)

@php
$qty = (int)($item['qty'] ?? 1);
$price = (float)($item['price'] ?? 0);
$subtotal = $price * $qty;
$total += $subtotal;
@endphp

<div class="cart-item">

<img
src="{{ asset($item['image'] ?? 'no-image.png') }}"
class="cart-image"
onerror="this.src='{{ asset('no-image.png') }}'">

<div class="cart-info">

<div class="cart-name">
{{ $item['name'] ?? 'Produk' }}
</div>

<div class="cart-price">
Rp {{ number_format($price,0,',','.') }}
</div>

<div class="qty-row">

<form method="POST" action="{{ url('/cart/update/'.$id) }}">
@csrf
<input type="hidden" name="qty" value="{{ max(1,$qty-1) }}">
<button class="qty-btn" type="submit">−</button>
</form>

<span class="qty-number">{{ $qty }}</span>

<form method="POST" action="{{ url('/cart/update/'.$id) }}">
@csrf
<input type="hidden" name="qty" value="{{ $qty+1 }}">
<button class="qty-btn" type="submit">+</button>
</form>

<form method="GET"
action="{{ url('/cart/remove/'.$id) }}"
onsubmit="return confirm('Hapus produk ini?')">

<button class="remove-btn" type="submit">
<i class="fas fa-trash"></i>
</button>

</form>

</div>

<div class="subtotal">
Subtotal:
<strong>
Rp {{ number_format($subtotal,0,',','.') }}
</strong>
</div>

</div>
</div>

@endforeach

@else

<div class="empty-cart">
<i class="fas fa-shopping-cart"></i>
<h3>Keranjang Masih Kosong</h3>
<p style="margin:15px 0;color:#777">
Silakan pilih produk terlebih dahulu.
</p>
<a href="{{ url('/') }}" class="checkout-btn">
Mulai Belanja
</a>
</div>

@endif

</div>

@if(count($cart) > 0)

<div class="checkout-box">
<div class="checkout-inner">

<div class="total-row">
<span>Total Belanja</span>
<span class="total-price">
Rp {{ number_format($total,0,',','.') }}
</span>
</div>

<a href="{{ url('/checkout') }}" class="checkout-btn">
Lanjut Checkout
<i class="fas fa-arrow-right"></i>
</a>

</div>
</div>

@endif

<div class="bottom-nav">

<a href="{{ url('/') }}">
<i class="fas fa-home"></i>
Home
</a>

<a href="{{ url('/cart') }}" class="active">
<i class="fas fa-shopping-cart"></i>
Cart
</a>

<a href="{{ url('/riwayat') }}">
<i class="fas fa-file-alt"></i>
Riwayat
</a>

<a href="{{ url('/admin') }}">
<i class="fas fa-user-cog"></i>
Admin
</a>

</div>

</body>
</html>
EOF

echo "Halaman keranjang selesai."

# ======================================
# 2. HALAMAN CHECKOUT
# ======================================

cat > resources/views/cart/checkout_v46.blade.php <<'EOF'
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
EOF

echo "Halaman checkout selesai."

# ======================================
# 3. CSS TOMBOL KERANJANG
# ======================================

cat > public/css/prima-cart-v46.css <<'EOF'

.prima-cart-form{
display:block;
width:100%;
margin:0;
}

.prima-cart-form .prima-v44-cart{
width:100%;
cursor:pointer;
font-family:inherit;
}

.prima-cart-toast{
position:fixed;
top:85px;
left:50%;
transform:translateX(-50%);
background:#00b140;
color:white;
padding:13px 20px;
border-radius:12px;
font-size:14px;
font-weight:bold;
z-index:999999;
box-shadow:0 5px 20px rgba(0,0,0,.2);
max-width:90%;
text-align:center;
}

EOF

# ======================================
# 4. AJAX KERANJANG
# ======================================

cat > public/js/prima-cart-v46.js <<'EOF'

document.addEventListener('DOMContentLoaded',function(){

document.querySelectorAll('.prima-cart-form').forEach(function(form){

form.addEventListener('submit',async function(e){

e.preventDefault();

const button=form.querySelector('button');

if(button.disabled)return;

button.disabled=true;

const oldText=button.innerHTML;
button.innerHTML='⏳ Menambahkan...';

try{

const response=await fetch(form.action,{
method:'POST',
body:new FormData(form),
headers:{
'Accept':'application/json',
'X-Requested-With':'XMLHttpRequest'
},
credentials:'same-origin'
});

if(!response.ok){
throw new Error('Gagal menambahkan produk');
}

showToast('✅ Produk berhasil ditambahkan');

const badge=document.querySelector('.cart-badge');

if(badge){
let count=parseInt(badge.textContent)||0;
badge.textContent=count+1;
}

}catch(error){

showToast('❌ Gagal menambahkan produk');

}finally{

button.disabled=false;
button.innerHTML=oldText;

}

});

});

function showToast(message){

const old=document.querySelector('.prima-cart-toast');
if(old)old.remove();

const toast=document.createElement('div');
toast.className='prima-cart-toast';
toast.textContent=message;

document.body.appendChild(toast);

setTimeout(function(){
toast.remove();
},2500);

}

});

EOF

# ======================================
# 5. UPDATE HOME BLADE
# ======================================

HOME="resources/views/home.blade.php"

if [ -f "$HOME" ]; then

php <<'PHP'
<?php

$file='resources/views/home.blade.php';

$html=file_get_contents($file);

$pattern='~<a\s+href="\{\{\s*url\(\s*[\'"]/product/[\'"]\s*\.\s*\$product->id\s*\)\s*\}\}"\s+class="prima-v44-cart"\s*>\s*🛒\s*Keranjang\s*</a>~u';

$replacement=<<<'BLADE'
<form action="{{ url('/cart/add/'.$product->id) }}" method="POST" class="prima-cart-form">
@csrf
<button type="submit" class="prima-v44-cart">🛒 Keranjang</button>
</form>
BLADE;

$html=preg_replace($pattern,$replacement,$html);

if(strpos($html,'prima-cart-v46.css')===false){

$html=str_replace(
'</head>',
'<link rel="stylesheet" href="{{ asset("css/prima-cart-v46.css") }}?v=46">'."\n".'</head>',
$html
);

}

if(strpos($html,'prima-cart-v46.js')===false){

$html=str_replace(
'</body>',
'<script src="{{ asset("js/prima-cart-v46.js") }}?v=46" defer></script>'."\n".'</body>',
$html
);

}

file_put_contents($file,$html);

echo "Home diperbarui.\n";
PHP

fi

# ======================================
# 6. ROUTE CHECKOUT
# ======================================

php <<'PHP'
<?php

$file='routes/web.php';

$html=file_get_contents($file);

$route=<<<'ROUTE'

// PRIMA HOUSE V4.6 CHECKOUT PAGE
Route::get('/checkout', function () {
    return view('cart.checkout_v46');
})->name('checkout.v46');

ROUTE;

if(strpos($html,'checkout.v46')===false){
    $html.="\n".$route;
    file_put_contents($file,$html);
}

echo "Route checkout diperiksa.\n";
PHP

# ======================================
# 7. CLEAR CACHE
# ======================================

php artisan view:clear
php artisan route:clear
php artisan config:clear
php artisan optimize:clear

echo ""
echo "======================================"
echo " PRIMA HOUSE V4.6 SELESAI"
echo "======================================"
echo ""
echo "Backup: $BACKUP"
echo ""
echo "Silakan tes:"
echo "1. Halaman utama"
echo "2. Tambah keranjang"
echo "3. Halaman /cart"
echo "4. Halaman /checkout"
echo ""


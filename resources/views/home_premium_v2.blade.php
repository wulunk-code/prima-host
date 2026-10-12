<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $setting->store_name ?? 'Prima House' }}</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Arial,sans-serif}
body{background:#f5f5f5}
.navbar{
background:#00b140;padding:12px;position:sticky;top:0;z-index:999;
box-shadow:0 2px 10px rgba(0,0,0,.15)
}
.header-row{display:flex;align-items:center;gap:10px}
.logo-mini{display:flex;align-items:center;gap:8px}
.logo-mini img{
width:42px;height:42px;border-radius:8px;background:#fff;
padding:2px;object-fit:contain
}
.logo-name{color:#fff;font-weight:bold;font-size:14px}
.logo-tagline{color:#eaffea;font-size:11px}
.search-box{
flex:1;background:#fff;border-radius:30px;padding:10px 15px
}
.search-box input{border:none;outline:none;width:100%}
.cart-btn{color:#fff;font-size:24px;text-decoration:none;position:relative}
.cart-badge{
position:absolute;top:-8px;right:-10px;background:red;color:#fff;
min-width:18px;height:18px;border-radius:50%;display:flex;
align-items:center;justify-content:center;font-size:11px
}
.container{max-width:1200px;margin:auto;padding:10px}
.welcome-text{
background:#fff;border-radius:10px;padding:8px 0;margin:10px 0;
overflow:hidden
}
.running-text{
white-space:nowrap;color:#00a651;font-weight:bold;
animation:jalan 15s linear infinite
}
@keyframes jalan{
from{transform:translateX(100%)}
to{transform:translateX(-100%)}
}
.slider-wrapper{
position:relative;overflow:hidden;border-radius:18px;
box-shadow:0 2px 10px rgba(0,0,0,.08)
}
.slides{display:flex;transition:transform .5s ease}
.slide{min-width:100%}
.slide img{width:100%;height:240px;object-fit:cover;display:block}
.dots{
position:absolute;bottom:10px;left:50%;
transform:translateX(-50%);display:flex;gap:5px
}
.dot{width:8px;height:8px;border-radius:50%;background:rgba(255,255,255,.5)}
.dot.active{background:#fff}
.menu-grid{
display:grid;grid-template-columns:repeat(4,1fr);
gap:10px;margin:15px 0
}
.menu-item{
background:#fff;padding:12px;border-radius:12px;text-align:center;
box-shadow:0 2px 8px rgba(0,0,0,.08)
}
.menu-item i{font-size:22px;color:#00b140;margin-bottom:5px}
.menu-item span{display:block;font-size:12px}
.section-title{
font-size:22px;font-weight:700;color:#00b140;
border-left:5px solid #00b140;padding-left:10px;margin:20px 0 12px
}
.event-card{
background:#fff;padding:15px;border-radius:12px;margin-bottom:10px;
box-shadow:0 2px 8px rgba(0,0,0,.08)
}
.product-grid{
display:grid;grid-template-columns:repeat(2,1fr);gap:12px
}
.product-card{
position:relative;background:#fff;border-radius:18px;overflow:hidden;
box-shadow:0 6px 20px rgba(0,0,0,.08)
}
.product-image{width:100%;height:170px;object-fit:cover}
.product-body{padding:10px}
.product-name{font-size:14px;font-weight:600;height:40px;overflow:hidden}
.product-price{font-size:20px;color:#ff6f00;font-weight:700;margin-top:8px}
.product-stock{font-size:12px;color:#777;margin-top:5px}
.badge-new,.sold-out{
position:absolute;top:8px;padding:4px 8px;border-radius:20px;
font-size:10px;color:#fff;font-weight:bold;z-index:10
}
.badge-new{left:8px;background:#ff6600}
.sold-out{right:8px;background:red}
.btn-detail,.btn-disabled{
display:block;width:100%;text-align:center;padding:10px;
border-radius:8px;margin-top:10px;font-weight:bold;text-decoration:none
}
.btn-detail{background:#00b140;color:#fff}
.btn-disabled{background:#999;color:#fff;border:none}
.footer{
background:#fff;text-align:center;padding:25px;margin-top:25px;color:#555
}
.wa-float{
position:fixed;right:20px;bottom:20px;width:60px;height:60px;
border-radius:50%;background:#25D366;color:#fff;display:flex;
align-items:center;justify-content:center;text-decoration:none;font-size:30px
}
@media(max-width:768px){
.slide img{height:180px}
.product-image{height:140px}
}
</style>
</head>
<body>

<div class="navbar">
<div class="header-row">

<div class="logo-mini">
@if(!empty($setting->store_logo))
<img src="{{ asset($setting->store_logo) }}">
@endif
<div>
<div class="logo-name">{{ $setting->store_name ?? 'Prima House' }}</div>
<div class="logo-tagline">Belanja Mudah & Cepat</div>
</div>
</div>

<form action="{{ url('/') }}" method="GET" class="search-box">
<input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk...">
</form>

<a href="{{ url('/cart') }}" class="cart-btn">
<i class="fas fa-shopping-cart"></i>
@if(session('cart'))
<span class="cart-badge">{{ count(session('cart')) }}</span>
@endif
</a>

</div>
</div>

<div class="container">

<div class="welcome-text">
<div class="running-text">
🌿 Selamat Datang di Prima House • Solusi Nutrisi & Gaya Hidup Sehat • Gratis Ongkir Radius 5 KM • Diskon Member • Produk Herbal Berkualitas 🌿
</div>
</div>

@if(isset($banners) && count($banners))
<div class="slider-wrapper">
<div class="slides">
@foreach($banners as $banner)
<div class="slide">
<img src="{{ asset('uploads/'.$banner->image) }}" alt="{{ $banner->title }}">
</div>
@endforeach
</div>
<div class="dots">
@foreach($banners as $banner)
<span class="dot"></span>
@endforeach
</div>
</div>
@endif

<div class="menu-grid">
<div class="menu-item"><i class="fas fa-capsules"></i><span>Herbal</span></div>
<div class="menu-item"><i class="fas fa-mug-hot"></i><span>Minuman</span></div>
<div class="menu-item"><i class="fas fa-utensils"></i><span>Makanan</span></div>
<div class="menu-item"><i class="fas fa-gift"></i><span>Promo</span></div>
</div>

<div class="section-title">🎉 Event & Promo</div>

@foreach($events as $event)
<div class="event-card">
<strong>{{ $event->title }}</strong><br><br>
{{ $event->description }}
</div>
@endforeach

<div class="section-title">🛒 Produk Terbaru</div>

<div class="product-grid">
@forelse($products as $product)
<div class="product-card">

@if($product->stock <= 0)
<span class="sold-out">HABIS</span>
@endif

@if($loop->iteration <= 4)
<span class="badge-new">BARU</span>
@endif

<img src="{{ asset($product->image) }}" class="product-image">

<div class="product-body">
<div class="product-name">{{ $product->name }}</div>
<div class="product-price">Rp {{ number_format($product->price,0,',','.') }}</div>
<div class="product-stock">Stok : {{ $product->stock }}</div>

@if($product->stock > 0)
<a href="{{ url('/product/'.$product->id) }}" class="btn-detail">Lihat Detail</a>
@else
<button class="btn-disabled">Stok Habis</button>
@endif

</div>
</div>
@empty
<p>Belum ada produk.</p>
@endforelse
</div>

<div class="footer">
<h3>{{ $setting->store_name ?? 'Prima House' }}</h3>
<p>© {{ date('Y') }} {{ $setting->store_name ?? 'Prima House' }}</p>
</div>

</div>

<script>
const slides=document.querySelector('.slides');
const dots=document.querySelectorAll('.dot');
if(slides){
let index=0;
const total=document.querySelectorAll('.slide').length;
function updateSlide(){
slides.style.transform=`translateX(-${index*100}%)`;
dots.forEach(d=>d.classList.remove('active'));
if(dots[index]) dots[index].classList.add('active');
}
updateSlide();
setInterval(()=>{
index=(index+1)%total;
updateSlide();
},3000);
}
</script>

</body>
</html>
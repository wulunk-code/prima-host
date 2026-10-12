<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Member Prima Host</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:Arial,sans-serif;
    background:#f5f5f5;
}

.header{
    background:#00b140;
    color:white;
    padding:20px;
    text-align:center;
}

.member-box{
    background:white;
    margin:15px;
    padding:20px;
    border-radius:12px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

.member-box h3{
    color:#00b140;
    margin-bottom:10px;
}

.member-box p{
    margin-bottom:8px;
    color:#555;
}

.menu-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:15px;
    padding:15px;
}

.menu-item{
    background:white;
    text-decoration:none;
    color:#333;
    border-radius:12px;
    padding:20px;
    text-align:center;
    box-shadow:0 2px 10px rgba(0,0,0,.08);
}

.menu-icon{
    font-size:35px;
    margin-bottom:10px;
}

.menu-item span{
    display:block;
    font-weight:bold;
}

.footer{
    text-align:center;
    padding:20px;
    color:#888;
    font-size:12px;
}

</style>
</head>
<body>

<div class="header">
    <h2>👤 Member Prima Host</h2>
    <p>Selamat Datang {{ $member->name }}</p>
</div>

<div class="member-box">
    <h3>{{ $member->name }}</h3>
    <p>📱 {{ $member->phone }}</p>
    <p>📧 {{ $member->email }}</p>
    <p>📍 {{ $member->address }}</p>
</div>

<div class="menu-grid">

    <a href="/produk" class="menu-item">
        <div class="menu-icon">🛒</div>
        <span>Belanja</span>
    </a>

    <a href="/keranjang" class="menu-item">
        <div class="menu-icon">🛍️</div>
        <span>Keranjang</span>
    </a>

    <a href="/checkout" class="menu-item">
        <div class="menu-icon">💳</div>
        <span>Checkout</span>
    </a>

    <a href="/promo" class="menu-item">
        <div class="menu-icon">🎁</div>
        <span>Promo</span>
    </a>

    <a href="/event" class="menu-item">
        <div class="menu-icon">📅</div>
        <span>Event</span>
    </a>

    <a href="/member/orders" class="menu-item">
        <div class="menu-icon">📦</div>
        <span>Pesanan Saya</span>
    </a>

    <a href="/member/logout" class="menu-item">
        <div class="menu-icon">🚪</div>
        <span>Logout</span>
    </a>

</div>

<div class="footer">
    Prima Host © 2026
</div>

</body>
</html>
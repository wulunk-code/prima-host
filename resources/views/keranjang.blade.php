<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Keranjang Belanja</title>

<style>

body{
    font-family:Arial,sans-serif;
    background:#f5f5f5;
    margin:0;
    padding:15px;
}

.card{
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

.item{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    border-bottom:1px solid #ddd;
    padding:15px 0;
}

.nama{
    font-size:18px;
    font-weight:bold;
    margin-bottom:8px;
}

.qty-box{
    margin-top:10px;
}

.qty-btn{
    display:inline-block;
    width:30px;
    height:30px;
    line-height:30px;
    text-align:center;
    text-decoration:none;
    color:white;
    border-radius:5px;
    font-weight:bold;
}

.minus{
    background:#ff6600;
}

.plus{
    background:#00b140;
}

.qty{
    display:inline-block;
    width:40px;
    text-align:center;
    font-weight:bold;
}

.harga{
    margin-top:8px;
    color:#666;
}

.subtotal{
    font-size:22px;
    font-weight:bold;
    color:#00b140;
}

.total{
    margin-top:20px;
    font-size:28px;
    font-weight:bold;
    color:#00b140;
}

.btn{
    display:block;
    text-align:center;
    color:white;
    padding:15px;
    text-decoration:none;
    border-radius:8px;
    margin-top:15px;
    font-weight:bold;
}

.checkout{
    background:#ff6600;
}

.belanja{
    background:#2196f3;
}

.hapus{
    display:inline-block;
    background:red;
    padding:6px 12px;
    border-radius:5px;
    color:white;
    text-decoration:none;
    font-size:12px;
    margin-top:10px;
}

</style>

</head>
<body>

<div class="card">

<h2>🛒 Keranjang Belanja</h2>

@forelse($cart as $id => $item)

<div class="item">

<div>

<div class="nama">
{{ $item['name'] }}
</div>

<div class="qty-box">

<a href="/cart/minus/{{ $item['id'] }}"
class="qty-btn minus">
➖
</a>

<span class="qty">
{{ $item['qty'] }}
</span>

<a href="/cart/plus/{{ $item['id'] }}"
class="qty-btn plus">
➕
</a>

</div>

<div class="harga">
Rp {{ number_format($item['price'],0,',','.') }}
</div>

<a href="/cart/hapus/{{ $id }}"
class="hapus">
Hapus
</a>

</div>

<div class="subtotal">
Rp {{ number_format($item['price'] * $item['qty'],0,',','.') }}
</div>

</div>

@empty

<p>Keranjang masih kosong</p>

@endforelse

<div class="total">
Total : Rp {{ number_format($total,0,',','.') }}
</div>

<a href="/produk" class="btn belanja">
🛍️ Lanjut Belanja
</a>

<a href="/checkout" class="btn checkout">
💳 Checkout
</a>

</div>

</body>
</html>
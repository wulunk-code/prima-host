<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Pembayaran QRIS</title>

<style>

body{
    background:#f4f4f4;
    font-family:Arial,sans-serif;
    padding:20px;
}

.card{
    max-width:500px;
    margin:auto;
    background:white;
    border-radius:20px;
    padding:25px;
    text-align:center;
    box-shadow:0 3px 10px rgba(0,0,0,.15);
}

h2{
    color:#00b140;
    margin-bottom:10px;
}

.jumlah{
    color:#00b140;
    font-size:32px;
    font-weight:bold;
    margin:20px 0;
}

.qris-img{
    width:280px;
    max-width:100%;
    border-radius:10px;
}

.info{
    margin-top:15px;
    color:#666;
    line-height:1.6;
}

.btn{
    display:block;
    margin-top:20px;
    background:#00b140;
    color:white;
    text-decoration:none;
    padding:15px;
    border-radius:10px;
    font-weight:bold;
}

</style>
</head>
<body>

<div class="card">

<h2>📱 Pembayaran QRIS</h2>

<p>Silakan scan QRIS berikut</p>

<div class="jumlah">
Rp {{ number_format($order->total,0,',','.') }}
</div>

<img
src="/images/qris_primahost.jpg"
class="qris-img">

<div class="info">
Setelah melakukan pembayaran,
admin akan memverifikasi transaksi Anda.
</div>

<a href="/" class="btn">
🏠 Kembali ke Beranda
</a>

</div>

</body>
</html>
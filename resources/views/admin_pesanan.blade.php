<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Admin Pesanan</title>

<style>

body{
    font-family:Arial,sans-serif;
    background:#f5f5f5;
    margin:0;
    padding:20px;
}

.header{
    background:#00b140;
    color:white;
    padding:15px;
    border-radius:10px;
    margin-bottom:20px;
}

.card{
    background:white;
    border-radius:10px;
    padding:15px;
    margin-bottom:15px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
}

.invoice{
    color:#00b140;
    font-weight:bold;
    font-size:18px;
}

.status{
    display:inline-block;
    padding:5px 10px;
    border-radius:20px;
    color:white;
    font-size:12px;
}

.pending{
    background:#ff9800;
}

.verifikasi{
    background:#9c27b0;
}

.diproses{
    background:#2196f3;
}

.dikirim{
    background:#00b140;
}

.selesai{
    background:#4caf50;
}

.btn{
    display:inline-block;
    padding:8px 12px;
    border-radius:5px;
    color:white;
    text-decoration:none;
    margin:3px;
    font-size:13px;
}

.detail{
    background:#2196f3;
}

.kirim{
    background:#00b140;
}

.selesai-btn{
    background:#4caf50;
}

.hapus{
    background:red;
}

.invoice-btn{
    background:#673ab7;
}

</style>

</head>
<body>

<div class="header">
<h2>📦 Daftar Pesanan</h2>
</div>

@foreach($orders as $order)

<div class="card">

<div class="invoice">
{{ $order->invoice }}
</div>

<p>
<b>{{ $order->customer_name }}</b>
</p>

<p>
📞 {{ $order->phone }}
</p>

<p>
💰 Rp {{ number_format($order->total,0,',','.') }}
</p>

<p>

@if($order->status=='pending')
<span class="status pending">
Pending
</span>

@elseif($order->status=='menunggu_verifikasi')
<span class="status verifikasi">
Menunggu Verifikasi
</span>

@elseif($order->status=='diproses')
<span class="status diproses">
Diproses
</span>

@elseif($order->status=='dikirim')
<span class="status dikirim">
Dikirim
</span>

@elseif($order->status=='selesai')
<span class="status selesai">
Selesai
</span>

@endif

</p>

<a
href="/admin/pesanan/{{ $order->id }}"
class="btn detail">
Detail
</a>

<a
href="/invoice/{{ $order->id }}"
class="btn invoice-btn">
Invoice
</a>

<a
href="/admin/pesanan/{{ $order->id }}/kirim"
class="btn kirim">
Kirim
</a>

<a
href="/admin/pesanan/{{ $order->id }}/selesai"
class="btn selesai-btn">
Selesai
</a>

<a
href="/admin/pesanan/{{ $order->id }}/hapus"
class="btn hapus"
onclick="return confirm('Hapus pesanan ini?')">
Hapus
</a>

</div>

@endforeach

</body>
</html>
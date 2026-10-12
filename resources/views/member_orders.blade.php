<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Pesanan Saya</title>

<style>

body{
    margin:0;
    padding:15px;
    background:#f5f5f5;
    font-family:Arial,sans-serif;
}

.header{
    background:#00b140;
    color:white;
    text-align:center;
    padding:18px;
    border-radius:15px;
    font-size:20px;
    font-weight:bold;
    margin-bottom:15px;
}

.card{
    background:white;
    border-radius:15px;
    padding:15px;
    margin-bottom:15px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

.order-title{
    font-size:18px;
    font-weight:bold;
    margin-bottom:10px;
}

.item{
    padding:10px 0;
    border-bottom:1px solid #eee;
}

.item:last-child{
    border-bottom:none;
}

.nama-produk{
    font-weight:bold;
}

.qty{
    color:#666;
    font-size:14px;
}

.subtotal{
    color:#00b140;
    font-weight:bold;
}

.total{
    color:#00b140;
    font-size:22px;
    font-weight:bold;
    margin-top:15px;
}

.pending{
    color:orange;
    font-weight:bold;
}

.proses{
    color:#2196f3;
    font-weight:bold;
}

.kirim{
    color:#9c27b0;
    font-weight:bold;
}

.selesai{
    color:green;
    font-weight:bold;
}

.back{
    display:block;
    text-align:center;
    background:#2196f3;
    color:white;
    text-decoration:none;
    padding:12px;
    border-radius:10px;
    margin-top:15px;
    font-weight:bold;
}

.info{
    margin-bottom:8px;
    color:#555;
}

.resi{
    background:#f8f8f8;
    padding:10px;
    border-radius:8px;
    margin-top:10px;
}

.bukti{
    margin-top:10px;
}

.bukti img{
    width:100%;
    max-width:250px;
    border-radius:10px;
    border:1px solid #ddd;
}

</style>
</head>
<body>

<div class="header">
📦 Pesanan Saya
</div>

@forelse($orders as $order)

<div class="card">

    <div class="order-title">
        Order #{{ $order->id }}
    </div>

    <div class="info">
        Nama :
        {{ $order->customer_name }}
    </div>

    <div class="info">
        Tanggal :
        {{ $order->created_at->format('d-m-Y H:i') }}
    </div>

    <div class="info">

        Status :

        @if($order->status=='pending')
            <span class="pending">
                Menunggu Verifikasi
            </span>

        @elseif($order->status=='diproses')
            <span class="proses">
                Sedang Diproses
            </span>

        @elseif($order->status=='dikirim')
            <span class="kirim">
                Sedang Dikirim
            </span>

        @elseif($order->status=='selesai')
            <span class="selesai">
                Selesai
            </span>
        @endif

    </div>

    @if($order->resi)

    <div class="resi">
        🚚 Resi Pengiriman :
        <b>{{ $order->resi }}</b>
    </div>

    @endif

    @if($order->bukti_transfer)

    <div class="bukti">

        <p>
            Bukti Transfer:
        </p>

        <img
        src="/bukti_transfer/{{ $order->bukti_transfer }}">

    </div>

    @endif

    <hr>

    <h4>Produk Dibeli</h4>

    @forelse($order->items as $item)

    <div class="item">

        <div class="nama-produk">
            {{ $item->product_name }}
        </div>

        <div class="qty">
            Qty : {{ $item->qty }}
        </div>

        <div class="subtotal">
            Rp {{ number_format($item->subtotal,0,',','.') }}
        </div>

    </div>

    @empty

    <div class="item">
        Detail produk tidak ditemukan
    </div>

    @endforelse

    <div class="total">
        Total :
        Rp {{ number_format($order->total,0,',','.') }}
    </div>

</div>

@empty

<div class="card">
    Belum ada pesanan.
</div>

@endforelse

<a href="/member/dashboard" class="back">
⬅ Kembali ke Dashboard
</a>

<a href="/invoice/{{ $order->id }}">
Lihat Invoice
</a>


</body>
</html>
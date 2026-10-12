<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Detail Pesanan</title>

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
    border-radius:10px;
    margin-bottom:15px;
    box-shadow:0 2px 8px rgba(0,0,0,.08);
}

h2{
    margin-top:0;
    color:#00b140;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th,
table td{
    border:1px solid #ddd;
    padding:10px;
}

table th{
    background:#f0f0f0;
}

.btn{
    display:inline-block;
    padding:10px 15px;
    border-radius:6px;
    color:white;
    text-decoration:none;
    margin:3px;
}

.approve{
    background:#00b140;
}

.reject{
    background:#e53935;
}

.invoice{
    background:#673ab7;
}

.kirim{
    background:#2196f3;
}

.wa{
    background:#25D366;
}

img{
    max-width:100%;
    border-radius:10px;
}

</style>

</head>
<body>

<div class="card">

<h2>Invoice {{ $order->invoice }}</h2>

<p>
<b>Nama :</b>
{{ $order->customer_name }}
</p>

<p>
<b>Telepon :</b>
{{ $order->phone }}
</p>

<p>
<b>Alamat :</b><br>
{{ $order->address }}
</p>

<p>
<b>Status :</b>
{{ strtoupper($order->status) }}
</p>

<p>
<b>Pembayaran :</b>
{{ strtoupper($order->payment_status) }}
</p>

<p>
<b>Total :</b>
Rp {{ number_format($order->total,0,',','.') }}
</p>

</div>

<div class="card">

<h3>Produk</h3>

<table>

<tr>
<th>Produk</th>
<th>Harga</th>
<th>Qty</th>
<th>Subtotal</th>
</tr>

@foreach($order->items as $item)

<tr>

<td>
{{ $item->product_name }}
</td>

<td>
Rp {{ number_format($item->price,0,',','.') }}
</td>

<td>
{{ $item->qty }}
</td>

<td>
Rp {{ number_format($item->subtotal,0,',','.') }}
</td>

</tr>

@endforeach

</table>

</div>

@if($order->bukti_transfer)

<div class="card">

<h3>Bukti Transfer</h3>

<img
src="{{ asset('bukti_transfer/'.$order->bukti_transfer) }}">

<p>
Pengirim :
{{ $order->sender_name }}
</p>

<p>
Bank :
{{ $order->bank }}
</p>

</div>

@endif

<div class="card">

<a
href="/admin/verifikasi/{{ $order->id }}/approve"
class="btn approve">
✔ Approve
</a>

<a
href="/admin/verifikasi/{{ $order->id }}/reject"
class="btn reject">
✖ Reject
</a>

<a
href="/invoice/{{ $order->id }}"
class="btn invoice">
🧾 Invoice
</a>

<a
href="/admin/pengiriman/{{ $order->id }}"
class="btn kirim">
🚚 Input Resi
</a>

<a
href="https://wa.me/{{ preg_replace('/[^0-9]/','',$order->phone) }}"
target="_blank"
class="btn wa">
💬 WhatsApp
</a>

</div>

</body>
</html>
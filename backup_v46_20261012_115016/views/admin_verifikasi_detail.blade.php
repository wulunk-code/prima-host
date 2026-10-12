<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Detail Verifikasi</title>

<style>

body{
font-family:Arial;
background:#f5f6fa;
padding:15px;
}

.card{
background:white;
padding:15px;
border-radius:10px;
box-shadow:0 2px 10px rgba(0,0,0,.1);
}

h2{
color:#00b140;
margin-bottom:15px;
}

table{
width:100%;
border-collapse:collapse;
margin-top:10px;
}

table td,
table th{
border:1px solid #ddd;
padding:8px;
}

img{
width:100%;
border-radius:10px;
margin-top:10px;
}

.btn{
display:inline-block;
padding:10px 15px;
border-radius:5px;
text-decoration:none;
color:white;
margin-top:15px;
}

.approve{
background:#00b140;
}

.reject{
background:red;
}

</style>

</head>
<body>

<div class="card">

<h2>Verifikasi Pembayaran</h2>

<p>
<b>Invoice :</b>
{{ $order->invoice }}
</p>

<p>
<b>Nama :</b>
{{ $order->customer_name }}
</p>

<p>
<b>Telepon :</b>
{{ $order->phone }}
</p>

<p>
<b>Alamat :</b>
{{ $order->address }}
</p>

<p>
<b>Pengirim :</b>
{{ $order->sender_name }}
</p>

<p>
<b>Bank :</b>
{{ $order->bank }}
</p>

<p>
<b>Total :</b>
Rp {{ number_format($order->total,0,',','.') }}
</p>

<h3>Produk</h3>

<table>

<tr>
<th>Produk</th>
<th>Qty</th>
<th>Harga</th>
<th>Subtotal</th>
</tr>

@foreach($order->items as $item)

<tr>
<td>{{ $item->product_name }}</td>
<td>{{ $item->qty }}</td>
<td>
Rp {{ number_format($item->price,0,',','.') }}
</td>
<td>
Rp {{ number_format($item->subtotal,0,',','.') }}
</td>
</tr>

@endforeach

</table>

<h3>Bukti Transfer</h3>

@if($order->bukti_transfer)

<img
src="{{ asset('bukti_transfer/'.$order->bukti_transfer) }}"
alt="Bukti Transfer">

@endif

<br>

<a
href="/admin/approve/{{ $order->id }}"
class="btn approve">
✅ Approve
</a>

<a
href="/admin/reject/{{ $order->id }}"
class="btn reject">
❌ Tolak
</a>

</div>

</body>
</html>
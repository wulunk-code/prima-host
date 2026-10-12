<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Invoice Pesanan</title>

<style>

body{
    font-family:Arial,sans-serif;
    background:#f5f5f5;
    padding:15px;
}

.invoice{
    max-width:900px;
    margin:auto;
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

.logo{
    text-align:center;
    margin-bottom:15px;
}

.logo img{
    width:120px;
}

.judul{
    text-align:center;
    font-size:28px;
    font-weight:bold;
    color:#00b140;
    margin-bottom:10px;
}

.invoice-no{
    text-align:center;
    color:#666;
    margin-bottom:25px;
}

.info{
    margin-bottom:25px;
}

.info p{
    margin:5px 0;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#00b140;
    color:white;
    padding:10px;
}

table td{
    padding:10px;
    border:1px solid #ddd;
}

.total{
    text-align:right;
    margin-top:20px;
    font-size:24px;
    font-weight:bold;
    color:#00b140;
}

.status{
    margin-top:20px;
    text-align:center;
}

.badge{
    display:inline-block;
    padding:10px 20px;
    border-radius:10px;
    color:white;
    font-weight:bold;
}

.pending{
    background:#ff9800;
}

.proses{
    background:#2196f3;
}

.kirim{
    background:#9c27b0;
}

.selesai{
    background:#00b140;
}

.transfer{
    margin-top:20px;
    background:#f8f8f8;
    padding:15px;
    border-radius:10px;
}

.btn{
    display:inline-block;
    margin-top:20px;
    background:#00b140;
    color:white;
    padding:12px 20px;
    text-decoration:none;
    border-radius:8px;
}

</style>

</head>
<body>

@php
$setting = \App\Models\Setting::first();
@endphp

<div class="invoice">

@if($setting && $setting->store_logo)

<div class="logo">
<img src="{{ asset('uploads/'.$setting->store_logo) }}">
</div>

@endif

<div class="judul">

{{ $setting->store_name ?? 'Prima Host' }}

</div>

<div class="invoice-no">

Invoice :
{{ $order->invoice ?? ('INV-'.$order->id) }}

</div>

<div class="info">

<p><b>Nama :</b> {{ $order->customer_name }}</p>

<p><b>Telepon :</b> {{ $order->phone }}</p>

<p><b>Alamat :</b> {{ $order->address }}</p>

<p><b>Tanggal :</b> {{ $order->created_at }}</p>

<p><b>Pembayaran :</b> {{ $order->payment_method }}</p>

</div>

<table>

<tr>
<th>Produk</th>
<th>Harga</th>
<th>Qty</th>
<th>Subtotal</th>
</tr>

@foreach($order->items as $item)

<tr>

<td>{{ $item->product_name }}</td>

<td>
Rp {{ number_format($item->price,0,',','.') }}
</td>

<td>{{ $item->qty }}</td>

<td>
Rp {{ number_format($item->subtotal,0,',','.') }}
</td>

</tr>

@endforeach

</table>

<div class="total">

Total :
Rp {{ number_format($order->total,0,',','.') }}

</div>

<div class="status">

@if($order->status=='pending')

<span class="badge pending">
Menunggu Pembayaran
</span>

@elseif($order->status=='diproses')

<span class="badge proses">
Sedang Diproses
</span>

@elseif($order->status=='dikirim')

<span class="badge kirim">
Sedang Dikirim
</span>

@elseif($order->status=='selesai')

<span class="badge selesai">
Pesanan Selesai
</span>

@endif

</div>

@if($setting)

<div class="transfer">

<h3>Informasi Pembayaran</h3>

<p>
<b>Bank :</b>
{{ $setting->bank_name }}
</p>

<p>
<b>No Rek :</b>
{{ $setting->bank_account }}
</p>

<p>
<b>Atas Nama :</b>
{{ $setting->bank_holder }}
</p>

@if($setting->qris_image)

<br>

<img
src="{{ asset('uploads/'.$setting->qris_image) }}"
style="width:220px;"
>

@endif

</div>

@endif

@if($order->bukti_transfer)

<div class="transfer">

<h3>Bukti Transfer</h3>

<img
src="{{ asset('bukti_transfer/'.$order->bukti_transfer) }}"
style="max-width:300px;"
>

</div>

@endif

<a href="/admin/pesanan" class="btn">
← Kembali
</a>

</div>

</body>
</html>
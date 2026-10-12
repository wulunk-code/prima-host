@extends('layouts.admin')

@section('content')

<div class="container-fluid">

<div class="card">

<div class="card-header">
Detail Pesanan
</div>

<div class="card-body">

<p>
<b>Invoice :</b>
{{ $order->invoice }}
</p>

<p>
<b>Nama :</b>
{{ $order->customer_name }}
</p>

<p>
<b>WhatsApp :</b>
{{ $order->phone }}
</p>

<p>
<b>Total :</b>
Rp {{ number_format($order->total,0,',','.') }}
</p>

<p>
<b>Status :</b>
{{ $order->status }}
</p>

@if($order->bukti_transfer)

<hr>

<h5>Bukti Transfer</h5>

<img
src="{{ asset($order->bukti_transfer) }}"
class="img-fluid rounded">

@endif

<hr>

<a href="{{ route('orders.verifikasi',$order->id) }}"
class="btn btn-success">

Verifikasi Pembayaran

</a>

<a href="{{ route('orders.kirim.form',$order->id) }}"
class="btn btn-primary">

Kirim Pesanan

</a>

<a href="{{ route('orders.selesai',$order->id) }}"
class="btn btn-dark">

Selesai

</a>

</div>
</div>
</div>

@endsection
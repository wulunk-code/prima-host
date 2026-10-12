@extends('layouts.app')

@section('content')

<h2 style="color:#00b140">
🛒 Keranjang Belanja
</h2>

@if(count($cart) > 0)

@php
$total = 0;
@endphp

@foreach($cart as $item)

@php
$subtotal = $item['price'] * $item['qty'];
$total += $subtotal;
@endphp

<div class="cart-item">

<img src="{{ asset($item['image']) }}">

<div class="info">

<h5>{{ $item['name'] }}</h5>

<div class="price">
Rp {{ number_format($item['price'],0,',','.') }}
</div>

<p>
Qty : {{ $item['qty'] }}
</p>

</div>

</div>

@endforeach

<div class="cart-footer">

<div>

<b>Total</b><br>

Rp {{ number_format($total,0,',','.') }}

</div>

<a href="{{ url('/checkout') }}"
class="checkout-btn">

Checkout

</a>

</div>

@else

<div class="alert alert-warning">

Keranjang masih kosong

</div>

@endif

@endsection
@extends('layouts.app')

@section('content')

<div class="cart-page">

<h2>🛒 Keranjang Belanja</h2>

@php
$total = 0;
@endphp

@foreach($cart as $id => $item)

@php
$subtotal = $item['price'] * $item['qty'];
$total += $subtotal;
@endphp

<div class="cart-item">

<img src="{{ asset($item['image']) }}">

<div class="info">
    <h4>{{ $item['name'] }}</h4>

    <div class="price">
        Rp {{ number_format($item['price'],0,',','.') }}
    </div>

    <form action="{{ route('cart.update',$id) }}" method="POST">
        @csrf

        <input
        type="number"
        name="qty"
        value="{{ $item['qty'] }}"
        min="1">

        <button>Simpan</button>
    </form>

    <small>
        Subtotal:
        Rp {{ number_format($subtotal,0,',','.') }}
    </small>

</div>

<a href="{{ route('cart.remove',$id) }}"
class="remove">
🗑
</a>

</div>

@endforeach

</div>

<div class="cart-footer">

<div class="total">
Total:
<strong>
Rp {{ number_format($total,0,',','.') }}
</strong>
</div>

<form action="{{ route('checkout') }}" method="POST">
@csrf
<button class="checkout-btn">
Checkout
</button>
</form>

</div>

@endsection
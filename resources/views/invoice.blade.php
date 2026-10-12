@extends('layouts.app')

@section('content')

<div class="card p-4">

    <h2 style="color:#00b140">
        📋 Invoice Pesanan
    </h2>

    <hr>

    <p>
        <b>Invoice :</b>
        {{ $order->invoice }}
    </p>

    <p>
        <b>Status :</b>

        @if($order->status=='Pending')
            <span class="badge bg-warning">Pending</span>

        @elseif($order->status=='Diproses')
            <span class="badge bg-info">Diproses</span>

        @elseif($order->status=='Dikirim')
            <span class="badge bg-primary">Dikirim</span>

        @elseif($order->status=='Selesai')
            <span class="badge bg-success">Selesai</span>

        @else
            <span class="badge bg-secondary">
                {{ $order->status }}
            </span>
        @endif
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

    <hr>

    <table class="table">
        <tr>
            <th>Produk</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>

        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->product->name ?? '-' }}</td>
            <td>{{ $item->qty }}</td>
            <td>
                Rp {{ number_format($item->subtotal,0,',','.') }}
            </td>
        </tr>
        @endforeach
    </table>

    <hr>

    <h3 style="color:#00b140">
        Total :
        Rp {{ number_format($order->total,0,',','.') }}
    </h3>

    @php
        $wa = preg_replace('/[^0-9]/','',$setting->store_phone ?? '');

        if(substr($wa,0,1)=='0'){
            $wa = '62'.substr($wa,1);
        }
    @endphp

    <div class="alert alert-warning">
        WA Admin : {{ $wa }}
    </div>

    <a href="https://wa.me/{{ $wa }}?text={{ urlencode('Halo Admin, saya sudah melakukan pembayaran Invoice '.$order->invoice) }}"
       class="btn btn-success w-100">
       Konfirmasi Pembayaran
    </a>

</div>

@endsection
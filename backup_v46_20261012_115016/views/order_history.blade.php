@extends('layouts.app')

@section('content')

<h2 style="color:#00b140">
📋 Riwayat Pesanan
</h2>

@forelse($orders as $order)

<div class="card p-3 mb-3">

<b>
{{ $order->invoice }}
</b>

<br>

{{ $order->customer_name }}

<br>

Rp {{ number_format($order->total,0,',','.') }}

<br>

Status :

<span style="color:#00b140">
@if($order->status=='Pending')
<span class="badge bg-warning">
Pending
</span>

@elseif($order->status=='Diproses')
<span class="badge bg-info">
Diproses
</span>

@elseif($order->status=='Dikirim')
<span class="badge bg-primary">
Dikirim
</span>

@elseif($order->status=='Selesai')
<span class="badge bg-success">
Selesai
</span>

@else
<span class="badge bg-secondary">
{{ $order->status }}
</span>
@endif

</span>

<br><br>

<a
href="/invoice/{{ $order->id }}"
class="btn btn-success">

Lihat Invoice

</a>

</div>

@empty

<div class="alert alert-warning">

Belum ada pesanan

</div>

@endforelse

@endsection
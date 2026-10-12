@extends('layouts.admin')

@section('content')

<div class="container-fluid">

<h4 class="mb-3">
📦 Data Pesanan
</h4>

<div class="card">

<div class="table-responsive">

<table class="table table-bordered">

<thead>

<tr>
<th>Invoice</th>
<th>Customer</th>
<th>Total</th>
<th>Status</th>
<th>Aksi</th>
</tr>

</thead>

<tbody>

@foreach($orders as $order)

<tr>

<td>{{ $order->invoice }}</td>

<td>{{ $order->customer_name }}</td>

<td>
Rp {{ number_format($order->total,0,',','.') }}
</td>

<td>

@if($order->status=='pending')
<span class="badge bg-warning">
Pending
</span>
@endif

@if($order->status=='menunggu_verifikasi')
<span class="badge bg-info">
Verifikasi
</span>
@endif

@if($order->status=='diproses')
<span class="badge bg-primary">
Diproses
</span>
@endif

@if($order->status=='dikirim')
<span class="badge bg-success">
Dikirim
</span>
@endif

@if($order->status=='selesai')
<span class="badge bg-dark">
Selesai
</span>
@endif

</td>

<td>

<a href="{{ route('orders.detail',$order->id) }}"
class="btn btn-sm btn-primary">
Detail
</a>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

@endsection
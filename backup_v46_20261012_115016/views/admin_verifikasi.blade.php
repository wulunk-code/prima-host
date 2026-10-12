<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Verifikasi Pembayaran</title>

<style>
body{
font-family:Arial;
background:#f5f5f5;
padding:20px;
}

table{
width:100%;
background:white;
border-collapse:collapse;
}

th,td{
padding:10px;
border:1px solid #ddd;
}

th{
background:#00b140;
color:white;
}

.btn{
padding:6px 10px;
background:#2196f3;
color:white;
text-decoration:none;
border-radius:5px;
}
</style>

</head>
<body>

<h2>Verifikasi Pembayaran</h2>

<table>

<tr>
<th>Invoice</th>
<th>Nama</th>
<th>Total</th>
<th>Status</th>
<th>Aksi</th>
</tr>

@foreach($orders as $order)

<tr>

<td>{{ $order->invoice }}</td>

<td>{{ $order->customer_name }}</td>

<td>
Rp {{ number_format($order->total,0,',','.') }}
</td>

<td>{{ $order->payment_status }}</td>

<td>

<a
href="/admin/verifikasi/{{ $order->id }}"
class="btn">
Detail
</a>

</td>

</tr>

@endforeach

</table>

</body>
</html>
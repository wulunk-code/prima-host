<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Input Pengiriman</title>

<style>

body{
    font-family:Arial,sans-serif;
    background:#f5f5f5;
    padding:20px;
}

.card{
    background:white;
    padding:20px;
    border-radius:12px;
    max-width:600px;
    margin:auto;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

input,select{
    width:100%;
    padding:12px;
    margin-top:5px;
    margin-bottom:15px;
    border:1px solid #ddd;
    border-radius:6px;
}

button{
    width:100%;
    background:#00b140;
    color:white;
    border:none;
    padding:14px;
    border-radius:8px;
    font-weight:bold;
}

.info{
    background:#f8f8f8;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
}

</style>

</head>
<body>

<div class="card">

<h2>🚚 Input Pengiriman</h2>

<div class="info">
<b>{{ $order->invoice }}</b><br>
{{ $order->customer_name }}<br>
Rp {{ number_format($order->total,0,',','.') }}
</div>

<form method="POST"
action="/admin/pengiriman/{{ $order->id }}">
@csrf

<label>Kurir</label>

<select name="kurir" required>
<option value="">Pilih Kurir</option>
<option>JNE</option>
<option>J&T</option>
<option>SiCepat</option>
<option>Anteraja</option>
<option>Ninja Express</option>
<option>Grab Express</option>
<option>GoSend</option>
</select>

<label>Nomor Resi</label>

<input
type="text"
name="resi"
required>

<button type="submit">
Simpan Pengiriman
</button>

</form>

</div>

</body>
</html>
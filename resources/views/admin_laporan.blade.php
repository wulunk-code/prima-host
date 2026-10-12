<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Laporan Penjualan</title>

<style>

body{
    background:#f5f5f5;
    font-family:Arial;
    padding:20px;
}

.grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:15px;
}

.card{
    background:white;
    padding:20px;
    border-radius:15px;
    text-align:center;
    box-shadow:0 2px 8px rgba(0,0,0,.1);
}

.nominal{
    font-size:28px;
    color:#00b140;
    font-weight:bold;
}

</style>

</head>
<body>

<h2>📊 Laporan Penjualan</h2>

<div class="grid">

<div class="card">
<h3>Omzet Hari Ini</h3>
<div class="nominal">
Rp {{ number_format($omzetHariIni,0,',','.') }}
</div>
</div>

<div class="card">
<h3>Omzet Bulan Ini</h3>
<div class="nominal">
Rp {{ number_format($omzetBulanIni,0,',','.') }}
</div>
</div>

<div class="card">
<h3>Total Pesanan</h3>
<div class="nominal">
{{ $totalOrder }}
</div>
</div>

<div class="card">
<h3>Pesanan Selesai</h3>
<div class="nominal">
{{ $orderSelesai }}
</div>
</div>

</div>

</body>
</html>
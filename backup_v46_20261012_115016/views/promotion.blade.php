<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Promo Prima Host</title>

<style>

body{
    font-family:Arial,sans-serif;
    background:#f2f2f2;
    margin:0;
    padding:20px;
}

.judul{
    background:#ff6600;
    color:white;
    text-align:center;
    padding:18px;
    border-radius:12px;
    font-size:28px;
    font-weight:bold;
    margin-bottom:20px;
}

.btn-tambah{
    display:inline-block;
    background:#2196f3;
    color:white;
    text-decoration:none;
    padding:12px 18px;
    border-radius:8px;
    margin-bottom:20px;
}

.card{
    background:white;
    border-radius:15px;
    padding:15px;
    margin-bottom:20px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

.card img{
    width:100%;
    height:250px;
    object-fit:cover;
    border-radius:10px;
    margin-top:10px;
}

.nama{
    font-size:22px;
    font-weight:bold;
    margin-bottom:10px;
}

.deskripsi{
    color:#555;
    margin-bottom:10px;
}

.tanggal{
    color:#777;
    font-size:14px;
    margin-bottom:15px;
}

.btn{
    display:inline-block;
    text-decoration:none;
    color:white;
    padding:10px 15px;
    border-radius:8px;
}

.edit{
    background:#2196f3;
}

.hapus{
    background:#f44336;
}

.kosong{
    text-align:center;
    padding:40px;
    background:white;
    border-radius:15px;
}

</style>
</head>
<body>

<div class="judul">
🎁 Promo Prima Host
</div>

<a href="/admin/promotion/create" class="btn-tambah">
+ Tambah Promo
</a>

@if(count($promotions) > 0)

@foreach($promotions as $promo)

<div class="card">

<div class="nama">
{{ $promo->title }}
</div>

<div class="deskripsi">
{{ $promo->description }}
</div>

@if($promo->start_date || $promo->end_date)

<div class="tanggal">
📅
{{ $promo->start_date }}
s/d
{{ $promo->end_date }}
</div>

@endif

@if($promo->image)

<img
src="{{ asset('uploads/'.$promo->image) }}"
alt="{{ $promo->title }}">

@endif

<br><br>

<a
href="/admin/promotion/edit/{{ $promo->id }}"
class="btn edit">
✏ Edit
</a>

<a
href="/admin/promotion/hapus/{{ $promo->id }}"
class="btn hapus"
onclick="return confirm('Hapus promo ini?')">
🗑 Hapus
</a>

</div>

@endforeach

@else

<div class="kosong">
Belum ada promo.
</div>

@endif

</body>
</html>
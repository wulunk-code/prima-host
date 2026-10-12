<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Promo Prima Host</title>

<style>

body{
    margin:0;
    background:#f4f4f4;
    font-family:Arial,sans-serif;
}

.container{
    max-width:1000px;
    margin:auto;
    padding:15px;
}

.judul{
    background:#ff6600;
    color:white;
    text-align:center;
    padding:12px;
    border-radius:10px;
    font-size:28px;
    font-weight:bold;
    margin-bottom:15px;
}

.btn-tambah{
    display:inline-block;
    background:#0099ff;
    color:white;
    text-decoration:none;
    padding:10px 18px;
    border-radius:6px;
    margin-bottom:15px;
}

.card{
    background:white;
    border-radius:12px;
    padding:15px;
    margin-bottom:15px;
    box-shadow:0 2px 8px rgba(0,0,0,.1);
}

.card h3{
    margin:0;
    margin-bottom:8px;
}

.card p{
    margin-top:0;
    color:#666;
}

.gambar{
    width:100%;
    border-radius:10px;
    overflow:hidden;
    margin-top:10px;
    margin-bottom:10px;
}

.gambar img{
    width:100%;
    height:auto;
    display:block;
}

.btn-edit{
    display:inline-block;
    background:#0099ff;
    color:white;
    text-decoration:none;
    padding:8px 14px;
    border-radius:6px;
}

.btn-hapus{
    display:inline-block;
    background:red;
    color:white;
    text-decoration:none;
    padding:8px 14px;
    border-radius:6px;
}

.kosong{
    background:white;
    padding:30px;
    text-align:center;
    border-radius:10px;
}

</style>
</head>
<body>

<div class="container">

<div class="judul">
🎁 Promo Prima Host
</div>

<a href="/admin/promotion/create" class="btn-tambah">
+ Tambah Promo
</a>

@if($promotions->count())

@foreach($promotions as $promo)

<div class="card">

<h3>{{ $promo->title }}</h3>

<p>{{ $promo->description }}</p>

@if($promo->image)

<div class="gambar">

<img
src="{{ asset('uploads/'.$promo->image) }}"
alt="{{ $promo->title }}">

</div>

@endif

<a
href="/admin/promotion/edit/{{ $promo->id }}"
class="btn-edit">
✏ Edit
</a>

<a
href="/admin/promotion/hapus/{{ $promo->id }}"
class="btn-hapus"
onclick="return confirm('Hapus promo ini?')">
🗑 Hapus
</a>

</div>

@endforeach

@else

<div class="kosong">
Belum ada promo
</div>

@endif

</div>

</body>
</html>
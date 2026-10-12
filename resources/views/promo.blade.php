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
    font-family:Arial;
}

.header{
    background:#ff6600;
    color:white;
    text-align:center;
    padding:15px;
    font-size:24px;
    font-weight:bold;
}

.card{
    background:white;
    margin:15px;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

.card img{
    width:100%;
    display:block;
}

.body{
    padding:15px;
}

.judul{
    font-size:20px;
    font-weight:bold;
    margin-bottom:10px;
}

.deskripsi{
    color:#555;
}

</style>
</head>
<body>

<div class="header">
🎁 Promo Prima Host
</div>

@foreach($promotions as $promo)

<div class="card">

@if($promo->image)

<img
src="{{ asset('uploads/'.$promo->image) }}">

@endif

<div class="body">

<div class="judul">
{{ $promo->title }}
</div>

<div class="deskripsi">
{{ $promo->description }}
</div>

</div>

</div>

@endforeach

</body>
</html>
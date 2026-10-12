<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Data Banner</title>

<style>

body{
    font-family:Arial,sans-serif;
    background:#f4f4f4;
    padding:15px;
}

.header{
    background:#00b140;
    color:white;
    padding:15px;
    border-radius:15px;
    text-align:center;
    font-size:24px;
    font-weight:bold;
}

.btn{
    display:inline-block;
    margin:15px 0;
    background:#2196F3;
    color:white;
    text-decoration:none;
    padding:12px 15px;
    border-radius:10px;
}

.card{
    background:white;
    border-radius:15px;
    padding:15px;
    margin-bottom:15px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

img{
    width:100%;
    max-width:300px;
    border-radius:10px;
}

.edit{
    background:orange;
    color:white;
    padding:8px 12px;
    text-decoration:none;
    border-radius:8px;
}

.hapus{
    background:red;
    color:white;
    padding:8px 12px;
    text-decoration:none;
    border-radius:8px;
}

</style>
</head>
<body>

<div class="header">
🖼 Banner Prima Host
</div>

<a href="/admin/banner/create" class="btn">
+ Tambah Banner
</a>

@foreach($banners as $banner)

<div class="card">

<h3>{{ $banner->title }}</h3>

@if($banner->image)
<img src="/uploads/{{ $banner->image }}">
@endif

<br><br>

<a
href="/admin/banner/edit/{{ $banner->id }}"
class="edit">
Edit
</a>

<a
href="/admin/banner/hapus/{{ $banner->id }}"
class="hapus">
Hapus
</a>

</div>

@endforeach

</body>
</html>
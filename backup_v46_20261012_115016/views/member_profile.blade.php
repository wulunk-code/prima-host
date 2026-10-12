<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Profil Saya</title>

<style>

body{
    margin:0;
    padding:15px;
    background:#f5f5f5;
    font-family:Arial,sans-serif;
}

.header{
    background:#00b140;
    color:white;
    text-align:center;
    padding:18px;
    border-radius:15px;
    font-size:20px;
    font-weight:bold;
    margin-bottom:15px;
}

.card{
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

input, textarea{
    width:100%;
    padding:12px;
    margin-bottom:12px;
    border:1px solid #ddd;
    border-radius:8px;
    box-sizing:border-box;
}

.btn{
    width:100%;
    border:none;
    background:#00b140;
    color:white;
    padding:14px;
    border-radius:10px;
    font-weight:bold;
}

.back{
    display:block;
    margin-top:15px;
    text-align:center;
    text-decoration:none;
    background:#2196f3;
    color:white;
    padding:12px;
    border-radius:10px;
}

.success{
    background:#d4edda;
    color:#155724;
    padding:10px;
    border-radius:8px;
    margin-bottom:10px;
}

</style>
</head>
<body>

<div class="header">
⚙️ Profil Saya
</div>

<div class="card">

@if(session('success'))
<div class="success">
{{ session('success') }}
</div>
@endif

<form method="POST" action="/member/profile">
@csrf

<input
type="text"
name="name"
value="{{ $member->name }}"
placeholder="Nama">

<input
type="text"
name="phone"
value="{{ $member->phone }}"
placeholder="Nomor WhatsApp">

<input
type="email"
name="email"
value="{{ $member->email }}"
placeholder="Email">

<textarea
name="address"
placeholder="Alamat">{{ $member->address }}</textarea>

<input
type="password"
name="password"
placeholder="Password Baru (kosongkan jika tidak ganti)">

<button type="submit" class="btn">
Simpan Perubahan
</button>

</form>

<a href="/member/dashboard" class="back">
⬅ Kembali ke Dashboard
</a>

</div>

</body>
</html>
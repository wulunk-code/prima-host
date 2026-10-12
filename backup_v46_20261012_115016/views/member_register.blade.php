<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Daftar Member Prima Host</title>

<style>

body{
    background:#f4f4f4;
    font-family:Arial, sans-serif;
    padding:20px;
}

.card{
    background:#fff;
    max-width:600px;
    margin:auto;
    padding:20px;
    border-radius:15px;
    box-shadow:0 0 10px rgba(0,0,0,.1);
}

h2{
    text-align:center;
    color:#00b140;
    margin-bottom:25px;
}

label{
    display:block;
    margin-bottom:6px;
    font-weight:bold;
    color:#555;
}

input,
textarea{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border:1px solid #ddd;
    border-radius:8px;
    box-sizing:border-box;
}

button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:10px;
    background:#00b140;
    color:white;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#009933;
}

.login{
    text-align:center;
    margin-top:15px;
}

a{
    text-decoration:none;
    color:#ff6600;
    font-weight:bold;
}

.error{
    background:#ffe5e5;
    color:red;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
}

.success{
    background:#e8fff0;
    color:green;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
}

</style>
</head>

<body>

<div class="card">

<h2>Daftar Member Prima Host</h2>

@if($errors->any())
<div class="error">
{{ $errors->first() }}
</div>
@endif

@if(session('success'))
<div class="success">
{{ session('success') }}
</div>
@endif

<form action="/member/register" method="POST">

@csrf

<label>Nama Lengkap</label>
<input
type="text"
name="name"
placeholder="Masukkan nama lengkap"
required>

<label>Email</label>
<input
type="email"
name="email"
placeholder="Masukkan email">

<label>Nomor WhatsApp</label>
<input
type="text"
name="phone"
placeholder="08xxxxxxxxxx"
required>

<label>Alamat Lengkap</label>
<textarea
name="address"
placeholder="Masukkan alamat lengkap"></textarea>

<label>Tanggal Lahir</label>
<input
type="date"
name="birth_date">

<label>Password</label>
<input
type="password"
name="password"
placeholder="Masukkan password"
required>

<button type="submit">
Daftar Sekarang
</button>

</form>

<div class="login">
Sudah punya akun?
<a href="/member/login">
Login Member
</a>
</div>

</div>

</body>
</html>
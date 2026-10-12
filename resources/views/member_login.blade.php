<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Login Member Prima Host</title>

<style>

body{
    font-family:Arial,sans-serif;
    background:#f4f4f4;
    padding:20px;
}

.card{
    max-width:500px;
    margin:auto;
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

h2{
    text-align:center;
    color:#00b140;
    margin-bottom:25px;
}

input{
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
    background:#00b140;
    color:white;
    font-size:16px;
    border-radius:8px;
    cursor:pointer;
}

button:hover{
    background:#009933;
}

.register{
    text-align:center;
    margin-top:15px;
}

.register a{
    color:#ff6600;
    text-decoration:none;
    font-weight:bold;
}

.alert{
    background:#ffebee;
    color:#c62828;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
}

.success{
    background:#e8f5e9;
    color:#2e7d32;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
}

</style>
</head>

<body>

<div class="card">

<h2>Login Member</h2>

@if(session('success'))
<div class="success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert">
    {{ session('error') }}
</div>
@endif

<form action="/member/login" method="POST">

@csrf

<input
type="text"
name="phone"
placeholder="Nomor WhatsApp"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<button type="submit">
Login
</button>

</form>

<div class="register">
Belum punya akun?
<a href="/member/register">
Daftar Member
</a>
</div>

</div>

</body>
</html>
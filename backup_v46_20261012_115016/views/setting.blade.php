<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Pengaturan Toko</title>

<style>

body{
    background:#f5f5f5;
    font-family:Arial,sans-serif;
    padding:20px;
}

.card{
    background:white;
    padding:20px;
    border-radius:15px;
    max-width:800px;
    margin:auto;
    box-shadow:0 2px 10px rgba(0,0,0,.1);
}

h2{
    color:#00b140;
    margin-bottom:20px;
}

label{
    display:block;
    margin-top:15px;
    margin-bottom:5px;
    font-weight:bold;
}

input,
textarea{
    width:100%;
    padding:12px;
    border:1px solid #ddd;
    border-radius:8px;
    box-sizing:border-box;
}

img{
    max-width:150px;
    margin-top:10px;
    border-radius:10px;
    border:1px solid #ddd;
}

button{
    background:#00b140;
    color:white;
    border:none;
    padding:15px;
    width:100%;
    margin-top:20px;
    border-radius:8px;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    opacity:.9;
}

.success{
    background:#d4edda;
    color:#155724;
    padding:12px;
    border-radius:8px;
    margin-bottom:15px;
}

.error{
    background:#f8d7da;
    color:#721c24;
    padding:12px;
    border-radius:8px;
    margin-bottom:15px;
}

</style>
</head>
<body>

<div class="card">

<h2>⚙️ Pengaturan Toko</h2>

@if(session('success'))
<div class="success">
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="error">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<form method="POST"
action="{{ route('settings.update') }}"
enctype="multipart/form-data">

@csrf

<label>Nama Toko</label>
<input
type="text"
name="store_name"
value="{{ $setting->store_name ?? '' }}">

<label>WhatsApp Admin</label>
<input
type="text"
name="store_phone"
value="{{ $setting->store_phone ?? '' }}">

<label>Alamat Toko</label>
<textarea
name="store_address"
rows="4">{{ $setting->store_address ?? '' }}</textarea>

<label>Nama Bank</label>
<input
type="text"
name="bank_name"
value="{{ $setting->bank_name ?? '' }}">

<label>Nomor Rekening</label>
<input
type="text"
name="bank_account"
value="{{ $setting->bank_account ?? '' }}">

<label>Atas Nama Rekening</label>
<input
type="text"
name="bank_holder"
value="{{ $setting->bank_holder ?? '' }}">

<label>Ongkir Default</label>
<input
type="number"
name="shipping_cost"
value="{{ $setting->shipping_cost ?? 5000 }}">

<label>Radius Gratis Ongkir (KM)</label>
<input
type="number"
name="free_shipping_radius"
value="{{ $setting->free_shipping_radius ?? 5 }}">

<label>Logo Toko</label>
<input
type="file"
name="store_logo">

@if(!empty($setting->store_logo))
<br>
<img src="{{ asset($setting->store_logo) }}">
@endif

<label>QRIS Pembayaran</label>
<input
type="file"
name="qris_image">

@if(!empty($setting->qris_image))
<br>
<img src="{{ asset($setting->qris_image) }}">
@endif

<button type="submit">
💾 Simpan Pengaturan
</button>

</form>

</div>

</body>
</html>
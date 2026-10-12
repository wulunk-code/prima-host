@extends('layouts.app')

@section('content')

<div class="card">

<div class="card-header bg-success text-white">

Tambah Member

</div>

<div class="card-body">

<form method="POST"
action="/admin/member/store">

@csrf

<div class="mb-3">
<label>Nama</label>
<input type="text"
name="name"
class="form-control">
</div>

<div class="mb-3">
<label>WhatsApp</label>
<input type="text"
name="phone"
class="form-control">
</div>

<div class="mb-3">
<label>Email</label>
<input type="email"
name="email"
class="form-control">
</div>

<div class="mb-3">
<label>Password</label>
<input type="password"
name="password"
class="form-control">
</div>

<div class="mb-3">
<label>Level</label>

<select name="level"
class="form-control">

<option value="member">
Member
</option>

<option value="reseller">
Reseller
</option>

<option value="admin">
Admin
</option>

</select>

</div>

<button class="btn btn-success">

Simpan

</button>

</form>

</div>
</div>

@endsection
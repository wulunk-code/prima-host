@extends('layouts.app')

@section('content')

<div class="card">

<div class="card-header">

Tambah Banner Promo

</div>

<div class="card-body">

<form
method="POST"
action="/admin/promotions/store"
enctype="multipart/form-data">

@csrf

<input
type="text"
name="title"
class="form-control mb-3"
placeholder="Judul Promo">

<input
type="text"
name="link"
class="form-control mb-3"
placeholder="Link Promo">

<input
type="file"
name="image"
class="form-control mb-3">

<button
class="btn btn-success">

Simpan Banner

</button>

</form>

</div>

</div>

@endsection
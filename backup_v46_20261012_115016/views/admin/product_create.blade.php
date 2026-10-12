@extends('layouts.app')

@section('content')

<div class="card">

<div class="card-header bg-success text-white">

Tambah Produk

</div>

<div class="card-body">

<form
method="POST"
action="/admin/products/store"
enctype="multipart/form-data">

@csrf

<input
type="text"
name="name"
class="form-control mb-3"
placeholder="Nama Produk">

<textarea
name="description"
class="form-control mb-3"
placeholder="Deskripsi"></textarea>

<input
type="number"
name="price"
class="form-control mb-3"
placeholder="Harga">

<input
type="number"
name="stock"
class="form-control mb-3"
placeholder="Stok">

<input
type="file"
name="image"
class="form-control mb-3">

<button
class="btn btn-success">

Simpan

</button>

</form>

</div>

</div>

@endsection
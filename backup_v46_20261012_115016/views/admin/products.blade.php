@extends('layouts.app')

@section('content')

<div class="card">

<div class="card-header bg-success text-white">

📦 Produk

<a href="/admin/products/create"
class="btn btn-light btn-sm float-end">

+ Tambah Produk

</a>

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>

<th>ID</th>
<th>Gambar</th>
<th>Nama</th>
<th>Harga</th>
<th>Stok</th>
<th>Aksi</th>

</tr>

@foreach($products as $product)

<tr>

<td>{{ $product->id }}</td>

<td>

@if($product->image)

<img
src="{{ asset('storage/'.$product->image) }}"
width="60">

@endif

</td>

<td>{{ $product->name }}</td>

<td>
Rp {{ number_format($product->price) }}
</td>

<td>{{ $product->stock }}</td>

<td>

<a
href="/admin/products/edit/{{ $product->id }}"
class="btn btn-primary btn-sm">

Edit

</a>

<a
href="/admin/products/delete/{{ $product->id }}"
class="btn btn-danger btn-sm"
onclick="return confirm('Hapus produk?')">

Hapus

</a>

</td>

</tr>

@endforeach

</table>

{{ $products->links() }}

</div>

</div>

@endsection
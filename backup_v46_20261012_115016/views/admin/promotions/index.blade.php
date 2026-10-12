@extends('layouts.app')

@section('content')

<div class="card">

<div class="card-header">

Banner Promo

<a
href="/admin/promotions/create"
class="btn btn-success btn-sm float-end">

Tambah

</a>

</div>

<div class="card-body">

<table class="table table-bordered">

<tr>
<th>Banner</th>
<th>Judul</th>
<th>Aksi</th>
</tr>

@foreach($promotions as $promo)

<tr>

<td width="200">

@if($promo->image)

<img
src="{{ asset('uploads/'.$promo->image) }}"
width="180">

@endif

</td>

<td>

{{ $promo->title }}

</td>

<td>

<a
href="/admin/promotions/delete/{{ $promo->id }}"
class="btn btn-danger">

Hapus

</a>

</td>

</tr>

@endforeach

</table>

</div>

</div>

@endsection
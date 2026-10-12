@extends('layouts.app')

@section('content')

<div class="card">

<div class="card-header">

Member Area

</div>

<div class="card-body">

<h4>

Selamat Datang
{{ auth()->user()->name }}

</h4>

<hr>

<a
href="/member/orders"
class="btn btn-success">

Pesanan Saya

</a>

<a
href="/member/profile"
class="btn btn-primary">

Profil

</a>

</div>

</div>

@endsection
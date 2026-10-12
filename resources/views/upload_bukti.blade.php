@extends('layouts.app')

@section('content')

<div class="container">

<div class="card">

<div class="card-header">
Upload Bukti Transfer
</div>

<div class="card-body">

<form
method="POST"
enctype="multipart/form-data"
action="/upload-bukti/{{ $order->id }}">

@csrf

<div class="mb-3">

<label>Nama Pengirim</label>

<input
type="text"
name="sender_name"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Bank Pengirim</label>

<input
type="text"
name="bank"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Bukti Transfer</label>

<input
type="file"
name="bukti_transfer"
class="form-control"
required>

</div>

<button
class="btn btn-success">

Upload

</button>

</form>

</div>

</div>

</div>

@endsection
@extends('layouts.app')

@section('content')

<div class="card">

<div class="card-header">

Tambah Voucher

</div>

<div class="card-body">

<form
method="POST"
action="/admin/vouchers/store">

@csrf

<input
type="text"
name="code"
class="form-control mb-3"
placeholder="KODEPROMO">

<input
type="number"
name="discount"
class="form-control mb-3"
placeholder="Diskon Rupiah">

<input
type="date"
name="expired_at"
class="form-control mb-3">

<button
class="btn btn-success">

Simpan Voucher

</button>

</form>

</div>

</div>

@endsection
@extends('layouts.app')

@section('content')

<div class="card">

<div class="card-header bg-success text-white">

👥 Data Member

<a href="/admin/member/tambah"
class="btn btn-light btn-sm float-end">

+ Tambah

</a>

</div>

<div class="card-body table-responsive">

<table class="table table-bordered">

<tr>
<th>ID</th>
<th>Nama</th>
<th>HP</th>
<th>Level</th>
<th>Saldo</th>
<th>Aksi</th>
</tr>

@foreach($members as $m)

<tr>

<td>{{ $m->id }}</td>

<td>{{ $m->name }}</td>

<td>{{ $m->phone }}</td>

<td>

@if($m->level=='admin')

<span class="badge bg-danger">
Admin
</span>

@elseif($m->level=='reseller')

<span class="badge bg-primary">
Reseller
</span>

@else

<span class="badge bg-success">
Member
</span>

@endif

</td>

<td>
Rp {{ number_format($m->saldo) }}
</td>

<td>

<a href="/admin/member/hapus/{{ $m->id }}"
class="btn btn-danger btn-sm">

Hapus

</a>

</td>

</tr>

@endforeach

</table>

</div>
</div>

@endsection
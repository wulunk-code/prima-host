@extends('layouts.app')

@section('content')

<div class="container">

    <h3>➕ Tambah Kategori</h3>

    <form action="{{ route('categories.store') }}"
          method="POST">

        @csrf

        <div class="mb-3">

            <label>Nama Kategori</label>

            <input
                type="text"
                name="name"
                class="form-control"
                required>

        </div>

        <div class="mb-3">

            <label>Deskripsi</label>

            <textarea
                name="description"
                class="form-control"
                rows="4"></textarea>

        </div>

        <button
            type="submit"
            class="btn btn-success">

            Simpan Kategori

        </button>

        <a href="{{ route('categories.index') }}"
           class="btn btn-secondary">

           Kembali

        </a>

    </form>

</div>

@endsection
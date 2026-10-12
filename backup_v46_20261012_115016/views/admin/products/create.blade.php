@extends('layouts.app')

@section('content')

<div class="container">

    <h3>📦 Tambah Produk</h3>

    <form
        action="{{ route('products.store') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        <div class="mb-3">
            <label>Kategori</label>

            <select
                name="category_id"
                class="form-control">

                <option value="">
                    Pilih Kategori
                </option>

                @foreach($categories as $category)

                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>

                @endforeach

            </select>
        </div>

        <div class="mb-3">
            <label>Nama Produk</label>

            <input
                type="text"
                name="name"
                class="form-control"
                required>
        </div>

        <div class="mb-3">
            <label>Slug</label>

            <input
                type="text"
                name="slug"
                class="form-control">
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>

            <textarea
                name="description"
                rows="4"
                class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Harga</label>

            <input
                type="number"
                name="price"
                class="form-control"
                value="0">
        </div>

        <div class="mb-3">
            <label>Stok</label>

            <input
                type="number"
                name="stock"
                class="form-control"
                value="0">
        </div>

        <div class="mb-3">
            <label>Berat (gram)</label>

            <input
                type="number"
                name="weight"
                class="form-control"
                value="0">
        </div>

        <div class="mb-3">
            <label>Foto Produk</label>

            <input
                type="file"
                name="image"
                class="form-control">
        </div>

        <div class="mb-3">

            <label>

                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    checked>

                Produk Aktif

            </label>

        </div>

        <button
            type="submit"
            class="btn btn-success">

            Simpan Produk

        </button>

    </form>

</div>

@endsection
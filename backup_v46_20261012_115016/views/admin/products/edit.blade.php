@extends('layouts.app')

@section('content')

<div class="container">

    <h3>✏ Edit Produk</h3>

    <form
        action="{{ route('products.update',$product->id) }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf

        <div class="mb-3">

            <label>Kategori</label>

            <select name="category_id" class="form-control">

    <option value="">
        Pilih Kategori
    </option>

    @foreach($categories as $category)

        <option
            value="{{ $category->id }}"
            {{ $product->category_id == $category->id ? 'selected' : '' }}>
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
                value="{{ $product->name }}"
                class="form-control">

        </div>

        <div class="mb-3">

            <label>Slug</label>

            <input
                type="text"
                name="slug"
                value="{{ $product->slug }}"
                class="form-control">

        </div>

        <div class="mb-3">

            <label>Deskripsi</label>

            <textarea
                name="description"
                rows="4"
                class="form-control">{{ $product->description }}</textarea>

        </div>

        <div class="mb-3">

            <label>Harga</label>

            <input
                type="number"
                name="price"
                value="{{ $product->price }}"
                class="form-control">

        </div>

        <div class="mb-3">

            <label>Stok</label>

            <input
                type="number"
                name="stock"
                value="{{ $product->stock }}"
                class="form-control">

        </div>

        <div class="mb-3">

            <label>Berat</label>

            <input
                type="number"
                name="weight"
                value="{{ $product->weight }}"
                class="form-control">

        </div>

        @if($product->image)

        <div class="mb-3">

            <img
                src="{{ asset($product->image) }}"
                width="120">

        </div>

        @endif

        <div class="mb-3">

            <label>Ganti Foto</label>

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
                    {{ $product->is_active ? 'checked' : '' }}>

                Produk Aktif

            </label>

        </div>

        <button
            type="submit"
            class="btn btn-primary">

            Update Produk

        </button>

    </form>

</div>

@endsection
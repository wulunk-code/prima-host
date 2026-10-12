@extends('layouts.app')

@section('content')

<div class="container">

    <h3>📦 Data Produk</h3>

    <a href="{{ route('products.create') }}"
       class="btn btn-success mb-3">

       + Tambah Produk

    </a>

    <table class="table table-bordered">

        <thead>

        <tr>

            <th>ID</th>
            <th>Foto</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>

        </tr>

        </thead>

        <tbody>

        @foreach($products as $product)

        <tr>

            <td>{{ $product->id }}</td>

            <td width="80">

                @if($product->image)

                    <img
                        src="{{ asset($product->image) }}"
                        width="60">

                @endif

            </td>

            <td>{{ $product->name }}</td>

            <td>

                {{ $product->category->name ?? '-' }}

            </td>

            <td>

                Rp {{ number_format($product->price,0,',','.') }}

            </td>

            <td>{{ $product->stock }}</td>

            <td>

                <a href="{{ route('products.edit',$product->id) }}"
                   class="btn btn-warning btn-sm">

                    Edit

                </a>

                <a href="{{ route('products.delete',$product->id) }}"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Hapus produk?')">

                    Hapus

                </a>

            </td>

        </tr>

        @endforeach

        </tbody>

    </table>

    {{ $products->links() }}

</div>

@endsection
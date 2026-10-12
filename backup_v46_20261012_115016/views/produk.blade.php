@extends('layouts.app')

@section('content')

<style>
.product-card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, .10);
    transition: .2s;
    height: 100%;
    background: #fff;
}

.product-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(0, 0, 0, .15);
}

.product-image-link {
    display: block;
    overflow: hidden;
    background: #f5f5f5;
}

.product-img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    display: block;
}

.product-body {
    padding: 10px;
}

.product-name {
    font-size: 15px;
    font-weight: 600;
    min-height: 40px;
    color: #222;
    overflow-wrap: anywhere;
}

.product-category {
    color: #777;
    font-size: 12px;
    margin-top: 5px;
    margin-bottom: 5px;
}

.product-price {
    font-size: 19px;
    font-weight: bold;
    color: #00b140;
    margin-top: 5px;
    margin-bottom: 8px;
}

.btn-detail {
    background: #0d6efd;
    color: #fff;
    border: none;
}

.btn-detail:hover {
    background: #0b5ed7;
    color: #fff;
}

.btn-order {
    background: #ff9800;
    color: #fff;
    border: none;
}

.btn-order:hover {
    background: #ed8900;
    color: #fff;
}

.btn-detail,
.btn-order {
    width: 100%;
    margin-top: 5px;
    padding: 7px 5px;
    border-radius: 6px;
}

.product-order-form {
    margin: 0;
}

.empty-box {
    text-align: center;
    padding: 50px 20px;
}

.product-heading {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 20px;
}

@media (max-width: 576px) {
    .product-img {
        height: 145px;
    }

    .product-heading {
        font-size: 20px;
    }

    .product-name {
        font-size: 14px;
    }

    .product-price {
        font-size: 17px;
    }
}
</style>

<div class="container py-3">

    {{-- JUDUL HALAMAN --}}

    <h2 class="product-heading">
        🛒 Produk Prima House
    </h2>

    {{-- PESAN SUKSES --}}

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Tutup">
            </button>
        </div>
    @endif

    {{-- PESAN ERROR --}}

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- VALIDASI ERROR --}}

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali:</strong>

            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- DAFTAR PRODUK --}}

    <div class="row">

        @forelse($products as $product)

            <div class="col-6 col-md-4 col-lg-3 mb-3">

                <div class="card product-card">

                    {{-- FOTO PRODUK --}}

                    <a
                        href="{{ route('product.show', $product->id) }}"
                        class="product-image-link"
                    >

                        @if(!empty($product->image))

                            @if(file_exists(public_path('uploads/products/' . $product->image)))

                                <img
                                    src="{{ asset('uploads/products/' . $product->image) }}"
                                    class="product-img"
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                >

                            @elseif(file_exists(public_path($product->image)))

                                <img
                                    src="{{ asset($product->image) }}"
                                    class="product-img"
                                    alt="{{ $product->name }}"
                                    loading="lazy"
                                >

                            @else

                                <img
                                    src="{{ asset('images/no-image.png') }}"
                                    class="product-img"
                                    alt="Foto produk tidak tersedia"
                                    loading="lazy"
                                >

                            @endif

                        @else

                            <img
                                src="{{ asset('images/no-image.png') }}"
                                class="product-img"
                                alt="Foto produk tidak tersedia"
                                loading="lazy"
                            >

                        @endif

                    </a>

                    {{-- INFORMASI PRODUK --}}

                    <div class="product-body">

                        <div class="product-name">
                            {{ $product->name }}
                        </div>

                        <div class="product-category">
                            📂
                            {{ $product->category->name ?? '-' }}
                        </div>

                        <div class="product-price">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>

                        {{-- TOMBOL DETAIL --}}

                        <a
                            href="{{ route('product.show', $product->id) }}"
                            class="btn btn-detail btn-sm"
                        >
                            Detail
                        </a>

                        {{-- TOMBOL PESAN SEKARANG --}}
                        {{-- WAJIB POST, BUKAN GET --}}

                        <form
                            action="{{ route('cart.add', $product->id) }}"
                            method="POST"
                            class="product-order-form"
                        >

                            @csrf

                            <input
                                type="hidden"
                                name="qty"
                                value="1"
                            >

                            <button
                                type="submit"
                                class="btn btn-order btn-sm"
                            >
                                🛒 Pesan Sekarang
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        @empty

            <div class="col-12">

                <div class="alert alert-warning empty-box">
                    <h5>Produk Belum Tersedia</h5>

                    <p class="mb-0">
                        Belum ada produk tersedia saat ini.
                        Silakan kembali lagi nanti.
                    </p>
                </div>

            </div>

        @endforelse

    </div>

    {{-- PAGINATION JIKA TERSEDIA --}}

    @if(method_exists($products, 'links'))
        <div class="d-flex justify-content-center mt-3">
            {{ $products->links() }}
        </div>
    @endif

</div>

@endsection
@extends('layouts.app')

@section('content')
<div class="container py-3">

    <a href="{{ url('/produk') }}" class="btn btn-secondary mb-3">
        ← Kembali
    </a>

    <div class="card shadow-sm border-0">
        
        <img src="{{ $product->image_url }}"
             class="card-img-top"
             style="height:250px;object-fit:cover;">

        <div class="card-body">

            <h3>{{ $product->name }}</h3>

            <p class="text-muted">
                {{ $product->category->name ?? '-' }}
            </p>

            <h2 class="text-success">
                Rp {{ number_format($product->price,0,',','.') }}
            </h2>

            <hr>

            <p>
                {{ $product->description }}
            </p>

            <p>
                <strong>Stok :</strong>
                {{ $product->stock }}
            </p>

            <a href="https://wa.me/6281232323510?text=Saya%20ingin%20pesan%20{{ urlencode($product->name) }}"
               class="btn btn-success w-100">
                Pesan via WhatsApp
            </a>

        </div>
    </div>

</div>
@endsection
@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="card shadow-sm">

        <div class="card-header bg-primary text-white">
            🚚 Kirim Pesanan
        </div>

        <div class="card-body">

            @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

            @endif

            @if($errors->any())

            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

            @endif

            <p>
                <b>Invoice :</b>
                {{ $order->invoice }}
            </p>

            <p>
                <b>Pelanggan :</b>
                {{ $order->customer_name }}
            </p>

            <p>
                <b>Total :</b>
                Rp {{ number_format($order->total,0,',','.') }}
            </p>

            <hr>

            <form
                method="POST"
                action="{{ route('orders.kirim',$order->id) }}">

                @csrf

                <div class="mb-3">

                    <label class="form-label">
                        Nama Kurir
                    </label>

                    <select
                        name="kurir"
                        class="form-control"
                        required>

                        <option value="">
                            Pilih Kurir
                        </option>

                        <option value="JNE">
                            JNE
                        </option>

                        <option value="J&T">
                            J&T
                        </option>

                        <option value="SiCepat">
                            SiCepat
                        </option>

                        <option value="AnterAja">
                            AnterAja
                        </option>

                        <option value="Shopee Express">
                            Shopee Express
                        </option>

                        <option value="GoSend">
                            GoSend
                        </option>

                        <option value="Grab Express">
                            Grab Express
                        </option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Nomor Resi
                    </label>

                    <input
                        type="text"
                        name="resi"
                        class="form-control"
                        required>

                </div>

                <button
                    type="submit"
                    class="btn btn-primary">

                    🚚 Simpan Pengiriman

                </button>

                <a
                    href="{{ route('orders.detail',$order->id) }}"
                    class="btn btn-secondary">

                    Kembali

                </a>

            </form>

        </div>

    </div>

</div>

@endsection
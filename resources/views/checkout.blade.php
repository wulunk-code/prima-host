@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow-sm">

        <div class="card-header bg-success text-white">
            🛒 Checkout Pesanan
        </div>

        <div class="card-body">

            <form action="{{ route('checkout') }}" method="POST">
    @csrf

                <h5>Data Pemesan</h5>

                <div class="mb-3">
                    <label>Nama</label>
                    <input
                        type="text"
                        name="nama"
                        class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label>Nomor WhatsApp</label>
                    <input
                        type="text"
                        name="telepon"
                        class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label>Alamat Pengiriman</label>
                    <textarea
                        name="alamat"
                        class="form-control"
                        rows="3"
                        required></textarea>
                </div>

                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <hr>

                <h5>Lokasi Pengiriman</h5>

                <div id="map"
                     style="height:300px;border-radius:10px;">
                </div>

                <hr>

                @php

                $subtotal = 0;

                foreach($cart as $item){

                    $subtotal +=
                    $item['price']
                    *
                    $item['qty'];
                }

                @endphp

                <h5>Ringkasan Pesanan</h5>

                <table class="table table-bordered">

                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th width="60">Qty</th>
                            <th width="120">Total</th>
                        </tr>
                    </thead>

                    <tbody>

                    @foreach($cart as $item)

                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['qty'] }}</td>
                            <td>
                                Rp {{ number_format(
                                    $item['price'] * $item['qty'],
                                    0,
                                    ',',
                                    '.'
                                ) }}
                            </td>
                        </tr>

                    @endforeach

                    </tbody>

                </table>

                <div class="alert alert-light">

                    <p>
                        Subtotal :
                        <b>
                            Rp {{ number_format(
                                $subtotal,
                                0,
                                ',',
                                '.'
                            ) }}
                        </b>
                    </p>

                    <p>
                        Ongkir :
                        <b id="ongkirText">
                            Gratis
                        </b>
                    </p>

                    <hr>

                    <h3 class="text-success">

                        Total Bayar :

                        <span id="grandTotal">
                            Rp {{ number_format(
                                $subtotal,
                                0,
                                ',',
                                '.'
                            ) }}
                        </span>

                    </h3>

                </div>

                <input
                    type="hidden"
                    name="ongkir"
                    id="ongkir"
                    value="0">

                <hr>

                <h5>Metode Pembayaran</h5>

                <select
                    name="metode_pembayaran"
                    class="form-control">

                    <option value="Transfer Bank">
                        Transfer Bank
                    </option>

                    <option value="QRIS">
                        QRIS
                    </option>

                </select>

                <hr>

                <h5>Pembayaran Transfer</h5>

                <div class="alert alert-warning">

                    <p>
                        🏦 Bank :
                        <b>{{ $setting->bank_name }}</b>
                    </p>

                    <p>
                        💳 Nomor Rekening :
                        <b>{{ $setting->bank_account }}</b>
                    </p>

                    <p>
                        👤 Atas Nama :
                        <b>{{ $setting->account_name }}</b>
                    </p>

                </div>

                <h5>QRIS</h5>

                @if($setting->qris)

                    <center>

                        <img
                            src="{{ asset($setting->qris) }}"
                            class="img-fluid"
                            style="max-width:250px">

                    </center>

                @endif

                <hr>

                <button
                    class="btn btn-success w-100">

                    ✅ Buat Pesanan

                </button>

            </form>

        </div>

    </div>

</div>

<link rel="stylesheet"
href="https://unpkg.com/leaflet/dist/leaflet.css"/>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

let subtotal =
{{ $subtotal }};

navigator.geolocation.getCurrentPosition(

function(pos){

let lat =
pos.coords.latitude;

let lng =
pos.coords.longitude;

document.getElementById(
'latitude'
).value = lat;

document.getElementById(
'longitude'
).value = lng;

let map =
L.map('map')
.setView(
[lat,lng],
15
);

L.tileLayer(
'https://tile.openstreetmap.org/{z}/{x}/{y}.png'
).addTo(map);

L.marker(
[lat,lng]
)
.addTo(map)
.bindPopup(
'Lokasi Anda'
)
.openPopup();

}

);

</script>

@endsection
@extends('layouts.app')

@section('content')

<div class="card">

    <div class="card-header bg-success text-white">

        📊 Laporan Penjualan

    </div>

    <div class="card-body">

        <form method="POST" action="/admin/laporan/filter">

            @csrf

            <div class="row">

                <div class="col-md-4">

                    <label>Tanggal Awal</label>

                    <input
                        type="date"
                        name="tanggal_awal"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-4">

                    <label>Tanggal Akhir</label>

                    <input
                        type="date"
                        name="tanggal_akhir"
                        class="form-control"
                        required>

                </div>

                <div class="col-md-4">

                    <label>&nbsp;</label>

                    <button
                        class="btn btn-success w-100">

                        Filter

                    </button>

                </div>

            </div>

        </form>

        <hr>

        <div class="alert alert-success">

            <h4>

                Total Omzet :
                Rp {{ number_format($totalOmzet,0,',','.') }}

            </h4>

        </div>

        <div class="table-responsive">

            <table class="table table-bordered">

                <thead class="table-success">

                <tr>

                    <th>Invoice</th>
                    <th>Pembeli</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>

                </tr>

                </thead>

                <tbody>

                @foreach($orders as $order)

                <tr>

                    <td>{{ $order->invoice }}</td>

                    <td>{{ $order->customer_name }}</td>

                    <td>
                        Rp {{ number_format($order->total,0,',','.') }}
                    </td>

                    <td>{{ $order->status }}</td>

                    <td>
                        {{ $order->created_at }}
                    </td>

                </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between mb-3">

        <h3>
            📦 Data Pesanan
        </h3>

    </div>

    @if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

    @endif

    <div class="card shadow-sm">

        <div class="table-responsive">

            <table class="table table-bordered table-hover mb-0">

                <thead class="table-success">

                    <tr>
                        <th>Invoice</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($orders as $order)

                <tr>

                    <td>
                        {{ $order->invoice }}
                    </td>

                    <td>
                        {{ $order->customer_name }}
                    </td>

                    <td>
                        Rp {{ number_format($order->total,0,',','.') }}
                    </td>

                    <td>

                        <span class="badge bg-{{ $order->status_badge }}">
                            {{ $order->status_label }}
                        </span>

                    </td>

                    <td>

                        @if($order->payment_status=='pending')

                            <span class="badge bg-warning">
                                Pending
                            </span>

                        @elseif($order->payment_status=='menunggu_verifikasi')

                            <span class="badge bg-info">
                                Menunggu Verifikasi
                            </span>

                        @elseif($order->payment_status=='lunas')

                            <span class="badge bg-success">
                                Lunas
                            </span>

                        @endif

                    </td>

                    <td>

                        <a
                        href="{{ route('orders.detail',$order->id) }}"
                        class="btn btn-sm btn-primary">

                        Detail

                        </a>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="text-center">
                        Belum ada pesanan
                    </td>

                </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-3">
        {{ $orders->links() }}
    </div>

</div>

@endsection
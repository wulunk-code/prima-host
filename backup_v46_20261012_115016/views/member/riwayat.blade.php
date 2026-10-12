@extends('layouts.app')

@section('content')

<div class="container py-3">

    <h3 class="mb-3">📋 Riwayat Pesanan</h3>

    @forelse($orders as $order)

    <div class="card shadow-sm mb-3 border-0">
        <div class="card-body">

            <h5 class="fw-bold">
                {{ $order->invoice ?? 'INV-'.$order->id }}
            </h5>

            <p class="mb-1">
                <strong>Nama :</strong>
                {{ $order->customer_name }}
            </p>

            <p class="mb-1">
                <strong>Status :</strong>

                @if($order->status == 'pending')
                    <span class="text-warning">⏳ Pending</span>

                @elseif($order->status == 'menunggu_verifikasi')
                    <span class="text-warning">📝 Menunggu Verifikasi</span>

                @elseif($order->status == 'diproses')
                    <span class="text-primary">⚙️ Diproses</span>

                @elseif($order->status == 'dikirim')
                    <span class="text-info">🚚 Dikirim</span>

                @elseif($order->status == 'selesai')
                    <span class="text-success">✅ Selesai</span>

                @elseif($order->status == 'dibatalkan')
                    <span class="text-danger">❌ Dibatalkan</span>

                @else
                    {{ $order->status }}
                @endif

            </p>

            <p class="mb-1">
                <strong>Pembayaran :</strong>
                {{ ucfirst($order->payment_status) }}
            </p>

            <p class="mb-3">
                <strong>Total :</strong>
                Rp {{ number_format($order->total,0,',','.') }}
            </p>

            <a href="{{ url('/invoice/'.$order->id) }}"
               class="btn btn-success w-100">
                📄 Lihat Invoice
            </a>

        </div>
    </div>

    @empty

    <div class="alert alert-info">
        Belum ada riwayat pesanan.
    </div>

    @endforelse

</div>

@endsection
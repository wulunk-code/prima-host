@extends('layouts.app')

@section('content')

<style>
    .order-detail-wrapper {
        max-width: 1000px;
        margin: auto;
        padding: 15px 0 30px;
    }

    .order-card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 14px rgba(0, 0, 0, .07);
        margin-bottom: 20px;
    }

    .order-card .card-header {
        padding: 14px 18px;
        font-weight: 700;
    }

    .info-label {
        color: #6c757d;
        font-size: 13px;
        margin-bottom: 3px;
    }

    .info-value {
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .info-box {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 12px;
        height: 100%;
    }

    .payment-proof {
        display: block;
        width: 100%;
        max-width: 500px;
        max-height: 600px;
        object-fit: contain;
        background: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 5px;
        margin: 12px auto;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }

    .action-button {
        min-height: 42px;
        margin: 3px;
    }

    .order-table th,
    .order-table td {
        vertical-align: middle;
    }

    @media (max-width: 576px) {
        .order-detail-wrapper {
            padding-top: 8px;
        }

        .order-card .card-body {
            padding: 14px;
        }

        .order-title {
            font-size: 19px;
        }

        .action-button {
            width: 100%;
            margin: 5px 0;
        }
    }
</style>

@php
    $status = strtolower(trim($order->status ?? 'pending'));

    $paymentStatus = strtolower(
        trim($order->payment_status ?? 'pending')
    );

    $statusStyles = [
        'pending' => ['warning', 'Pending'],
        'menunggu_verifikasi' => ['info', 'Menunggu Verifikasi'],
        'diproses' => ['primary', 'Diproses'],
        'dikirim' => ['info', 'Dikirim'],
        'selesai' => ['success', 'Selesai'],
        'dibatalkan' => ['danger', 'Dibatalkan'],
    ];

    $paymentStyles = [
        'pending' => ['warning', 'Menunggu Pembayaran'],
        'menunggu_verifikasi' => ['info', 'Menunggu Verifikasi'],
        'lunas' => ['success', 'Lunas'],
        'paid' => ['success', 'Lunas'],
        'gagal' => ['danger', 'Gagal'],
        'ditolak' => ['danger', 'Ditolak'],
    ];

    [$statusColor, $statusText] = $statusStyles[$status]
        ?? ['secondary', ucfirst(str_replace('_', ' ', $status))];

    [$paymentColor, $paymentText] = $paymentStyles[$paymentStatus]
        ?? ['secondary', ucfirst(str_replace('_', ' ', $paymentStatus))];
@endphp

<div class="container order-detail-wrapper">

    {{-- JUDUL HALAMAN --}}

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">

        <h3 class="order-title mb-2">
            🧾 Detail Pesanan
        </h3>

        <a href="{{ route('orders.index') }}"
           class="btn btn-outline-secondary btn-sm mb-2">
            ← Kembali ke Pesanan
        </a>

    </div>


    {{-- NOTIFIKASI --}}

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>

            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- INFORMASI PESANAN --}}

    <div class="card order-card">

        <div class="card-header bg-success text-white">
            📋 Informasi Pesanan
        </div>

        <div class="card-body">

            <div class="row g-3">

                <div class="col-12 col-md-6">
                    <div class="info-box">
                        <div class="info-label">Nomor Invoice</div>

                        <div class="info-value">
                            {{ $order->invoice ?: '-' }}
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="info-box">
                        <div class="info-label">Tanggal Pesanan</div>

                        <div class="info-value">
                            {{ $order->created_at
                                ? $order->created_at->format('d-m-Y H:i')
                                : '-' }}
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="info-box">
                        <div class="info-label">Nama Pelanggan</div>

                        <div class="info-value">
                            {{ $order->customer_name ?: '-' }}
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="info-box">
                        <div class="info-label">Nomor WhatsApp</div>

                        <div class="info-value">
                            {{ $order->phone ?: '-' }}
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="info-box">
                        <div class="info-label">Alamat Pengiriman</div>

                        <div class="info-value">
                            {{ $order->address ?: '-' }}
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="info-box">
                        <div class="info-label">Metode Pembayaran</div>

                        <div class="info-value">
                            {{ $order->payment_method ?: '-' }}
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="info-box">
                        <div class="info-label">Status Pembayaran</div>

                        <span class="badge bg-{{ $paymentColor }}">
                            {{ $paymentText }}
                        </span>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="info-box">
                        <div class="info-label">Status Pesanan</div>

                        <span class="badge bg-{{ $statusColor }}">
                            {{ $statusText }}
                        </span>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="info-box">
                        <div class="info-label">Ongkos Kirim</div>

                        <div class="info-value">
                            Rp {{ number_format((float) ($order->ongkir ?? 0), 0, ',', '.') }}
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>


    {{-- DETAIL PRODUK --}}

    <div class="card order-card">

        <div class="card-header bg-light">
            📦 Detail Produk
        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered order-table mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Harga</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($order->items as $item)

                        <tr>
                            <td>
                                {{ $item->product_name ?? 'Produk' }}
                            </td>

                            <td class="text-center">
                                {{ $item->qty }}
                            </td>

                            <td class="text-end">
                                Rp {{ number_format((float) ($item->price ?? 0), 0, ',', '.') }}
                            </td>

                            <td class="text-end">
                                Rp {{ number_format((float) ($item->subtotal ?? 0), 0, ',', '.') }}
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="text-center py-3">
                                Tidak ada detail produk.
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="p-3 text-end bg-light">

                <div class="text-muted">
                    Total Pembayaran
                </div>

                <h4 class="text-success mb-0">
                    Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                </h4>

            </div>

        </div>

    </div>


    {{-- BUKTI TRANSFER --}}

    <div class="card order-card">

        <div class="card-header bg-light">
            💳 Bukti Pembayaran
        </div>

        <div class="card-body">

            <div class="row g-3 mb-3">

                <div class="col-12 col-md-6">
                    <div class="info-box">
                        <div class="info-label">Nama Pengirim</div>

                        <div class="info-value">
                            {{ $order->sender_name ?: '-' }}
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="info-box">
                        <div class="info-label">Bank Pengirim</div>

                        <div class="info-value">
                            {{ $order->bank ?: '-' }}
                        </div>
                    </div>
                </div>

            </div>

            @if($order->bukti_transfer)

                <p class="text-muted small">
                    Klik gambar untuk membuka bukti transfer di tab baru.
                </p>

                <a href="{{ asset($order->bukti_transfer) }}"
                   target="_blank"
                   rel="noopener noreferrer">

                    <img
                        src="{{ asset($order->bukti_transfer) }}"
                        alt="Bukti transfer {{ $order->invoice }}"
                        class="payment-proof"
                        loading="lazy"
                    >

                </a>

            @else

                <div class="alert alert-warning mb-0">
                    Belum ada bukti transfer yang diunggah pelanggan.
                </div>

            @endif

        </div>

    </div>


    {{-- INFORMASI PENGIRIMAN --}}

    @if($order->kurir || $order->resi)

        <div class="card order-card">

            <div class="card-header bg-light">
                🚚 Informasi Pengiriman
            </div>

            <div class="card-body">

                <p>
                    <strong>Kurir:</strong>
                    {{ $order->kurir ?: '-' }}
                </p>

                <p class="mb-0">
                    <strong>Nomor Resi:</strong>
                    {{ $order->resi ?: '-' }}
                </p>

            </div>

        </div>

    @endif


    {{-- AKSI ADMIN --}}

    <div class="card order-card">

        <div class="card-header bg-dark text-white">
            ⚙️ Aksi Admin
        </div>

        <div class="card-body">

            @if(
                $paymentStatus === 'menunggu_verifikasi'
                && $order->bukti_transfer
            )

                <div class="alert alert-info">
                    Periksa bukti transfer dan cocokkan nominal pembayaran
                    sebelum menyetujui pembayaran.
                </div>

                <form
                    action="{{ route('orders.verifikasi', $order->id) }}"
                    method="POST"
                    onsubmit="return confirm('Apakah bukti transfer sudah diperiksa dan pembayaran benar-benar diterima?')"
                    class="mb-3"
                >

                    @csrf

                    <button type="submit"
                            class="btn btn-success action-button">
                        ✅ Verifikasi Pembayaran
                    </button>

                </form>

            @elseif($paymentStatus === 'menunggu_verifikasi')

                <div class="alert alert-warning">
                    Pembayaran menunggu verifikasi, tetapi bukti transfer
                    belum tersedia.
                </div>

            @elseif(in_array($paymentStatus, ['lunas', 'paid']))

                <div class="alert alert-success">
                    Pembayaran sudah ditandai lunas.
                </div>

            @endif


            @if($status === 'diproses')

                <a
                    href="{{ route('orders.kirim.form', $order->id) }}"
                    class="btn btn-primary action-button"
                >
                    🚚 Kirim Pesanan
                </a>

            @endif


            @if($status === 'dikirim')

                <form
                    action="{{ route('orders.selesai', $order->id) }}"
                    method="POST"
                    class="d-inline"
                    onsubmit="return confirm('Tandai pesanan ini sebagai selesai?')"
                >

                    @csrf

                    <button type="submit"
                            class="btn btn-dark action-button">
                        ✅ Tandai Selesai
                    </button>

                </form>

            @endif


            @if(!in_array($status, ['selesai', 'dibatalkan']))

                <form
                    action="{{ route('orders.batal', $order->id) }}"
                    method="POST"
                    class="d-inline"
                    onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')"
                >

                    @csrf

                    <button type="submit"
                            class="btn btn-outline-danger action-button">
                        ❌ Batalkan Pesanan
                    </button>

                </form>

            @endif


            <hr>

            <a
                href="{{ route('invoice', $order->id) }}"
                class="btn btn-outline-success action-button"
            >
                🧾 Lihat Invoice
            </a>

            <a
                href="{{ route('orders.index') }}"
                class="btn btn-outline-secondary action-button"
            >
                ← Kembali
            </a>

        </div>

    </div>

</div>

@endsection
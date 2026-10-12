@extends('layouts.app')

@section('content')

<style>
.order-card {
    border: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 3px 12px rgba(0,0,0,.07);
    margin-bottom: 18px;
}

.order-header {
    font-weight: 600;
}

.order-label {
    color: #777;
    font-size: 13px;
    margin-bottom: 4px;
}

.order-value {
    font-weight: 500;
    overflow-wrap: anywhere;
}

.order-total {
    font-size: 25px;
    font-weight: 700;
    color: #008b50;
}

.product-table th,
.product-table td {
    vertical-align: middle;
}

.proof-image {
    max-width: 100%;
    max-height: 350px;
    object-fit: contain;
    border-radius: 8px;
}

@media (max-width: 576px) {
    .order-total {
        font-size: 22px;
    }

    .product-table {
        font-size: 13px;
    }
}
</style>

<div class="container py-3">

    {{-- PESAN BERHASIL --}}
    <div class="alert alert-success">
        <strong>✅ Detail Pesanan Prima House</strong>
        <br>
        Simpan nomor invoice untuk memudahkan pengecekan pesanan.
    </div>

    {{-- INFORMASI PESANAN --}}
    <div class="card order-card">

        <div class="card-header bg-success text-white order-header">
            🧾 Informasi Pesanan
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <div class="order-label">Nomor Invoice</div>
                    <div class="order-value">
                        {{ $order->invoice }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="order-label">Nama Pelanggan</div>
                    <div class="order-value">
                        {{ $order->customer_name }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="order-label">Nomor WhatsApp</div>
                    <div class="order-value">
                        {{ $order->phone }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="order-label">Metode Pembayaran</div>
                    <div class="order-value">
                        {{ $order->payment_method }}
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <div class="order-label">Alamat Pengiriman</div>
                    <div class="order-value">
                        {{ $order->address }}
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="order-label">Status Pembayaran</div>

                    @php
                        $paymentStatus = strtolower(
                            trim($order->payment_status ?? 'pending')
                        );
                    @endphp

                    @if($paymentStatus == 'lunas')
                        <span class="badge bg-success">Lunas</span>
                    @elseif($paymentStatus == 'menunggu_verifikasi')
                        <span class="badge bg-info">Menunggu Verifikasi</span>
                    @elseif($paymentStatus == 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @else
                        <span class="badge bg-secondary">
                            {{ $order->payment_status }}
                        </span>
                    @endif
                </div>

                <div class="col-md-6 mb-3">
                    <div class="order-label">Status Pesanan</div>

                    @php
                        $orderStatus = strtolower(
                            trim($order->status ?? 'pending')
                        );
                    @endphp

                    @if($orderStatus == 'pending')
                        <span class="badge bg-warning text-dark">
                            Menunggu Pembayaran
                        </span>
                    @elseif($orderStatus == 'menunggu_verifikasi')
                        <span class="badge bg-info">
                            Menunggu Verifikasi
                        </span>
                    @elseif($orderStatus == 'diproses')
                        <span class="badge bg-primary">Diproses</span>
                    @elseif($orderStatus == 'dikirim')
                        <span class="badge bg-success">Dikirim</span>
                    @elseif($orderStatus == 'selesai')
                        <span class="badge bg-dark">Selesai</span>
                    @elseif($orderStatus == 'dibatalkan')
                        <span class="badge bg-danger">Dibatalkan</span>
                    @else
                        <span class="badge bg-secondary">
                            {{ $order->status }}
                        </span>
                    @endif
                </div>

            </div>

            <hr>

            <div class="text-end">
                <div class="order-label">Total Pembayaran</div>
                <div class="order-total">
                    Rp {{ number_format($order->total, 0, ',', '.') }}
                </div>
            </div>

        </div>
    </div>

    {{-- DETAIL PRODUK --}}
    <div class="card order-card">

        <div class="card-header bg-light order-header">
            📦 Detail Produk
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered product-table">

                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th class="text-center">Qty</th>
                            <th class="text-end">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($order->items as $item)

                            <tr>
                                <td>{{ $item->product_name }}</td>

                                <td class="text-center">
                                    {{ $item->qty }}
                                </td>

                                <td class="text-end">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="3" class="text-center">
                                    Belum ada detail produk.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>
    </div>

    {{-- BUKTI TRANSFER YANG SUDAH DIUPLOAD --}}
    @if(!empty($order->bukti_transfer))

        <div class="card order-card">

            <div class="card-header bg-light order-header">
                🧾 Bukti Pembayaran
            </div>

            <div class="card-body">

                <p>
                    <strong>Nama Pengirim:</strong>
                    {{ $order->sender_name ?? '-' }}
                </p>

                <p>
                    <strong>Bank Pengirim:</strong>
                    {{ $order->bank ?? '-' }}
                </p>

                <a
                    href="{{ asset($order->bukti_transfer) }}"
                    target="_blank"
                    rel="noopener"
                >
                    <img
                        src="{{ asset($order->bukti_transfer) }}"
                        alt="Bukti Transfer"
                        class="proof-image border"
                    >
                </a>

            </div>

        </div>

    @endif

    {{-- FORM UPLOAD BUKTI TRANSFER --}}
    @if(
        in_array($paymentStatus, ['pending', 'belum_bayar'])
        && empty($order->bukti_transfer)
    )

        <div class="card order-card">

            <div class="card-header bg-warning order-header">
                💳 Upload Bukti Transfer
            </div>

            <div class="card-body">

                <div class="alert alert-info">
                    Silakan transfer sesuai total pembayaran, lalu unggah
                    bukti transfer untuk diperiksa oleh admin.
                </div>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    method="POST"
                    action="{{ route('upload.bukti', $order->id) }}"
                    enctype="multipart/form-data"
                >

                    @csrf

                    <div class="mb-3">
                        <label for="sender_name" class="form-label">
                            Nama Pengirim
                        </label>

                        <input
                            type="text"
                            id="sender_name"
                            name="sender_name"
                            class="form-control"
                            value="{{ old('sender_name') }}"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="bank" class="form-label">
                            Bank Pengirim
                        </label>

                        <input
                            type="text"
                            id="bank"
                            name="bank"
                            class="form-control"
                            value="{{ old('bank') }}"
                            placeholder="Contoh: BCA, BRI, Mandiri"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label for="bukti_transfer" class="form-label">
                            Foto Bukti Transfer
                        </label>

                        <input
                            type="file"
                            id="bukti_transfer"
                            name="bukti_transfer"
                            class="form-control"
                            accept="image/jpeg,image/png,image/webp"
                            required
                        >

                        <small class="text-muted">
                            Format JPG, PNG, atau WEBP. Maksimal 2 MB.
                        </small>
                    </div>

                    <button
                        type="submit"
                        class="btn btn-success w-100"
                    >
                        ✅ Kirim Bukti Transfer
                    </button>

                </form>

            </div>
        </div>

    @elseif($paymentStatus == 'menunggu_verifikasi')

        <div class="alert alert-info">
            ⏳ Bukti pembayaran sedang menunggu verifikasi admin.
        </div>

    @elseif($paymentStatus == 'lunas')

        <div class="alert alert-success">
            ✅ Pembayaran telah dikonfirmasi.
        </div>

    @endif

    {{-- INFORMASI PENGIRIMAN --}}
    @if(!empty($order->resi))

        <div class="card order-card">

            <div class="card-header bg-primary text-white order-header">
                🚚 Informasi Pengiriman
            </div>

            <div class="card-body">

                <p>
                    <strong>Kurir:</strong>
                    {{ $order->kurir ?? '-' }}
                </p>

                <p class="mb-0">
                    <strong>Nomor Resi:</strong>
                    {{ $order->resi }}
                </p>

            </div>

        </div>

    @endif

    {{-- TOMBOL KEMBALI --}}
    <div class="d-grid gap-2 mb-4">

        <a href="{{ url('/') }}" class="btn btn-outline-success">
            🏠 Kembali ke Prima House
        </a>

        <a href="{{ url('/cart') }}" class="btn btn-outline-primary">
            🛒 Lihat Keranjang
        </a>

    </div>

</div>

@endsection
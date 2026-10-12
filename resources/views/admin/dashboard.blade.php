@extends('layouts.app')

@section('content')

<style>
    .dashboard-wrapper {
        padding: 15px 0 30px;
    }

    .dashboard-title {
        font-size: 24px;
        font-weight: 700;
        color: #198754;
        margin-bottom: 22px;
    }

    .stat-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0,0,0,.07);
        height: 100%;
        transition: transform .2s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
    }

    .stat-label {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 8px;
    }

    .stat-value {
        font-size: 25px;
        font-weight: 700;
        margin: 0;
        overflow-wrap: anywhere;
    }

    .stat-icon {
        font-size: 27px;
        margin-bottom: 10px;
    }

    .dashboard-panel {
        border: none;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0,0,0,.06);
        overflow: hidden;
    }

    .dashboard-panel .card-header {
        background: #fff;
        padding: 15px;
        font-weight: 700;
        border-bottom: 1px solid #eee;
    }

    .dashboard-panel .card-body {
        padding: 15px;
    }

    .status-card {
        border-radius: 10px;
        padding: 15px 10px;
        text-align: center;
        height: 100%;
        background: #fff;
    }

    .status-number {
        font-size: 27px;
        font-weight: 700;
        margin: 5px 0 0;
    }

    .dashboard-table {
        margin-bottom: 0;
        font-size: 13px;
        white-space: nowrap;
    }

    .dashboard-table th {
        background: #f8f9fa;
        font-weight: 600;
    }

    .dashboard-table td,
    .dashboard-table th {
        vertical-align: middle;
        padding: 11px 10px;
    }

    .quick-button {
        display: block;
        padding: 14px 10px;
        border-radius: 10px;
        text-align: center;
        text-decoration: none;
        font-weight: 600;
        transition: .2s;
    }

    .quick-button:hover {
        opacity: .88;
        transform: translateY(-2px);
    }

    .payment-warning {
        border-left: 4px solid #ffc107;
    }

    @media (max-width: 576px) {
        .dashboard-title {
            font-size: 21px;
        }

        .stat-value {
            font-size: 22px;
        }

        .stat-card .card-body {
            padding: 13px;
        }

        .dashboard-table {
            font-size: 12px;
        }

        .quick-button {
            font-size: 13px;
        }
    }
</style>

<div class="container-fluid dashboard-wrapper">

    {{-- JUDUL --}}

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">

        <h3 class="dashboard-title mb-2">
            📊 Dashboard Prima House
        </h3>

        <span class="badge bg-success mb-2">
            Admin
        </span>

    </div>


    {{-- PESAN SUKSES --}}

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif


    {{-- PESAN ERROR --}}

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif


    {{-- STATISTIK UTAMA --}}

    <div class="row g-3 mb-4">

        <div class="col-6 col-md-4 col-xl-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-icon">📦</div>
                    <div class="stat-label">Total Produk</div>
                    <h3 class="stat-value">
                        {{ number_format($totalProducts, 0, ',', '.') }}
                    </h3>
                    <small class="text-muted">Produk terdaftar</small>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-4 col-xl-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-icon">🧾</div>
                    <div class="stat-label">Total Pesanan</div>
                    <h3 class="stat-value">
                        {{ number_format($totalOrders, 0, ',', '.') }}
                    </h3>
                    <small class="text-muted">Semua pesanan</small>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-4 col-xl-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-icon">👥</div>
                    <div class="stat-label">Total Member</div>
                    <h3 class="stat-value">
                        {{ number_format($totalMembers, 0, ',', '.') }}
                    </h3>
                    <small class="text-muted">Member terdaftar</small>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-4 col-xl-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-icon">💰</div>
                    <div class="stat-label">Total Omzet</div>
                    <h3 class="stat-value text-success">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </h3>
                    <small class="text-muted">Pesanan selesai</small>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-4 col-xl-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-icon">🎉</div>
                    <div class="stat-label">Promosi</div>
                    <h3 class="stat-value">
                        {{ number_format($totalPromotions, 0, ',', '.') }}
                    </h3>
                    <small class="text-muted">Data promosi</small>
                </div>
            </div>
        </div>


        <div class="col-6 col-md-4 col-xl-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="stat-icon">📅</div>
                    <div class="stat-label">Event</div>
                    <h3 class="stat-value">
                        {{ number_format($totalEvents, 0, ',', '.') }}
                    </h3>
                    <small class="text-muted">Data kegiatan</small>
                </div>
            </div>
        </div>

    </div>


    {{-- STATUS PESANAN --}}

    <div class="card dashboard-panel mb-4">

        <div class="card-header">
            📋 Ringkasan Status Pesanan
        </div>

        <div class="card-body">

            <div class="row g-3">

                <div class="col-6 col-md-4 col-xl-2">
                    <div class="status-card border border-warning">
                        <div>🕒 Pending</div>
                        <div class="status-number text-warning">
                            {{ $pendingOrders }}
                        </div>
                    </div>
                </div>


                <div class="col-6 col-md-4 col-xl-2">
                    <div class="status-card border border-primary">
                        <div>⚙️ Diproses</div>
                        <div class="status-number text-primary">
                            {{ $processingOrders }}
                        </div>
                    </div>
                </div>


                <div class="col-6 col-md-4 col-xl-2">
                    <div class="status-card border border-info">
                        <div>🚚 Dikirim</div>
                        <div class="status-number text-info">
                            {{ $shippingOrders }}
                        </div>
                    </div>
                </div>


                <div class="col-6 col-md-4 col-xl-2">
                    <div class="status-card border border-success">
                        <div>✅ Selesai</div>
                        <div class="status-number text-success">
                            {{ $completedOrders }}
                        </div>
                    </div>
                </div>


                <div class="col-6 col-md-4 col-xl-2">
                    <div class="status-card border border-secondary">
                        <div>🔍 Verifikasi</div>
                        <div class="status-number text-secondary">
                            {{ $verifikasi }}
                        </div>
                    </div>
                </div>


                <div class="col-6 col-md-4 col-xl-2">
                    <div class="status-card border border-danger">
                        <div>❌ Dibatalkan</div>
                        <div class="status-number text-danger">
                            {{ $dibatalkan }}
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>


    {{-- PEMBAYARAN MENUNGGU VERIFIKASI --}}

    <div class="card dashboard-panel payment-warning mb-4">

        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <div>
                    <h6 class="mb-1">
                        💳 Pembayaran Menunggu Verifikasi
                    </h6>

                    <p class="text-muted mb-0">
                        Bukti transfer yang perlu diperiksa admin.
                    </p>
                </div>

                <div class="text-end mt-2">

                    <h3 class="text-warning mb-2">
                        {{ $pendingPayments }}
                    </h3>

                    <a href="{{ route('orders.index') }}"
                       class="btn btn-warning btn-sm">
                        Periksa Pesanan
                    </a>

                </div>

            </div>

        </div>

    </div>


    {{-- PESANAN TERBARU --}}

    <div class="card dashboard-panel mb-4">

        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">

            <span>🧾 Pesanan Terbaru</span>

            <a href="{{ route('orders.index') }}"
               class="btn btn-success btn-sm mt-1">
                Lihat Semua
            </a>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover dashboard-table">

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Invoice</th>
                            <th>Nama Pelanggan</th>
                            <th>Telepon</th>
                            <th>Total</th>
                            <th>Pembayaran</th>
                            <th>Status Pesanan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($latestOrders as $order)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <strong>
                                    {{ $order->invoice ?: '-' }}
                                </strong>
                            </td>

                            <td>
                                {{ $order->customer_name ?: '-' }}
                            </td>

                            <td>
                                {{ $order->phone ?: '-' }}
                            </td>

                            <td>
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>

                            <td>
                                @php
                                    $paymentStatus = strtolower(
                                        $order->payment_status ?? 'pending'
                                    );
                                @endphp

                                @if(in_array($paymentStatus, ['lunas', 'paid']))
                                    <span class="badge bg-success">
                                        Lunas
                                    </span>
                                @elseif($paymentStatus === 'menunggu_verifikasi')
                                    <span class="badge bg-warning text-dark">
                                        Menunggu Verifikasi
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        {{ ucfirst(str_replace('_', ' ', $paymentStatus)) }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                @php
                                    $status = strtolower($order->status ?? 'pending');

                                    $badgeClass = match ($status) {
                                        'pending' => 'bg-warning text-dark',
                                        'menunggu_verifikasi' => 'bg-secondary',
                                        'diproses' => 'bg-primary',
                                        'dikirim' => 'bg-info text-dark',
                                        'selesai' => 'bg-success',
                                        'dibatalkan' => 'bg-danger',
                                        default => 'bg-secondary',
                                    };
                                @endphp

                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $status)) }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ route('orders.detail', $order->id) }}"
                                   class="btn btn-primary btn-sm">
                                    Detail
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="text-center py-4">
                                Belum ada pesanan.
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    {{-- MENU CEPAT --}}

    <div class="card dashboard-panel mb-4">

        <div class="card-header">
            ⚡ Menu Cepat Admin
        </div>

        <div class="card-body">

            <div class="row g-3">

                <div class="col-6 col-md-3">
                    <a href="{{ route('products.index') }}"
                       class="quick-button bg-success text-white">
                        📦<br>
                        Kelola Produk
                    </a>
                </div>


                <div class="col-6 col-md-3">
                    <a href="{{ route('orders.index') }}"
                       class="quick-button bg-primary text-white">
                        🧾<br>
                        Kelola Pesanan
                    </a>
                </div>


                <div class="col-6 col-md-3">
                    <a href="{{ route('members.index') }}"
                       class="quick-button bg-warning text-dark">
                        👥<br>
                        Kelola Member
                    </a>
                </div>


                <div class="col-6 col-md-3">
                    <a href="{{ route('settings.index') }}"
                       class="quick-button bg-dark text-white">
                        ⚙️<br>
                        Pengaturan Toko
                    </a>
                </div>


                <div class="col-6 col-md-3">
                    <a href="{{ route('promotions.index') }}"
                       class="quick-button bg-info text-dark">
                        🎉<br>
                        Promosi
                    </a>
                </div>


                <div class="col-6 col-md-3">
                    <a href="{{ route('events.index') }}"
                       class="quick-button bg-secondary text-white">
                        📅<br>
                        Event
                    </a>
                </div>


                <div class="col-6 col-md-3">
                    <a href="{{ route('laporan') }}"
                       class="quick-button bg-success text-white">
                        📈<br>
                        Laporan Omzet
                    </a>
                </div>


                <div class="col-6 col-md-3">
                    <a href="{{ route('home') }}"
                       class="quick-button border text-dark">
                        🏠<br>
                        Lihat Toko
                    </a>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection
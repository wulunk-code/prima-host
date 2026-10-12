@extends('layouts.app')

@section('content')

<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow border-0">

        <div class="card-header bg-success text-white">
            <h4 class="mb-0">
                ⚙️ Pengaturan Toko
            </h4>
        </div>

        <div class="card-body">

            <form method="POST"
action="{{ route('settings.update') }}"
enctype="multipart/form-data">

@csrf

                {{-- INFORMASI TOKO --}}
                <h5 class="text-success mb-3">
                    Informasi Toko
                </h5>

                <div class="mb-3">
                    <label class="form-label">
                        Nama Toko
                    </label>

                    <input
                        type="text"
                        name="store_name"
                        class="form-control"
                        value="{{ $setting->store_name ?? '' }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Logo Toko
                    </label>

                    @if(!empty($setting->store_logo))
                        <div class="mb-2">
                            <img
                                src="{{ asset($setting->store_logo) }}"
                                class="img-thumbnail"
                                style="max-height:120px;">
                        </div>
                    @endif

                    <input
                        type="file"
                        name="store_logo"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Nomor WhatsApp
                    </label>

                    <input
                        type="text"
                        name="store_phone"
                        class="form-control"
                        value="{{ $setting->store_phone ?? '' }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Alamat Toko
                    </label>

                    <textarea
                        name="store_address"
                        rows="4"
                        class="form-control">{{ $setting->store_address ?? '' }}</textarea>
                </div>

                <hr>

                {{-- REKENING --}}
                <h5 class="text-success mb-3">
                    Informasi Rekening
                </h5>

                <div class="mb-3">
                    <label class="form-label">
                        Nama Bank
                    </label>

                    <input
                        type="text"
                        name="bank_name"
                        class="form-control"
                        value="{{ $setting->bank_name ?? '' }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Nomor Rekening
                    </label>

                    <input
                        type="text"
                        name="bank_account"
                        class="form-control"
                        value="{{ $setting->bank_account ?? '' }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Atas Nama Rekening
                    </label>

                    <input
                        type="text"
                        name="bank_holder"
                        class="form-control"
                        value="{{ $setting->bank_holder ?? '' }}">
                </div>

                <hr>

                {{-- QRIS --}}
                <h5 class="text-success mb-3">
                    QRIS Pembayaran
                </h5>

                @if(!empty($setting->qris_image))
                    <div class="mb-2">
                        <img
                            src="{{ asset($setting->qris_image) }}"
                            class="img-thumbnail"
                            style="max-width:250px;">
                    </div>
                @endif

                <div class="mb-3">
                    <input
                        type="file"
                        name="qris_image"
                        class="form-control">
                </div>

                <hr>

                {{-- ONGKIR --}}
                <h5 class="text-success mb-3">
                    Pengaturan Ongkir
                </h5>

                <div class="mb-3">
                    <label class="form-label">
                        Ongkir Default
                    </label>

                    <input
                        type="number"
                        name="shipping_cost"
                        class="form-control"
                        value="{{ $setting->shipping_cost ?? 5000 }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Radius Gratis Ongkir (KM)
                    </label>

                    <input
                        type="number"
                        name="free_shipping_radius"
                        class="form-control"
                        value="{{ $setting->free_shipping_radius ?? 5 }}">
                </div>

                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-success">

                        💾 Simpan Pengaturan

                    </button>

                    <a href="/admin"
                       class="btn btn-secondary">

                        Kembali

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection
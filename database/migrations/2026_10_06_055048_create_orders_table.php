<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Invoice
            $table->string('invoice')->unique();

            // Data pelanggan
            $table->string('customer_name');
            $table->string('phone');
            $table->text('address');

            // Pembayaran
            $table->string('payment_method')
                  ->default('Transfer');

            $table->string('payment_status')
                  ->default('Belum Bayar');

            // Status pesanan
            $table->string('status')
                  ->default('Pending');

            // Ongkir
            $table->decimal('shipping_fee', 12, 2)
                  ->default(0);

            // Total
            $table->decimal('total', 12, 2)
                  ->default(0);

            // Bukti transfer
            $table->string('bukti_transfer')
                  ->nullable();

            $table->string('sender_name')
                  ->nullable();

            $table->string('bank')
                  ->nullable();

            // Pengiriman
            $table->string('kurir')
                  ->nullable();

            $table->string('resi')
                  ->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
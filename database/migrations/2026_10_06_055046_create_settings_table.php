<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // Informasi toko
            $table->string('store_name')->default('Prima House');
            $table->string('store_logo')->nullable();

            $table->text('store_address')->nullable();
            $table->string('store_phone')->nullable();
            $table->string('store_email')->nullable();

            // Rekening pembayaran
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();

            // QRIS
            $table->string('qris_image')->nullable();

            // Ongkir
            $table->integer('free_shipping_radius')
                  ->default(5);

            $table->decimal('shipping_fee', 12, 2)
                  ->default(5000);

            // Sosial media
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();

            // Status toko
            $table->boolean('is_active')
                  ->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
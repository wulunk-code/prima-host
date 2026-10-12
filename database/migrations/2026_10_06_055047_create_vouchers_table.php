<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();

            $table->string('name');

            $table->enum('type', [
                'percent',
                'fixed',
                'shipping'
            ])->default('fixed');

            $table->decimal('value', 12, 2)
                  ->default(0);

            $table->decimal('minimum_order', 12, 2)
                  ->default(0);

            $table->integer('usage_limit')
                  ->default(1);

            $table->integer('used_count')
                  ->default(0);

            $table->date('start_date')
                  ->nullable();

            $table->date('end_date')
                  ->nullable();

            $table->boolean('is_active')
                  ->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
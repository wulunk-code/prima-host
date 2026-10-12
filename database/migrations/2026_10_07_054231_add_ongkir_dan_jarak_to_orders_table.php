<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            if (!Schema::hasColumn('orders','ongkir')) {
                $table->integer('ongkir')->default(0);
            }

            if (!Schema::hasColumn('orders','jarak')) {
                $table->decimal('jarak',8,2)->default(0);
            }

        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            if (Schema::hasColumn('orders','ongkir')) {
                $table->dropColumn('ongkir');
            }

            if (Schema::hasColumn('orders','jarak')) {
                $table->dropColumn('jarak');
            }

        });
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stock_mutation', function (Blueprint $table) {
            // Stok sebelum dan sesudah mutasi (untuk audit trail)
            $table->integer('stock_before')->nullable()->after('quantity');
            $table->integer('stock_after')->nullable()->after('stock_before');

            // Harga beli per unit saat transaksi (untuk kalkulasi avg HPP)
            $table->decimal('unit_price', 15, 2)->nullable()->after('stock_after');
        });
    }

    public function down(): void
    {
        Schema::table('stock_mutation', function (Blueprint $table) {
            $table->dropColumn(['stock_before', 'stock_after', 'unit_price']);
        });
    }
};
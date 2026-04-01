<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('consumable_restock', function (Blueprint $table) {
        // Fix kolom yang sudah ada
        $table->decimal('purchase_price', 15, 2)->nullable()->default(null)->change();
        $table->integer('quantity_added')->default(0)->change();

        // Tambah kolom yang belum ada
        $table->integer('quantity_returned')->default(0)->after('quantity_added');
        $table->string('supplier_id', 50)->nullable()->after('bhp_id');
    });
}

public function down(): void
{
    Schema::table('consumable_restock', function (Blueprint $table) {
        $table->decimal('purchase_price', 15, 2)->nullable(false)->default('0.00')->change();
        $table->integer('quantity_added')->nullable(false)->change();
        $table->dropColumn(['quantity_returned', 'supplier_id']);
    });
}
};

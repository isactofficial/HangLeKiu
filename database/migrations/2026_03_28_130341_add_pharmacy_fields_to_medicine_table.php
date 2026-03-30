<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('medicine', function (Blueprint $table) {
            $table->string('medicine_code', 20)->nullable()->unique()->after('id');
            $table->string('manufacturer', 100)->nullable()->after('medicine_name');
            $table->enum('medicine_type', [
                'Tablet', 'Kapsul', 'Cairan', 'Injeksi', 'Salep', 'Lainnya'
            ])->default('Tablet')->after('manufacturer');
            $table->decimal('purchase_price', 15, 2)->nullable()->after('minimum_stock');
            $table->decimal('selling_price_general', 15, 2)->nullable()->after('purchase_price');
            $table->decimal('selling_price_otc', 15, 2)->nullable()->after('selling_price_general');
            $table->decimal('avg_hpp', 15, 2)->nullable()->after('selling_price_otc');
        });
    }

    public function down(): void
    {
        Schema::table('medicine', function (Blueprint $table) {
            $table->dropUnique(['medicine_code']);
            $table->dropColumn([
                'medicine_code',
                'manufacturer',
                'medicine_type',
                'purchase_price',
                'selling_price_general',
                'selling_price_otc',
                'avg_hpp',
            ]);
        });
    }
};
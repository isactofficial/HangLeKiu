<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consumable_items', function (Blueprint $table) {
            $table->string('id', 50)->primary();           
            $table->string('item_code', 50)->unique();     
            $table->string('item_name', 150);
            $table->string('brand', 100)->nullable();
            $table->integer('initial_stock')->default(0);
            $table->integer('current_stock')->default(0); // auto-updated via usage/restock
            $table->decimal('purchase_price', 15, 2)->default(0); 
            $table->decimal('general_price', 15, 2)->default(0);  
            $table->decimal('otc_price', 15, 2)->default(0);      
            $table->decimal('avg_hpp', 15, 2)->default(0);        
            $table->integer('min_stock')->default(0);     
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consumable_items');
    }
};
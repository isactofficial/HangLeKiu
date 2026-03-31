<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consumable_restock', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('bhp_id', 50);
            $table->enum('restock_type', ['restock', 'return']);
            $table->integer('quantity_added');
            $table->decimal('purchase_price', 15, 2)->default(0);
            $table->date('expiry_date')->nullable();
            $table->string('batch_number', 100)->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('bhp_id')
                  ->references('id')
                  ->on('consumable_items')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consumable_restock');
    }
};
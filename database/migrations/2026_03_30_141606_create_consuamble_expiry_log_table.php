<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consumable_expiry_log', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('bhp_id', 50);
            $table->integer('quantity_expired');
            $table->date('expiry_date');
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
        Schema::dropIfExists('consumable_expiry_log');
    }
};
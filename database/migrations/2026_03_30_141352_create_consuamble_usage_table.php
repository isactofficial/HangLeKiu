<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consumable_usage', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('bhp_id', 50);
            $table->string('treatment_id', 50)->nullable(); // ref TREATMENT
            $table->enum('usage_type', ['umum', 'bpjs']);
            $table->integer('quantity_used');
            $table->decimal('unit_price', 15, 2)->default(0);
            $table->date('usage_date');
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
        Schema::dropIfExists('consumable_usage');
    }
};
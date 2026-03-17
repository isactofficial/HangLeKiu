<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procedure_item', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            $table->string('procedure_id', 50)->nullable();
            $table->string('master_procedure_id', 50)->nullable();

            $table->integer('quantity')->nullable();
            $table->decimal('unit_price', 12, 2)->nullable();

            $table->enum('discount_type', ['fix', 'percentage', 'none'])->nullable();
            $table->decimal('discount_value', 12, 2)->nullable();

            $table->decimal('subtotal', 12, 2)->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->foreign('procedure_id')->references('id')->on('medical_procedure');
            $table->foreign('master_procedure_id')->references('id')->on('master_procedure');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procedure_item');
    }
};

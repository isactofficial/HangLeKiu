<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('procedure_medicine', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            $table->string('procedure_id', 50)->nullable();
            $table->string('medicine_id', 50)->nullable();

            $table->integer('quantity_used')->nullable();

            $table->timestamp('created_at')->useCurrent();

            $table->foreign('procedure_id')->references('id')->on('medical_procedure');
            $table->foreign('medicine_id')->references('id')->on('medicine');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('procedure_medicine');
    }
};

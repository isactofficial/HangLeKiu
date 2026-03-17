<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicine', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('medicine_name', 150)->nullable();
            $table->string('category', 100)->nullable();
            $table->string('unit', 50)->nullable();
            $table->integer('current_stock')->default(0);
            $table->integer('minimum_stock')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicine');
    }
};

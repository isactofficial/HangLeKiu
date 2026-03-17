<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_mutation', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            $table->string('medicine_id', 50)->nullable();
            $table->string('user_id', 50)->nullable();

            $table->enum('type', ['in', 'out', 'adjustment'])->nullable();
            $table->integer('quantity')->nullable();

            $table->string('notes', 255)->nullable();

            $table->timestamps();

            $table->foreign('medicine_id')->references('id')->on('medicine');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_mutation');
    }
};

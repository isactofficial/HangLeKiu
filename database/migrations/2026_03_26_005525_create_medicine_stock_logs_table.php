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
        Schema::create('medicine_stock_logs', function (Blueprint $table) {
            $table->id();        
            $table->string('medicine_id', 50);        
            $table->enum('type', ['IN', 'OUT']);        
            $table->integer('qty');        
            $table->text('note')->nullable();        
            $table->timestamps();        
            $table->foreign('medicine_id')->references('id')->on('medicine')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_stock_logs');
    }
};

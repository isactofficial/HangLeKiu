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
        Schema::dropIfExists('articles');
        
        Schema::create('articles', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->string('category', 50);
            $table->string('image', 255)->nullable();
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->decimal('rating', 3, 1)->default(0.0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};

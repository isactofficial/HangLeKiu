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
        Schema::create('user', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('role_id', 50)->nullable();
            $table->string('name', 50);
            $table->string('email', 50)->unique();
            $table->string('password', 255);
            $table->string('avatar_url', 255)->nullable();
            $table->boolean('is_active')->default(true)->comment('Soft Ban');
            $table->boolean('is_verified')->default(false)->comment('Email Verified');
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
 
            $table->foreign('role_id')->references('id')->on('role');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};

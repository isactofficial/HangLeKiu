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
        Schema::create('doctor', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('user_id', 50)->nullable();
            $table->string('full_name', 100);
            $table->string('email', 150)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('title_prefix', 50)->nullable();
            $table->string('license_no', 50)->nullable();
            $table->string('str_institution', 50)->nullable();
            $table->string('str_number', 50)->nullable();
            $table->date('str_expiry_date')->nullable();
            $table->string('sip_institution', 50)->nullable();
            $table->string('sip_number', 50)->nullable();
            $table->date('sip_expiry_date')->nullable();
            $table->string('specialization', 100)->nullable();
            $table->string('subspecialization', 100)->nullable();
            $table->string('job_title', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
 
            $table->foreign('user_id')->references('id')->on('user');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor');
    }
};

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
        // Ingat boss, kalau di database namanya pakai akhiran 's' (registrations), 
        // tambahkan huruf 's' nya ya. Kalau pas 'registration', biarkan begini.
        Schema::table('registration', function (Blueprint $table) {
            $table->timestamps();   // Nambahin created_at & updated_at
            $table->softDeletes();  // Nambahin deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registration', function (Blueprint $table) {
            $table->dropTimestamps();
            $table->dropSoftDeletes();
        });
    }
};
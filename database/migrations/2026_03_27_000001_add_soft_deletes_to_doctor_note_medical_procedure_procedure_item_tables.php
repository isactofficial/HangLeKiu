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
        Schema::table('doctor_note', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('medical_procedure', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('procedure_item', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('procedure_item', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('medical_procedure', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('doctor_note', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};

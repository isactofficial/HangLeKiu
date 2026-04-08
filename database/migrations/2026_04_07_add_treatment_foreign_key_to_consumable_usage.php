<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('consumable_usage', function (Blueprint $table) {
            // Add foreign key constraint for treatment_id
            $table->foreign('treatment_id')
                  ->references('id')
                  ->on('medical_procedure')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('consumable_usage', function (Blueprint $table) {
            $table->dropForeign(['treatment_id']);
        });
    }
};

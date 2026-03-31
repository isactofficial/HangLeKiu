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
        Schema::table('patient', function (Blueprint $table) {
            // Menambahkan 5 kolom baru setelah kolom allergy_history
            $table->string('religion', 50)->nullable()->after('allergy_history');
            $table->string('education', 50)->nullable()->after('religion');
            $table->string('occupation', 50)->nullable()->after('education');
            $table->string('marital_status', 50)->nullable()->after('occupation');
            $table->date('first_chat_date')->nullable()->after('marital_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patient', function (Blueprint $table) {
            
            $table->dropColumn([
                'religion',
                'education',
                'occupation',
                'marital_status',
                'first_chat_date'
            ]);
        });
    }
};
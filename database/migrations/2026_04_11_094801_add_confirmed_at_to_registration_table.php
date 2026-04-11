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
     Schema::table('registration', function (Blueprint $table) {
        DB::statement("ALTER TABLE registration MODIFY COLUMN status 
        ENUM('pending','confirmed','waiting','engaged','succeed','failed') NULL");
        
        // 2. confirmed_at
        if (!Schema::hasColumn('registration', 'confirmed_at')) {
            $table->timestamp('confirmed_at')->nullable()->after('status');
        }

        // 3. timestamps
        if (!Schema::hasColumn('registration', 'created_at')) {
            $table->timestamps();
        }

        // 4. softDeletes
        if (!Schema::hasColumn('registration', 'deleted_at')) {
            $table->softDeletes();
        }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registration', function (Blueprint $table) {
            //
        });
    }
};

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
        Schema::table('articles', function (Blueprint $table) {
            // Menambahkan kolom author setelah kolom category
            $table->string('author', 100)->nullable()->after('category');
            
            // Menambahkan kolom source setelah kolom author
            $table->string('source', 255)->nullable()->after('author');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Menghapus kolom jika di-rollback
            $table->dropColumn(['author', 'source']);
        });
    }
};
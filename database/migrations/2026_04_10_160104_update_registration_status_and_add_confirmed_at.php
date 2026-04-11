<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('registration', function (Blueprint $table) {

        // 1. Ubah enum — tambah 'failed'
        DB::statement("ALTER TABLE registration MODIFY COLUMN status 
            ENUM('pending','confirmed','waiting','engaged','succeed','failed') NULL");

        // 2. confirmed_at — hanya kalau belum ada
        if (!\Schema::hasColumn('registration', 'confirmed_at')) {
            $table->timestamp('confirmed_at')->nullable()->after('status');
        }

        // 3. created_at & updated_at — hanya kalau belum ada
        if (!\Schema::hasColumn('registration', 'created_at')) {
            $table->timestamps();
        }

        // 4. deleted_at — hanya kalau belum ada
        if (!\Schema::hasColumn('registration', 'deleted_at')) {
            $table->softDeletes();
        }
    });
}

public function down(): void
{
    Schema::table('registration', function (Blueprint $table) {

        DB::statement("ALTER TABLE registration MODIFY COLUMN status 
            ENUM('pending','confirmed','waiting','engaged','succeed') NULL");

        if (\Schema::hasColumn('registration', 'confirmed_at')) {
            $table->dropColumn('confirmed_at');
        }
    });
}
};

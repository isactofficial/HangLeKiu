<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('master_care_type', function (Blueprint $table) {
            if (!Schema::hasColumn('master_care_type', 'price')) {
                $table->decimal('price', 12, 2)->default(0)->after('name');
            }
            if (!Schema::hasColumn('master_care_type', 'description')) {
                $table->text('description')->nullable()->after('price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('master_care_type', function (Blueprint $table) {
            if (Schema::hasColumn('master_care_type', 'price')) {
                $table->dropColumn('price');
            }
            if (Schema::hasColumn('master_care_type', 'description')) {
                $table->dropColumn('description');
            }
        });
    }
};
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
            $table->timestamp('waiting_at')->nullable()->after('confirmed_at');
            $table->timestamp('engaged_at')->nullable()->after('waiting_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registration', function (Blueprint $table) {
            $table->dropColumn(['waiting_at', 'engaged_at']);
        });
    }
};

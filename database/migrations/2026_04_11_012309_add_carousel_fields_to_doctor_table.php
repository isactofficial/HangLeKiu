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
        Schema::table('doctor', function (Blueprint $table) {
            $table->string('experience')->nullable();
            $table->string('alma_mater')->nullable();
            $table->text('bio')->nullable();
            $table->string('shadow_image')->nullable();
            $table->string('badge_1')->nullable();
            $table->string('badge_2')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->integer('carousel_order')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor', function (Blueprint $table) {
            $table->dropColumn([
                'experience',
                'alma_mater',
                'bio',
                'shadow_image',
                'badge_1',
                'badge_2',
                'instagram_url',
                'linkedin_url',
                'carousel_order',
            ]);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tooth_procedure', function (Blueprint $table) {
            $table->string('id', 50)->primary();

            $table->string('procedure_item_id', 50)->nullable();
            $table->tinyInteger('tooth_number')->nullable();

            $table->foreign('procedure_item_id')->references('id')->on('procedure_item');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tooth_procedure');
    }
};

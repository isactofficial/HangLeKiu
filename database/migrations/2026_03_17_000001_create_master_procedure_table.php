<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_procedure', function (Blueprint $table) {
            $table->string('id', 50)->primary();
            $table->string('procedure_name', 150)->nullable();
            $table->decimal('base_price', 12, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_procedure');
    }
};

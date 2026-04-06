<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('
        UPDATE stock_mutation sm
        JOIN medicine m ON sm.medicine_id = m.id
        SET sm.unit_price = m.purchase_price
        WHERE sm.unit_price IS NULL
        AND m.purchase_price IS NOT NULL
        ');

        }


        public function down(): void

        {
            // tidak bisa di-rollback karena data lama sudah NULL
        }
};

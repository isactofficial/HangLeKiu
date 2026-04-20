<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->boolean('is_multi_payment')->default(false);
            $table->string('second_payment_method_id')->nullable();
            $table->decimal('second_payment_amount', 15, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
       
            $table->dropColumn([
                'is_multi_payment',
                'second_payment_method_id',
                'second_payment_amount'
            ]);
        });
    }
};
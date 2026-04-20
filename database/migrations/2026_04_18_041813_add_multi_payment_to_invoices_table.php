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
            
            // Ubah dari foreignId() menjadi string() agar tipe datanya cocok
            $table->string('second_payment_method_id')->nullable();
            $table->decimal('second_payment_amount', 15, 2)->nullable();

            // Deklarasikan foreign key secara terpisah
            $table->foreign('second_payment_method_id')
                  ->references('id')
                  ->on('master_payment_method')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropForeign(['second_payment_method_id']);
            $table->dropColumn(['is_multi_payment', 'second_payment_method_id', 'second_payment_amount']);
        });
    }
};
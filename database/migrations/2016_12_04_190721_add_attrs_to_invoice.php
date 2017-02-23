<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAttrsToInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->boolean('isIntermediate')->default(false);
            $table->boolean('intermediateNumber')->nullable()->default(null);
            $table->mediumInteger('amountHT')->unsigned();
            $table->mediumInteger('amountTTC')->unsigned();
            $table->tinyInteger('percent')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['isIntermediate', 'intermediateNumber', 'amountHT', 'amountTTC', 'percent']);
        });
    }
}

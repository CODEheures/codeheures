<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number');
            $table->integer('demo_number')->default(0);
            $table->integer('purchase_id')->nullable()->default(null);
            $table->integer('quotation_id')->nullable()->default(null);
            $table->enum('origin',['purchase', 'quotation'])->nullable()->default(null);
            $table->boolean('isDown')->default(false);
            $table->boolean('isSold')->default(false);
            $table->boolean('isPayed')->default(false);
            $table->string('mail')->default(null);
            $table->integer('nbMailBefore')->default(0);
            $table->integer('nbMailAfter')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('invoices');
    }
}

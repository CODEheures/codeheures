<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinequotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_quotes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('quotation_id')->unsigned()->index();
            $table->integer('product_id')->unsigned()->index();
            $table->integer('quantity')->unsigned();
            $table->integer('discount')->unsigned();
            $table->enum('discount_type', ['devise', 'percent']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('line_quotes');
    }
}

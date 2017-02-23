<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->date('validity');
            $table->integer('user_id')->unsigned()->index();
            $table->boolean('isPublished')->default(false);
            $table->boolean('isViewed')->default(false);
            $table->boolean('isOrdered')->default(false);
            $table->boolean('isRefused')->default(false);
            $table->boolean('isArchived')->default(false);
            $table->integer('sms_code')->unsigned()->nullable()->default(null);
            $table->timestamp('sms_validity')->nullable()->default(null);
            $table->tinyInteger('sms_tentatives')->unsigned()->nullable()->default(null);
            $table->timestamp('orderDate')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('quotations');
    }
}

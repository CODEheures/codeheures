<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prestations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name',35);
            $table->string('description');
            $table->decimal('duration',4,2);
            $table->boolean('isPublished')->default(false);
            $table->boolean('isObsolete')->default(false);
            $table->string('url')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prestations');
    }
}
<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->boolean('confirmed')->default(false);
            $table->string('confirmation_token',60);
            $table->string('password', 60);
            $table->string('role')->default('user'); //user, admin
            $table->string('lastName')->default(null)->nullable();
            $table->string('firstName')->default(null)->nullable();
            $table->boolean('is_premium')->default(false);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}

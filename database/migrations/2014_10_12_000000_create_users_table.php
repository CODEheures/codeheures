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
            $table->string('name');
            $table->string('email')->unique()->nullable()->default(null);
            $table->boolean('confirmed')->default(false);
            $table->string('confirmation_token',60);
            $table->string('password', 60)->nullable()->default(null);
            $table->string('role')->default('user'); //user, admin
            $table->string('lastName')->default(null)->nullable();
            $table->string('firstName')->default(null)->nullable();
            $table->string('facebook_id')->unique()->nullable()->default(null);
            $table->string('google_id')->unique()->nullable()->default(null);
            $table->string('twitter_id')->unique()->nullable()->default(null);
            $table->string('github_id')->unique()->nullable()->default(null);
            $table->string('avatar')->nullable()->default(null);
            $table->smallInteger('quota')->default(0);
            $table->boolean('is_admin_valid')->default(false);
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

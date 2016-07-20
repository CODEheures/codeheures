<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRatioPrestationToConsommation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consommations', function (Blueprint $table) {
            $table->decimal('ratio_prestation',4,2)->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consommations', function (Blueprint $table) {
            $table->dropColumn(['ratio_prestation']);
        });
    }
}

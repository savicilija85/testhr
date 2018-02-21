<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProvisionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provisions', function (Blueprint $table) {
            $table->increments('id');
            /*$table->double('btcbuy', 5, 2);
            $table->double('btcsell', 5, 2);
            $table->double('ethbuy', 5, 2);
            $table->double('ethsell', 5, 2);
            $table->double('ltcbuy', 5, 2);
            $table->double('ltcsell', 5, 2);*/
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
        Schema::dropIfExists('provisions');
    }
}

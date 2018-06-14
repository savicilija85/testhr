<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('account_number');
            $table->string('address');
            $table->enum('buy_sell', ['Kupovina', 'Prodaja']);
            $table->string('wallet')->nullable();
            $table->string('destination_tag');
            $table->double('quantity', 13,8);
            $table->string('currency');
            $table->double('sum',8,2);
            $table->string('provision');
            $table->double('pdv', 8, 2);
            $table->double('amount', 8, 2);
            $table->integer('success');
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
        Schema::dropIfExists('orders');
    }
}

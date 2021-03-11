<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('payments', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id');
          $table->dateTime('date');
          $table->float('amount', 8,2);
          $table->tinyInteger('payment_method');
          $table->string('transaction_id', 40);
          $table->string('description', 255);
          $table->string('source_id', 40);
          $table->string('order_id', 40);
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
        Schema::dropIfExists('payments');
    }
}

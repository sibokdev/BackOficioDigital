<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableUsers2openpay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('users2openpay', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id');
          $table->string('customer_id', 40);
          $table->string('email', 255);  
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
        Schema::dropIfExists('users2openpay');
    }
}

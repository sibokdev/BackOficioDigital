<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCards extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table){ 
            $table->increments('id'); 
            $table->string('name',50); 
            $table->string('number',4);
            $table->string('expiration_month',2);
            $table->string('expiration_year',2);
            $table->string('token',25);
            $table->string('idApiCard',25);
            $table->integer('client_id');
            $table->timestamps(); }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cards');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTypesAndSubtypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('types', function (Blueprint $table){ 
            $table->increments('id'); 
            $table->string('name'); 
            $table->timestamps(); }
        );

        Schema::create('subtypes', function (Blueprint $table){ 
            $table->increments('id'); 
            $table->string('name'); 
            $table->integer('type_id');
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
        Schema::dropIfExists('types');
        Schema::dropIfExists('subtypes');
    }
}

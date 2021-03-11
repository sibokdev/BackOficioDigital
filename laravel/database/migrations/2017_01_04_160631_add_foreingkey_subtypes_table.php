<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeingkeySubtypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subtypes', function (Blueprint $table) {
            $table->integer('type_id')->unsigned()->change();
            $table->foreign('type_id')
              ->references('id')->on('types')
              ->onUpdate('cascade')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subtypes', function (Blueprint $table) {
            $table->integer('type_id')->change();
            $table->dropForeign('subtypes_type_id_foreign');
        });
    }
}

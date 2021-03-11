<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeIdApiCardColumnName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cards2openpay', function (Blueprint $table) {
            $table->renameColumn('idApiCard', 'id_api_card');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cards2openpay', function (Blueprint $table) {
            $table->renameColumn('id_api_card', 'idApiCard');
        });
    }
}

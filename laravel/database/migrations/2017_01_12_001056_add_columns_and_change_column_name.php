<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsAndChangeColumnName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cards2openpay', function (Blueprint $table) {
          $table->string('idApiCard',255)->change();
          $table->tinyInteger('main')->after('client_id')->default('0');
          $table->string('device_session_id',255)->after('main');


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
          $table->dropColumn('main');
          $table->dropColumn('device_session_id');
          $table->string('idApiCard',25)->change();
        });
    }
}

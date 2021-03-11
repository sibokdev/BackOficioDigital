<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDefaultIdCourierOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services_orders', function (Blueprint $table) {
            $table->integer('id_courier')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services_orders', function (Blueprint $table) {
            $table->integer('id_courier')->default(null)->change();
        });
    }
}

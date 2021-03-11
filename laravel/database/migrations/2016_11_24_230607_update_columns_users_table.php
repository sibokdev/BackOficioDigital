<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
            
            $table->tinyInteger('active_status')->after('remember_token')->default('0');
            $table->tinyInteger('pay_status')->after('active_status')->default('0');
            $table->tinyInteger('profile_status')->after('pay_status')->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('status');
            
            $table->dropColumn('active_status');
            $table->dropColumn('pay_status');
            $table->dropColumn('profile_status');
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmailAndNulleableIdReferredUsersReferreds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_referreds', function (Blueprint $table) {
            $table->integer('id_referred_user')->nullable()->change();
            $table->string('email', 255)->after('id_referred_user')->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_referreds', function (Blueprint $table) {
            $table->integer('id_referred_user')->change();
            $table->dropColumn('email');
        });
    }
}

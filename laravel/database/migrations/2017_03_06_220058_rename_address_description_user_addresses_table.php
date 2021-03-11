<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameAddressDescriptionUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->renameColumn('address_description', 'alias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_addresses', function (Blueprint $table) {
            $table->renameColumn('alias', 'address_description');
        });
    }
}

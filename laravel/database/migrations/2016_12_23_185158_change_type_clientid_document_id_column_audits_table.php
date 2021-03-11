<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTypeClientidDocumentIdColumnAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audits', function (Blueprint $table) {
            $table->integer('client_id')->change();
            $table->integer('document_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audits', function (Blueprint $table) {
            $table->string('client_id', 40)->change();
            $table->string('document_id', 40)->change();
        });
    }
}

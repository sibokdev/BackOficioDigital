<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddDropColumnsDocumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->renameColumn('picture', 'picture_path');
            
            $table->dropColumn('number');
            $table->dropColumn('status');

            $table->integer('folio')->after('id');
            $table->string('location')->after('folio');
            $table->string('type')->after('location');
            $table->string('subtype')->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->renameColumn('picture_path', 'picture');
            $table->string('expedition')->change();
            $table->string('expiration')->change();
            
            $table->string('number')->after('expiration');
            $table->integer('status')->after('number');
            
            $table->dropColumn('folio');
            $table->dropColumn('location');
            $table->dropColumn('type');
            $table->dropColumn('subtype');
        });
    }
}


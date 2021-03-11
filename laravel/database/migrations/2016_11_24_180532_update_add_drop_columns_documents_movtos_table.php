<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAddDropColumnsDocumentsMovtosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documents_movements', function (Blueprint $table) {
            $table->dropColumn('document_bag_barcode');
            $table->dropColumn('document_name');
            $table->dropColumn('document_type');
            $table->dropColumn('document_owner_id');
            $table->dropColumn('document_location');
            
            $table->integer('document_id')->after('id');
            $table->string('new_location')->after('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documents_movements', function (Blueprint $table) {
			$table->dropColumn('document_id');
            $table->dropColumn('date');
            $table->dropColumn('new_location');
            
            $table->string('document_bag_barcode')->after('id');
            $table->string('document_type')->after('document_bag_barcode');
            $table->integer('document_owner_id')->after('document_type');
            $table->integer('document_location')->after('document_owner_id');
        });
    }
}

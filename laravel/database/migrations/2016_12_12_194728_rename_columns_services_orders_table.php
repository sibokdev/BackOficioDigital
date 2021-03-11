<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnsServicesOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services_orders', function (Blueprint $table) {
            $table->renameColumn('cliente_id', 'id_client');
            //alter table services_orders change fecha date timestamp;
            $table->string('direccion', 255)->change();
            $table->renameColumn('direccion', 'address');
            $table->renameColumn('documentos', 'documents');
            $table->renameColumn('descripcion', 'notes');
            $table->renameColumn('tipo_orden', 'service_type');
            $table->renameColumn('estatus', 'status');
            $table->renameColumn('mensajero_id', 'id_courier');
            
            $table->tinyInteger('urgent')->after('estatus')->default('0');
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
            $table->renameColumn('id_client', 'cliente_id');
            //alter table services_orders change date fecha timestamp;
            $table->renameColumn('address', 'direccion');
            $table->renameColumn('documents', 'documentos');
            $table->renameColumn('notes', 'documentos');
            $table->renameColumn('service_type', 'tipo_orden');
            $table->renameColumn('status', 'estatus');
            $table->renameColumn('id_courier', 'mensajero_id');
            
            $table->dropColumn('urgent');
        });
    }
}

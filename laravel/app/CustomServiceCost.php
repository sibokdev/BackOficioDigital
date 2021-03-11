<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomServiceCost extends Model
{
    protected $table='custom_service_cost';

   protected $fillable=[
       'unique_service_id',
       'client_id',
       'cost_type',
       'cost',
       'begin_promotion',
       'end_promotion',
       'created_at',
       'updated_at'
   ];
}

# @column(cost_type) integer (1.- Costo Anual, 2.- Servicio Urgente)

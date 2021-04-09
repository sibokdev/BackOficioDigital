<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalDirection extends Model
{
     protected $table = 'PersonalDirection';

   public $timestamps = false;

   protected $fillable = [
    
    'calle',
    'numero',
    'codigopostal',
    'colonia',
    'municipio',
    'estado',
    'geolocalizacion',
    'users_id'
 
 ];
 

}


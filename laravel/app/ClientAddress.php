<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientAddress extends Model{

   protected $table='user_addresses';

   public $timestamps = false;

   protected $fillable=[
      'id_user',
      'alias',
      'address',
      'longitude',
      'latitude',
      'created',
      'updated'
   ];
}

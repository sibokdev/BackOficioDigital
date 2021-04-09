<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonalReference extends Model
{
    protected $table = 'PersonalReferences';

    public $timestamps = false;
 
    protected $fillable = [
     'users_id',
     'pnombre',
     'papellidos',
     'ptelefono1',
     'ptelefono2',
     'pnombre2',
     'papellidos2',
     'ptelefono12',
     'ptelefono22',
  ];

}





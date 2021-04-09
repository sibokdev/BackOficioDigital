<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkReference extends Model
{
    protected $table = 'WorkReferences';

    public $timestamps = false;
 
    protected $fillable = [
     'users_id',
     'wnombre',
     'wapellidos',
     'wtelefono1',
     'wtelefono2',
     'wnombre2',
     'wapellidos2',
     'wtelefono12',
     'wtelefono22',
  ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class random_code extends Model
{
    protected $table = 'random_codes';

    public $timestamps = false;
 
    protected $fillable = [
     'users_id',
     'phone1',
     'code',
     'keycode',
    
  ];
}

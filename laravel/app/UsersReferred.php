<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsersReferred extends Model
{
	protected $table = 'users_referreds';

    protected $fillable=[
    	'id',
        'id_user',
        'id_referred_user',
        'email',
        'created_at',
        'update_at'
    ];
}

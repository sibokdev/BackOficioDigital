<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cards2openpay extends Model
{
    protected $table = 'cards2openpay';

    protected $fillable=[
        'id',
        'name',
        'number',
        'expiration_month',
        'expiration_year',
        'token',
        'id_api_card',
        'device_session_id',
        'client_id',
        'main',
        'created_at',
        'updated_at'
    ];
}

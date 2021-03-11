<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicesStatus extends Model
{
    protected $fillable=[
        'client_id',
        'start_date',
        'expiration_date',
        'status',
        'created_at',
        'updated_at'
    ];
}

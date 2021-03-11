<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $fillable=[
        'client_id',
        'services_order_id',
        'created_at',
        'updated_at'
    ];
}

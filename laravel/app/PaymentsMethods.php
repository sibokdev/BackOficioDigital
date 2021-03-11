<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentsMethods extends Model
{
    protected $fillable=[
        'customer_id',
        'payment_method',
        'email',
        'titular_name',
        'card_number',
        'expiration',
        'cvv',
        'postal_code',
        'created_at',
        'updated_at'
    ];

}

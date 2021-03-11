<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users2openpay extends Model
{
    protected $table = 'users2openpay';

    protected $fillable=[
      'id',
      'user_id',
      'customer_id',
      'email',
      'created_at',
      'updated_at'
    ];

    # @param($customer_id) string (get from OpenPay)
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentMethod
 * @package App
 *
 * @property string    $name
 * @property string    $number
 * @property \DateTime $expiration
 * @property string    $cvv
 * @property string    $url
 * @property int       $type 0:Paypal|1:Tarjeta
 * @property int       $customer_id
 */
class ServiceCost extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'service_cost';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable =
        [
            'annual_cost',
            'reception_cost',
            'delivery-cost',
            'mixed_cost',
            'created_at',
            'updated_at'
        ];

}

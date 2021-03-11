<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * @package App
 *
 * @property \DateTime $date
 * @property integer   $status
 * @property integer   $customer_id
 * @property integer   $messenger_id
 * @property string    $cost
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class Order extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable =
        [
            'date',
            'status',
            'customer_id',
            'messenger_id',
            'cost',
            'created_at',
            'updated_at',
        ];

    /**
     * Get al documents for the order
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function documents()
    {
        return $this->belongsToMany('App\Document', 'order_has_document');
    }
}

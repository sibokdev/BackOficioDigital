<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BusinessMethod
 * @package App
 *
 * @property string    $annual_cost
 * @property string    $cost_visit
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class BusinessMethod extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable =
        [
            'annual_cost',
            'cost_visit',
            'created_at',
            'updated_at',
        ];
}

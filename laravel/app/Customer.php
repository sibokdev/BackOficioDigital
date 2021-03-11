<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Customer
 * @package App
 * @property string $first_name
 * @property string $last_name
 * @property string $last2_name
 * @property string $gender
 * @property string $rfc
 * @property string $phone
 * @property string $phone2
 * @property string $email
 * @property string $email2
 * @property integer $user_id
 * @property integer $invited_id
 * @property integer $custom_year_cost
 * @property integer $custom_cost_visit
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class Customer extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable =
        [
            'first_name',
            'last_name',
            'last2_name',
            'gender',
            'rfc',
            'phone',
            'phone2',
            'email',
            'email2',
            'user_id',
            'invited_id',
            'custom_year_cost',
            'custom_cost_visit',
            'created_by',
            'updated_by',
        ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}

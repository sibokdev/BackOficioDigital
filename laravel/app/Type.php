<?php

namespace App;

use Faker\Provider\zh_TW\DateTime;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Types
 * @package App
 *
 * @property string $name
 * @property DateTime $created_at
 * @property DateTime $updated_at
 */
class Type extends Model
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
            'name',
            'created_at',
            'updated_at',
        ];

}

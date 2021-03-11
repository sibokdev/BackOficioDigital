<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SubTypes
 * @package App
 * @property string $name
 */
class SubTypes extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subtypes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable =
        [
            'name',
            'type_id',
            'created_at',
            'updated_at',
        ];
}

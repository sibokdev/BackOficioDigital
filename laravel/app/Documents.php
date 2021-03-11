<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Document
 * @package App
 *
 * @property string    $alias
 * @property \DateTime $expedition
 * @property \DateTime $expiration
 * @property string    $picture_path
 * @property string    $notes
 * @property int       $customer_id
 * @property string    $created_at
 * @property string    $updated_at
 */
class Documents extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'documents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
		'id_user',
		'alias',
		'folio',
		'location',
		'expedition',
		'expiration',
		'picture_path',
		'notes',
		'created_at',
		'updated_at',
	];
	
	//status
	//1 active
	//0 deleted
}

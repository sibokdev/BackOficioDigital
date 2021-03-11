<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentsMovements extends Model
{	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'documents_movements';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable=[
        'id',
        'document_id',
        'new_location',
        'date',
        'created_at',
		'updated_at'
    ];
    
    /**
	* Get the document of the movement.
	*/
    public function document() {
        return $this->hasOne('App\Documents', 'id', 'document_id');
    }
}

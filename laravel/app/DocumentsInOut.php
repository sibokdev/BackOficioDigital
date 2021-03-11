<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentsInOut extends Model
{	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'documents_inout';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable=[
        'id',
        'document_id',
        'folio',
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

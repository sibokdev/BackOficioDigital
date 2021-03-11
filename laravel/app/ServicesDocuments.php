<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicesDocuments extends Model {
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'services2documents';
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'service_id',
        'document_id',
        'created_at',
        'updated_at'
    ];
    
	/**
	* Get the client of the service.
	*/
    public function client() {
        return $this->hasOne('App\ServicesOrder','id', 'service_id');
    }
    
    
    /**
	* Get the client of the service.
	*/
    public function courier() {
        return $this->hasOne('App\Document','id', 'document_id');
    }
}

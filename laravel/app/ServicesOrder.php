<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicesOrder extends Model {
	
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'services_orders';
    
     /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'id_client',
        'date',
        'address',
        'notes',
        'folio',
        'service_type',
        'status',
        'urgent',
        'latitude',
        'longitude',
        'id_courier',
        'created_at',
        'updated_at'
    ];
    
    # @param($status) integer (1.- Pendiente de asignar, 2.- Programado, 3.- En curso,4.- Completado, 5.- Cancelado, 6.- Borrado)
    # @param($service_type) integer (1:entrega, 2:recolección, 3:mixto)
    
	/**
	* Get the client of the service.
	*/
    public function client() {
        return $this->hasOne('App\User','id', 'id_client');
    }
    
    
    /**
	* Get the client of the service.
	*/
    public function courier() {
        return $this->hasOne('App\User','id', 'id_courier');
    }
}

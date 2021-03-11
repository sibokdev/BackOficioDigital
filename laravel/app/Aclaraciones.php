<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aclaraciones extends Model
{
    protected $table = 'clarifications';

    public $primaryKey  = 'folio';

    protected $fillable=[
        'folio',
        'client_id',
        'clarification_type',
        'content',
        'solution_type',
        'description_solution',
        'status',
        'created_at',
        'updated_at'
    ];
    # @param($status) integer (1.- Pendiente, 2.- Aclarado, 3.- Cancelado)
    # @param($clarification_type) integer (1.- Cobro excesivo, 2.- Servicios no reconocidos, 3.- Cuentas de usuario)
    # @param($solution_type) integer (1.- A favor del cliente(procedente), 2.- Inprocedente, 3.- Aclarado(no monetario), 4.- Solicitud atendida)
}

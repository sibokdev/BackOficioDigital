<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $table = 'audits';

    protected $fillable=[
        'id',
        'client_id',
        'date',
        'status',
        'notes',
        'paid',
        'created_at',
        'updated_at'
    ];

    # @param($status) integer (0.- Pendiente, 1.- Auditado, 2.- Cancelado)
    # @param($paid) integer (0.- No pagado, 1.- Pagado)
}

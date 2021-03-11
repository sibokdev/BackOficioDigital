<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $table = 'payments';

    protected $fillable=[
        'id',
        'user_id',
        'date',
        'amount',
        'payment_method',
        'transaction_id',
        'description',
        'source_id',
        'order_id',
        'status',
        'type',
        'created_at',
        'updated_at',
        'start_date',
        'end_date'
    ];
    # @param($transaction_id) string (get from OpenPay)
    # @param($payment_method) integer (1.- Openpay, 2.-Paypal)
    # @param(status) integer (0.- Declinado, 1.- Pagado, 2.- Error en transacción)
    # @param($type) integer (0.- Pago Cuota Anual, 1.- Pago Servicios Urgente)
}

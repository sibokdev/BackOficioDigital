    <div class="modal-tittle">
        <label><strong>Datos de la tarjeta</strong></label>
    </div>

    <div class="modal-body">
        @foreach($payment_data as $payment)
            <div>
                <div><label><strong>Nombre del titular:</strong></label></div>
                <div>{{$payment -> titular_name}}</div>
            </div>
            <div>
                <div><label><strong>Numero de tarjeta:</strong></label></div>
                <div>{{$payment -> card_number}}</div>
            </div>
            <div>
                <div><label><strong>Fecha de expiracion:</strong></label></div>
                <div>{{$payment -> expiration}}</div>
            </div>
            <div>
                <div><label><strong>CVV:</strong></label></div>
                <div>{{$payment -> cvv}}</div>
            </div>
            <div>
                <div><label><strong>Codigo postal:</strong></label></div>
                <div>{{$payment -> postal_code}}</div>
            </div>

    </div>

    <div class="modal-footer">
        <a href="/charges/payment/{{$service_id}}"><button type="button" class="btn btn-success btn-default">Cobrar</button></a>
        @endforeach
        <button type="button" class="btn grey-salsa btn-outline btn-default" data-dismiss="modal">Cerrar</button>
    </div>

        <div class="modal-tittle">
            <label><strong>{{$name->name}} {{$name->first_name}} {{$name->last_name}}</strong></label>
        </div>
        <div class="modal-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tipo de servicio</th>
                        <th>Monto</th>
                        <th>Fecha de pago</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($orders as $key=>$value)
                    <tr>
                        <td>@if($value -> services_order_id == 1)
                                Entrega
                            @elseif($value -> services_order_id == 2)
                                Recoleccion
                            @elseif($value -> services_order_id == 3)
                                Mixto
                                @else
                                Cuota Anual
                            @endif
                        </td>
                        <td><i class="fa fa-usd"></i>{{$value -> amount}}</td>
                        <td>{{$value -> created_at}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn grey-salsa btn-outline btn-default" data-dismiss="modal">Cerrar</button>
        </div>


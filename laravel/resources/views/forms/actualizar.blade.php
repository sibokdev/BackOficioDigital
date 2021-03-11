<div class="form-group">
    {!!Form::label('NOMBRE:')!!}
    {!!Form::text('name',null,['class'=>'form-control','placeholder'=>'INGRESA EL NOMBRE','id'=>'name_actualizado'])!!}
</div>

<div class="form-group">
    {!!Form::label('CORREO:')!!}
    {!!Form::text('email',null,['class'=>'form-control','placeholder'=>'INGRESA EL EMAIL','id'=>'email_actualizado'])!!}
</div>


<div class="form-group">
    <label class="control-label col-md-3">ROL:</label>
    <div class="col-md-4">


        <select name="role" class="bs-select form-control" tabindex="-98" id="role_actualizado">
            <option value="1">Administrador</option>
            <option value="2">Super Administrador</option>
            <option value="4">Encargado de Boveda</option>
            <option value="5">Mensajero</option>
        </select>
    </div>
</div>
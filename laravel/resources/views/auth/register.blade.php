@extends('layouts.login')

@section('content')
    <!-- BEGIN REGISTRATION FORM -->
    {!! Form::open(array('method' => 'POST', 'url' => '/auth/register', 'class'=>"form-horizontal col-sm-offset-1 col-sm-10")) !!}
        <h3>Crear Cuenta</h3>

        @if($errors->has())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span><br>
                @endforeach
            </div>
        @endif

        <p class="hint">
            Agregar datos personales:
        </p>
        <div class="form-group">
            {!! Form::text($name = 'name', $value = old('name'), $attributes = array('class'=>"form-control", 'id'=>"name", 'placeholder'=>"Nombre (s)")) !!}
        </div>

        <div class="form-group">
            {!! Form::text($name = 'surname1', $value = old('surname1'), $attributes = array('class'=>"form-control", 'id'=>"surname1", 'placeholder'=>"Apellido Paterno")) !!}
        </div>

        <div class="form-group">
            {!! Form::text($name = 'surname2', $value = old('surname2'), $attributes = array('class'=>"form-control", 'id'=>"surname2", 'placeholder'=>"Apellido Materno")) !!}
        </div>
        
        <div class="form-group">
            {!! Form::email($name = 'email', $value = old('email'), $attributes = array('class'=>"form-control", 'id'=>"email", 'placeholder'=>"Correo Electronico")) !!}
        </div>

        <div class="form-group">
            <input type="password" class="form-control" name="password" id="password" placeholder="Clave de Acceso">
        </div>

        <div class="form-group">
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirmar Clave de Acceso">
        </div>

        <!-- <p class="hint">
            Agregar datos de la empresa:
        </p>
        <div class="form-group">
            {!! Form::text($name = 'trade_name', $value = old('trade_name'), $attributes = array('class'=>"form-control", 'id'=>"trade_name", 'placeholder'=>"Nombre de la empresa")) !!}
        </div>

        <div class="form-group">
            {!! Form::text($name = 'rfc', $value = old('rfc'), $attributes = array('class'=>"form-control", 'id'=>"rfc", 'placeholder'=>"Registro Federal de Contribuyentes")) !!}
        </div>

        <div class="form-group">
            {!! Form::text($name = 'phone', $value = old('phone'), $attributes = array('class'=>"form-control", 'id'=>"phone", 'placeholder'=>"Telefono")) !!}
        </div> -->

        <div class="form-actions">
            <!-- {!! link_to('auth/login', "Ya soy usuario", array('class'=>'btn btn-default'), null) !!} -->
			{!! link_to('auth/login', "Ya soy usuario", array(''), null) !!}
            {!! Form::submit('Crear Cuenta', array('class'=>"btn btn-success uppercase pull-right")) !!}
        </div>
    {!! Form::close() !!}
    <!-- END REGISTRATION FORM -->
@stop

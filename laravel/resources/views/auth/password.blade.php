@extends('layouts.login')


@section('content')

    <!-- BEGIN FORGOT PASSWORD FORM -->
    {!! Form::open(array('method' => 'POST', 'url' => '/password/email')) !!}

    <h3>Olvido su clave?</h3>
    @if($errors->has())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <span>{{ $error }}</span><br>
            @endforeach
        </div>
    @endif
    <p>
        Teclee su email para recuperar su clave.
    </p>

    <div class="form-group">
        {!! Form::email($name = 'email', $value = old('email'), $attributes = array('class'=>"form-control", 'id'=>"email", 'placeholder'=>"Correo Electronico")) !!}
    </div>

    <div class="form-actions">
        {{--<button type="button" id="back-btn" class="btn btn-default">Back</button>--}}
        {!! link_to('auth/login', "Iniciar Sesion", array('class' => "btn btn-default"), null) !!}
        {{--<button type="submit" class="btn btn-success uppercase pull-right">Submit</button>--}}
        {!! Form::submit('Recuperar Clave', array('class'=>"btn btn-success uppercase pull-right")) !!}
    </div>
    {!! Form::close() !!}
    <!-- END FORGOT PASSWORD FORM -->

@stop

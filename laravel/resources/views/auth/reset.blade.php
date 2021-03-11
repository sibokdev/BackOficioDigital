@extends('layouts.login')


@section('content')


    {!! Form::open(array('method' => 'POST', 'url' => '/password/reset')) !!}


        <h3>Reset password</h3>
        <input type="hidden" name="token" value="{{ $token }}">
        @if($errors->has())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span><br>
                @endforeach
            </div>
        @endif

        <div class="form-group">
            {!! Form::email($name = 'email', $value = old('email'), $attributes = array('class'=>"form-control", 'id'=>"email", 'placeholder'=>"Email")) !!}
        </div>

        <div class="form-group">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>

        <div class="form-group">
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm Password">
        </div>

        <div class="form-group">
            {!! Form::submit('Reset Password', array('class'=>"btn btn-success uppercase pull-right")) !!}
        </div>

    {!! Form::close() !!}

@stop
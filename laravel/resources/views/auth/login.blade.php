@extends('layouts.login')

@section('content')

<!-- BEGIN : LOGIN PAGE 5-1 -->
<div class="user-login-5">
	<div class="row bs-reset">
		<div class="col-md-6 bs-reset mt-login-5-bsfix">
			<div class="login-bg" style="background-image:url(../assets/pages/img/login/bg1.jpg)"></div>
		</div>
		<div class="col-md-6 login-container bs-reset mt-login-5-bsfix">
			<div class="login-content">
					<img class="login-logo" src="../assets/pages/img/login/logo.png" width="180" height="180"/><br><br>
				@include('alerts.error')
				@if($errors->has())
					@foreach ($errors->all() as $error)
						<div class="alert alert-danger">
							<div class="col-md-11">
								<span style="float: left;">*{{ $error }}</span><br>
							</div>
							<div class="col-md-1">
								<button type="button" class="close" data-dismiss="alert" aria-label="close">
									<span aria-hidden="true"> &times; </span></button><br>
							</div><br>
						</div><br><br><br>
					@endforeach
				@endif
				<h1>Boveda de Documentos</h1>
				<p> Para iniciar sesion proporcione sus credenciales de acceso. Para recuperar su clave use el link de "Recuperar Clave" </p>
				<form action="../auth/loginForm"  method="post">
				{!! csrf_field() !!}
					<div class="row">
						<div class="col-xs-6">
							<input class="form-control form-control-solid placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
						<div class="col-xs-6">
							<input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="Password" name="password" /> </div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<div class="rem-password">
								<label class="rememberme mt-checkbox mt-checkbox-outline">
									<input type="checkbox" name="remember" value="1" /> Recordar mis datos
									<span></span>
								</label>
							</div>
						</div>
						<div class="col-sm-8 text-right">
							<div class="forgot-password">
								<a href="javascript:;" id="forget-password" class="forget-password">Recuperar Clave?</a>
							</div>
							<button class="btn green" type="submit">Iniciar</button>
						</div>
					</div>
				</form>
				<!-- BEGIN FORGOT PASSWORD FORM -->
				<form class="forget-form" action="javascript:;" method="post">
					<h3 class="font-green">Olvido su Clave ?</h3>
					<p> Proporcione su correo electrónico para recuperar su clave. </p>
					<div class="form-group">
						<input class="form-control placeholder-no-fix form-group" type="text" autocomplete="off" placeholder="Correo Electrónico" name="email" /> </div>
					<div class="form-actions">
						<button type="button" id="back-btn" class="btn green btn-outline">Regresar</button>
						<button type="submit" class="btn btn-success uppercase pull-right">Enviar</button>
					</div>
				</form>
				<!-- END FORGOT PASSWORD FORM -->
			</div>
			<div class="login-footer">
				<div class="row bs-reset">
					<div class="col-xs-5 bs-reset">
						<ul class="login-social">
							<li>
								<a href="javascript:;">
									<i class="icon-social-facebook"></i>
								</a>
							</li>
							<li>
								<a href="javascript:;">
									<i class="icon-social-twitter"></i>
								</a>
							</li>
							<li>
								<a href="javascript:;">
									<i class="icon-social-dribbble"></i>
								</a>
							</li>
						</ul>
					</div>
					<div class="col-xs-7 bs-reset">
						<div class="login-copyright text-right">
							<p>Boveda de Documentos &copy; 2016</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END : LOGIN PAGE 5-1 -->
@stop

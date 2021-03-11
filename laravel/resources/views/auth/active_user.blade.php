@extends('layouts.login')

@section('content')

<!-- BEGIN : LOGIN PAGE 5-1 -->
<div class="user-login-5">
	<div class="row bs-reset">
		<div class="col-md-6 bs-reset mt-login-5-bsfix">
			<div class="login-bg">
				<img src="/assets/pages/img/login/bg1.jpg" style="width:100%; height:100%;">
			</div>
		</div>
		<div class="col-md-6 login-container bs-reset mt-login-5-bsfix">
			<div class="login-content">
					<img class="login-logo" src="/assets/pages/img/login/logo.png" width="180" height="180"/><br><br>
				@include('alerts.error')
				
				@if(isset($error))
					<div class="alert alert-danger">
						<div class="col-md-11">
							<span style="float: left;">*{{ $error }}</span><br>
						</div>
						<div class="col-md-1">
							<button type="button" class="close" data-dismiss="alert" aria-label="close">
								<span aria-hidden="true"> &times; </span></button><br>
						</div><br>
					</div><br><br><br>
				@endif
				
				<h1>Boveda de Documentos</h1>
				
				@if(isset($active))
					<div class="success alert-success">
						<p style="color:#635E5E;">Tu cuenta ha sido activada correctamente, ingresa a la aplicación móvil para iniciar sesión.</p>
					</div>
				@endif
			</div>
		</div>
	</div>
</div>
<!-- END : LOGIN PAGE 5-1 -->
@stop

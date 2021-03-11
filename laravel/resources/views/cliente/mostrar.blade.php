@extends('layouts.client')

@section('content')
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEAD -->
			<div class="page-head div-content-top-title">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1><a href="/">Inicio</a> <small>Administracion de Clientes</small></h1>
				</div>
				<!-- END PAGE TITLE -->
				<!-- END PAGE TOOLBAR -->
			</div>
			<!-- END PAGE HEAD -->
			<!-- BEGIN PAGE CONTENT INNER -->

            <!-- BEGIN Alerts Section -->
            @include('alerts.success')
            @include('alerts.error')
            <!-- END Alerts Section -->

			<!-- Comienza la tabla de clientes -->
			<div class="portlet light portlet-fit ">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-user"></i>
						<span class="caption-subject sbold uppercase">Administracion de Clientes</span>
					</div>
				</div>
				<div class="portlet-body">
					<div>
						<table class="table table-hover table-bordered" id="clients_table">
							<thead>
								<tr class="uppercase">
									<th>Estatus</th>
									<th>Nombre</th>
									<th>Correo</th>
									<th>Genero</th>
									<th>Telefono</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Termina la tabla de clientes -->
			<!-- Modals -->
			<div class="modal fade" id="client-data" tabindex="-1" role="basic" aria-hidden="false" style="display: block;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title"><strong>Datos del cliente</strong></h4>
				</div>
				<div class="modal-body">
					<table class="table table-hover table-light ">
						<tbody>
						<tr>
							<td><strong>Nombre:</strong></td>
							<td><span class="client-name"></span></td>
						</tr>
						<tr>
							<td><strong>Correo:</strong></td>
							<td><span class="client-email"></span></td>
						</tr>
						<tr>
							<td><strong>Genero</strong></td>
							<td><span class="client-gender"></span></td>
						</tr>
						<tr>
							<td><strong>Telefono</strong></td>
							<td><span class="client-phone"></span></td>
						</tr>
						<tr>
							<td><strong>Estatus</strong></td>
							<td><span class="client-status"></span></td>
						</tr>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
			<!-- Modals -->
			<!-- END PAGE CONTENT INNER -->
		</div>
	</div>
	<!-- END CONTENT -->
@endsection
@section('scripts')
			<script>
				jQuery(document).ready(function() {
					var $tableLogbook=$('#clients_table'), tLoogbook;
					tLoogbook = Components.table(
							$tableLogbook,
							[{}, {} , {}, {}, {}],
							'/cliente/mostrar/ajaxClientDataTable',
							function (row, data, rowIndex) {
							},
							true,
							true,
							function(){
								client_data();
							}
					);
					tLoogbook;
				});

			</script>
@endsection
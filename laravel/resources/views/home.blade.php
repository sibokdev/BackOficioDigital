@extends('layouts.home')

@section('content')
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEAD -->
			<div class="page-head div-content-top-title">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1><a href="/">Inicio</a> <small>Servicios Pendientes de Asignacion</small></h1>
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

			<!-- Comienza la tabla de servicios -->
			<div class="portlet light portlet-fit ">
				<div class="portlet-title">
					<div class="caption">
						<i class="icon-home"></i>
						<span class="caption-subject sbold uppercase">Servicios Pendientes de Asignacion</span>
					</div>
					<div class="actions">
						<div class="btn-group btn-group-devided" data-toggle="buttons">
							<a class="aggregate_service_token btn red btn-outline sbold" data-token="{{csrf_token()}}" data-target="#aggregate-service" data-toggle="modal"> Agregar un Servicio <i class="glyphicon glyphicon-earphone"></i></a>
						</div>
					</div>
				</div>

				<div>
					<table class="table table-hover table-bordered" id="services_orders">
						<thead>
							<tr class="uppercase">
								<th> Cliente </th>
								<th> Tipo de Servicio</th>
								<th> Hora </th>
								<th> Direccion</th>
								<th> Acciones</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
			<!-- Termina la tabla de servicios -->
			</div>
		</div>
	</div>


	<!-- Modal Section -->

    <!--<div class="modal fade" id="ajax" role="basic" aria-hidden="true">
            <div class="modal-content">
                <div class="modal-body">
					<img src="/assets/metronic/global/img/loading-spinner-grey.gif" alt="" class="loading">
                    <span> &nbsp;&nbsp;Loading... </span>
                </div>
            </div>
    </div>-->

<div class="modal fade" id="ajax" role="basic" aria-hidden="true">
	<div class="modal-content">
		<div class="modal-body">
			<table class=" table table-bordered">
				<thead>
				<tr>
					<th>Mensajero</th>
					<th class="text-center">Servicios Asignados</th>
				</tr>
				</thead>
				<tbody>
				@foreach($users as $user)
					<tr>

						<td><a class="mensajero_id" data-id="{{$user->id}}"> {{$user -> name}}</a></td>
						<td class="text-center">
							{{$user -> ordenes}}
						</td>

					</tr>
				@endforeach
				</tbody>
			</table>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn grey-salsa btn-outline btn-default" data-dismiss="modal">Cerrar</button>
		</div>

	</div>
</div>


	<div class="modal fade" id="aggregate-service" tabindex="-1" role="basic" aria-hidden="false" style="display: block;">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Agregar Servicio</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<table class="table table-bordered">
				<!--<div class="portlet-body">-->
							{!! Form::open(['url'=>'/home/createService','method'=>'POST']) !!}
							<tbody>
							<tr>
								<td><label class="control-label"><strong>Nombre:</strong></label></td>
								<td><div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-user"></i>
										</span>
										<span class="twitter-typeahead" style="position: relative; display: inline-block;">
											<input type="text" class="form-control tt-hint" readonly="" autocomplete="off" spellcheck="false" tabindex="-1" dir="ltr" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: none 0% 0% / auto repeat scroll padding-box border-box rgb(255, 255, 255);">
											<input type="text" id="search-clients-service" name="search-clients-service" class="search-client-service-cost form-control" autocomplete="off" style=" float: none; position: relative; vertical-align: top; background-color: transparent;">
											<pre class="tt-suggestion" aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: auto; text-transform: none;">
											</pre>
										</span>
									</div>
								</td>
							</tr>
							<tr>
								<td><strong>Cliente</strong></td>
								<td><label class="client-name-service"></label>
									<input class="service-client-id" type="hidden" id="service-client-id" name="service-client-id" >
								</td>
							</tr>
							<tr>
								<td><strong>Tipo de Servicio</strong></td>
								<td><select name="type-service" class="bs-select form-control" tabindex="-98" id="type-service">
										<option value="1">Entrega</option>
										<option value="2">Recoleccion</option>
										<option value="3">Mixto</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><strong>Fecha en que Desea el Servicio</strong></td>
								<td><div class="form-group">
											<div class="date-service input-group date form_datetime">
												<input name="date-service-selected" type="text" size="16" readonly="" class="form-control">
													<span class="input-group-btn">
													<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
													</span>
											</div>
									</div>

								</td>
							</tr>
							<tr>
								<td><strong>Direccion</strong></td>
								<td><!--<input type="text" id="address-service" name="address-service">-->
									<div class="col-md-4">
										<select class="form-control input-large select2me" name="selected-address" id="select_address" data-placeholder="Select...">
										</select>
									</div>
								</td>
							</tr>
							</tbody>
						</table>
					</div>
				   <div class="modal-footer">
					   {!! Form::submit('Guardar Orden de Servicio',['class'=>'btn btn-success btn-default'])!!}
					<button type="button" class="btn grey-salsa btn-outline btn-default" data-dismiss="modal">Cerrar</button>
					{!! Form::close() !!}
					 </div>
				<!--</div>-->
			</div>
		</div>
	</div>

<div id="edit-service-modal" class="modal fade modal-lg"  tabindex="-1"  style="display:block;">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title">Editar servicio</h4>
		</div>
		<div class="modal-body" >
			<div class="portlet-body">
				<div class="table-scrollable">
					<table class="table table-bordered">
							<tbody>
							<tr>
								<td><strong>Cliente:</strong></td>
								{!! Form::open(['url'=>'/home/editService','method'=>'POST']) !!}
								<td><label class="edit-service-client-name"></label>
									<input type="hidden" class="edit-service-id" name="edit-service-id"></td>
							</tr>
							<tr>
								<td><strong>Tipo de Servico:</strong></td>
								<td><label class="edit-service-type"></label></td>
							</tr>
							<tr>
								<td><strong>Hora:</strong></td>
								<td><div class="form-group">
										<div class="date-service input-group date form_datetime">
											<input name="edit-service-date" type="text" size="16" readonly="" class="edit-service-date form-control">
													<span class="input-group-btn">
													<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
													</span>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td><strong>Direccion:</strong></td>
								<td><select class="form-control input-large select2me" name="edit-service-address" id="edit_address" data-placeholder="Select...">
									</select>
									</td>
							</tr>
							</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			{!! Form::submit('Guardar Cambios',['class'=>'btn btn-success btn-default']) !!}
			<button type="button" data-dismiss="modal" class="btn grey-salsa btn-outline btn-default">Cerrar</button>
			{!! Form::close() !!}
		</div>
	</div>
</div>

	<!-- END Modal Section -->

@endsection

@section('scripts')
	<script>
		var asignar_id;

		function asignar(id) {
			asignar_id = id;
		}

		jQuery(document).ready(function() {
            var $tableLogbook=$('#services_orders'), tLoogbook;
			tLoogbook = Components.table(
				$tableLogbook,
				[{}, {} , {}, {}, {"orderable":false}],
				'/home/ajaxDataTable',
				function (row, data, rowIndex) {},
				true,
				true,
					function(){
						var edit=$('.edit-service'),id,id_field=$('.edit-service-id');

						edit.on("click",function(){
							id=$(this).data('service_id');
							id_field.val(id);
					});
				}
			);
			tLoogbook;



		});
	</script>
@endsection

@extends('layouts.clarification')

@section('content')
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEAD -->
			<div class="page-head div-content-top-title">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1><a href="/">Inicio</a> <small>Administracion de Aclaraciones</small></h1>
				</div>
				<!-- END PAGE TITLE -->
			</div>
			<!-- END PAGE HEAD -->
			<!-- BEGIN PAGE CONTENT INNER -->

            <!-- BEGIN Alerts Section -->
            @include('alerts.success')
            @include('alerts.error')
            <!-- END Alerts Section -->
			<div class="portlet light portlet-fit ">
				<div class="portlet-title">
					<div class="caption">
						<i class="glyphicon glyphicon-pushpin"></i>
						<span class="caption-subject sbold uppercase">Aclaraciones</span>
					</div>
					<div class="actions">
						<div class="btn-group btn-group-devided" data-toggle="buttons">
							<a class="modal_button btn red btn-outline sbold" data-target="#clarifications-done" data-toggle="modal">Historial de Aclaraciones </a>
						</div>
					</div>
				</div>
		<!-- Comienza la tabla de servicios -->
		<div class="portlet-body">
                <table class=" table table table-striped table-hover table-bordered " id="clarifications_table">
                    <thead>
                    <tr class="uppercase">
                        <th>Folio</th>
                        <th>Cliente</th>
                        <th>Tipo de Aclaracion</th>
                        <th>Tipo de Solución</th>
                        <th>Descripción de Solución</th>
                        <th>Status</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>

					</tbody>
                </table>
            </div>
        </div>
    </div>

			<div class="modal fade modal-lg modal container" id="aclarado" tabindex="-1" role="basic" aria-hidden="false" style="display: block;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Aclaracion </h4>
				</div>
				<div class="modal-body">
					<input class="folio-modal" type="hidden" name="folio-modal" id="folio-modal">
					<div class="aclaracion-text">
					</div>
				</div>
				<div class="modal-footer">
					<a class="solution-modal btn btn-success btn-default" data-target="#solution"  data-toggle="modal">Solucionar</a>
					<button type="button" class="btn grey-salsa btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>

		<div class="modal fade modal-lg modal container" id="solution" tabindex="-1" role="basic" aria-hidden="true" style="display: block; padding-right: 17px;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title"> Solucion </h4>
			</div>
		    <div class="modal-body">
				{!! Form::open(['url'=>'/aclaraciones/aclaraciones/solution','method'=>'PUT']) !!}
				<input class="id-field" name="folio" type="hidden" id="id_aclaracion">
				<table>
					<tbody>
					<tr>
						<td><label><strong>TIPO DE SOLUCION</strong></label></td>
						<td><select class="solution-type bs-select form-control btn-circle btn-primary " name="solution-type" >
								<option value=1>A favor del cliente(Procedente)</option>
								<option value=2>Inprocedente</option>
								<option value=3>Aclarado(No monetario)</option>
								<option value=4>Solicitud atendida</option>
							</select>
						</td>
					</tr>
					</tbody>
				</table>
				<br><br><br>
					<table>
						<tbody>
						<tr>
							<td><label><strong>Descripcion de la Solucion</strong></label></td>
							<td width="95%"><textarea name="solution-description" data-provide="markdown" rows="10"></textarea></td>
						</tr>
						</tbody>
					</table>

			</div>
			<br><br>
			<div class="modal-footer">
				<br>
				{!! Form::submit('Guardar',['class'=>'btn-success btn-default']) !!}
				<button type="button" class="btn grey-salsa btn-default" data-dismiss="modal"> Cerrar </button>
				{!! Form::close() !!}
			</div>
		</div>
		<div class="modal fade modal container" id="clarifications-done" tabindex="-1" role="basic" aria-hidden="false" style="display: block;">
				<div class="modal-body">
					<div class="portlet light portlet-fit ">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-settings"></i>
								<span class="caption-subject sbold uppercase">Historial de Aclaraciones</span>
							</div>
						</div>
						<div class="portlet-body">
							<div>
								<table class="table table-bordered " id="historical_table">
									<thead>
									<tr class="uppercase">
										<th>Folio</th>
										<th>Cliente</th>
										<th>Tipo de Aclaracion</th>
										<th>Tipo de Solucion</th>
										<th>Estatus</th>
									</tr>
									</thead>
									<tbody>

									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn grey-salsa btn-default " data-dismiss="modal">Cerrar</button>
				</div>
			</div>

			<div class="modal fade modal-lg modal container" id="clarifications-full" tabindex="-1" role="basic" aria-hidden="false" style="display: block; height: 80%;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Aclaracion </h4>
				</div>
				<div class="modal-body">
					<table class="table table-hover table-light ">
						<thead>
						<tr class="uppercase">
							<th >
								<div><strong class="col-client" style=""></strong></div>
							</th>
						</tr>
						</thead>
						<tbody>
						<tr><td><strong>Folio:</strong></td>
							<td><span class="col-folio"></span></td>
							<td><strong>Nombre:</strong></td>
							<td><span class="col-client"></span></td>
							<td><strong>Estatus de la Aclaracion:</strong></td>
							<td><span class="col-status"></span></td>
						</tr>
						</tbody>
						</table>
					<table class="table table-hover table-light ">
						<tbody>
						<tr><td><strong>Tipo de Aclaracion:</strong></td>
							<td><span class="col-clarification-type"></span></td>
							<td><strong>Fecha de Aclaracion:</strong></td>
							<td><span class="col-created"></span></td>
						</tr>
						</tbody>
						</table>
					<table class="table table-hover table-light ">
						<tbody>
						<tr>
							<td><strong>Aclaracion:</strong></td>
							<td><span class="col-clarification-content"></span></td>
						</tr>
						</tbody>
						</table>
					<table class="table table-hover table-light ">
						<tbody>
						<tr>
							<td><strong>Tipo de Solucion:</strong></td>
							<td><span class="col-solution-type"></span></td>
							<td><strong>Fecha de Solucion:</strong></td>
							<td><span class="col-updated"></span></td>
						</tr>
						</tbody>
						</table>
					<table class="table table-hover table-light ">
						<tbody>
						<tr>
							<td><strong class="title" style="">Descripcion de la Solucion:</strong></td>
							<td><span class="col-solution-description"></span></td>
						</tr>
						</tbody>
					</table>
				 </div>
				<div class="modal-footer">
					<button type="button" class="btn grey-salsa btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
			<!-- Modals -->
			<!-- END PAGE CONTENT INNER -->
		</div>
	<!-- END CONTENT -->
@endsection

@section('scripts')
	<script>

	function solucion(id){
		$("#id_aclaracion").val(id);
	}
		jQuery(document).ready(function() {
			var $tableLogbook=$('#clarifications_table'), tLoogbook, modalTable, historicalTable=$('#historical_table');
			tLoogbook = Components.table(
					$tableLogbook,
					[{}, {} , {}, {}, {}, {}, {}, {orderable:false}],
					'/aclaraciones/aclaraciones/ajaxMainDataTable',
					function (row, data, rowIndex) {
					},
					true,
					true
			);
			modalTable = Components.table(
					historicalTable,
										[{}, {} , {}, {}, {}],
					'/aclaraciones/aclaraciones/ajaxDataTable',
					function (row, data, rowIndex) {
					},
					true,
					true,
					function(){
						//script historial de aclaraciones.
						$( ".clarifications-full" ).on( "click", function() {
							//Values Clarification full
							var folio= $(this).data("folio"), client=$(this).data('name'), clarification_type=$(this).data('clarification_type'),
									solution_type=$(this).data('solution_type'), content=$(this).data('content'), clarification_date=$(this).data("clarification_date"),
									solution_description=$(this).data("content_solution"), solution_date=$(this).data("solution_date"), status=$(this).data("status");
							//fields clarification full
							var folio_field=$('.col-folio'),client_field=$(".col-client"),clarification_type_field=$(".col-clarification-type"),
									solution_type_field=$(".col-solution-type"),content_field=$(".col-clarification-content"), clarification_date_field=$(".col-created"),
									solution_description_field=$(".col-solution-description"), solution_date_field=$(".col-updated"), status_field=$(".col-status");

							folio_field.html(folio);
							client_field.html(client);

							clarification_type_field.html(clarification_type);
							content_field.html(content);
							clarification_date_field.html(clarification_date);

							solution_type_field.html(solution_type);
							solution_description_field.html(solution_description);
							solution_date_field.html(solution_date);

							status_field.html(status);
						});
						//End script of Historial de Aclaraciones
					}
			);

			$('.modal_button').on("click",function(){
				modalTable;
			});

			tLoogbook;
		});

	</script>
@endsection
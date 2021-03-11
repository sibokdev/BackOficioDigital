@extends('layouts.audit')

@section('content')
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEAD -->
			<div class="page-head div-content-top-title">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1><a href="/">Inicio</a> <small>Administracion de Auditorias</small></h1>
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
						<i class="glyphicon glyphicon-briefcase"></i>
						<span class="caption-subject sbold uppercase">Auditorias</span>
					</div>
					<div class="actions">
						<div class="btn-group btn-group-devided" data-toggle="buttons">
							<a class="modal_button btn red btn-outline sbold" data-target="#clarifications-done" data-toggle="modal">Historial Auditorias </a>
						</div>
					</div>
				</div>
		<!-- Comienza la tabla de auditorias -->
		<div class="portlet-body">
                <table class=" table table table-striped table-hover table-bordered " id="audits_table">
                    <thead>
                    <tr class="uppercase">
                        <th>Folio</th>
                        <th>Cliente</th>
                        <th>Status</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    	<tr>
	                        
	                    </tr>
					</tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade modal-lg modal container" id="auditar" tabindex="-1" role="basic" aria-hidden="true" style="display: block; padding-right: 17px;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title"> ¿Desea auditar? </h4>
			</div>
		    <div class="modal-footer">
				{!! Form::open(['url'=>'/auditorias/auditorias/auditar','method'=>'PUT']) !!}
				<input class="id-field" name="id" type="hidden" id="id_auditoria">
				<br>
				{!! Form::submit('Auditar',['class'=>'btn btn-success btn-default']) !!}
				<button type="button" class="btn grey-salsa btn-default" data-dismiss="modal"> Salir </button>
				{!! Form::close() !!}
			</div>
		</div>

		<div class="modal fade modal container" id="clarifications-done" tabindex="-1" role="basic" aria-hidden="false" style="display: block;">
				<div class="modal-body">
					<div class="portlet light portlet-fit ">
						<div class="portlet-title">
							<div class="caption">
								<i class="icon-settings"></i>
								<span class="caption-subject sbold uppercase">Historial de Auditorias</span>
							</div>
						</div>
						<div class="portlet-body">
							<div>
								<table class="table table-bordered " id="historical_table">
									<thead>
									<tr class="uppercase">
										<th>Folio</th>
				                        <th>Cliente</th>
				                        <th>Status</th>
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

			<!-- Modals -->
			<!-- END PAGE CONTENT INNER -->
		</div>
	<!-- END CONTENT -->
@endsection

@section('scripts')
	<script>
	function auditar(id){
		$("#id_auditoria").val(id);
	}
		jQuery(document).ready(function() {


			var $tableLogbook=$('#audits_table'), tLoogbook, modalTable, historicalTable=$('#historical_table');
			tLoogbook = Components.table(
					$tableLogbook,
					[{}, {} , {}, {}, {orderable:false}],
					'/auditorias/auditorias/ajaxMainDataTable',
					function (row, data, rowIndex) {
					},
					true,
					true
			);
			modalTable = Components.table(
					historicalTable,
					[{}, {} , {}],
					'/auditorias/auditorias/ajaxDataTable',
					function (row, data, rowIndex) {
					},
					true,
					true
			);
			
		});

	</script>
@endsection
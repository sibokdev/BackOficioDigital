@extends('layouts.documents')

@section('content')
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEAD -->
			<div class="page-head div-content-top-title">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1><a href="/">Inicio </a> <small>Control de Entrada y Salida de Documentos</small></h1>
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
						<i class="glyphicon glyphicon-barcode"></i>
						<span class="caption-subject sbold uppercase">Control de Entrada y Salida de Documentos</span>
					</div>
					<div class="actions">
						<div class="btn-group btn-group-devided" data-toggle="buttons">
							<a class="btn red btn-outline sbold" data-toggle="modal" href="#historial"> Ver Historial de Documentos al Dia</a>
						</div>
					</div>
				</div>

				<div class="document-reader-input" style="width:80%;">
					{!! Form::open(['url'=>'/documentos/control','method'=>'POST','accept-charset'=>'UTF-8']) !!}
					   <div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">
                        		<i class="fa fa-barcode"></i>
                        	</span>
							{!! Form::text('code',null,['class'=>'form-control','placeholder'=>'Scan Barcode','style'=>'height: 50px;']) !!}
						</div>
						   <br>
						{!! Form::submit('Guardar Codigo',['class'=>'btn btn-lg default btn-block green-meadow']) !!}
					   </div>
					{!! Form::close() !!}
				</div>
			</div>
			<!-- Termina la tabla de servicios -->
		</div>
	</div>

	<!-- Begin Modal Section -->	
	
    <div class="modal fade modal container" id="historial" tabindex="-1" role="dialog" aria-hidden="true" style="display: block; ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Historial de Entradas/Salidas de Documentos</h4>
                </div>
                <div class="modal-body"> 
    					<table class=" table table-bordered" id="historical_day">
    						<thead>
    							<tr class="uppercase">
    								<th>Documento</th>
									<th>Ubicación</th>
									<th>Fecha</th>
									<th>Cliente</th>
    							</tr>
    						</thead>
							<tbody>

							</tbody>
    					</table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cerrar</button>
                </div>
    </div>

	<!-- End Modal Section -->
	
@endsection


@section('scripts')
	<script>
		jQuery(document).ready(function() {
			var $tableLogbook=$('#historical_day'), tLoogbook;
			tLoogbook = Components.table(
					$tableLogbook,
					[{}, {} , {}, {}],
					'/documentos/historicalDayAjaxDataTable',
					function (row, data, rowIndex) {
					},
					true,
					true
			);
			tLoogbook;
		});

	</script>
@endsection

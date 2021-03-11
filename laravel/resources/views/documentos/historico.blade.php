@extends('layouts.documents')

@section('content')
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEAD -->
			<div class="page-head div-content-top-title">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1><a href="/">Inicio </a> <small>Historico de Documentos</small></h1>
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
						<i class="icon-notebook"></i>
						<span class="caption-subject sbold uppercase">Historico de Documentos</span>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<div class="portlet light">
							<div class="portlet-body">
								<table class="table table-striped table-hover table-bordered"  id="historical_day">
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
						</div>
						<!-- END EXAMPLE TABLE PORTLET-->
					</div>
				</div>
			</div>
		</div>
	</div>

	
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


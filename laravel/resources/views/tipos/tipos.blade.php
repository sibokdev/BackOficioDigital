@extends('layouts.audit')

@section('content')
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEAD -->
			<div class="page-head div-content-top-title">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1><a href="/">Inicio</a> <small>Administracion de Tipo de Documentos</small></h1>
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
						<span class="caption-subject sbold uppercase">Tipo de documentos</span>
					</div>
					<div class="actions">
						<div class="btn-group btn-group-devided" data-toggle="buttons">
							<a class="modal_button btn red btn-outline sbold" data-target="#newtipo" data-toggle="modal">Nuevo tipo </a>
						</div>
					</div>
				</div>
		<!-- Comienza la tabla de auditorias -->
		<div class="portlet-body">
                <table class=" table table table-striped table-hover table-bordered " id="audits_table">
                    <thead>
                    <tr class="uppercase">
                        <th>ID</th>
                        <th>Tipo</th>
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

    <div class="modal fade modal-lg modal container" id="newtipo" tabindex="-1" role="basic" aria-hidden="true" style="display: block; padding-right: 17px;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title"> Nuevo tipo </h4>
		</div>
	    <div class="modal-body">
			{!! Form::open(['url'=>'/tipos/tipos/agregar','method'=>'POST']) !!}
			<table>
				<tbody>
				<tr>
					<td><label><strong>Tipo</strong></label></td>
					<td><input id="type-create" name="name" type="text" class="form-control" placeholder="Nombre del tipo">
					</td>
				</tr>
				</tbody>
			</table>

		</div>
		<br><br>
		<div class="modal-footer">
			<br>
			{!! Form::submit('Guardar',['class'=>'btn btn-success btn-default']) !!}
			<button type="button" class="btn grey-salsa btn-default" data-dismiss="modal"> Cerrar </button>
			{!! Form::close() !!}
		</div>
	</div>

	<div class="modal fade modal-lg modal container" id="edittipo" tabindex="-1" role="basic" aria-hidden="true" style="display: block; padding-right: 17px;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
			<h4 class="modal-title"> Nuevo tipo </h4>
		</div>
	    <div class="modal-body">
			{!! Form::open(['url'=>'/tipos/tipos/editar','method'=>'PUT']) !!}
			<input type="hidden" name="id" class="id form-control">
			<table>
				<tbody>
				<tr>
					<td><label><strong>Tipo</strong></label></td>
					<td><input type="text" name="name" class="name_edit form-control" placeholder="Nombre del tipo">	
					</td>
				</tr>
				</tbody>
			</table>

		</div>
		<br><br>
		<div class="modal-footer">
			<br>
			{!! Form::submit('Guardar',['class'=>'btn btn-success btn-default']) !!}
			<button type="button" class="btn grey-salsa btn-default" data-dismiss="modal"> Cerrar </button>
			{!! Form::close() !!}
		</div>
	</div>

	<div class="modal fade modal-lg modal container" id="borrartipo" tabindex="-1" role="basic" aria-hidden="true" style="display: block; padding-right: 17px;">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title"> ¿Desea eliminar este tipo? </h4> <h5>Se eliminaran los subtipos tambien</h5>
			</div>
		    <div class="modal-footer">
				{!! Form::open(['url'=>'/tipos/tipos/borrar','method'=>'DELETE']) !!}
				<input type="hidden" name="id" class="id form-control">
				<br>
				{!! Form::submit('Eliminar',['class'=>'btn btn-success btn-default']) !!}
				<button type="button" class="btn grey-salsa btn-default" data-dismiss="modal"> Salir </button>
				{!! Form::close() !!}
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
					[{}, {}, {orderable:false}],
					'/tipos/tipos/ajaxMainDataTable',
					function (row, data, rowIndex) {
					},
					true,
					true,
					function(){
						var edit=$('.modificar'),name,name_field=$('.name_edit'),id,id_field=$('.id'),id_field=$('.id');

						edit.on("click",function(){
							name=$(this).data('name');
							name_field.val(name);
							id=$(this).data('id');
							id_field.val(id);
						});

						var drop=$('.eliminar'),id,id_field=$('.id');

						drop.on("click",function(){

							id=$(this).data('id');
							id_field.val(id);

						});
					}
			);
			
		});

	</script>
@endsection
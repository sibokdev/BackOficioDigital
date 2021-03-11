@extends('layouts.empleados')

@section('content')
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEAD -->
			<div class="page-head div-content-top-title">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1><a href="/">Inicio</a> <small>Administracion de Empleados</small></h1>
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
						<i class="glyphicon glyphicon-pushpin"></i>
						<span class="caption-subject sbold uppercase">Administracion de Empleados</span>
					</div>
					<div class="actions">
						<div class="btn-group btn-group-devided" data-toggle="buttons">
							<a class="btn red btn-outline sbold" data-target="#stack1" data-toggle="modal"> Agregar Empleado </a>
						</div>
					</div>
				</div>
				<div class="portlet-body">
					<div>
						<table class="table table-hover table-bordered" id="employed_table">
							<thead>
								<tr class="uppercase">
									<th>Estatus</th>
									<th>Nombre</th>
									<th>Correo</th>
									<th>Rol</th>
									<th>Operacion</th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Termina la tabla de empleados -->
			<!-- Modals -->
			
			<div id="stack1" class="modal fade" tabindex="-1" style="display: block;">
				<div class="modal-content">
					<div class="modal-body">
						<h3><strong>Agregar Empleado</strong></h3>
						<div class="row">
							<div class="col-md-12">
								<div id="add_alerts"></div>
								<p >
								<input type="hidden" value="{{csrf_token()}}" id="token-create">
								@include('forms.user')
							</div>
						</div>
					</div>
					<div class="modal-footer">
						{!!Form::button('CREAR',['class'=>'employed_button btn btn-success'])!!}
						<button type="button"  class="close_button btn dark btn-outline">Cerrar</button>
					</div>
				</div>
			</div>
			
			<div id="stack2" class="modal fade" tabindex="-1"  role="form" style="display:block;">
				<div class="modal-content ">
					<div class="modal-header">
						<h3><strong>Modificar Empleado</strong></h3>
					<div class="modal-body">
						<div class="row">
    						<div class="col-md-12">
								{!! Form::open(['url'=>'/empleado/actualizar','method'=>'POST']) !!}
                                <div class="form-group">
                                    <label>Nombre</label>
                                    <div class="input-group">
                                		<span class="input-group-addon">
                                			<i class="fa fa-user"></i>
                                		</span>
                                		<input type="text" name="name" class="name_edit form-control" placeholder="Nombre">
									</div>
									<label>Primer Apellido</label>
									<div class="input-group">
                                		<span class="input-group-addon">
                                			<i class="fa fa-user"></i>
                                		</span>
										<input type="text" name="first-name" class="first_name_edit form-control" placeholder="Primer Apellido">
									</div>
									<label>Segundo Apellido</label>
									<div class="input-group">
                                		<span class="input-group-addon">
                                			<i class="fa fa-user"></i>
                                		</span>
										<input type="text" name="last-name" class="last_name_edit form-control" placeholder="Segundo Apellido">
									</div>
                                </div>
    						
                                <div class="form-group">
                                    <label>Correo Electronico</label>
                                    <div class="input-group">
                                		<span class="input-group-addon">
                                			<i class="fa fa-envelope"></i>
                                		</span>
                                	<input type="text" name="email" class="email_edit form-control" placeholder="Correo Electronico"> </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Rol</label>
                                    <select name="role" class="role_edit bs-select form-control" tabindex="-98">
                                        <option value="1">Administrador</option>
                                        <option value="2">Super Administrador</option>
                                        <option value="4">Encargado de Boveda</option>
                                        <option value="5">Mensajero</option>
                                    </select>
								</div>

    							
    							{!! Form::hidden('id',null,['class'=>'id_edit',]) !!}

						</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn green">Guardar Cambios</button>
						<button type="button" data-dismiss="modal" class="btn dark btn-outline">Close</button>
					</div>
					{!!Form::close()!!}
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
			var $tableLogbook=$('#employed_table'), tLoogbook;
			tLoogbook = Components.table(
					$tableLogbook,
					[{}, {}, {} , {}, {"orderable":false}],
					'/empleado/ajaxDataTable',
					function (row, data, rowIndex) {
					},
					true,
					true,
					function(){
						var edit=$('.modificar'),name, first_name, last_name,email,role,id,name_field=$('.name_edit'),
								first_name_field=$('.first_name_edit'), last_name_field=$('.last_name_edit'),email_field=$('.email_edit'),
								role_field=$('.role_edit'),id_field=$('.id_edit');

						edit.on("click",function(){
							name=$(this).data('name');
							first_name=$(this).data('first_name');
							last_name=$(this).data('last_name');
							email=$(this).data('email');
							role=$(this).data('role');
							id=$(this).data('id');
							console.log(name+first_name+last_name);
							name_field.val(name);
							first_name_field.val(first_name);
							last_name_field.val(last_name);
							email_field.val(email);
							role_field.val(role);
							id_field.val(id);
						});
					}
			);
			tLoogbook;


		});

	</script>
@endsection
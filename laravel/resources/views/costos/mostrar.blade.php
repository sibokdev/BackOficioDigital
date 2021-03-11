@extends('layouts.costos')

@section('content')
	<!-- BEGIN CONTENT -->
	<div class="page-content-wrapper">
		<div class="page-content">
			<!-- BEGIN PAGE HEAD -->
			<div class="page-head div-content-top-title">
				<!-- BEGIN PAGE TITLE -->
				<div class="page-title">
					<h1><a href="/">Inicio</a> <small>Administracion de Cuotas y Servicios</small></h1>
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

			<!-- BEGIN MENU COSTS -->
			@if((\Illuminate\Support\Facades\Auth::user()->id_role == 2) || (\Illuminate\Support\Facades\Auth::user()->id_role == 1))
	    	<div class="portlet-title tabbable-line up_margin">
				<ul class="nav nav-tabs">
					@if(\Illuminate\Support\Facades\Auth::user()->id_role == 2)
					<li class="active">
						<a href="#portlet_tab1" data-toggle="tab" aria-expanded="false">Cuota Anual</a>
					</li>
					@endif

					<li class="">
						<a href="#portlet_tab2" data-toggle="tab" aria-expanded="false"> Cuota Anual Personalizada </a>
					</li>

						@if(\Illuminate\Support\Facades\Auth::user()->id_role == 2)
					<li class="">
						<a href="#portlet_tab4" data-toggle="tab" aria-expanded="true"> Costo Servicio </a>
					</li>
						@endif

						<li class="">
							<a href="#portlet_tab3" data-toggle="tab" aria-expanded="false"> Costo Servicio Personalizado </a>
						</li>
				</ul>
			</div>
			@endif
			<!--END MENU COSTS -->

			@if((\Illuminate\Support\Facades\Auth::user()->id_role == 2) || (\Illuminate\Support\Facades\Auth::user()->id_role == 1))
			<div class="portlet-body">
				<div class="tab-content">
				<!--BEGIN TAB ANNUAL COST -->
				@if(\Illuminate\Support\Facades\Auth::user()->id_role == 2)
				<div class="tab-pane active" id="portlet_tab1">
					<div class="portlet light portlet-fit ">
						<div class="portlet-body">
							<div class="row">
								<table class="annual_quote_table table table table-hover table-bordered" id="sample_editable_1" id_profile="grid" aria-describedby="sample_editable_1_info">
									<thead>
										<tr role="row">
											<th class="sorting_asc" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1" aria-label=" Username : activate to sort column descending" style="width: 151px;" aria-sort="ascending">
												Cuota: </th>
											<th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1" aria-label=" Full Name : activate to sort column ascending" style="width: 170px;">
												Costo Actual: </th>
											<th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1" aria-label=" Full Name : activate to sort column ascending" style="width: 170px;">
												Acciones: </th>
										</tr>
									</thead>
									<tbody>
										@foreach($costs as $cost)
										<tr role="row" class="odd">
											<td class="sorting_1"><strong>Cuota Anual</strong></td>
											{!!Form::open(['url'=>'/costos/mostrar/updateAnnualCost','method'=>'POST'])!!}
											<td><i class="glyphicon glyphicon-usd"></i><input type="text" class="annual-cost" name="annual-cost" id="annual-cost" value={{number_format( $cost -> annual_cost ,2)}}></td>
											<td>{!! Form::submit('actualizar',['class'=>'btn btn-success btn-default']) !!}</td>
											{!!Form::close()!!}
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				@endif
				<!-- END TAB ANNUAL COST -->

				<!-- BEGIN TAB PERSONALIZED ANNUAL COST -->
				<div class="tab-pane" id="portlet_tab2">
					<!-- BEGIN TABLE PERSONALIZED ANNUAL COST -->
					<div class="portlet light portlet-fit ">
						<div class="portlet-body">
							<div>
								<div class="col-md-offset-9">
									<div class="btn-group btn-group-devided" data-toggle="buttons">
										<a class="aggregate_annual_quote_token btn red btn-outline sbold" data-target="#aggregate-annual-quote" data-token="{{csrf_token()}}" data-toggle="modal"> Agregar Cuota Anual Personalizada </a>
									</div>
									<br><br>
								</div>
								<table class="table table table-hover table-bordered" id="annual_table" id_profile="grid" aria-describedby="sample_editable_1_info">
									<thead>
										<tr class="uppercase">
											<th>Nombre</th>
											<th>Tipo Costo</th>
											<th>Costo</th>
											<th>Inicio de Promocion</th>
											<th>Fin de Promocion</th>
											<th>Operaciones</th>
										</tr>
									</thead>
									<tbody>

									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- END TABLE PERSONALIZED ANNUAL COST -->
				</div>
				<!-- END TAB PERSONALIZED ANNUAL COST -->

				<!-- BEGIN TAB SERVICE COST  -->
				@if(\Illuminate\Support\Facades\Auth::user()->id_role == 2)
					<div class="tab-pane" id="portlet_tab4">
						<!-- BEGIN TABLE SERVICE COST -->
					 	<div class="portlet light portlet-fit ">
							<div class="portlet-body">
								<div>
									<table class="service_cost_table table table table-hover table-bordered" id="sample_editable_1" id_profile="grid" aria-describedby="sample_editable_1_info">
										<thead>
											<tr role="row">
												<th class="sorting_asc" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1" aria-label=" Username : activate to sort column descending" style="width: 151px;" aria-sort="ascending">
													Servicio: </th>
												<th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1" aria-label=" Full Name : activate to sort column ascending" style="width: 170px;">
													Costo: </th>
												<th class="sorting" tabindex="0" aria-controls="sample_editable_1" rowspan="1" colspan="1" aria-label=" Full Name : activate to sort column ascending" style="width: 170px;">
													Acciones: </th>
											</tr>
										</thead>
										<tbody>
											@foreach($costs as $cost)
											<tr role="row" class="odd">
												<td class="sorting_1"><strong>Entrega</strong></td>
												{!!Form::open(['url'=>'/costos/mostrar/updateDeliveryCost','method'=>'POST'])!!}
												{!! Form::hidden('_token',csrf_token()) !!}
												<td><i class="glyphicon glyphicon-usd"></i><input type="text" class="delivery-cost" name="delivery-cost" id="delivery-cost" value={{number_format($cost -> delivery_cost,2)}}></td>
												<td>{!! Form::submit('actualizar',['class'=>'btn btn-success btn-default']) !!}</td>
												{!!Form::close()!!}
											</tr>
											<tr role="row" class="even">
												<td class="sorting_1"><strong>Recoleccion</strong></td>
												{!!Form::open(['url'=>'/costos/mostrar/updateReceptionCost','method'=>'POST'])!!}
												{!! Form::hidden('_token',csrf_token()) !!}
												<td><i class="glyphicon glyphicon-usd"></i><input type="text" class="reception-cost" name="reception-cost" id="reception-cost" value={{number_format($cost->reception_cost, 2)}}></td>
												<td>{!! Form::submit('actualizar',['class'=>'btn btn-success btn-default']) !!}</td>
												{!!Form::close()!!}

											</tr>
											<tr role="row" class="even">
												<td class="sorting_1"><strong>Mixto</strong></td>
												{!!Form::open(['url'=>'/costos/mostrar/updateMixedCost','method'=>'POST'])!!}
												{!! Form::hidden('_token',csrf_token()) !!}
												<td><i class="glyphicon glyphicon-usd"></i><input type="text" class="mixed-cost" name="mixed-cost" value={{number_format($cost->mixed_cost, 2)}}></td>
												<td>{!! Form::submit('actualizar',['class'=>'btn btn-success btn-default']) !!}</td>
												{!!Form::close()!!}

											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<!-- END TABLE SERVICES COST -->
					</div>
				@endif
						<!-- END TAB SERVICES COST-->

					<!-- BEGIN TAB PERSONALIZED SERVICES COST-->
					<div class="tab-pane" id="portlet_tab3">
						<!-- BEGIN TABLE PERSONALIZED SERVICES COST -->
						<div class="portlet light portlet-fit ">
							<div class="portlet-body">
								<div>
									<div class="col-md-offset-8">
										<div class="btn-group btn-group-devided" data-toggle="buttons">
											<a class="btn red btn-outline sbold" data-target="#aggregate-service-cost"  data-toggle="modal"> Agregar Costo  de Servicio Personalizado </a>
										</div>
									</div>
									<br><br>
									<table class="table table table-hover table-bordered" id="services_table" id_profile="grid" aria-describedby="sample_editable_1_info">
										<thead>
											<tr class="uppercase">
												<th>Nombre</th>
												<th>Tipo de Servicio</th>
												<th>Costo</th>
												<th>Comienzo de la Promocion</th>
												<th>Fin de la Promocion</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tbody>

										</tbody>
									</table>
								</div>
							</div>
						</div>
						<!-- END TABLE PERSONALIZED SERVICES COST -->
					</div>
					<!-- END TAB PERSONALIZED SERVICES COST-->
				</div>
			</div>
			@endif
		</div>
		<!-- BEGIN MODAL MODIFY ANNUAL COST-->
		<div id="modification-quota" class="modal fade" tabindex="-1"  id_profile="form" style="display:block;">
			<div class="modal-content ">
				<div class="modal-header">
					<h4 class="modal-title">Modificar Cuota Anual</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">

				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn grey-salsa btn-outline btn-default">Cerrar</button>
				</div>
			</div>
		</div>
		<!-- END MODIFY ANNUAL COST -->

		<!-- BEGIN MODAL MODIFY SERVICE COST -->
		<div id="modification-services" class="modal fade" tabindex="-1"  id_profile="form" style="display:block;">
			<div class="modal-content ">
				<div class="modal-header">
					<h4 class="modal-title">Modificar Costo de Servicios</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">

				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn grey-salsa btn-outline btn-default">Cerrar</button>
				</div>
			</div>
		</div>
		<!-- END MODAL MODIFY SERVICE COST -->

		<!--BEGIN MODAL MODIFY PERSONALIZED SERVICE COST-->
		<div id="aggregate-service-cost" class="modal fade" tabindex="-1"  id_profile="form" style="display:block;">
				<div class="modal-header">
					<h4 class="modal-title">Agregar Costo de Servicio Personalizado</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
						<table class="table table-bordered">
							<tbody>
							<tr>
								<td><label class="control-label"><strong>Nombre:</strong></label></td>
								<td><div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-user"></i>
										</span>
										<span class="twitter-typeahead" style="position: relative; display: inline-block;">
											<input type="text" class="form-control tt-hint" readonly="" autocomplete="off" spellcheck="false" tabindex="-1" dir="ltr" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: none 0% 0% / auto repeat scroll padding-box border-box rgb(255, 255, 255);">
											<input type="text" name="search-clients-service" class="search-client-service-cost form-control" autocomplete="off" style="position: relative; vertical-align: top; background-color: transparent;">
											<pre class="tt-suggestion" aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: auto; text-transform: none;">
											</pre>
										</span>
									</div>
								</td>
							</tr>
							<tr>
								<td><strong>Cliente</strong></td>
								<td><label class="client-name-service-cost-modal" ></label></td>
							</tr>
							<tr>{!! Form::open(['url'=>'/costos/mostrar/personalizedServiceCostModal']) !!}
								{!! Form::hidden('_token',csrf_token()) !!}
								<!-- <td><strong>Tipo de Servicio</strong></td>
								<td><select name="service-type-modal" class="client_type_service_cost_modal bs-select form-control" tabindex="-98" id="id_profile_actualizado">
										<option value="2">Entrega</option>
										<option value="3">Recoleccion</option>
										<option value="4">Mixto</option>
									</select>
								</td> -->
							</tr>
							<tr>
								<td><Strong>Costo</Strong></td>
								<td><i class="glyphicon glyphicon-usd"></i><input class="client_service_cost_modal" name="service-cost-modal" type="text">
									<input type="hidden" name="client-id-service-cost-modal" class="client-id-service-cost-modal">
								</td>
							</tr>
							<tr>
								<td><strong>Inicio de la Promocion</strong></td>
								<td><div class="form-group">
										<div class="calendar input-group date form_datetime">
											<input name="date-begin-service-cost-modal" type="text" size="16" readonly="" class="date_begin_service_cost_modal form-control">
											<span class="input-group-btn">
												<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
											</span>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td><strong>Fin de la Promocion</strong></td>
								<td><div class="form-group">
										<div class="calendar input-group date form_datetime">
											<input name="date-end-service-cost-modal" type="text" size="16" readonly="" class="date_end_service_cost_modal form-control">
											<span class="input-group-btn">
												<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
											</span>
										</div>
									</div>
								</td>
							</tr>
							</tbody>
						</table>
				</div>
				<div class="modal-footer">
					{!! Form::submit('Guardar',['class'=>'btn btn-success btn-default'])!!}
					<button type="button" class="btn grey-salsa btn-outline btn-default" data-dismiss="modal">Cerrar</button>
					{!!Form::close()!!}
				</div>

		</div>
		<!-- END MODAL MODIFY PERSONALIZED SERVICE COST -->

		<!-- BEGIN MODAL MODIFY PERSONALIZED ANNUAL COST -->
		 <div id="aggregate-annual-quote" class="modal fade" id_profile="dialog" aria-hidden="true" style="display: block; width: 500px">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Cuota Anual Personalizada</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<table class="table table-bordered">
							<tbody>
							<tr>
								<td><label class="control-label"><strong>Nombre:</strong></label></td>
								<td><div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-user"></i>
										</span>
										<span class="twitter-typeahead" style="position: relative; display: inline-block;">
											<input type="text" class="form-control tt-hint" readonly="" autocomplete="off" spellcheck="false" tabindex="-1" dir="ltr" style="position: absolute; top: 0px; left: 0px; border-color: transparent; box-shadow: none; opacity: 1; background: none 0% 0% / auto repeat scroll padding-box border-box rgb(255, 255, 255);">
											<input type="text" name="search-clients-annual-quote" id="search-clients-annual-quote" class="search-clients-annual-quote form-control" autocomplete="off" style="position: relative; vertical-align: top; background-color: transparent;">
											<pre class="tt-suggestion" aria-hidden="true" style="position: absolute; visibility: hidden; white-space: pre; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px; font-style: normal; font-variant-ligatures: normal; font-variant-caps: normal; font-weight: 400; word-spacing: 0px; letter-spacing: 0px; text-indent: 0px; text-rendering: auto; text-transform: none;">
											</pre>
										</span>
									</div>
								</td>
							</tr>
							<tr>
								<td><strong>Cliente</strong></td>
								<td><label class="client-name-annual-cost-modal"></label></td>
							</tr>
							<tr>
								<td><Strong>Cuota Anual</Strong></td>
								<td>{!!Form::open(['url'=>'/costos/mostrar/personalizedAnnualCostModal','method'=>'POST'])!!}
									{!! Form::hidden('_token',csrf_token()) !!}
									<input type="hidden" name="client-id-annual-cost-modal" class="client-id-annual-cost-modal">
									<i class="glyphicon glyphicon-usd"></i><input class="personalized-annual-cost-modal"  name="personalized-annual-cost-modal" type="text">
								</td>
							</tr>
							<tr>
								<td><strong>Inicio de la Promocion</strong></td>
								<td><div class="form-group">
										<div class="calendar input-group date form_datetime">
											<input name="date-begin-annual-cost-modal" type="text" size="16" readonly="" class="date-begin-annual-cost-modal form-control">
													<span class="input-group-btn">
													<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
													</span>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td><strong>Fin de la Promocion</strong></td>
								<td><div class="form-group">
										<div class="calendar input-group date form_datetime">
											<input name="date-end-annual-cost-modal" type="text" size="16" readonly="" class="date-end-annual-cost-modal form-control">
													<span class="input-group-btn">
													<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
													</span>
										</div>
									</div>
								</td>
							</tr>
					</tbody>
						</table>
					</div>

				</div>
				<div class="modal-footer">
					{!! Form::submit('Guardar',['class'=>'btn btn-success btn-default'])!!}
					<button type="button" class="btn grey-salsa btn-outline btn-default" data-dismiss="modal">Cerrar</button>
					{!! Form::close() !!}
				</div>
			</div>
		 </div>
		<!-- END MODAL MODIFY PERSONALIZED ANNUAL COST-->

		<!-- BEGIN MODAL MODIFY customized ANNUAL COST -->
		 <div id="edit-annual-quote" class="modal fade" id_profile="dialog" aria-hidden="true" style="display: block; width: 500px">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Cuota Anual Personalizada</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<table class="table table-bordered">
							<tbody>
							<tr>
								<td><Strong>Cuota Anual</Strong></td>
								<td>{!!Form::open(['url'=>'/costos/mostrar/customizedAnnualCostModal','method'=>'POST'])!!}
									{!! Form::hidden('_token',csrf_token()) !!}
									<input type="hidden" name="id-annual-cost-customized" class="id-annual-cost-customized">
									<i class="glyphicon glyphicon-usd"></i><input class="customized-annual-cost"  name="customized-annual-cost" type="text">
								</td>
							</tr>
							<tr>
								<td><strong>Inicio de la Promocion</strong></td>
								<td><div class="form-group">
										<div class="calendar input-group date form_datetime">
											<input name="date-begin-annual-cost-customized" type="text" size="16" readonly="" class="date-begin-annual-cost-customized form-control">
													<span class="input-group-btn">
													<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
													</span>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td><strong>Fin de la Promocion</strong></td>
								<td><div class="form-group">
										<div class="calendar input-group date form_datetime">
											<input name="date-end-annual-cost-customized" type="text" size="16" readonly="" class="date-end-annual-cost-customized form-control">
													<span class="input-group-btn">
													<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
													</span>
										</div>
									</div>
								</td>
							</tr>
					</tbody>
						</table>
					</div>

				</div>
				<div class="modal-footer">
					{!! Form::submit('Guardar',['class'=>'btn btn-success btn-default'])!!}
					<button type="button" class="btn grey-salsa btn-outline btn-default" data-dismiss="modal">Cerrar</button>
					{!! Form::close() !!}
				</div>
			</div>
		 </div>
		<!-- END MODAL MODIFY PERSONALIZED ANNUAL COST-->

		<!-- BEGIN MODAL MODIFY customized service COST -->
		 <div id="edit-service-quote" class="modal fade" id_profile="dialog" aria-hidden="true" style="display: block; width: 500px">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
					<h4 class="modal-title">Costo de Servicio Personalizado</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<table class="table table-bordered">
							<tbody>
							<tr>
								<td><Strong>Cuota Anual</Strong></td>
								<td>{!!Form::open(['url'=>'/costos/mostrar/customizedServiceCostModal','method'=>'POST'])!!}
									{!! Form::hidden('_token',csrf_token()) !!}
									<input type="hidden" name="id-service-cost-customized" class="id-service-cost-customized">
									<i class="glyphicon glyphicon-usd"></i><input class="customized-service-cost"  name="customized-service-cost" type="text">
								</td>
							</tr>
							<tr>
								<td><strong>Inicio de la Promocion</strong></td>
								<td><div class="form-group">
										<div class="calendar input-group date form_datetime">
											<input name="date-begin-service-cost-customized" type="text" size="16" readonly="" class="date-begin-service-cost-customized form-control">
													<span class="input-group-btn">
													<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
													</span>
										</div>
									</div>
								</td>
							</tr>
							<tr>
								<td><strong>Fin de la Promocion</strong></td>
								<td><div class="form-group">
										<div class="calendar input-group date form_datetime">
											<input name="date-end-annual-service-customized" type="text" size="16" readonly="" class="date-end-service-cost-customized form-control">
													<span class="input-group-btn">
													<button class="btn default date-set" type="button"><i class="fa fa-calendar"></i></button>
													</span>
										</div>
									</div>
								</td>
							</tr>
					</tbody>
						</table>
					</div>

				</div>
				<div class="modal-footer">
					{!! Form::submit('Guardar',['class'=>'btn btn-success btn-default'])!!}
					<button type="button" class="btn grey-salsa btn-outline btn-default" data-dismiss="modal">Cerrar</button>
					{!! Form::close() !!}
				</div>
			</div>
		 </div>
		<!-- END MODAL MODIFY PERSONALIZED service COST-->
	</div>
@endsection

@section('scripts')
	<script>
		jQuery(document).ready(function() {
			var $tableLogbook=$('#services_table'), tLoogbook, annualTable=$('#annual_table'), table;
			tLoogbook = Components.table(
					$tableLogbook,
					[{}, {} , {}, {}, {} , {orderable:false}],
					'/costos/mostrar/ajaxServicesDataTable',
					function (row, data, rowIndex) {
					},
					true,
					true,
					function(){
						var edit2=$('.edit-service-quote'), id2, id_field2=$('.id-service-cost-customized'), begin2, begin_field2=$('.date-begin-service-cost-customized'), end2, end_field2=$('.date-end-service-cost-customized'), cost2, cost_field2=$('.customized-service-cost') ;

						edit2.on("click",function(){
							id2=$(this).data('id');
							id_field2.val(id2);
							console.log(id2);
							begin2=$(this).data('begin_promotion');
							begin_field2.val(begin2);
							end2=$(this).data('end_promotion');
							end_field2.val(end2);
							cost2=$(this).data('cost');
							cost_field2.val(cost2);
						});
					}
			);
			table = Components.table(
					annualTable,
					[{}, {} , {}, {}, {} , {orderable:false}],
					'/costos/mostrar/ajaxAnnualDataTable',
					function (row, data, rowIndex) {
					},
					true,
					true,
					function(){
						var edit=$('.edit-annual-quote'), id, id_field=$('.id-annual-cost-customized'), begin, begin_field=$('.date-begin-annual-cost-customized'), end, end_field=$('.date-end-annual-cost-customized'), cost, cost_field=$('.customized-annual-cost') ;

						edit.on("click",function(){
							id=$(this).data('id');
							id_field.val(id);
							begin=$(this).data('begin_promotion');
							begin_field.val(begin);
							end=$(this).data('end_promotion');
							end_field.val(end);
							cost=$(this).data('cost');
							cost_field.val(cost);
						});
					}
			);
			table;
			tLoogbook;
		});

	</script>
@endsection

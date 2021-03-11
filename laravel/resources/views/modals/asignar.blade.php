
<div class="modal-tittle">
	<label><strong>Asignar mensajero</strong></label>
</div>

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
					@if(array_key_exists($user->id, $services_counter))
						{{$services_counter[$user->id]}}
					@else
						0
					@endif
				</td>

			</tr>
		@endforeach
		</tbody>
	</table>
</div>

<div class="modal-footer">
	<button type="button" class="btn grey-salsa btn-outline btn-default" data-dismiss="modal">Cerrar</button>
</div>
{!! Html::script('assets/js/home.js') !!}

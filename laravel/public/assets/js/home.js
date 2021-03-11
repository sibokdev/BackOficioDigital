jQuery(document).ready(function() {
	TableManaged.init();

	var $clients= $( "#search-clients-service"), engine,client_id,datid,datname;
	var mensajero_id_valor, date_service, edit_service=$('.edit-service'), edit_service_id,
		edit_service_client_name,edit_service_type,name, id , service_type, date , address,
		order_type, edit_service_date, edit_service_address, token, aggregate_service=$('.aggregate_service_token');
	
	$(".asignar_id").on("click", function () {
		asignar_id = $(this).data("asignar_id");
	});
	
	$(".mensajero_id").on("click", function () {
		mensajero_id_valor = $(this).data("id");
		window.location.href = "/home/asignar/" + mensajero_id_valor + "/" + asignar_id;
	});

	aggregate_service.on("click",function(){
		token=$(this).data('token');
	});

	engine = new Bloodhound({
		remote: '/client/query?name=%QUERY%',
		//local: ['dog', 'pig', 'moose'],
		datumTokenizer: Bloodhound.tokenizers.whitespace('name'),
		queryTokenizer: Bloodhound.tokenizers.whitespace
	});

	engine.initialize();

	//Get the value of the autocomplete
	$clients.on('typeahead:selected', function(obj, dat, name) {
		datid=dat.id;
		//alert(token);
				datname = $('.client-name-service');
				client_id=$('.service-client-id');
				datname.html(dat.name+" "+dat.surname1+" "+dat.surname2);
				client_id.val( datid);
		$.ajax({
			type: "POST",
			url: "/home/clientAddress",
			data: {id_client:datid , _token: token},
			success: function(data) {
				//console.log(data);
				var select=$('#select_address');
				select.empty();
				$.each(data, function (index, obj) {
					select.append($("<option></option>").attr("value",obj.id).text(obj.address_description+": "+obj.address));
					console.log(obj.id);
				});

			}
		})
	});

	//Autocomplete
	$clients.typeahead({
		hint: true,
		highlight: true,
		minLength: 2
	}, {
		source: engine.ttAdapter(),
		limit:5,
		name: 'Customers_list',
		displayKey: 'name',
		templates: {
			empty: [
				'<div class="empty-message">No se ha encontrado ningun cliente</div>'
			],
			suggestion : function(Customers_list){
				return Customers_list.name + " [" + Customers_list.email + "]";

			}
		}
	});

	date_service=$('.date-service');
	date_service.datetimepicker({
		showOn:'button',
		autoclose:true,
		changeMonth:true,
		changeYear:true,
		minDate:new Date(2016,8 -1,23),
		monthNames:['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
	});

	//Begin script edit service
	edit_service.on("click",function(){
		token=$(this).data('token_edit');
		client_id=$(this).data('client_id');
		//console.log(client_id);
		edit_service_id=$(this).data('service_id');
		edit_service_client_name=$(this).data('client_name');
		edit_service_type=$(this).data('service_type');
		edit_service_date=$(this).data('service_date');
		edit_service_address=$(this).data('service_address');
			name = $('.edit-service-client-name');
			id=$('.edit-service-id');
			service_type=$('.edit-service-type');
			date=$('.edit-service-date');
			address=$('#edit_address');
			name.html(edit_service_client_name);
			id.val(edit_service_id);
			order_type=edit_service_type;
			//address.val(edit_service_address);
			//console.log(edit_service_id);
			if(order_type == 1){
				service_type.html('ENTREGA');
			}
			else if(order_type == 2){
				service_type.html('RECOLECCION');
			}
			else{
				service_type.html('MIXTO');
			}
			date.val(edit_service_date);
		$.ajax({
			type: "POST",
			url: "/home/clientAddress",
			data: {id_client:client_id , _token: token},
			success: function(data) {
				//console.log(data);
				//var select=$('#edit_address');
				address.empty();
				$.each(data, function (index, obj) {
					address.append($("<option></option>").attr("value",obj.id).text(obj.address_description+": "+obj.address));
					//console.log(obj.id);
				});
			}
		});
	});
	//End script edit service

});

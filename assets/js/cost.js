jQuery(document).ready(function() {
    var token, engine, cost, datname,client_id, $clients= $( ".search-clients-annual-quote"), service_id=$('.service-id-annual-cost-modal'),
        date_begin_annual_cost=$('.date-begin-annual-cost-modal'),date_end_annual_cost=$('.date-end-annual-cost-modal'), calendar=$('.calendar'),
        annual_cost=$('.personalized-annual-cost-modal'),client_id_annual_cost=$('.client-id-annual-cost-modal'),
        client_name_service_cost=$('.client-name-service-cost-modal'), client_id_service_cost=$('.client-id-service-cost-modal'),
        client_service_cost=$('.search-client-service-cost'),service_type_field=$('.client_type_service_cost_modal'),
        service_cost_field=$('.client_service_cost_modal'),date_begin_service_cost_field=$('.client_date_begin_service_cost_modal'),
        date_end_service_cost_field=$('.client_date_end_service_cost_modal');

    //Auto
    engine = new Bloodhound({
        remote: '/client/query?name=%QUERY%',
        //local: ['dog', 'pig', 'moose'],
        datumTokenizer: Bloodhound.tokenizers.whitespace('name'),
        queryTokenizer: Bloodhound.tokenizers.whitespace
    });

    engine.initialize();

    //Begin script modal annual quote
    $('.aggregate_annual_quote_token').on("click",function(){
        token=$(this).data('token');
    });

    $clients.on('typeahead:selected', function(obj, dat, name) {
        //Annual quote data
        datname = $('.client-name-annual-cost-modal');
        datname.html(dat.name+" "+dat.surname1+" "+dat.surname2);
        client_id=dat.id;
        client_id_annual_cost.val(client_id);
        //console.log(dat.name);

        //Service cost data
        client_id_annual_cost.val(dat.id);
        client_name_service_cost.html(dat.name);
        $.ajax({
            type: "POST",
            url: "/costos/mostrar/personalizedAnnualQuote",
            data: {id_client:client_id , _token: token},
            success: function(response) {
              if (response) {
                cost=response.cost;
                service_id.val(response.id);
                annual_cost.val(parseFloat(cost));
                date_begin_annual_cost.val(response.begin_promotion);
                date_end_annual_cost.val(response.end_promotion);
              }
            }
        })
    });

    //Auto complete annual quote
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
    //End script modal annual quote

    //Begin script modal services cost
    $('.aggregate_services_cost_token').on("click",function(){
        token=$(this).data('token');
    });

    client_service_cost.on('typeahead:selected', function(obj, dat, name) {
        //Service cost data
        client_id_service_cost.val(dat.id);
        client_name_service_cost.html(dat.name+" "+dat.surname1+" "+dat.surname2);

    });

    //Auto complete service cost
    client_service_cost.typeahead({
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
    //End script modal services cost

    //calendar scripts
    calendar.datetimepicker({
        showOn:'button',
        autoclose:true
    });

});

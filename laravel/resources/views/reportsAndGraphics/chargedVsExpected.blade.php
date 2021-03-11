@extends('layouts.reportsAndGraphics')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head div-content-top-title">
                <div class="page-title">
                    <h1><a href="/">Inicio</a> <small>Cobrados vs Esperados</small></h1>
                </div>
            </div>
            @include('alerts.success')
            @include('alerts.error')
            <div class="portlet light portlet-fit ">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject sbold uppercase">Cobrados vs Esperados</span>
                    </div>
                    @if(\Illuminate\Support\Facades\Auth::user()->role == 2)
                    <div class="actions">
                        <a class="btn btn-circle btn-icon-only btn-default" href="/download/excel/cobros" target="_blank">
                            <i class="icon-cloud-download"></i>
                        </a>
                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                            <i class="icon-size-fullscreen"></i>
                        </a>
                        <a class="btn btn-circle btn-icon-only btn-default" href="javascript:;">
                            <i class="icon-envelope-open"></i>
                        </a>
                    </div>
                    @endif
                </div>
                <div class="portlet-body">
                    <div id="chart_2" class="chart" style="height: 400px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
@section('scripts')
<script>
    jQuery(document).ready(function() {


    	var ChartsAmcharts = function() {

    	    var initChartSample2 = function() {
			var $date;

				var chart = AmCharts.makeChart("chart_2", {
    	            "type": "serial",
    	            "theme": "light",

    	            "fontFamily": 'Open Sans',
    	            "color":    '#888888',

    	            "legend": {
    	                "equalWidths": false,
    	                "useGraphSettings": true,
    	                "valueAlign": "left",
    	                "valueWidth": 120
    	            },
    	            "dataProvider":  [
						@foreach($services as $key=>$value)
						{"date": "{{$year_now."-".$month_now."-".$key}}", //Fecha es la parte de abajo
						"distance": "{{$value}}", //La barra azul
						//"townName": "", //aparece abajo de la horizontal al seleccionarlo
						//"townName2": "", //Aparece en el punto amarillo
						"townSize": 5, //Indica que tan grande es el punto amarillo
						"latitude": "{{$services_paid[$key]}}", //Aparece debajo de la horizontal a unlado del TownName
						"duration": "{{$services_unpaid[$key]}}" //Calculado en minutos y aparece en horas
						 },
						@endforeach
					],
					"valueAxes": [{
						"id": "distanceAxis",
						"axisAlpha": 0,
						"gridAlpha": 0,
						"position": "left",
						"title": "Servicios"
					}, {
						"id": "latitudeAxis",
						"axisAlpha": 0,
						"gridAlpha": 0,
						"labelsEnabled": false,
						"position": "right"
					}],
					"graphs": [{
    	                "balloonText": "[[value]] servicios totales",//valor en la etiqueta al posicionarse en el punto
    	                "dashLengthField": "dashLength",//Genera una linea punteada (su valor es pa separacion)
    	                "fillAlphas": 0.7,//puntea la columna de la grafica
    	                "legendPeriodValueText": "total: [[value.sum]] servicios totales",//label a lado de distancia(millas totales)
    	                "legendValueText": "[[value]] total de servicios",//label a lado de distancia(millas por columna)
    	                "title": "Servicios Totales",//label a lado de cuadro azul (con titulo "distancia")
    	                "type": "column",//tipo de representacion en la grafica
    	                "valueField": "distance",//de donde obtiene los datos para la distancia
    	                "valueAxis": "distanceAxis"//Datos en x o en y, valueAxes
    	            }, {
    	                "balloonText": "[[value]] Servicios Pagados",
    	                "bullet": "round",
    	                "bulletBorderAlpha": 1,
    	                "useLineColorForBulletBorder": true,
    	                "bulletColor": "#FFFFFF",
    	                "bulletSizeField": "townSize",
    	                "dashLengthField": "dashLength",
    	                "descriptionField": "townName",
    	                "labelPosition": "right",
    	                "labelText": "[[townName2]]",
						"legendPeriodValueText": "total: [[value.sum]] servicios pagados",
    	                "title": "Servicios Pagados",
    	                "fillAlphas": 0,
    	                "valueField": "latitude",
    	                "valueAxis": "latitudeAxis"
    	            }, {
						"balloonText": "[[value]] Servicios no Pagados",
    	                "bullet": "square",
    	                "bulletBorderAlpha": 1,
    	                "bulletBorderThickness": 1,
    	                "dashLengthField": "dashLength",
    	                "legendPeriodValueText": "total: [[value.sum]] servicios no pagados",
    	                "title": "Servicios no Pagados",
    	                "fillAlphas": 0,
    	                "valueField": "duration"
    	            }],
					//cursor que se genera sobre las columnas
    	            "chartCursor": {
    	                "categoryBalloonDateFormat": "DD",
    	                "cursorAlpha": 0.1,
    	                "cursorColor": "#000000",
    	                "fullWidth": true,
    	                "valueBalloonsEnabled": false,
    	                "zoomable": false
    	            },
    	            //"dataDateFormat": "YYYY-MM-DD",
    	            "categoryField": "date",
    	            "categoryAxis": {
    	                "dateFormats": [{
    	                    "period": "DD",
    	                    "format": "DD"
    	                }, {
    	                    "period": "WW",
    	                    "format": "MMM DD"
    	                }, {
    	                    "period": "MM",
    	                    "format": "MMM"
    	                }, {
    	                    "period": "YYYY",
    	                    "format": "YYYY"
    	                }],
    	                "parseDates": true,
    	                "autoGridCount": false,
    	                "axisColor": "#555555",
    	                "gridAlpha": 0.1,
    	                "gridColor": "#FFFFFF",
    	                "gridCount": 50
    	            },
    	            "exportConfig": {
    	                "menuBottom": "20px",
    	                "menuRight": "22px",
    	                "menuItems": [{
    	                    "icon": Metronic.getGlobalPluginsPath() + "amcharts/amcharts/images/export.png",
    	                    "format": 'png'
    	                }]
    	            }
    	        });

    	        $('#chart_2').closest('.portlet').find('.fullscreen').click(function() {
    	            chart.invalidateSize();
    	        });
    	    }


    	    return {
    	        //main function to initiate the module

    	        init: function() {

    	            //initChartSample1();
    	            initChartSample2();
    	            //initChartSample3();
    	            //initChartSample4();
    	            //initChartSample5();
    	            //initChartSample6();
    	            //initChartSample7();
    	            //initChartSample8();
    	            //initChartSample9();
    	            //initChartSample10();
    	            //initChartSample11();
    	            //initChartSample12();
    	        }

    	    };

    	}();

    	ChartsAmcharts.init();
    });
</script>
    @endsection
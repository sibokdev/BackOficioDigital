@extends('layouts.reportsAndGraphics')
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head div-content-top-title">
                <div class="page-title">
                    <h1><a href="/">Inicio</a> <small>Estadisticas de servicios</small></h1>
                </div>
            </div>
            @include('alerts.success')
            @include('alerts.error')
            <div class="portlet light portlet-fit ">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject sbold uppercase">Estadisticas de servicios</span>
                    </div>
                    @if(\Illuminate\Support\Facades\Auth::user()->role == 2)
                    <div class="actions">
                        <a class="btn btn-circle btn-icon-only btn-default" href="/download/excel/services" target="_blank">
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

                    <div id="statistic_services" class="chart" style="height: 400px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        jQuery(document).ready(function(){

            function statisticServices() {
                if ($('#statistic_services').size() != 1) {
                    return;
                }

                var delivery = [];
                @foreach($delivery_service as $key=>$value)
                    delivery.push([{{$key}},{{$value}}]);
                @endforeach
                //console.log("{{$date->format('j')}}");
                var harvest = [];
                @foreach($harvest_service as $key=>$value)
                        harvest.push([{{$key}},{{$value}}]);
                        @endforeach

                    var mixed = [];
                @foreach($mixed_service as $key=>$value)
                        mixed.push([{{$key}},{{$value}}]);
                        @endforeach


                    var plot = $.plot($("#statistic_services"), [{
                    data: delivery,
                    label: "Servicios de Entrega",
                    lines: {
                        lineWidth: 1,
                    },
                    shadowSize: 0

                }, {
                    data: harvest,
                    label: "Servicio de Recoleccion",
                    lines: {
                        lineWidth: 1,
                    },
                    shadowSize: 0
                }, {
                    data: mixed,
                    label: "Servicio Mixto",
                    lines: {
                        lineWidth: 1,
                    },
                    shadowSize: 0
                }], {
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 2,
                            fill: true,
                            fillColor: {
                                colors: [{
                                    opacity: 0.05
                                }, {
                                    opacity: 0.01
                                }]
                            }
                        },
                        points: {
                            show: true,
                            radius: 3,
                            lineWidth: 1
                        },
                        shadowSize: 2
                    },
                    grid: {
                        hoverable: true,
                        clickable: true,
                        tickColor: "#eee",
                        borderColor: "#eee",
                        borderWidth: 1,

                    },
                    colors: ["#3CB371","#d12610",  "#00BFFF	"],
                    xaxis: {
                        ticks: function(){
                            var ticks=[];
                            @for($i=1; $i <= $days_month->format('j') ;$i++)

                    ticks.push([{{$i}},{{$i}}]);
                            @endfor

                            return ticks;
                        },
                        tickDecimals: 0,
                        tickColor: "#eee"
                    },
                    yaxis: {
                        ticks: 11,
                        tickDecimals: 0,
                        tickColor: "#eee",

                    }
                });


                function showTooltip(x, y, contents) {
                    $('<div id="tooltip">' + contents + '</div>').css({
                        position: 'absolute',
                        display: 'none',
                        top: y + 5,
                        left: x + 15,
                        border: '1px solid #333',
                        padding: '4px',
                        color: '#fff',
                        'border-radius': '3px',
                        'background-color': '#333',
                        opacity: 0.80
                    }).appendTo("body").fadeIn(200);
                }

                var previousPoint = null;
                $("#statistic_services").bind("plothover", function(event, pos, item) {
                    $("#x").text(pos.x.toFixed(2));
                    $("#y").text(pos.y.toFixed(2));

                    if (item) {
                        if (previousPoint != item.dataIndex) {
                            previousPoint = item.dataIndex;

                            $("#tooltip").remove();
                            var x = item.datapoint[0].toFixed(2),
                                    y = item.datapoint[1].toFixed(2);

                            showTooltip(item.pageX, item.pageY, item.series.label + " of " + x + " = " + y);
                        }
                    } else {
                        $("#tooltip").remove();
                        previousPoint = null;
                    }
                });
            }


            statisticServices();


        });

    </script>
@endsection

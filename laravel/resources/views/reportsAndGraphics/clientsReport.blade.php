@extends('layouts.reportsAndGraphics')
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-head div-content-top-title">
                <div class="page-title">
                    <h1><a href="/">Inicio</a> <small>Reporte de clientes</small></h1>
                </div>
            </div>
            @include('alerts.success')
            @include('alerts.error')
            <div class="portlet light portlet-fit ">
                <div class="portlet-title">
                    <div class="caption">
                        <span class="caption-subject sbold uppercase">Reporte de clientes</span>
                    </div>
                   @if(\Illuminate\Support\Facades\Auth::user()->role == 2)
                    <div class="actions">
                        <a class="btn btn-circle btn-icon-only btn-default" href="/download/excel/clientes" target="_blank">
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
                    <div><label><strong>Total de Clientes:</strong></label>&nbsp &nbsp<i class="glyphicon glyphicon-user"></i> &nbsp <label>{{$total_clients}}</label></div>
                    <div id="chart_2" class="chart" style="height: 400px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    jQuery(document).ready(function(){

            function chart2() {
                if ($('#chart_2').size() != 1) {
                    return;
                }

                var subscribed = [];
                    @foreach($subscribed_clients as $key=>$value)
                        subscribed.push([{{$key}},{{$value}}]);
                    @endforeach


                var unsubscribed = [];
                @foreach($unsubscribed_clients as $key=>$value)
                        unsubscribed.push([{{$key}},{{$value}}]);
                    @endforeach


                var plot = $.plot($("#chart_2"), [{
                    data: subscribed,
                    label: "Usuarios Registrados",
                    lines: {
                        lineWidth: 1,
                    },
                    shadowSize: 0

                }, {
                    data: unsubscribed,
                    label: "Usuarios dados de baja",
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
                        borderWidth: 1

                    },
                    colors: ["#3CB371","#d12610",  "#00BFFF	"],
                    xaxis: {
                        ticks: function(){
                            var ticks=[];
                                    @for($i=1; $i <= date('t',strtotime($days_month)) ;$i++)

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
                $("#chart_2").bind("plothover", function(event, pos, item) {
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


            chart2();


    });

</script>
    @endsection
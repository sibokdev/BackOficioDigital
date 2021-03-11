<!doctype html>
<html>
<head>
    @include('includes.head')
    {!! Html::style('assets/metronic/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css') !!}
</head>
<body class="page-header-fixed page-sidebar-closed-hide-logo page-sidebar-closed-hide-logo">
@include('includes.header')
@include('includes.sidebar')
@yield('content')
@include('includes.footer')
{!! Html::script('assets/metronic/global/plugins/amcharts/amcharts/amcharts.js') !!}
{!! Html::script('assets/metronic/global/plugins/amcharts/amcharts/serial.js') !!}
{!! Html::script('assets/metronic/global/plugins/amcharts/amcharts/pie.js') !!}
{!! Html::script('assets/metronic/global/plugins/amcharts/amcharts/radar.js') !!}
{!! Html::script('assets/metronic/global/plugins/amcharts/amcharts/themes/light.js') !!}
{!! Html::script('assets/metronic/global/plugins/amcharts/amcharts/themes/patterns.js') !!}
{!! Html::script('assets/metronic/global/plugins/amcharts/amcharts/themes/chalk.js') !!}
{!! Html::script('assets/metronic/global/plugins/amcharts/ammap/ammap.js') !!}
{!! Html::script('assets/metronic/global/plugins/amcharts/ammap/maps/js/worldLow.js') !!}
{!! Html::script('assets/metronic/global/plugins/amcharts/amstockcharts/amstock.js') !!}
<script>
    jQuery(document).ready(function() {
        $('.graphics_list').addClass("open");
        document.getElementById("graphics_menu").style.display = 'block';

    });

</script>
</body>
</html>
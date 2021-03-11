<!doctype html>
<html>
    <head>
        {!! Html::style('assets/metronic/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css') !!}
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-sidebar-closed-hide-logo">
        @yield('content')
        {!! Html::script('assets/js/home.js') !!}
	</body>
</html>
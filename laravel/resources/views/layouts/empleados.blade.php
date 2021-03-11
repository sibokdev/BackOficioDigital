<!doctype html>
<html>
    <head>
        @include('includes.head')
		{!! Html::style('assets/css/custom/dropzone.css') !!}
        {!! Html::style('assets/metronic/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') !!}
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-sidebar-closed-hide-logo">
        @include('includes.header')
			@include('includes.sidebar')
            @yield('content')
        @include('includes.footer')
        @yield('scripts')
		{!! Html::script('assets/js/custom/dropzone.js') !!}
		{!! Html::script('assets/js/employee.js') !!}
        {!! Html::script('assets/metronic/admin/pages/scripts/components.js')!!}

    </body>
</html>
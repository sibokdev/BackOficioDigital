<!doctype html>
<html>
    <head>
        @include('includes.head')
		{!! Html::style('assets/metronic/global/plugins/typeahead/typeahead.css') !!}
		{!! Html::style('assets/metronic/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') !!}
		{!! Html::style('assets/metronic/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') !!}
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-sidebar-closed-hide-logo">
        @include('includes.header')
		@include('includes.sidebar')
        @yield('content')
        <!-- </div> -->

        @include('includes.footer')
		{!! Html::script('assets/metronic/global/plugins/typeahead/typeahead.bundle.min.js') !!}
		{!! Html::script('assets/metronic/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') !!}
		{!! Html::script('assets/js/cost.js') !!}
        {!! Html::script('assets/metronic/admin/pages/scripts/components.js')!!}
    </body>
</html>
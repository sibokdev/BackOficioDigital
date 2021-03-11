<!doctype html>
<html>
    <head>
        @include('includes.head')
		{!! Html::style('assets/metronic/global/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css') !!}
		{!! Html::style('assets/metronic/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') !!}
		{!! Html::style('assets/metronic/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.css') !!}
		{!! Html::style('assets/metronic/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css') !!}
		{!! Html::style('assets/metronic/global/plugins/bootstrap-colorpicker/css/colorpicker.css') !!}
		{!! Html::style('assets/metronic/global/plugins/clockface/css/clockface.css') !!}
		{!! Html::style('assets/metronic/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') !!}
		<style type="text/css">
			.tt-dropdown-menu{
				background: white;
			    border: 1px solid black;
			    padding: 5px;
			    cursor: pointer;
			}
			.tt-suggestion:hover{
				background: #EEE;
			}
		</style>

    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-sidebar-closed-hide-logo">
        @include('includes.header')
			@include('includes.sidebar')
            @yield('content')
        @include('includes.footer')
		{!! Html::script('assets/metronic/global/plugins/typeahead/typeahead.bundle.min.js') !!}
		{!! Html::script('assets/metronic/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}
		{!! Html::script('assets/metronic/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') !!}
		{!! Html::script('assets/metronic/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js') !!}
		{!! Html::script('assets/metronic/global/plugins/clockface/js/clockface.js') !!}
		{!! Html::script('assets/js/home.js') !!}
		{!! Html::script('assets/metronic/admin/pages/scripts/components.js')!!}
		{!! Html::script('assets/js/ui-modals.min.js') !!}
		@yield('scripts')

	</body>
</html>
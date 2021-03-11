<!doctype html>
<html>
    <head>
        @include('includes.head')
        {!! Html::style('assets/metronic/global/plugins/bootstrap-modal/css/bootstrap-modal-bs3patch.css') !!}
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-sidebar-closed-hide-logo">
        @include('includes.header')
			@include('includes.sidebar')
            @yield('content')
        @include('includes.footer')
        @yield('scripts')
        {!! Html::script('assets/js/documents.js')!!}
        {!! Html::script('assets/metronic/admin/pages/scripts/table-managed.js')!!}
        {!! Html::script('assets/metronic/admin/pages/scripts/components.js')!!}
        <script>
            jQuery(document).ready(function() {
                $('.options_list').addClass("open");
                document.getElementById("menu").style.display = 'block';

            });

        </script>
    </body>
</html>
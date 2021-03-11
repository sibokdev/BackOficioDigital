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
{!! Html::script('assets/js/client.js') !!}
{!! Html::script('assets/metronic/admin/pages/scripts/components.js')!!}
<script>
    jQuery(document).ready(function() {
        $('.clients_list').addClass("open");
        document.getElementById("clients_menu").style.display = 'block';
    });
</script>
</body>
</html>
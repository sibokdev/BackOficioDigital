<!doctype html>
<html>
<head>
	<title>Boveda de Documentos</title>
    {!! Html::style('assets/metronic/admin/layout/css/custom.css') !!}
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    {!! Html::style('assets/metronic/global/plugins/font-awesome/css/font-awesome.min.css') !!}
    {!! Html::style('assets/metronic/global/plugins/simple-line-icons/simple-line-icons.min.css') !!}
    {!! Html::style('assets/metronic/global/plugins/bootstrap/css/bootstrap.min.css') !!}
    {!! Html::style('assets/metronic/global/plugins/uniform/css/uniform.default.css') !!}
            <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! Html::style('assets/metronic/admin/pages/css/login.css') !!}
            <!-- END PAGE LEVEL SCRIPTS -->
    <!-- BEGIN THEME STYLES -->
    {!! Html::style('assets/metronic/global/css/components.css') !!}
	{!! Html::style('assets/metronic/global/plugins/select2/select2.min.css') !!}
	{!! Html::style('assets/metronic/global/plugins/select2/select2-bootstrap.min.css') !!}
    {!! Html::style('assets/metronic/global/css/plugins.css') !!}
    {!! Html::style('assets/metronic/admin/layout/css/layout.css') !!}
    {!! Html::style('assets/metronic/admin/layout/css/custom.css') !!}
	{!! Html::style('assets/metronic/admin/pages/css/login.css') !!}
</head>
<body class="login">
<center>
<div>
    @yield('content')
</div>
</center>





<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
{!! Html::script('assets/metronic/global/plugins/respond.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/excanvas.min.js') !!}
<![endif]-->
{!! Html::script('assets/metronic/global/plugins/jquery.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/jquery-migrate.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/bootstrap/js/bootstrap.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/jquery.blockui.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/jquery.cokie.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/uniform/jquery.uniform.min.js') !!}
        <!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
{!! Html::script('assets/metronic/global/plugins/jquery-validation/js/jquery.validate.min.js') !!}
        <!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
{!! Html::script('assets/metronic/global/scripts/metronic.js') !!}
{!! Html::script('assets/metronic/admin/layout/scripts/layout.js') !!}
{!! Html::script('assets/metronic/admin/layout/scripts/demo.js') !!}
{!! Html::script('assets/metronic/admin/pages/scripts/login.js') !!}
{!! Html::script('assets/metronic/global/plugins/backstretch/jquery.backstretch.min.js') !!}
        <!-- END PAGE LEVEL SCRIPTS -->
<script>
    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core components
        Layout.init(); // init current layout
        Login.init();
        Demo.init();
    });
</script>
<!-- END JAVASCRIPTS -->
</body>
</html>
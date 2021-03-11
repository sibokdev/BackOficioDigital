<div id="copyright text-right">Boveda de Documentos © 2016</div>
<!-- Scripts -->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>-->


        <!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
{!! Html::script('assets/metronic/global/plugins/respond.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/excanvas.min.js') !!}

<![endif]-->
{!! Html::script('assets/metronic/global/plugins/jquery.min.js') !!}
<!--{!! Html::script('assets/js/bootstrap.min.js') !!}-->
{!! Html::script('assets/metronic/global/plugins/jquery-migrate.min.js') !!}
        <!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
{!! Html::script('assets/metronic/global/plugins/jquery-ui/jquery-ui.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/bootstrap/js/bootstrap.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/jquery.blockui.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/jquery.cokie.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/uniform/jquery.uniform.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') !!}
        <!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
{!! Html::script('assets/metronic/global/plugins/flot/jquery.flot.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/flot/jquery.flot.resize.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/flot/jquery.flot.categories.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/jquery.pulsate.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/bootstrap-daterangepicker/moment.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/bootstrap-daterangepicker/daterangepicker.js') !!}
        <!-- IMPORTANT! fullcalendar depends on jquery-ui.min.js for drag & drop support -->
{!! Html::script('assets/metronic/global/plugins/fullcalendar/fullcalendar.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js') !!}
{!! Html::script('assets/metronic/global/plugins/jquery.sparkline.min.js') !!}
        <!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
{!! Html::script('assets/metronic/global/scripts/metronic.js') !!}
{!! Html::script('assets/metronic/admin/layout/scripts/layout.js') !!}
{!! Html::script('assets/metronic/admin/layout/scripts/quick-sidebar.js') !!}
{!! Html::script('assets/metronic/admin/pages/scripts/index.js') !!}
{!! Html::script('assets/metronic/admin/pages/scripts/tasks.js') !!}

<!-- Scripts por eliminar despues de probar -->
<!--{!! Html::script('assets/metronic/admin/layout/scripts/demo.js') !!}-->
<!-- Terminan los Scripts por eliminar despues de probar -->

        <!-- END PAGE LEVEL SCRIPTS -->

{!! Html::script('assets/metronic/global/plugins/bootstrap-modal/js/bootstrap-modalmanager.js') !!}
{!! Html::script('assets/metronic/global/plugins/bootstrap-modal/js/bootstrap-modal.js') !!}


        <!--BEGIN SCRIPTS PAGINATION-->
{!! Html::script('assets/metronic/admin/pages/scripts/table-managed.js')!!}
{!! Html::script('assets/metronic/global/plugins/datatables/media/js/jquery.dataTables.min.js')!!}
{!! Html::script('assets/metronic/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js')!!}
{!! Html::script('assets/metronic/global/plugins/select2/select2.min.js')!!}
<!--END SCRIPTS PAGINATION-->
<script>
    var folio_all;

    jQuery(document).ready(function() {
        Metronic.init(); // init metronic core componets
        Layout.init(); // init layout
        TableManaged.init();//init pagination
        //QuickSidebar.init(); // init quick sidebar
        Index.init();
        //Index.initDashboardDaterange();
        //Index.initJQVMAP(); // init index page's custom scripts
        //Index.initCalendar(); // init index page's custom scripts
        //Index.initCharts(); // init index page's custom scripts
        //Index.initChat();
        //Index.initMiniCharts();
        //Tasks.initDashboardWidget();
    });

</script>
<!-- END JAVASCRIPTS -->
</body>

@yield('scripts')
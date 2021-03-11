@extends('layouts.charges')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN PAGE HEAD -->
            <div class="page-head div-content-top-title">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1><a href="/">Inicio</a> <small>Consulta de Cargos y Abonos</small></h1>
                </div>
                <!-- END PAGE TITLE -->
                <!-- END PAGE TOOLBAR -->
            </div>
            <!-- END PAGE HEAD -->
            <!-- BEGIN PAGE CONTENT INNER -->

            <!-- BEGIN Alerts Section -->
            @include('alerts.success')
            @include('alerts.error')
                    <!-- END Alerts Section -->

            <!-- Comienza la tabla de orders -->
            <div class="portlet light portlet-fit ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-folder-alt"></i>
                        <span class="caption-subject sbold uppercase">Consulta de Cargos y Abonos</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div>
                        <table class="table table-hover table-bordered" id="orders_table">
                            <thead>
                            <tr class="uppercase">
                                <th><strong>Cliente</strong></th>
                                <th><strong>Tipo de Servicio</strong></th>
                                <th><strong>Fecha de Pago</strong></th>
                                <th><strong>Monto</strong></th>
                                <th><strong>Metodo de pago</strong></th>
                            </tr>
                            </thead>

                            <tbody>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <!-- Termina la tabla de orders -->
            <!-- END PAGE CONTENT INNER -->
        </div>
    </div>
    <!-- END CONTENT -->

    <!--Begin Modals-->
    <div class="modal fade" id="ajax" role="basic" aria-hidden="true">
            <div class="modal-content">
                <div class="modal-body">
                    <img src="/assets/metronic/global/img/loading-spinner-grey.gif" alt="" class="loading">
                    <span> &nbsp;&nbsp;Loading... </span>
                </div>
            </div>
    </div>
    <!--End Modals-->
    @endsection
@section('scripts')
<script>
    jQuery(document).ready(function() {
        var $tableLogbook=$('#orders_table'), tLoogbook;
        tLoogbook = Components.table(
                $tableLogbook,
                [{}, {} , {}, {}, {}],
                '/charges/showChargesAndDeposits/ajaxDataTable',
                function (row, data, rowIndex) {
                },
                true,
                true
        );
        tLoogbook;
    });

</script>
@endsection

@extends('layouts.client')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN PAGE HEAD -->
            <div class="page-head div-content-top-title">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1><a href="/">Inicio</a> <small>Clientes Referidos</small></h1>
                </div>
                <!-- END PAGE TITLE -->
                <!-- END PAGE TOOLBAR -->
            </div>
            <!-- END PAGE HEAD -->
            <!-- BEGIN PAGE CONTENT INNER -->

            <!-- BEGIN Alerts Section -->
            @include('alerts.success')
            @include('alerts.error')
            <!--END ALERTS SECTION-->

            <!--BEGIN CONTENT PAGE-->
            <div class="portlet light portlet-fit ">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-user"></i>
                        <span class="caption-subject sbold uppercase">Clientes Referidos</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div>
                        <table class="table table-hover table-bordered" id="referred_table">
                            <thead>
                            <tr class="uppercase">
                                <th>Cliente Referido</th>
                                <th>Correo</th>
                                <th>Cliente</th>
                                <th>Correo</th>
                                <th>Fecha</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT PAGE-->

@endsection

@section('scripts')
    <script>
        jQuery(document).ready(function() {
            var $tableLogbook=$('#referred_table'), tLoogbook;
            tLoogbook = Components.table(
                    $tableLogbook,
                    [{}, {} , {}, {}, {}],
                    '/cliente/userReferred/ajaxDataTable',
                    function (row, data, rowIndex) {
                    },
                    true,
                    true
            );
            tLoogbook;
        });

    </script>
@endsection
@extends('layouts.reportsAndGraphics')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN PAGE HEAD -->
            <div class="page-head div-content-top-title">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1><a href="/">Inicio</a> <small>Reporte de Finanzas</small></h1>
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
                        <span class="caption-subject sbold uppercase">Reporte de Finanzas</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <center><h1><strong>WORK IN PROGRESS....</strong></h1></center>
                </div>
            </div>
        </div>
    </div>
@endsection

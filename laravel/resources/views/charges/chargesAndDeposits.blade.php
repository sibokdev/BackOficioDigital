@extends('layouts.charges')

@section('content')

    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN PAGE HEAD -->
            <div class="page-head div-content-top-title">
                <!-- BEGIN PAGE TITLE -->
                <div class="page-title">
                    <h1><a href="/">Inicio</a> <small>Ejecucion de Cargos y Abonos</small></h1>
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
                        <i class="icon-drawer"></i>
                        <span class="caption-subject sbold uppercase">Ejecucion de Cargos y Abonos</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div>
                        <table class="charges_table table table-hover table-bordered">
                            <thead>
                            <tr class="uppercase">
                                <th><strong>Cliente</strong></th>
                                <th><strong>Inicio del Servicio</strong></th>
                                <th><strong>Fin del Servicio</strong></th>
                                <th><strong>Acciones</strong></th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($services_status as $key=>$value)
                                <tr>
                                    <td>{{$clients[$value -> client_id]['name']}} {{$clients[$value -> client_id]['first_name']}} {{$clients[$value -> client_id]['last_name']}}</td>
                                    <td>{{$value -> start_date}} </td>
                                    <td>{{$value -> expiration_date}}</td>
                                    <td><div class="actions">
                                            <div class="btn-group">
                                                <a class="btn btn-default btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-close-others="true" aria-expanded="true"> Actions
                                                    <i class="fa fa-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-menu pull-right">
                                                    <li>
                                                        <a href="/charges/payment/{{$value -> id}}">Marcar como pagado</a>
                                                    </li>
                                                    <li>
                                                        <a href="/modals/paymentData/{{$clients[$value -> client_id]['id']}}/{{$value ->id}}" data-toggle="modal" data-target="#payment-data">Hacer cobro con tarjeta</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div></td>
                                </tr>
                            @endforeach
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

    <!--Begin modals-->
    <div class="modal fade" id="payment-data" role="basic" aria-hidden="true" style="display: block; ">
        <div class="modal-content">
            <div class="modal-body ">
                <img src="/assets/metronic/global/img/loading-spinner-grey.gif" alt="" class="loading">
                <span> &nbsp;&nbsp;Loading... </span>
            </div>
        </div>
    </div>

    <!--End modals-->

    @endsection
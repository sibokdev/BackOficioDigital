<?php

namespace App\Http\Controllers;

use App\Orders;
use App\ServicesOrder;
use App\ServicesStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
class ReportsAndGraphicsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showChargedVsExpected()
    {
        //$date_now=Carbon::now("America/Mexico_City");
        $month_now=date('n');
        $year_now=date('Y');
        $days_month=date('t');
        //Inicio variables total servicios
            $total_services=ServicesOrder::where('status','!=',4)->get();
            $total_annual_quote=ServicesStatus::all();
            $services=array();

        //Fin variables total servicios

        //Inicio variables servicios pagados
            $services_paid_db=Orders::all();
            $services_paid=array();
        //Fin variables servicios pagados

        //Inicio variables servicios no pagados.
            $all_services=ServicesOrder::all();
            $services_unpaid=array();
            $payed=$services_paid_db->count();

        //Fin variables servicios no pagados.

        //Inicio de creacion de los array
        for ($i = 1; $i <= $days_month; $i++) {
            $services[$i]=0;
            $services_paid[$i]=0;
            $services_unpaid[$i]=0;
        }
        //Fin de la creacion de los array

        //Comienza a agregar los servicios totales por dia.
            //Comienzo del array del total de servicios por dia
            foreach($total_services as $value){
                $day=date('j',strtotime($value -> created_at));
                $month=date('n',strtotime($value -> created_at));
                if($month_now == $month){
                    if(array_key_exists($day , $services)){
                        $services[$day]++;
                    }
                    else{
                        $services[$day]=0;
                    }
                }
            }
            //Finaliza de agregar el total de servicios por dia

            //Comienza a agregar el total de cuotas annuales por dia.
            foreach($total_annual_quote as $value){
                $day=date('j',strtotime($value -> expiration_date));
                $month=date('n',strtotime($value -> expiration_date));
                    if($month_now == $month){
                        if(array_key_exists($day , $services)){
                            $services[$day]++;
                        }
                    }


            }
            //Finaliza de aggregar el total de cuotas anuales por dia.

        //Finaliza arrat de servicios totales.

        //Comienza array de servicios pagados.
            //Comienzo del array de los servicios pagados por dia
            foreach($services_paid_db as $value){
                $day=date('j',strtotime($value -> created_at));
                $month=date('n',strtotime($value -> created_at));
                if($month_now == $month){
                    if(array_key_exists($day , $services_paid)){
                        $services_paid[$day]++;
                    }
                    else{
                        $services_paid[$day]=0;
                    }
                }
            }
            //fin del array de los servicios pagados

            //Comienza a agregar en el array de servicios pagados las cuotas anual pagadas
            /*foreach($annual_cost_paid as $value){
                $day=date('j',strtotime($value -> updated_at));
                $month=date('j',strtotime($value -> updated_at));
                if($month_now == $month){
                    if(array_key_exists($day, $services_paid)){
                        $services_paid[$day]++;
                    }
                }
            }*/
            //Finaliza de agregar en el array de servicios pagados las cuotas anual pagadas

        //Finaliza array de servicios pagados.

        //Comienza el array de servicios no pagados.

            //Comienza a aggregar el total de los servicios.
            for($i=1;$i<=date('t');$i++){
                $services_unpaid[$i]=$services[$i];
            }

            //Termina de aggregar el total de los servicios.

            //Comienza a restar de todos los servicios, los pagados.
                for($i=1;$i<=date('t');$i++){
                    if(($services_unpaid[$i] != 0) && ($payed > 0)){
                        $services_unpaid[$i]--;
                        $payed--;
                    }
                }

            //Finalza a restar de todos los servicios, los pagados.
        //Termina el array de servicios no pagados.

        //return view('reportsAndGraphics.chargedVsExpected')->with('date_now',$date_now)->with('date_begin',$date_begin)->with('counter',$counter);
        return view('reportsAndGraphics.chargedVsExpected')->with('services',$services)->with('services_paid',$services_paid)->with('days_month',$days_month)
            ->with('month_now',$month_now)->with('year_now',$year_now)->with('services_unpaid',$services_unpaid);

    }

    public function showClientsReport()
    {
        $total_clients=User::where('id_role','=',3)->count();
        $subscribed_clients_db=User::where('active_status',1)->where('id_role',3)->get();
        $subscribed_clients=array();
        $unsubscribed_clients_db=User::where('active_status',2)->where('id_role',3)->get();
        $unsubscribed_clients=array();
        $days_month=Carbon::now()->endOfMonth();
        $month_now=Carbon::now()->format('n');
        for ($i = 1; $i <= $days_month->format('j'); $i++) {
            $subscribed_clients[$i]=0;
            $unsubscribed_clients[$i]=0;
        }

         foreach($subscribed_clients_db as $value){
             $date=Carbon::parse($value->created_at);
             if($month_now == $date->month) {
                 if (array_key_exists($date->format('j'), $subscribed_clients)) {
                     $subscribed_clients[$date->format('j')]++;
                 } else {
                     $subscribed_clients[$date->format('j')] = 0;
                 }
             }
        }
        foreach($unsubscribed_clients_db as $value){
            $date=Carbon::parse($value->created_at);
            if($month_now == $date->month) {
                if (array_key_exists($date->format('j'), $unsubscribed_clients)) {
                    $unsubscribed_clients[$date->format('j')]++;
                } else {
                    $unsubscribed_clients[$date->format('j')] = 0;
                }
            }
        }

        return view('reportsAndGraphics.clientsReport')->with('total_clients',$total_clients)->with('subscribed_clients',$subscribed_clients)
            ->with('unsubscribed_clients',$unsubscribed_clients)->with('month_now',$month_now)->with('days_month',$days_month);

    }

    public function showStatisticServices()
    {
        $total_services=ServicesOrder::count();
        $delivery_service_db=ServicesOrder::where('service_type',1)->get();
        $delivery_service=array();
        $harvest_service_db=ServicesOrder::where('service_type',2)->get();
        $harvest_service=array();
        $mixed_service_db=ServicesOrder::where('service_type',3)->get();
        $mixed_service=array();
        $days_month=Carbon::now()->endOfMonth();
        $month_now=Carbon::now()->format('n');
        //$date=ServicesOrder::where('id',3)->first();

        for ($i = 1; $i <= $days_month->format('j'); $i++) {
            $delivery_service[$i]=0;
            $harvest_service[$i]=0;
            $mixed_service[$i]=0;
        }

        foreach($delivery_service_db as $value){
            $date=Carbon::parse($value->created_at);
            if($month_now == $date->month) {
                if (array_key_exists($date->format('j'), $delivery_service)) {
                    $delivery_service[$date->format('j')]++;
                } else {
                    $delivery_service[$date->format('j')] = 0;
                }
            }
        }


        foreach($harvest_service_db as $value){
            $date=Carbon::parse($value->created_at);
            if($month_now == $date->month) {
                if (array_key_exists($date->format('j'), $harvest_service)) {
                    $harvest_service[$date->format('j')]++;
                } else {
                    $harvest_service[$date->format('j')] = 0;
                }
            }
        }

        foreach($mixed_service_db as $value){
            $date=Carbon::parse($value->created_at);
            if($month_now == $date->month) {
                if (array_key_exists($date->format('j'), $mixed_service)) {
                    $mixed_service[$date->format('j')]++;
                } else {
                    $mixed_service[$date->format('j')] = 0;
                }
            }
        }

        return view('reportsAndGraphics.statisticServices')->with('delivery_service',$delivery_service)->with('harvest_service',$harvest_service)
            ->with('mixed_service',$mixed_service)->with('total_services',$total_services)->with('days_month',$days_month)
            ->with('date',$date);
    }

    public function showFinancesReport()
    {
        return view('reportsAndGraphics.financesReport');
    }

}

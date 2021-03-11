<?php

namespace App\Http\Controllers;

use App\Order;
use App\Orders;
use App\PaymentsMethods;
use App\ServicesStatus;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\ServicesOrder;
use Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class ModalsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function asignar()
    {
        $orders = DB::table('services_orders')->where('estatus', '=', 1)->get();
        $services_counter=array();
        foreach($orders as $key=>$value){
            if(array_key_exists($value->mensajero_id, $services_counter)){
                $services_counter[$value->mensajero_id] ++;
            }
            else{
            $services_counter[$value->mensajero_id] = 1;
            }
        }
        $messenger_counter=array();
        foreach($orders as $value){
            $messenger_counter[$value -> mensajero_id]=$value;
        }
        $customers_db = User::where('role' , '=' , 3)->get();
        $customers = array();
        foreach($customers_db as $key => $value){
            $customers[$value->id] = $value;
        }
        $date=Carbon::now();
        $users = DB::table('users')->where('role', '=', 5 )->where('status','=',1)->get();

        return view('modals.asignar')->with('date',$date)->with('orders', $orders)->with('users',$users)->with('customers',$customers)->with('services_counter',$services_counter);
    }

    public function historical($id)
    {
        $orders=Orders::where('client_id',$id)->get();
        $name=User::where('id',$id)->first();
        return view('modals.historicalCharges')->with('orders',$orders)->with('name',$name);
    }

    public function paymentData($id, $service_id)
    {
        $payment_data=PaymentsMethods::where('customer_id',$id)->get();
        return view('modals.paymentData')->with('payment_data',$payment_data)->with('service_id',$service_id);
    }
}

<?php

namespace App\Http\Controllers;

use App\Orders;
use App\ServicesOrder;
use App\ServicesStatus;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;



class ChargesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if((Auth::user()->id_role == 2) || (Auth::user()->id_role == 1)) {
            $services_status = ServicesStatus::where('status', 1)->get();
            $clients_db = User::where('id_role','=',3)->get();
            $clients = array();
            foreach ($clients_db as $key => $value) {
                $clients[$value->id] = $value;
            }

            return view('charges.chargesAndDeposits')->with('clients', $clients)->with('services_status', $services_status);
        }
        else{
            return redirect('/home');
        }

    }

    public function show()
    {

        $clients_db = User::where('id_role','=',3)->get();
        $clients = array();
        foreach ($clients_db as $key => $value) {
            $clients[$value->id]['name'] = $value->name." ".$value->first_name." ".$value->last_name;
        }

        $cobro = DB::select('select * from orders');
        $cobros = array();
        foreach($cobro as $key => $value){

            $cobros[$key]['name'] = $clients[$value->client_id]['name'];
            $cobros[$key]['client_id'] = $value->client_id;
            $cobros[$key]['services_order_id'] = $value->services_order_id;
            $cobros[$key]['created_at'] = $value->created_at;
            $cobros[$key]['amount'] = $value->amount;
            $cobros[$key]['payment_type'] = $value->payment_type;

        }

        return view('charges.showChargesAndDeposits')->with('cobros', $cobros);


    }

    public function payment($id)
    {
        ServicesStatus::where('id',$id)->update(array(
            'status'=>2
        ));

        Session::flash('message','EL SERVICIO FUE PAGADO ');
        return redirect('/charges/chargesAndDeposits');
    }

    //Ajax data
    /*
     * This function get the data from the DB through a query, return this with the data of the DataTable to  the script in the view "charges.showChargesAndDeposits" and show this data in a table.
     * $request contain all the attributes of dataTable.
     */
    /**
     * @param Request $request
     * @return array
     */
    public function ajaxDataTable(Request $request)
    {
        //Get data, this data will send to the dataTable
        $start = $request->get('start');
        $length = $request->get('length');
        $draw = $request->get('draw');
        $search = $request->get('search');
        $order = isset($request->get('order')[0]['column']) ? $request->get('order')[0]['column'] : '';
        $orderDir = isset($request->get('order')[0]['dir']) ? $request->get('order')[0]['dir'] : '';


        //array that will contain the data of the table
        $data = [];

        //query to the data base.
        $query = DB::table('payments as payment')
            ->select(
                DB::raw('payment.id as payment_id'),
                DB::raw('(CASE WHEN type = 0 THEN "Pago cuota anual" WHEN type = 1 THEN "Pago servicio urgente"  END) as type'),
                DB::raw('payment.amount as payment_amount'),
                DB::raw('(CASE WHEN payment_method = 1 THEN "OpenPay" WHEN payment_method = 2 THEN "PayPal" END) as payment_method'),
                DB::raw('payment.date as date'),
                DB::raw('user.id as user_id'),
                DB::raw('CONCAT(user.name," ",user.surname1," ",user.surname2) as client')
            )
            ->join('users as user', 'user.id', '=', 'payment.user_id')
            //->where('service_cost.cost_type', '=',1)
            ->where('user.id_role', '=',3)
            ->where(function($query) use ($search){
                $query->where(DB::raw('CONVERT(CONCAT(user.name," ",user.surname1," ",user.surname2) USING latin1)'), 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('(CASE WHEN type = 0 THEN "Pago cuota anual" WHEN type = 1 THEN "Pago servicio urgente"  END) '), 'like', '%'.$search["value"].'%')
                    ->orwhere('payment.amount', 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('(CASE WHEN payment_method = 1 THEN "OpenPay" WHEN payment_method = 2 THEN "PayPal" END) '), 'like', '%'.$search["value"].'%')
                    ->orwhere('payment.date', 'like', '%'.$search["value"].'%');
            });

        //records counter
        $total = count($query->get());

        if($order !== ''){
            $orderBy = '';
            switch($order){
                case 0:
                    $orderBy = 'client';
                    break;
                case 1:
                    $orderBy = 'type';
                    break;
                case 2:
                    $orderBy = 'date';
                    break;
                case 3:
                    $orderBy = 'payment_amount';
                    break;
                case 4:
                    $orderBy = 'payment_method';
                    break;
            }
            if($orderBy !== ''){
                $query->orderBy($orderBy, $orderDir);
            }
        };

        if($length > 0 ){
            $query->skip($start)->take($length);
        }

        foreach($query->get() as $arr) {
            $data[] = [
                htmlentities($arr->client,ENT_SUBSTITUTE),
                $arr->type,
                $arr->date,
                number_format( $arr->payment_amount , 2),
                $arr->payment_method
            ];
        }
        return ([
            'draw'            => $draw,
            'recordsTotal'    => $total,
            'recordsFiltered' => $total,
            //'search'          => $search,
            'data'            => $data,
        ]);

    }

}

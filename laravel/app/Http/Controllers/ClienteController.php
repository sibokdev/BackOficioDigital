<?php

namespace App\Http\Controllers;

use App\UsersReferred;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActionRequest;
use Session;
use Redirect;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\UrlGenerator;
use App\Customer;
use Illuminate\Support\Facades\DB;
use mysqli_sql_exception;
class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request)
    {
        if((Auth::user()->id_role == 2) || (Auth::user()->id_role == 1)) {
            $customers = User::where('id_role','=',3)->get();

            return view('cliente.mostrar')->with('customers', $customers);
        }
        else{
            return redirect('/home');
        }
    }

    /*
     * This function get the data from the DB through a query, return this with the data of the DataTable to  the script in the view "cliente.mostrar" and show this data in a table.
     * $request contain all the attributes of dataTable.
     */
    public function ajaxClientDataTable(Request $request)
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
        $query = DB::table('users as user')
            ->select(
                DB::raw('user.id as id'),
                DB::raw('user.email as email'),
                DB::raw(DB::raw('(CASE WHEN user.gender = 1 THEN "Masculino" WHEN user.gender = 2 THEN "Femenino" END) as gender')),
                DB::raw('CONCAT(user.name," ",user.surname1," ",user.surname2) as client'),
                DB::raw('user.phone as phone'),
                DB::raw(DB::raw('(CASE WHEN user.active_status = 1 THEN "Activo" WHEN user.active_status = 0 THEN "Inactivo" END) as status'))
            )
            ->where('user.id_role','=',3)
            ->where(function($query) use ($search){
                $query->where('user.name', 'like', '%'.$search["value"].'%')
                    ->orwhere('user.email', 'like', '%'.$search["value"].'%')
                    ->orwhere('user.phone', 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('CONVERT(CONCAT(user.name," ",user.surname1," ",user.surname2) USING latin1)'), 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('(CASE WHEN user.gender = 1 THEN "Masculino" WHEN user.gender = 2 THEN "Femenino" END)') , 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('(CASE WHEN user.active_status = 1 THEN "Activo" WHEN user.active_status = 0 THEN "Inactivo" END)'), 'like', '%'.$search["value"].'%');
            });
        //records counter
        $total = count($query->get());
        if($order !== ''){
            $orderBy = '';
            switch($order){
                case 0:
                    $orderBy = 'status';
                    break;
                case 1:
                    $orderBy = 'client';
                    break;
                case 2:
                    $orderBy = 'email';
                    break;
                case 3:
                    $orderBy = 'gender';
                    break;
                case 4:
                    $orderBy = 'phone';
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
                $arr->status,
                '<a class="client-data modal-solution" data-toggle="modal" data-target="#client-data" data-name="'.htmlentities($arr->client,ENT_SUBSTITUTE).'"
										   data-email="'.$arr->email.'" data-gender="'.$arr->gender.'" data-status="'.$arr->status.'"
										   data-phone="'.$arr->phone.'">'.htmlentities($arr->client,ENT_SUBSTITUTE).'</a>',
                $arr->email,
                $arr->gender,
                $arr->phone
            ];
        }
        //return json_encode($data);
        return ([
            'draw'            => $draw,
            'recordsTotal'    => $total,
            'recordsFiltered' => $total,
            //'search'          => $search,
            'data'            => $data,
        ]);
    }

    /*
     * This function get the data from the DB through a query, return this with the data of the DataTable to  the script in the view "cliente.usersReferred" and show this data in a table.
     * $request contain all the attributes of dataTable.
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
        $query = DB::table('users_referreds as referred')
            ->select(
                DB::raw('referred.id as id'),
                DB::raw('referred.created_at as date'),
                DB::raw('CONCAT(user.name," ",user.surname1," ",user.surname2) as user_name'),
                DB::raw('user.email as user_email'),
                DB::raw('CONCAT(user_referred.name," ",user_referred.surname1," ",user_referred.surname2) as referred_name'),
                DB::raw('user_referred.email as referred_email')
            )
            ->join('users as user', 'user.id', '=', 'referred.id_user')
            ->join('users as user_referred', 'user_referred.id', '=', 'referred.id_referred_user')
            ->where('user.id_role','=',3)
            ->where(function($query) use ($search){
                $query->where(DB::raw('CONVERT(CONCAT(user.name," ",user.surname1," ",user.surname2) USING latin1)'), 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('CONVERT(CONCAT(user_referred.name," ",user_referred.surname1," ",user_referred.surname2) USING latin1)'), 'like', '%'.$search["value"].'%')
                    ->orwhere('referred.created_at', 'like', '%'.$search["value"].'%')
                    ->orwhere('user.email', 'like', '%'.$search["value"].'%')
                    ->orwhere('user_referred.email', 'like', '%'.$search["value"].'%');
            });


        //records counter
        $total = count($query->get());

        if($order !== ''){
            $orderBy = '';
            switch($order){
                case 0:
                    $orderBy = 'user_name';
                    break;
                case 1:
                    $orderBy = 'user_email';
                    break;
                case 2:
                    $orderBy = 'referred_name';
                    break;
                case 3:
                    $orderBy = 'referred_email';
                    break;
                case 4:
                    $orderBy = 'date';
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
                htmlentities($arr->user_name,ENT_SUBSTITUTE),
                $arr->user_email,
                htmlentities($arr->referred_name,ENT_SUBSTITUTE),
                $arr->referred_email,
                $arr->date,
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

    public function showUsersReferred()
    {
        if((Auth::user()->id_role == 2) || (Auth::user()->id_role == 1)) {
            $usersReferred = UsersReferred::all();
            $customers_db=User::where('id_role',3)->get();
            $customers=array();
            foreach($customers_db as $key=>$value){
                $customers[$value->id]=$value;
            }
            return view('cliente.usersReferred')->with('customers', $customers)->with('usersReferred',$usersReferred);
        }
        else{
            return redirect('/home');
        }
    }

    public function query(Request $request)
    {
        $query = $request->get('name');
        $res   = User::where('name', 'LIKE', "%$query%")->where('id_role', '=', "3")
            ->get();
        return json_encode($res);
    }


}

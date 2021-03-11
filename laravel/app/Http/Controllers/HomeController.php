<?php

namespace App\Http\Controllers;

use App\ClientAddress;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\ServicesOrder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
class HomeController extends Controller{

   public function __construct(){
      $this->middleware('auth');
   }

    /*
     * This function get the data from the DB through a query, return this with the data of the DataTable to  the script in the view "home" and show this data in a table.
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
       $query = DB::table('services_orders as services')
          ->select(
              DB::raw('services.id as id'),
              DB::raw('services.date as date'),
              DB::raw('services.service_type as type'),
              DB::raw('CONCAT(user.name," ",user.surname1," ",user.surname2) as client'),
              DB::raw('useraddress.address'),
              DB::raw('services.id_client as client_id'),
              DB::raw('services.status as status')
          )
          ->join('users as user', 'user.id', '=', 'services.id_client')
          ->leftjoin('user_addresses as useraddress', 'useraddress.id', '=', 'services.address')
          ->where('services.status', '=', 1)
          ->where(function($query) use ($search){
             $query->where(DB::raw('CONVERT(CONCAT(user.name," ",user.surname1," ",user.surname2) USING latin1)'), 'like', '%'.$search["value"].'%')
                 ->orwhere('services.date', 'like', '%'.$search["value"].'%')
                 ->orwhere('useraddress.address', 'like', '%'.$search["value"].'%')
                 ->orwhere(DB::raw('(CASE WHEN services.service_type = 1 THEN "Entrega" WHEN services.service_type = 2 THEN "Recoleccion" WHEN services.service_type = 3 THEN "Mixto" END)'), 'like', '%'.$search["value"].'%');
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
               $orderBy = 'address';
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
         if ($arr->type == 1) {
            $type = "Entrega";
         }
         else if($arr->type == 2){
            $type="Recolección";
         }
         else if($arr->type == 3){
            $type="Mixto";
         }
         else{
            $type="No definido";
         }
         $data[] = [
             htmlentities($arr->client,ENT_SUBSTITUTE),
             $type,
             $arr->date,
             $arr->address,
             '<div class="actions">
										<div class="btn-group">
											<a class="btn btn-default btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-close-others="true" aria-expanded="true"> Actions
												<i class="fa fa-angle-down"></i>
											</a>
											<ul class="dropdown-menu pull-right">
												<li>
													<a  data-target="#ajax" data-toggle="modal" class="asignar_id" onclick="asignar(' . $arr->id . ')" data-asignar_id="'.$arr -> id.'"> Asignar </a>
												</li>
												<li>
													<a href="/home/cancelar/'.$arr->id.'">Cancelar</a>
												</li>

												<li>
													<a class="edit-service" data-target="#edit-service-modal" data-toggle="modal" data-client_name="'.htmlentities($arr->client,ENT_SUBSTITUTE).'"
													   data-service_id="'.$arr->id.'" data-client_id="'.$arr->client_id.'" data-service_date="'.$arr->date.'"
													   data-service_address="'.$arr->address.'" data-service_type="'.$arr->type.'" data-token_edit="'.csrf_token().'">Editar</a>
												</li>
											</ul>
										</div>
									</div>'
         ];
      }
      return ([
          'draw'            => $draw,
          'recordsTotal'    => $total,
          'recordsFiltered' => $total,
          'data'            => $data,
      ]);

   }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function home()
    {
       $roleClient = 3;
       $roleMessenger = 5;
       $userRole = Auth::user()->id_role;
       $isUserNotGranted = $userRole == $roleClient || $userRole== $roleMessenger;

       if ($isUserNotGranted) {
           $role = "";
               if ($userRole == $roleClient){
                   $role="Cliente";
                 }
              else if ($userRole == $roleMessenger){
               $role="Mensajero";
              }
                Auth::logout();
               Session::flash('message-error','Éste usuario ya esta registrado como '.$role);
               return view('auth.login');
       }
       else {
           $orders = ServicesOrder::where('status', '=', 1)->get();

           $customers_db = DB::table('users')->where('id_role',3)->get();
           $customers = array();
           $address_db = ClientAddress::all();
           $address = array();

           foreach ($address_db as $value) {
               $address[$value->id] = $value;
           }

           foreach ($customers_db as $key => $value) {
               $customers[$value->id] = $value;
           }

           $date = Carbon::now();
           $users = DB::table('users')
                                ->leftjoin('services_orders', 'users.id', '=', 'services_orders.id_courier')
                                ->select(DB::raw('users.*, count(services_orders.id_courier) as ordenes'))
                                ->where('users.id_role',5)
                                ->where('active_status', '=', 1)
                                ->groupBy('users.id')
                                ->get();
           return view('home')->with('address', $address)->with('date', $date)->with('orders', $orders)->with('users', $users)->with('customers', $customers);
       }
    }

   public function cancel($id ){
      $order = ServicesOrder::find($id);
      $order->status = 5;
      $order->save();

      Session::flash('message', 'El servicio fue cancelado ');
      return redirect('/home');
   }

   public function assign($mensajero_id_valor , $asignar_id){
      $user=User::find($mensajero_id_valor);
      $order=ServicesOrder::find($asignar_id);
      $order->status = 2;
      $order->id_courier = $user->id;
      $order->save();


      Session::flash('message','El servicio fue asignado a un mensajero ');
      return redirect('/home');
   }


   public function aggregateService(Request $request){
      $id = $request->input('id_client');
      $client_annual_quote = CustomServiceCost::where('client_id', '=', $id)->where('cost_type', '=', 1)->first();
      return $client_annual_quote;

   }

   public function createService(Request $request){
      $min_date=Carbon::now("America/Mexico_City")->addHour(1);
      $max_date=Carbon::now("America/Mexico_City")->addMonth(1);
      if(($request['date-service-selected'] >= $min_date) && ($request['date-service-selected'] <= $max_date )) {
         $service=ServicesOrder::create([
             'id_client'=>$request['service-client-id'],
             'service_type'=>$request['type-service'],
             'address'=>$request['selected-address'],
             'status'=>1,
             'date'=>$request['date-service-selected']
         ]);
         $service->save();

         Session::flash('message','El servicio fue creado');
         return redirect('/home');
      }
      else{
         Session::flash('message-error','EL SERVICIO NO PUEDE SER CREADO, VERIVIQUE QUE SU SERVICIO ESTE
         EN UN RANGO DE UNA HORA DESPUES DE LA HORA ACTUAL Y UN MES DESPUES DE LA FECHA ACTUAL' . $request['selected-address']);
         return redirect('/home');
      }
   }

   public function editServiceData(Request $request){
      $id=$request['edit_service_id'];
      $data=ServicesOrder::where('id','=',$id)->first();
      return $data;
   }

   public function editService(Request $request){

      $id=$request['edit-service-id'];
      $date=$request['edit-service-date'];
      $address=$request['edit-service-address'];
      ServicesOrder::where('id','=',$id)->update([
         'date'=>$date,
         'address'=>$address
      ]);
      Session::flash('message','EL SERVICIO FUE MODIFICADO :');
      return redirect('/home');
   }

   public function clientAddress(Request $request){
      $client_id=$request['id_client'];
      $address=ClientAddress::where('id_user',$client_id)->get();
      return $address;
   }
}

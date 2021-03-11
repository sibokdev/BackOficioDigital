<?php

namespace App\Http\Controllers;

use App\CustomServiceCost;
use App\ServiceCost;
use Carbon\Carbon;
use Collective\Html\FormBuilder;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActionRequest;
use Illuminate\Support\Facades\Input;
use Session;
use Redirect;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\UrlGenerator;
use App\Customer;
use Illuminate\Support\Facades\DB;
class CostosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Show Data
    public function show()
    {
        if((Auth::user()->id_role == 2) || (Auth::user()->id_role == 1)){
            //$results = DB::select('select * from users where id = :id', ['id' => 1]);
            // DB::table('service_cost')->truncate();
            //$costs=DB::raw('SELECT TRUNCATE ');
            $personalized_costs = CustomServiceCost::all();

            $customers_db = User::where('id_role','=',3)->get();
            $customers = array();
            foreach ($customers_db as $key => $value) {
                $customers[$value->id] = $value;
            }

            $costs = ServiceCost::where('id', '=', 1)->get();
            return view('costos/mostrar')->with('customers', $customers)->with('costs', $costs)->with('personalized_costs', $personalized_costs);
        }
        else{
            return redirect('/home');
        }

    }
    //End show data

    //validations
    public function store(Request $request)
    {
        $this->validate($request,[
            'reception_cost' => 'numeric',
            'annual_cost' => 'numeric',
            'delivery_cost' => 'numeric',
            'unique_service_id'=>'numeric'
        ]);
    }
    //end validations

    //Functions fixed costs
    public function updateReceptionCost(Request $request)
    {

        $id=1;
        $reception_cost=ServiceCost::find($id);
        $reception_cost->reception_cost=str_replace(',','',$request->input('reception-cost'));
        $reception_cost->save();
        Session::flash('message','EL COSTO DEL SERVICIO DE RECOLECCION FUE ACTUALIZADO CORRECTAMENTE '  );
        return redirect('/costos/mostrar');
    }

    public function updateDeliveryCost(Request $request)
    {
        $id=1;
        $delivery_cost=ServiceCost::find($id);
        $delivery_cost->delivery_cost=str_replace(',','',$request->input('delivery-cost'));
        $delivery_cost->save();
        Session::flash('message','EL COSTO DEL SERVICIO DE ENTREGA FUE ACTUALIZADO CORRECTAMENTE '  );
        return redirect('/costos/mostrar');
    }

    public function updateMixedCost(Request $request)
    {
        $id=1;
        $delivery_cost=ServiceCost::find($id);
        $delivery_cost->mixed_cost=str_replace(',','',$request->input('mixed-cost'));
        $delivery_cost->save();
        Session::flash('message','EL COSTO DEL SERVICIO MIXTO FUE ACTUALIZADO CORRECTAMENTE '  );
        return redirect('/costos/mostrar');
    }

    public function updateAnnualCost(Request $request)
    {
        $id=1;
        $annual_cost=ServiceCost::find($id);
        $annual_cost->annual_cost=str_replace(',','',$request->input('annual-cost'));
        $annual_cost->save();

        Session::flash('message','EL COSTO DE LA CUOTA ANUAL FUE ACTUALIZADO CORRECTAMENTE ');
        return redirect('/costos/mostrar');
    }
    //End functions fixed costs


    //Functions personalized costs
    public function personalizedAnnualQuote(Request $request)
    {
        $id=$request['id_client'];
        $personalized_costs=CustomServiceCost::where('client_id' , '=' , $id)->where('cost_type' , '=' , 1)->first();
        return $personalized_costs;
    }


    public function updatePersonalizedAnnualCost(Request $request)
    {
        $begin_promotion=$request['annual-quote-date-begin-promotion'];
        $end_promotion=$request['annual-quote-date-end-promotion'];
        $min_date=Carbon::now("America/Mexico_City")->addHour(1);
        $max_date=Carbon::now("America/Mexico_City")->addMonth(1);
        $max_end_promotion=Carbon::parse($begin_promotion)->addMonth(1);
        if(($begin_promotion >= $min_date) && ($begin_promotion <= $max_date) && (($end_promotion > $begin_promotion) && ($end_promotion <= $max_end_promotion) ) ){
            $id=$request['id-personalized-annual-cost'];
            CustomServiceCost::where('unique_service_id',$id)->update(array(
                'cost' => $request['personalized-annual-cost'],
                'begin_promotion' => $begin_promotion,
                'end_promotion' => $end_promotion
            ));
            Session::flash('message','LA CUOTA ANUAL FUE MODIFICADA CORRECTAMENTE ');
            return redirect('/costos/mostrar');
        }
        else{
            Session::flash('message-error','LA FECHA DE INICIO DEBE DE SER MAYOR AL DIA DE HOY Y MENOR A 1 MES. LA FECHA DE FIN NO PUEDE SER MENOR A LA FECHA DE HOY NI A LA FECHA DE INICIO');
            return redirect('/costos/mostrar');
        }

    }

    public function  personalizedAnnualCostModal(Request $request)
    {
        $client_id=$request['client-id-annual-cost-customized'];
        $unique=$client_id.'1';
        $unique_id=$unique;
        $client_registered=CustomServiceCost::where('unique_service_id',$unique_id)->where('cost_type',1)->first();


      if($client_registered != null){
            CustomServiceCost::where('unique_service_id',$unique_id)->update(array(
                'cost'=>$request['personalized-annual-cost-modal'],
                'begin_promotion'=>$request['date-begin-annual-cost-modal'],
                'end_promotion'=>$request['date-end-annual-cost-modal']
            ));
            Session::flash('message','LA CUOTA ANUAL FUE MODIFICADO CORRECTAMENTE');
            return redirect('/costos/mostrar');
        }
        else{
            CustomServiceCost::create([
                'unique_service_id'=>$unique_id,
                'client_id'=>$client_id,
                'cost_type'=>1,
                'cost'=>$request['personalized-annual-cost-modal'],
                'begin_promotion'=>$request['date-begin-annual-cost-modal'],
                'end_promotion'=>$request['date-end-annual-cost-modal']
            ]);

            Session::flash('message','LA CUOTA ANUAL FUE CREADA CORRECTAMENTE');
            return redirect('/costos/mostrar');
        }

    }

    public function  customizedAnnualCostModal(Request $request)
    {
      $begin_promotion=$request['date-begin-annual-cost-customized'];
      $end_promotion=$request['date-end-annual-cost-customized'];
      $id=$request['id-annual-cost-customized'];
      CustomServiceCost::where('unique_service_id',$id)->update(array(
          'cost' => $request['customized-annual-cost'],
          'begin_promotion' => $begin_promotion,
          'end_promotion' => $end_promotion
      ));
      Session::flash('message','La cuota anual fue modificada correctamente ');
      return redirect('/costos/mostrar');

    }

    public function  customizedServiceCostModal(Request $request)
    {
      $begin_promotion=$request['date-begin-service-cost-customized'];
      $end_promotion=$request['date-end-service-cost-customized'];
      $id=$request['id-service-cost-customized'];
      CustomServiceCost::where('unique_service_id',$id)->update(array(
          'cost' => $request['customized-service-cost'],
          'begin_promotion' => $begin_promotion,
          'end_promotion' => $end_promotion
      ));
      Session::flash('message','La cuota de servicio urgente fue modificada correctamente ');
      return redirect('/costos/mostrar');

    }

    public function updatePersonalizedServiceCost(Request $request)
    {
        $cost_id=$request['client-id-service-cost'];
        CustomServiceCost::where('unique_service_id',$cost_id)->update(array(
            'cost'=>$request['personalized-service-cost'],
            'begin_promotion'=>$request['service-cost-date-begin-promotion'],
            'end_promotion'=>$request['service-cost-date-end-promotion']
        ));
        Session::flash('message','El SERVICIO FUE MODIFICADO CORRECTAMENTE');
        return redirect('/costos/mostrar');
    }

    public function personalizedServiceCostModal(Request $request)
    {
        $client_id=$request['client-id-service-cost-modal'];
        $cost_type= 2;
        $unique_id=$client_id.$cost_type;
        $unique_id_int=intval($unique_id);
        $cost=$request['service-cost-modal'];
        $begin_promotion=$request['date-begin-service-cost-modal'];
        $end_promotion=$request['date-end-service-cost-modal'];
        $client_exist=CustomServiceCost::where('unique_service_id',$unique_id_int)->first();
        if($client_exist == null){
            CustomServiceCost::create([
                'unique_service_id'=>$unique_id,
                'client_id'=>$client_id,
                'cost_type'=>$cost_type,
                'cost'=>$cost,
                'begin_promotion'=>$begin_promotion,
                'end_promotion'=>$end_promotion
            ]);

            Session::flash('message','El COSTO DE SERVICIO FUE CREADO CORRECTAMENTE ');
            return redirect('/costos/mostrar');
        }
        else{
            CustomServiceCost::where('unique_service_id',$unique_id_int)->update([
                'cost'=>$cost,
                'begin_promotion'=>$begin_promotion,
                'end_promotion'=>$end_promotion
            ]);
            Session::flash('message','El COSTO DE SERVICIO FUE MODIFICADO CORRECTAMENTE ');
            return redirect('/costos/mostrar');

        }


        /*DB::insert(DB::raw("INSERT INTO custom_service_cost.dox(unique_service_id, client_id, cost_type, cost, begin_promotion, end_promotion)
            VALUES($unique_id_int,$client_id, $cost_type, $cost, $begin_promotion, $end_promotion)
            ON DUPLICATE KEY UPDATE(cost=$cost, begin_promotion=$begin_promotion,end_promotion=$end_promotion)"));

        Session::flash('message','El COSTO DE SERVICIO FUE MODIFICADO CORRECTAMENTE ');
        return redirect('/costos/mostrar');*/

    }


    //End functions personalized costs

    //Ajax data
    /*
     * This function get the data from the DB through a query, return this with the data of the DataTable to  the script in the view "costos.mostrar" and show this data in a table.
     * $request contain all the attributes of dataTable.
     */
    /**
     * @param Request $request
     * @return array
     */
    public function ajaxServicesDataTable(Request $request)
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
        $query = DB::table('custom_service_cost as service_cost')
            ->select(
                DB::raw('service_cost.unique_service_id as id'),
                DB::raw('service_cost.cost as cost'),
                DB::raw('service_cost.begin_promotion as begin_promotion'),
                DB::raw('service_cost.end_promotion as end_promotion'),
                DB::raw('CONVERT(CONCAT(user.name," ",user.surname1," ",user.surname2) USING latin1) as client'),
                DB::raw('(CASE WHEN service_cost.cost_type = 1 THEN "Costo Anual" WHEN service_cost.cost_type = 2 THEN "Servicio Urgente" END) as cost_type')
            )
            ->join('users as user', 'user.id', '=', 'service_cost.client_id')
            //->where('service_cost.cost_type', '=',2)
            ->where('user.id_role', '=',3)
            ->where('service_cost.cost_type', '=',2)
            ->where(function($query) use ($search){
                $query->where(DB::raw('CONVERT(CONCAT(user.name," ",user.surname1," ",user.surname2) USING latin1)'), 'like', '%'.$search["value"].'%')
                    ->orwhere('service_cost.cost', 'like', '%'.$search["value"].'%')
                    ->orwhere('service_cost.begin_promotion', 'like', '%'.$search["value"].'%')
                    ->orwhere('service_cost.end_promotion', 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('(CASE WHEN service_cost.cost_type = 1 THEN "Costo Anual" WHEN service_cost.cost_type = 2 THEN "Servicio Urgente" END)'), 'like', '%'.$search["value"].'%');
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
                    $orderBy = 'cost_type';
                    break;
                case 2:
                    $orderBy = 'cost';
                    break;
                case 3:
                    $orderBy = 'begin_promotion';
                    break;
                case 4:
                    $orderBy = 'end_promotion';
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
                $arr->cost_type,
                '<i class="glyphicon glyphicon-usd"></i>'.number_format( $arr->cost , 2),
                $arr->begin_promotion,
                $arr->end_promotion,
                '<a class="btn btn-success btn-default edit-service-quote" data-target="#edit-service-quote" data-toggle="modal" data-id="'.$arr->id.'" data-cost="'.$arr->cost.'" data-begin_promotion="'.$arr->begin_promotion.'" data-end_promotion="'.$arr->end_promotion.'">Actualizar</a>'
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


    //Ajax data
    /*
     * This function get the data from the DB through a query, return this with the data of the DataTable to  the script in the view "costos.mostrar" and show this data in a table.
     * $request contain all the attributes of dataTable.
     */
    /**
     * @param Request $request
     * @return array
     */
    public function ajaxAnnualDataTable(Request $request)
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
        $query = DB::table('custom_service_cost as service_cost')
            ->select(
                DB::raw('service_cost.unique_service_id as id'),
                DB::raw('service_cost.cost as cost'),
                DB::raw('service_cost.begin_promotion as begin_promotion'),
                DB::raw('service_cost.end_promotion as end_promotion'),
                DB::raw('CONVERT(CONCAT(user.name," ",user.surname1," ",user.surname2) USING latin1) as client'),
                DB::raw('(CASE WHEN service_cost.cost_type = 1 THEN "Costo Anual" WHEN service_cost.cost_type = 2 THEN "Servicio Urgente" END) as cost_type')
            )
            ->join('users as user', 'user.id', '=', 'service_cost.client_id')
            //->where('service_cost.cost_type', '=',1)
            ->where('user.id_role', '=',3)
            ->where('service_cost.cost_type', '=',1)
            ->where(function($query) use ($search){
                $query->where(DB::raw('CONVERT(CONCAT(user.name," ",user.surname1," ",user.surname2) USING latin1)'), 'like', '%'.$search["value"].'%')
                    ->orwhere('service_cost.cost', 'like', '%'.$search["value"].'%')
                    ->orwhere('service_cost.begin_promotion', 'like', '%'.$search["value"].'%')
                    ->orwhere('service_cost.end_promotion', 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('(CASE WHEN service_cost.cost_type = 1 THEN "Costo Anual" WHEN service_cost.cost_type = 2 THEN "Servicio Urgente" END)'), 'like', '%'.$search["value"].'%');
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
                    $orderBy = 'cost_type';
                    break;
                case 2:
                    $orderBy = 'cost';
                    break;
                case 3:
                    $orderBy = 'begin_promotion';
                    break;
                case 4:
                    $orderBy = 'end_promotion';
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
                $arr->cost_type,
                '<i class="glyphicon glyphicon-usd"></i>'.number_format( $arr->cost , 2),
                $arr->begin_promotion,
                $arr->end_promotion,
                '<a class="btn btn-success btn-default edit-annual-quote" data-target="#edit-annual-quote" data-toggle="modal" data-id="'.$arr->id.'" data-cost="'.$arr->cost.'" data-begin_promotion="'.$arr->begin_promotion.'" data-end_promotion="'.$arr->end_promotion.'">Actualizar</a>'
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

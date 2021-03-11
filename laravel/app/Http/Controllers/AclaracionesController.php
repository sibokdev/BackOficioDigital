<?php

namespace App\Http\Controllers;

use App\Aclaraciones;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\User;
class AclaracionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if((Auth::user()->id_role == 2) || (Auth::user()->id_role == 1)){
            $clarifications_pending=Aclaraciones::where('status','=',1)->get();
            $clarifications_no_pending=Aclaraciones::where('status','!=',1)->get();
            $customers_db = User::where('id_role',3)->get();
            $customers = array();
            foreach($customers_db as $key => $value){
                $customers[$value->id] = $value;
            }
            return view('aclaraciones.aclaraciones')->with('clarifications_pending', $clarifications_pending)
                ->with('customers',$customers)->with('clarifications_no_pending',$clarifications_no_pending);

        }
        return redirect('/home');
    }


    public function solution(Request $request)
    {
        $folio=$request['folio'];
        $solution_type=$request['solution-type'];
        $solution_description=$request['solution-description'];
        Aclaraciones::where('folio','=',$folio)->update([
            'solution_type'=>$solution_type,
            'description_solution'=>$solution_description,
            'status'=>2
        ]);


        Session::flash('message','Solucion hecha correctamente'.$request['content']);
        return redirect('/aclaraciones/aclaraciones');
    }

    //Ajax data
    /*
     * This function get the data from the DB through a query, return this with the data of the DataTable to  the script in the view "aclaraciones.aclaraciones" and show this data in a table.
     * $request contain all the attributes of dataTable.
     */
    /**
     * @param Request $request
     * @return array
     */
    public function ajaxMainDataTable(Request $request)
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
        $query = DB::table('clarifications as clarification')
            ->select(
                DB::raw('clarification.folio as folio'),
                DB::raw('(CASE WHEN clarification.clarification_type = 1 THEN "Cobro excesivo" WHEN clarification.clarification_type = 2 THEN "Servicios no reconocidos" WHEN clarification.clarification_type = 3 THEN "Cuentas de usuario"  END) as clarification_type'),
                DB::raw('clarification.content as clarification'),
                DB::raw('(CASE WHEN clarification.solution_type = 1 THEN "A favor del cliente(Procedente)" WHEN clarification.solution_type = 2 THEN "Inprocedente" WHEN clarification.solution_type = 3 THEN "Aclarado(No monetario)" WHEN clarification.solution_type = 4 THEN "Solicitud atendida" END) as solution_type'),
                DB::raw('clarification.description_solution as solution'),
                DB::raw('clarification.created_at as date'),
                DB::raw('CONCAT(user.name," ",user.surname1," ",user.surname2) as client'),
                DB::raw('(CASE WHEN clarification.status = 1 THEN "Pendiente" WHEN clarification.status = 2 THEN "Aclarado" WHEN clarification.status = 3 THEN "Cancelado" END) as status')
            )
            ->join('users as user', 'user.id', '=', 'clarification.client_id')
            //->where('service_cost.cost_type', '=',1)
            ->where('user.id_role', '=',3)
            ->where(function($query) use ($search){
                $query->where(DB::raw('CONVERT(CONCAT(user.name," ",user.surname1," ",user.surname2) USING latin1)'), 'like', '%'.$search["value"].'%')
                    ->orwhere('clarification.folio', 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('(CASE WHEN clarification.clarification_type = 1 THEN "Cobro excesivo" WHEN clarification.clarification_type = 2 THEN "Servicios no reconocidos" WHEN clarification.clarification_type = 3 THEN "Cuentas de usuario"  END)'), 'like', '%'.$search["value"].'%')
                    ->orwhere('clarification.content', 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('(CASE WHEN clarification.solution_type = 1 THEN "A favor del cliente(Procedente)" WHEN clarification.solution_type = 2 THEN "Inprocedente" WHEN clarification.solution_type = 3 THEN "Aclarado(No monetario)" WHEN clarification.solution_type = 4 THEN "Solicitud atendida" END) '), 'like', '%'.$search["value"].'%')
                    ->orwhere('clarification.description_solution', 'like', '%'.$search["value"].'%')
                    ->orwhere('clarification.created_at', 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('(CASE WHEN clarification.status = 1 THEN "Pendiente" WHEN clarification.status = 2 THEN "Aclarado" WHEN clarification.status = 3 THEN "Cancelado" END)'), 'like', '%'.$search["value"].'%');
            });

        //records counter
        $total = count($query->get());

        if($order !== ''){
            $orderBy = '';
            switch($order){
                case 0:
                    $orderBy = 'folio';
                    break;
                case 1:
                    $orderBy = 'client';
                    break;
                case 2:
                    $orderBy = 'clarification_type';
                    break;
                case 3:
                    $orderBy = 'solution_type';
                    break;
                case 4:
                    $orderBy = 'solution';
                    break;
                case 5:
                    $orderBy = 'status';
                    break;
                case 6:
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
            if ($arr->status == "Pendiente") {
                $button = '<a class="solution-from-drop-down btn-default btn-success" onclick="solucion('.$arr->folio.')" data-target="#solution" data-toggle="modal" data-folio="'.$arr->folio.'">Solucionar</a>';
            } else {
                $button = '';
            }
            $data[] = [
                $arr->folio,
                htmlentities($arr->client,ENT_SUBSTITUTE),
                $arr->clarification_type,
                $arr->solution_type,
                $arr->solution,
                $arr->status,
                $arr->date,
                $button
                
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
     * This function get the data from the DB through a query, return this with the data of the DataTable to  the script in the view "aclaraciones.aclaraciones" and show this data in a table.
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
        $query = DB::table('clarifications as clarification')
            ->select(
                DB::raw('clarification.folio as folio'),
                DB::raw('(CASE WHEN clarification.clarification_type = 1 THEN "Cobro excesivo" WHEN clarification.clarification_type = 2 THEN "Servicios no reconocidos" WHEN clarification.clarification_type = 3 THEN "Cuentas de usuario"  END) as clarification_type'),
                DB::raw('clarification.content as clarification'),
                DB::raw('(CASE WHEN clarification.solution_type = 1 THEN "A favor del cliente(Procedente)" WHEN clarification.solution_type = 2 THEN "Inprocedente" WHEN clarification.solution_type = 3 THEN "Aclarado(No monetario)" WHEN clarification.solution_type = 4 THEN "Solicitud atendida" END) as solution_type'),
                DB::raw('clarification.description_solution as solution'),
                DB::raw('clarification.created_at as date'),
                DB::raw('clarification.updated_at as updated'),
                DB::raw('CONCAT(user.name," ",user.surname1," ",user.surname2) as client'),
                DB::raw('(CASE WHEN clarification.status = 1 THEN "Pendiente" WHEN clarification.status = 2 THEN "Aclarado" WHEN clarification.status = 3 THEN "Cancelado" END) as status')
            )
            ->join('users as user', 'user.id', '=', 'clarification.client_id')
            //->where('service_cost.cost_type', '=',1)
            ->where('user.id_role', '=',3)
            ->where(function($query) use ($search){
                $query->where(DB::raw('CONVERT(CONCAT(user.name," ",user.surname1," ",user.surname2) USING latin1)'), 'like', '%'.$search["value"].'%')
                    ->orwhere('clarification.folio', 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('(CASE WHEN clarification.clarification_type = 1 THEN "Cobro excesivo" WHEN clarification.clarification_type = 2 THEN "Servicios no reconocidos" WHEN clarification.clarification_type = 3 THEN "Cuentas de usuario"  END)'), 'like', '%'.$search["value"].'%')
                    ->orwhere('clarification.content', 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('(CASE WHEN clarification.solution_type = 1 THEN "A favor del cliente(Procedente)" WHEN clarification.solution_type = 2 THEN "Inprocedente" WHEN clarification.solution_type = 3 THEN "Aclarado(No monetario)" WHEN clarification.solution_type = 4 THEN "Solicitud atendida" END) '), 'like', '%'.$search["value"].'%')
                    ->orwhere('clarification.description_solution', 'like', '%'.$search["value"].'%')
                    ->orwhere('clarification.created_at', 'like', '%'.$search["value"].'%')
                    ->orwhere('clarification.updated_at', 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('CONCAT(user.name," ",user.surname1," ",user.surname2)'), 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('(CASE WHEN clarification.status = 1 THEN "Pendiente" WHEN clarification.status = 2 THEN "Aclarado" WHEN clarification.status = 3 THEN "Cancelado" END)'), 'like', '%'.$search["value"].'%');
            });

        //records counter
        $total = count($query->get());

        if($order !== ''){
            $orderBy = '';
            switch($order){
                case 0:
                    $orderBy = 'folio';
                    break;
                case 1:
                    $orderBy = 'client';
                    break;
                case 2:
                    $orderBy = 'clarification_type';
                    break;
                case 3:
                    $orderBy = 'solution_type';
                    break;
                case 4:
                    $orderBy = 'status';
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
                $arr->folio,
                '<a class="clarifications-full" data-target="#clarifications-full" data-toggle="modal" data-folio="'.$arr -> folio.'"
                 data-name="'.htmlentities($arr->client,ENT_SUBSTITUTE).'" data-token="'.csrf_token().'" data-status="'.$arr->status.'" data-clarification_type="'.$arr->clarification_type.'" data-clarification_date="'.$arr->date.'"
                 data-content="'.$arr->clarification.'" data-solution_type="'.$arr->solution_type.'" data-solution_date="'.$arr->updated.'" data-content_solution="'.$arr->solution.'">
                 '.htmlentities($arr->client,ENT_SUBSTITUTE).'</a>',
                $arr->clarification_type,
                $arr->solution_type,
                $arr->status
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

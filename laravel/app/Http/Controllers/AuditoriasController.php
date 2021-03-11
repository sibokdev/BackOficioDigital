<?php

namespace App\Http\Controllers;

use App\Audit;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\User;
class AuditoriasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if((Auth::user()->id_role == 2) || (Auth::user()->id_role == 1)){
            return view('auditorias.auditorias');
        }
        return redirect('/home');
    }

    /**
    * METHOD PUT
    *
    * This method is used to complete the audit, change the status to 1 "Auditado"
    * 
    *  @param($id) integer
    *
    *  @return success or in case an error the corresponding data about it
    */
    public function auditar(Request $request)
    {
        $id=$request['id'];
        Audit::where('id','=',$id)->update([
            'status'=>1
        ]);

        Session::flash('message','Auditoria con folio #'.$id.' ejecutada correctamente');
        return redirect('/auditorias/auditorias');
    }

    //Ajax data
    /*
     * This function get the data from the DB through a query, return this with the data of the DataTable to  the script in the view "auditorias.auditorias" and show this data in a table.
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
        $query = DB::table('audits as audit')
            ->select(
                DB::raw('audit.id as id'),
                DB::raw('audit.created_at as date'),
                DB::raw('audit.date as date'),
                DB::raw('CONCAT(user.name," ",user.surname1," ",user.surname2) as client'),
                DB::raw('(CASE WHEN audit.status = 0 THEN "Pendiente" WHEN audit.status = 1 THEN "Auditado" WHEN audit.status = 2 THEN "Cancelado" END) as status')
            )
            ->join('users as user', 'user.id', '=', 'audit.client_id')
            ->where('user.id_role', '=',3)
            ->where(function($query) use ($search){
                $query->where(DB::raw('CONVERT(CONCAT(user.name," ",user.surname1," ",user.surname2) USING latin1)'), 'like', '%'.$search["value"].'%')
                    ->orwhere('audit.id', 'like', '%'.$search["value"].'%')
                    ->orwhere('audit.date', 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('(CASE WHEN audit.status = 0 THEN "Pendiente" WHEN audit.status = 1 THEN "Auditado" WHEN audit.status = 2 THEN "Cancelado" END)'), 'like', '%'.$search["value"].'%');
            });

        //records counter
        $total = count($query->get());

        if($order !== ''){
            $orderBy = '';
            switch($order){
                case 0:
                    $orderBy = 'id';
                    break;
                case 1:
                    $orderBy = 'client';
                    break;
                case 2:
                    $orderBy = 'status';
                    break;
                case 3:
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
                $button = '<a class="auditar-from-drop-down btn-default btn-success" onclick="auditar('.$arr->id.')"  data-target="#auditar" data-toggle="modal" data-id="'.$arr->id.'">Auditar</a>';
            } else {
                $button = '';
            }
            $data[] = [
                $arr->id,
                htmlentities($arr->client,ENT_SUBSTITUTE),
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
     * This function get the data from the DB through a query, return this with the data of the DataTable to  the script in the view "auditorias.auditorias" and show this data in a table.
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
        $query = DB::table('audits as audit')
            ->select(
                DB::raw('audit.id as id'),
                DB::raw('audit.created_at as date'),
                DB::raw('audit.date as date'),
                DB::raw('CONCAT(user.name," ",user.surname1," ",user.surname2) as client'),
                DB::raw('(CASE WHEN audit.status = 0 THEN "Pendiente" WHEN audit.status = 1 THEN "Aclarado" WHEN audit.status = 2 THEN "Cancelado" END) as status')
            )
            ->join('users as user', 'user.id', '=', 'audit.client_id')
            ->where('user.id_role', '=',3)
            ->where(function($query) use ($search){
                $query->where(DB::raw('CONVERT(CONCAT(user.name," ",user.surname1," ",user.surname2) USING latin1)'), 'like', '%'.$search["value"].'%')
                    ->orwhere('audit.id', 'like', '%'.$search["value"].'%')
                    ->orwhere('audit.date', 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('(CASE WHEN audit.status = 1 THEN "Pendiente" WHEN audit.status = 2 THEN "Aclarado" WHEN audit.status = 3 THEN "Cancelado" END)'), 'like', '%'.$search["value"].'%');
            });

        //records counter
        $total = count($query->get());

        if($order !== ''){
            $orderBy = '';
            switch($order){
                case 0:
                    $orderBy = 'id';
                    break;
                case 1:
                    $orderBy = 'client';
                    break;
                case 2:
                    $orderBy = 'status';
                    break;
                case 3:
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
                $arr->id,
                htmlentities($arr->client,ENT_SUBSTITUTE),
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

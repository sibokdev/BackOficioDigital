<?php

namespace App\Http\Controllers;

use App\Type;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\User;
class TiposController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if((Auth::user()->id_role == 2) || (Auth::user()->id_role == 1)){
            return view('tipos.tipos');
        }
        return redirect('/home');
    }


    /**
    * METHOD PUT
    *
    * This method is used to edit a type
    * 
    *  @param($id) integer
    *  @param($name) string
    *
    *  @return success or in case an error the corresponding data about it
    */
    public function editar(Request $request)
    {
        $id=$request['id'];
        $name=$request['name'];
        Type::where('id','=',$id)->update([
            'name'=>$name
        ]);
        

        Session::flash('message','Tipo con id #'.$id.' se actualizó correctamente');
        return redirect('/tipos/tipos');
    }

    /**
    * METHOD DELETE
    *
    * This method is used to delate a type
    * 
    *  @param($id) integer
    *
    *  @return success or in case an error the corresponding data about it
    */
    public function borrar(Request $request)
    {
        $id=$request['id'];
        $type = Type::where('id', '=', $id)->delete();

        Session::flash('message','El tipo '.$type["name"].' eliminado exitosamente ');
        return redirect('/tipos/tipos');
    }

    /**
    * METHOD POST
    *
    * This method is used to add a new type
    * 
    *  @param($name) string
    *
    *  @return success or in case an error the corresponding data about it
    */
    public function agregar(Request $request)
    {
        $name=$request['name'];
        $data = array(
            'name' => $name,
        );
                
        $type = Type::create($data);

        Session::flash('message','Tipo '.$name.' agregada correctamente');
        return redirect('/tipos/tipos');
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
        $query = DB::table('types as tipos')
            ->select(
                DB::raw('tipos.id as id'),
                DB::raw('tipos.name as tipo')
            )
            ->where(function($query) use ($search){
                $query->where('tipos.id', 'like', '%'.$search["value"].'%')
                    ->orwhere('tipos.name', 'like', '%'.$search["value"].'%');
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
                    $orderBy = 'tipo';
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
                $arr->tipo,
                '<a class="eliminar solution-from-drop-down btn-default btn-danger pull-right" data-target="#borrartipo" data-toggle="modal" data-id="'.$arr->id.'">Eliminar</a><a class="modificar solution-from-drop-down btn-default btn-success pull-right" data-target="#edittipo" data-name="'.$arr->tipo.'" data-toggle="modal" data-id="'.$arr->id.'" style="margin-right: 10px;">Editar</a>',
                 
                
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

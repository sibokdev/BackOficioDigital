<?php

namespace App\Http\Controllers;

use App\Aclaraciones;
use App\Documents;
use App\DocumentsInOut;
use App\DocumentsMovements;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class DocumentosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
     * This function get the data from the DB through a query, return this with the data of the DataTable to  the script in the view "documentos.historico" and show this data in a table.
     * $request contain all the attributes of dataTable.
     */
    public function ajaxDataTable(Request $request)
    {
        $start = $request->get('start');
        $length = $request->get('length');
        $draw = $request->get('draw');
        $search = $request->get('search');
        $order = isset($request->get('order')[0]['column']) ? $request->get('order')[0]['column'] : '';
        $orderDir = isset($request->get('order')[0]['dir']) ? $request->get('order')[0]['dir'] : '';
        $data = [];

        $query = DB::table('documents_movements')
            ->select(
                DB::raw('documents.folio as code'),
                DB::raw('documents_movements.new_location as location'),
                DB::raw('documents_movements.date as date'),
                DB::raw('CONCAT(name, " ", surname1, " ", surname2) AS user')
            )
            ->join('documents', 'documents.id', '=', 'documents_movements.document_id')
            ->join('users', 'documents.id_user', '=', 'users.id')
            ->where('documents.status', '=', 1)
            ->where(function($query) use ($search){
                $query->where('documents.folio', 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('(CASE WHEN documents.location = 0 THEN "Con el Cliente" WHEN documents.location=1 THEN "Ingreso a Boveda" WHEN documents.location = 2 THEN "Servicio en Progreso" END)'), 'like', '%'.$search["value"].'%');
            });

        $total = count($query->get());

        if($order !== ''){
            $orderBy = '';
            switch($order){
                case 0:
                    $orderBy = 'code';
                    break;
                case 1:
                    $orderBy = 'location';
                    break;
                case 2:
                    $orderBy = 'arrival';
                    break;
                case 3:
                    $orderBy = 'departure';
                    break;
            }
            if($orderBy !== ''){
                $query->orderBy($orderBy, $orderDir);
            }
        };

        if($length > 0  ){
            $query->skip($start)->take($length);
        }

        foreach($query->get() as $arr) {
            if ($arr->location == 0) {
                $location = "Con el Cliente";
            }
            else if($arr->location == 1){
                $location="Ingreso a Boveda";
            }
            else if($arr->location == 2){
                $location="Servicio en Progreso";
            }
            else{
                $location="No Definido";
            }

            $data[] = [
                $arr->code,
                $location,
                $arr->arrival,
                $arr->departure
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

    /*
     * This function get the data from the DB through a query, return this with the data of the DataTable to  the script in the view "documentos.control" and show this data in the table of the modal "historial del dia".
     * $request contain all the attributes of dataTable.
     */
    public function historicalDayAjaxDataTable(Request $request)
    {
        $start = $request->get('start');
        $length = $request->get('length');
        $draw = $request->get('draw');
        $search = $request->get('search');
        $order = isset($request->get('order')[0]['column']) ? $request->get('order')[0]['column'] : '';
        $orderDir = isset($request->get('order')[0]['dir']) ? $request->get('order')[0]['dir'] : '';
        $data = [];

        $query = DB::table('documents_movements')
            ->select(
                DB::raw('documents.folio as code'),
                DB::raw('documents_movements.new_location as location'),
                DB::raw('documents_movements.date as date'),
                DB::raw('CONCAT(name, " ", surname1, "", surname2) AS user')
            )
            ->join('documents', 'documents.id', '=', 'documents_movements.document_id')
            ->join('users', 'documents.id_user', '=', 'users.id')
            ->where('documents.status', '=', "1")
            ->where(function($query) use ($search){
                $query->where('documents.folio', 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('(CASE WHEN documents.location = 0 THEN "Con el Cliente" WHEN documents.location=1 THEN "Ingreso a Boveda" WHEN documents.location = 2 THEN "Servicio en Progreso" END)'), 'like', '%'.$search["value"].'%');
            });

        $total = count($query->get());
        if ($order == "") {
            $orderBy = 'date';
            $order = 2;
        }
        if($order !== ''){
            $orderBy = '';
            switch($order){
                case 0:
                    $orderBy = 'code';
                    break;
                case 1:
                    $orderBy = 'location';
                    break;
                case 2:
                    $orderBy = 'date';
                    break;
                case 3:
                    $orderBy = 'user';
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
            if ($arr->location == 0) {
                $location = "Con el Cliente";
            }
            else if($arr->location == 1){
                $location="Ingreso a Boveda";
            }
            else if($arr->location == 2){
                $location="Servicio en Progreso";
            }
            else{
                $location="No Definido";
            }

            $data[] = [
                $arr->code,
                $arr->location,
                $arr->date,
                $arr->user
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

    public function show()
    {
        $documents = DB::select('select * from documents');
        return view('documentos.control')->with('documents', $documents);
    }

    public function historico()
    {
        $documents = DB::select('select * from documents');
        return view('documentos.historico')->with('documents', $documents);
    }

    public function saveCode(Request $request) {
		$code=$request['code'];

		if($code) {
            $document = Documents::where('folio', $code)->first();
			$documentInOut = DocumentsInOut::create([
				'document_id' => $document->id,
				'folio' => $code
			]);

			Session::flash('message','El código fue almacenado');
			return redirect('/documentos/control');
		} else {
			Session::flash('message','El código no pertenece a un documento');
			return redirect('/documentos/control');
		}
    }
}

<?php

namespace App\Http\Controllers;

use App\Aclaraciones;
use App\ClientAddress;
use App\Document;
use App\Documentos;
use App\Documents;
use App\ServicesOrder;
use App\ServicesStatus;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class DownloadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cobros()
    {
        $csv_output = "Client,Fecha de Pago,Estatus,Expira \n";
       
        $cobros = DB::select('select * from services_statuses');
        
        foreach($cobros as $key => $value){
            $csv_output .= $value->client_id.",".$value->created_at.",".$value->status.",".$value->expiration_date."\n";
        }
        return view('downloads.excelfile')->with('csv', $csv_output);
    }
    
    public function clientes()
    {
        $csv_output = "Nombre,Apellido Paterno,Apellido Materno,Direcciones,email,Estatus,Fecha Alta,Fecha de Baja \n";
         
        $clients = User::where('role',3)->get();
        $address_db=ClientAddress::all();
        $address=array();
        foreach($address_db as $value){
            $address[$value->client_id]="";
        }
        foreach($address_db as $value){
            if($address[$value->client_id]== null){
                $address[$value->client_id]=$value->address_description.": ".$value->address;
            }
            else{
                $address[$value->client_id]=$address[$value->client_id]."|".$value->address_description.": ".$value->address;
            }
        }
        foreach($clients as $key => $value){
            if($value->status == 1){
                $status = "Activo";
            } else {
                $status = "Inactivo";
            }
            $csv_output .= $value->name.",".$value->first_name.",".$value->last_name.",".$address[$value->id].",".$value->email.",".$status.",".$value->created_at.",".$value->updated_at."\n";
        }
        return view('downloads.excelfile')->with('csv', $csv_output);
    }
    
    public function services()
    {
        $csv_output = "Cliente,Direccion,Tipo de Servicio,Mensajero Asignado,Fecha,Estatus \n";
        $services_order=ServicesOrder::all();
        //$services_annual=ServicesStatus::all();
        //$services=array();
        $users_db=User::all();
        $users=array();
        $address_db=ClientAddress::all();
        $address=array();
        foreach($users_db as $value){
            $users[$value->id]=$value;
        }
        foreach($address_db as $value){
            $address[$value->id]=$value;
        }
        foreach($services_order as  $value){
            if($value->estatus == 1){
                $status = "Programado";
            }
            else if($value -> estatus == 2) {
                $status = "En Curso";
            }
            else if($value -> estatus == 3) {
                $status = "Concluido";
            }
            else if($value -> estatus == 4) {
                $status = "Cancelado";
            }

            if($value->tipo_orden == 1){
                $type_order="Entrega";
            }
            else if($value->tipo_orden == 2){
                $type_order="Recoleccion";
            }
            else if($value->tipo_orden == 3){
                $type_order="Mixto";
            }
            else{
                $type_order="Cuota Anual";
            }

            if($value->mensajero_id != null){
                $messenger=$users[$value->mensajero_id]['name']." ".$users[$value->mensajero_id]['first_name']." ".$users[$value->mensajero_id]['last_name'];
            }
            else{
                $messenger="";
            }

            $csv_output .= $users[$value->cliente_id]['name']." ".$users[$value->cliente_id]['first_name']." ".$users[$value->cliente_id]['last_name'].",".$address[$value->client_address_id]['address'].",".$type_order.",".$messenger.",".$value->fecha.",".$status."\n";
            //$csv_output.=$messenger."--------";

        }
        //return json_encode($csv_output);

        return view('downloads.excelfile')->with('csv', $csv_output);

    }
    

    public function historico()
    {
        $documents = DB::select('select * from documents');
        return view('documentos.historico')->with('documents', $documents);
    }
    
}

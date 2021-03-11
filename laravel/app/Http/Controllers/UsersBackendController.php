<?php

namespace App\Http\Controllers;

use App\ServicesOrder;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\ActionRequest;
use Illuminate\Support\Str;
use Session;
use Redirect;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

class UsersBackendController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
     * This function get the data from the DB through a query, return this with the data of the DataTable to  the script in the view "empleado.mostrar" and show this data in a table.
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

        $query = DB::table('users as user')
            ->select(
                DB::raw('user.id as id'), //0
                DB::raw('CONCAT(user.name," ",user.surname1," ",user.surname2) as employed'),
                DB::raw('user.name as employed_name'),
                DB::raw('user.surname1 as employed_first_name'),
                DB::raw('user.surname2 as employed_last_name'),
                DB::raw('user.email as email'), //2
                DB::raw('user.id_role as role'), //3
                DB::raw('(CASE WHEN user.active_status = 1 THEN "Activo" WHEN user.active_status = 0 THEN "Inactivo" END) as status')
            )
            ->where('user.id_role','!=',3)
            ->where(function($query) use ($search){
                $query->where(DB::raw('CONVERT(CONCAT(user.name," ",user.surname1," ",user.surname2) USING latin1)'), 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('(CASE WHEN user.active_status = 1 THEN "Activo" WHEN user.active_status = 0 THEN "Inactivo" END)'), 'like', '%'.$search["value"].'%')
                    ->orwhere('user.email', 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('(CASE WHEN user.id_role = 1 THEN "Administrador" WHEN user.id_role=2 THEN "Super Administrador" WHEN user.id_role = 4 THEN "Encargado de Boveda" WHEN user.id_role = 5 THEN "Mensajero" END)'), 'like', '%'.$search["value"].'%');
            });

        $total = count($query->get());

        if($order !== ''){
            $orderBy = '';
            switch($order){
                case 0:
                    $orderBy = 'status';
                    break;
                case 1:
                    $orderBy = 'employed';
                    break;
                case 2:
                    $orderBy = 'email';
                    break;
                case 3:
                    $orderBy = 'role';
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
            if ($arr->role == 1) {
                $role = "Administrador";
            }
            else if($arr->role == 2){
                $role="Super Administrador";
            }
            else if($arr->role == 4){
                $role="Encargado de Boveda";
            }
            else if($arr->role == 5){
                $role="Mensajero";
            }
            else{
                $role="No Definido";
            }
            if ($arr->status == 'Inactivo') {
                $activo = '<a href="/empleado/activar/'.$arr->id.'">Activar</a>';
            } else {
               $activo = '<a href="/empleado/suspender/'.$arr->id.'">Suspender</a>';
            }
            $data[] = [
                $arr->status,
                $arr->employed,
                $arr->email,
                $role,
                '<div class="actions">
                    <div class="btn-group">
                        <a class="btn btn-default btn-outline btn-circle btn-sm" href="javascript:;" data-toggle="dropdown" data-close-others="true" aria-expanded="true"> Actions
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a data-target="#stack2" class="modificar" data-name="'.htmlentities($arr->employed_name,ENT_SUBSTITUTE).'" data-first_name="'.htmlentities($arr->employed_first_name,ENT_SUBSTITUTE).'" data-last_name="'.htmlentities($arr->employed_last_name,ENT_SUBSTITUTE).'"
                                data-email="'.$arr->email.'" data-role="'.$arr->role.'" data-id="'.$arr->id.'" data-toggle="modal"> Modificar</a>

                            </li>
                            <li class="divider"> </li>
                            <li>
                                '.$activo.'
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
            //'search'          => $search,
            'data'            => $data,
        ]);

    }

    public function create(Request $request)
    {
        $validator=Validator::make($request->all(), array(
            'name_create' => 'required',
            'first_create' => 'required',
            'last_create'=>'required',
            'password_create'=>'required|confirmed',
            'password_create_confirmation'=>'required',
            'email_create'=>'required|email|unique:users,email',
            'role_create'=>'required'
        ),
            array(
                'name_create.required'=>'El nombre es requerido',
                'first_create.required'=>'El primer apellido es requerido',
                'last_create.required'=>'El segundo apellido es requerido ',
                'password_create.required'=>'El password es requerido ',
                'password_create_confirmation.required'=>'confirmar password es requerido ',
                'password_create.confirmed'=>'El password debe ser igual a confirmar password',
                'email_create.required'=>'El email es requerido',
                'email_create.email'=>'El email debe de ser valido',
                'email_create.unique'=>'El email ya fue registrado',
                'role_create.required'=>'El rol es requerido'
            ));

        $errors=[];
        foreach($validator->errors()->all() as $value){
            $errors[]=$value;
        }
        $e=$validator->errors()->all();
        if($validator->fails()){
            return array('success'=>false,
                         'message'=>$errors);
        }
        else {
            //$passwordGenerate = 'XDFRE';
            //$passwordGenerate = Hash::make(str_random(8));
            //$passwordGenerate = Str::random(8);
            $status = 1;

            //Se envia el correo
            //mail($_POST['email-create'], "PASSWORD", "BIENVENIDO SU PASSWORD ES: " . $passwordGenerate, null, null);

            User::create([
                   'name' => $request['name_create'],
                   'surname1'=>$request['first_create'],
                   'surname2'=>$request['last_create'],
                   'email' => $request['email_create'],
                   'password'=>bcrypt($request['password_create']),
                   'id_role' =>$request['role_create'],
                   'active_status'=>$status
               ]);


            return array('success'=>true,
                         'message'=>'Empleado creado exitosamente');
        }
    }

    public function show()
    {
        $users= User::where('id_role','!=',3);

        return view('empleado.mostrar')->with('users', $users);
    }

    public function getUpdate($id)
    {
        $user=User::find($id);
        return view('empleado.mostrar',['user'=>$user]);
    }

    public function postUpdate(Request $request)
    {
        $id=$request['id'];
        $name=$request['name'];
        $first_name=$request['first-name'];
        $last_name=$request['last-name'];
        $email=$request['email'];
        $role=$request['role'];
        User::where('id','=',$id)->update([
            'name'=>$name,
            'surname1'=>$first_name,
            'surname2'=>$last_name,
            'email'=>$email,
            'id_role'=>$role
        ]);
        Session::flash('message','El usuario fue actualizado ');
        return redirect('/empleado/mostrar');

    }

    public function suspender($id)
    {
        $user = User::find($id);
        if ($user->id_role == 2) {
            # code...
        } else {
            $ban = 0;
            $services=ServicesOrder::where('id_courier',$id)->get();
            if($services != null){
                foreach($services as $key=>$value){
                    if($value -> status == 2){
                        $value->id_courier = 0;
                        $value->save();
                    } elseif ($value -> status == 3) {
                        $ban = 1;
                    }
                }
                if ($ban == 1) {
                    Session::flash('message','El usuario no puede ser suspendido porque tiene ordenes en curso ');
                    return redirect('empleado/mostrar');
                } else {
                    $user->active_status = 0;
                    $user->save();
                    Session::flash('message','El usuario fue suspendido ');
                    return redirect('empleado/mostrar');
                }           
            } else {
                $user->active_status = 0;
                $user->save();
                Session::flash('message','El usuario fue suspendido ');
                return redirect('empleado/mostrar');
            }
        }
        Session::flash('message','No se puede suspender a un superusuario ');
        return redirect('empleado/mostrar');
    }

    public function activar($id)
    {
        $user = User::find($id);
       
        $user->active_status = 1;
        $user->save();
        Session::flash('message','El usuario ha sido activado ');
        return redirect('empleado/mostrar');
    }   
}
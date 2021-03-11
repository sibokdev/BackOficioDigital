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

use Dingo\Api\Routing\Helpers;

class UsersBackendApiController extends Controller
{
	use Helpers;

    public function __construct()
    {
        $this->middleware('api.auth');
    }


   	/*
	validateUser
	Function to validate if the user is able to use the API using the token
   	@return mixed
   	*/
	public function validateUser()
	{
		$user = $this->auth->user();
		if(!$user) {
			$responseArray = [
				'message' => 'Not authorized. Please login again',
				'status' => false
			];

			return response()->json($responseArray)->setStatusCode(403);
		}
		else
		{
			$responseArray = [
			'message' => 'User is authorized',
			'status' => true
			];

			return response()->json($responseArray)->setStatusCode(200);
		}
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
                DB::raw('CONCAT(user.name," ",user.surname1," ",user.surname2) as employed'), //1
                DB::raw('user.email as email'), //2
                DB::raw('user.id_role as role'), //3
                DB::raw('user.active_status as status') //6
            )
            ->where('user.active_status', '=',1)
            ->where(function($query) use ($search){
                $query->where(DB::raw('CONCAT(user.name," ",user.surname1," ",user.surname2)'), 'like', '%'.$search["value"].'%')
                    ->orwhere('user.email', 'like', '%'.$search["value"].'%')
                    ->orwhere(DB::raw('(CASE WHEN user.id_role = 1 THEN "Administrador" WHEN user.id_role=2 THEN "Super Administrador" WHEN user.id_role = 4 THEN "Encargado de Boveda" WHEN user.id_role = 5 THEN "Mensajero" END)'), 'like', '%'.$search["value"].'%');
            });

        $total = count($query->get());

        if($order !== ''){
            $orderBy = '';
            switch($order){
                case 0:
                    $orderBy = 'employed';
                    break;
                case 1:
                    $orderBy = 'email';
                    break;
                case 2:
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

            $data[] = [
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
                                <a data-target="#stack2" class="modificar" data-name="{{$user->name}}" data-first_name="{{$user->first_name}}" data-last_name="{{$user->last_name}}" data-email="{{$user->email}}" data-role="{{$user->role}}" data-id="{{$user->id}}" data-toggle="modal"> Modificar</a>

                            </li>
                            <li class="divider"> </li>
                            <li>
                                <a href="/empleado/suspender/{{$user->id}}">Suspender</a>
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
        //$passwordGenerate = 'XDFRE';
        //$passwordGenerate = Hash::make(str_random(8));
         $passwordGenerate = Str::random(8);
        $status=1;

        //Se envia el correo
        mail($_POST['email-create'],"PASSWORD","BIENVENIDO SU PASSWORD ES: ".$passwordGenerate,null,null);

        /*User::create([
               'name' => $request['name-create'],
               'first_name'=>$request['first_name-create'],
               'last_name'=>$request['last_name-create'],
               'email' => $request['email-create'],
               'password'=>bcrypt($passwordGenerate),
               'role' =>$request['role-create'],
               'status'=>$status
           ]);*/


           Session::flash('message', 'USUARIO REGISTRADO, LA CONTRASEÑA FUE ENVIADA AL CORREO ');
           return redirect('/empleado/mostrar');
    }

    public function show()
    {
        $users= User::all();

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
            'first_name'=>$first_name,
            'last_name'=>$last_name,
            'email'=>$email,
            'role'=>$role
        ]);
        Session::flash('message','EL USUARIO FUE ACTUALIZADO ');
        return redirect('/empleado/mostrar');

    }

    public function suspender($id)
    {
        $user = User::find($id);
        $user->active_status = 2;
        $user->save();

        $services=ServicesOrder::where('mensajero_id',$id)->get();
        if($services != null){
            foreach($services as $key=>$value){
                if($value -> estatus == 1){
                    $value->mensajero_id=0;
                    $value->save();
                }
            }
            Session::flash('message','EL USUARIO FUE SUSPENDIDO ');
            return redirect('empleado/mostrar');
        }
        else{
            Session::flash('message','EL USUARIO FUE SUSPENDIDO ');
            return redirect('empleado/mostrar');
        }

    }
}

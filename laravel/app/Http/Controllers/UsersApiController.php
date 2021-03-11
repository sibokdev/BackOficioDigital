<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\AuthController;
use App\PaymentsMethods;
use App\Security;
use App\SecurityQuestions;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use Dingo\Api\Routing\Helpers;
use Dingo\Api\Auth\Provider\OAuth2;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use App\User;
use DB;
use App\Library\EmailHelper\EmailHandler;
use App\Library\CustomResponsesHandler;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use Illuminate\Support\Facades\Validator;

class UsersApiController extends Controller{

   use Helpers;

   public function store(Request $request){
     $this->validate($request,array(
        'email'=>'unique',
        'birthday'=>'date_format:y/m/d'
     ));
   }

   /**
   * METHOD DELETE
   *
   * This method if for delete a user by his email
   */
   public function deleteUser(Request $request){
      if (!empty($request['email'])) {
         $user = DB::table('users')->where('email', '=', $request['email'])->get();

         $delete_documents = DB::table('documents')->where('id_user', '=', $user[0]->id)->delete();
         $was_delete = DB::table('users')->where('id', '=', $user[0]->id)->delete();

         DB::table('oauth_sessions')->where('owner_id', '=', $user[0]->id)->delete();

         if ($was_delete) {
            return CustomResponsesHandler::response([
               'code' => 200,
               'message' => 'Usuario eliminado con éxito',
               'response' => null
            ]);
         } else {
            return CustomResponsesHandler::response([
               'code' => 404,
               'message' => 'Error al eliminar usuario',
               'response' => null
            ]);
         }
      } else {
          return CustomResponsesHandler::response([
               'code' => 404,
               'message' => 'Email nulo, proporciona uno válido',
               'response' => null
            ]);
      }
   }

   /**
   * METHOD POST
   *
   * This method checks if the user is already registered.
   * If is true return the client data.
   * If is false return a message saying that the password or email are wrong
   *
   * @param($request) contains the user's email and password
   *
   * @return If is true returns the client data, else a message saying that the
   * password or email are wrong both cases in json format
   */
   public function login(Request $request){
      if (!$this->checkEmptyDate(['email' => $request['username'], 'password' => $request['password']])) {

         if (Auth::attempt(['email' => $request['username'], 'password' => $request['password']])) {
            $user = User::where('email', $request['username']);

            if ($user->first()->id_role == 3) {

               $auth = $this->lookingForToken($user->first()->id);

               if (empty($auth)){
                  Authorizer::issueAccessToken();
                  $auth = $this->lookingForToken($user->first()->id);
               }

               return CustomResponsesHandler::response([
                  'code' => 200,
                  'message' => 'Bienvenido a bóveda de documentos',
                  'response' => $this->responseCreate($user->first(), $auth)

               ]);

            } else {
               return CustomResponsesHandler::response([
                  "code" => 404,
                  "message" => "No tienes permisos para iniciar sesión",
                  "response" => null
               ]);
            }

         } else {
            return CustomResponsesHandler::response([
               'code' => 200,
               'message' => 'Usuario o contraseña incorrectas',
               'response' => null
            ]);

         }

      }else{
         return CustomResponsesHandler::response([
            "code" => 404,
            "message" => "Se deben de llenar todos los campos para completar el inicio de sesión",
            "response" => null
         ]);

      }
   }

	/**
	* METHOD GET
	*
	* This method is used to active user
	*
	* @param($request) contains the user's email
	*
	*@return view
	*/
	public function active($email) {
		$user = User::where("email", $email)->first();
		
		if($user) {
			$user->active_status=1;
			$user->save();
			
			return view('auth.active_user')->with('active', $email);
		} else {
			return view('auth.active_user')->with('error', 'Ha ocurrido un error al activar la cuenta');
		}
	}
	
   /**
   * METHOD POST
   *
   * This method is used to register a new user. If was added susseccfully
   * sends a confimation email
   *
   * @param($request) contains the user's email, password, security_question,
   * security_answer, birthday and phone.
   *
   *@return success or in case an error the corresponding data about it
   */
   public function contract(Request $request){

      $data = array(
         "email" => $request['email'],
         "password" =>  $request['password'],
         "security_question" => $request['security_question'],
         "security_answer" => $request['security_answer']
      );
	
      if (!$this->checkEmptyDate($data)) {
         $user = DB::table('users')->where('email', '=', $request['email'])->first();

         if (empty($user)) {
            $data = array(
               'email' => $request['email'],
               'password' => bcrypt($request['password']),
               'id_security_question' => $request['security_question'],
               'security_question_answer' => $request['security_answer'],
               'id_role' => 3,
               'active_status' => 0,
               'created' => Carbon::now(),
               'updated' => Carbon::now()
            );

            $was_inserted = DB::table('users')->insert($data);

            if ($was_inserted) {
				
               $emailHelper = new EmailHandler();
               return $emailHelper->sendEmail([
                  'email' => $request['email'],
                  'subject' => 'Bienvenido a bóveda de documentos',
                  'message' => 'Confirma tu correo para poder usar nuestro servicio ingresando a la siguiente url ' . url('client/active/' . $request['email'])
               ], 'contract');
            }

         } else {
            return CustomResponsesHandler::response([
               "code" => 404,
               "message" => "El email ya esta registrado",
               "response" => null
            ]);
         }
      } else {
         return CustomResponsesHandler::response([
            "code" => 404,
            "message" => "Datos vacíos",
            "response" => null
         ]);
      }
   }

   /**
   * METHOD PUT
   *
   * This method is used to complete the registration of a new user.
   * Validate if the token belongs to the client_id provided
   *
   * @param($client_id) the user id
   * @param($request) contains name, surname1, surname2, gender, brithday, phone,
   *
   * @return success or in case an error the corresponding data about it
   *
   */
   public function completeData($client_id, Request $request){
      $access_token = trim(str_replace('Bearer', '', $request->header('Authorization')));

      if ($access_token == $this->lookingForToken($client_id)[0]->token) {
         $user = User::find($client_id);

         if (empty($user)) {
            return CustomResponsesHandler::response([
               "code" => 404,
               "message" => "El usuario no existe",
               "response" => null
            ]);
         } else {
            if ($this->checkEmptyDate($request)) {
               return CustomResponsesHandler::response([
                  "code" => 404,
                  "message" => "Faltan datos para completar el registro del cliente",
                  "response" => null
               ]);

            }else {

               $user->name = $request['name'];
               $user->surname1 = $request['surname1'];
               $user->surname2 = $request['surname2'];
               $user->gender = $request['gender'];
               $user->birthday = $request['birthday'];
               $user->phone = $request['phone'];
               $user->profile_status = 1;

               $was_updated = $user->save();

               if ($was_updated){
                  return CustomResponsesHandler::response([
                     "code" => 200,
                     "message" => "Datos actualizados correctamente",
                     "response" => $this->responseCreate(User::find($client_id), $this->lookingForToken($user->id))
                  ]);

               } else {
                  return CustomResponsesHandler::response([
                     "code" => 404,
                     "message" => "Error al actualizar los datos",
                     "response" => null
                  ]);
               }
            }
         }
      } else {
         return CustomResponsesHandler::response([
            "code" => 404,
            "message" => "permisos denegados para el client con id " . $client_id,
            "response" => null
         ]);
      }
   }

   /**
   * METHOD POST
   *
   * This method is for generate a new password
   *
   * @param($password) string
   * @param($newpassword) string
   *
   * @return success or an error body
   */
	public function changePassword(Request $request) {
		$user = $this->auth->user();

         if(!$user) {
            return CustomResponsesHandler::response([
                "code" => 401,
                "message" => "Permisos denegados para el cliente",
                "response" => null
            ]);
        } else {
            $user = User::where("id", $user->id)->first();

            $validator = Validator::make($request->all(), ['password' => 'required', 'newpassword' => 'required'],['password.required' => 'El campo password es requerido.', 'newpassword.required' => 'El campo newpassword es requerido.']);

			if($validator->fails()) {
				return CustomResponsesHandler::response([
                    "code" => 400,
                    "message" => "Error en los parámetros: " . implode(", ", $validator->errors()->all()),
                    "response" => null
                ]);
			}

            if($user) {
                if (password_verify($request['password'], $user->password)) {
                    $user->password = bcrypt($request['newpassword']);
                    $user->save();
                    $emailHelper = new EmailHandler();
                    return $emailHelper->sendEmail([
                       'email' => $user->email,
                       'subject' => 'Bóveda de documentos: Cambio de contraseña',
                       'message' => 'Tu contraseña ha sido modificada con exito'
                   ], 'change');

                    return CustomResponsesHandler::response([
                        "code" => 200,
                        "message" => "Contraseña modificada",
                        "response" => null
                    ]);
                } else {
                    return CustomResponsesHandler::response([
                        "code" => 202,
                        "message" => "Contraseña incorrecta",
                        "response" => null
                    ]);
                }

            } else {
                return CustomResponsesHandler::response([
                    "code" => 202,
                    "message" => "No se encontró el usuario",
                    "response" => null
                ]);
            }
        }
	}

   /**
   * METHOD PUT
   *
   * This method is for generate a new password and sent to the user email
   * also, the new password is added like an update in the users table
   *
   * @param($request) contains the user email
   *
   * @return success or an error body
   */
   public function recoveryPassword(Request $request){

      if (empty($request['email'])) {
         return CustomResponsesHandler::response([
            "code" => 404,
            "message" => "El correo proporcionado es nulo",
            "response" => null
         ]);
      }else{
         $exists = User::where('email',  $request['email'])->where('id_role', 3);

         if (empty($exists->first())) {
            return CustomResponsesHandler::response([
               "code" => 404,
               "message" => "El correo proporcionado no esta en nuestra base de datos",
               "response" => null
            ]);

         } else {
            $user = User::where('email','=', $request['email']);
            $new_password = str_random(10);

            $was_updated = DB::table('users')
               ->where('email', $request['email'])
               ->update(['password' => Hash::make($new_password)]);

            if ($was_updated) {
               $emailHelper = new EmailHandler();
               return $emailHelper->sendEmail([
                  'email' => $request['email'],
                  'subject' => 'Bóveda de documentos: Recuperación de contraseña',
                  'message' => 'Se ha generado una contraseña temporal'. ' ' . $new_password
               ], 'recovery');

            } else {
               return response()->json([
                  "code" => 404,
                  "message" => "La contraseña no se actualizó en la base de datos",
                  "response" => null
               ]);
            }
         }
      }
   }

   /**
   * METHOD DELETE
   *
   * This method delete the session of a user
   *
   * @param($client_id) the user's id
   *
   * @return code 200 if a session was delete successfully or code 404 in case an error
   */
   public function logout($client_id, Request $request){
      $access_token = trim(str_replace('Bearer', '', $request->header('Authorization')));

      if ($access_token == $this->lookingForToken($client_id)[0]->token) {
         $was_delete = DB::table('oauth_sessions')->where('owner_id', '=', $client_id)->delete();

         if ($was_delete) {
            return CustomResponsesHandler::response([
               'code' => 200,
               'message' => 'Sesión cerrada',
               'response' => null
            ]);

         } else {
            return CustomResponsesHandler::response([
               'code' => 404,
               'message' => 'Error al cerrar sesión',
               'response' => null
            ]);
         }

      } else {
         return CustomResponsesHandler::response([
            "code" => 404,
            "message" => "permisos denegados para el client con id " . $client_id,
            "response" => null
         ]);
      }

   }


   /*
   * METHOD GET
   *
   * This method is used to obtain all the services of a client depending
   * on the given client_id
   *
   * @param($client_id) client id
   *
   * @return all the service of the client
   *
   */
   public function showAllServices($client_id){
      $dummie = array(
         array(
            "client_id" => 3123123,
            "audit_date" => "2016-11-10",
            "address" => "Insurgentes 213",
            "documents"  => [],
            "order_type" => 3,
            "status" => 2,
            "courier_id" => 16791721),
         array(
            "client_id" => 432243,
            "audit_date" => "2016-12-10",
            "address" => "Aldama 213",
            "documents"  => [],
            "order_type" => 1,
            "status" => 1,
            "courier_id" => 16791721
         )
      );

      return response()->json($dummie);
   }

   /*
   * METHOD GET
   *
   * This method is used to obtain a service of a client depending
   * on the given client_id
   *
   * @param($client_id) the client id
   * @param($service_id) the service id
   *
   * @return success or in case an error the corresponding data about it
   *
   */
   public function serviceDetail($client_id, $service_id){
      return response()->json([
         "client_id" => 3123123,
         "audit_date" => "2016-11-10",
         "address" => "Insurgentes 213",
         "documents"  => [],
         "order_type" => 3,
         "status" => 2,
         "courier_id" => 16791721
      ]);
   }

   public function selectPaymentMethod(Request $request){
        $email=$request['email'];
        $selected=$request['payment-method'];
        PaymentsMethods::where('email',$email)->update(array(
            'payment_method'=>$selected
        ));
        return json_encode(array(
            'status'=>200,
            'messenger'=>'Metodo de pago guardado'
        ));
   }

   public function paymentMethodData(Request $request){
      $email=$request['email'];
      $titular_name=$request['titular-name'];
      $card_number=$request['card-number'];
      $expiration=$request['expiration'];
      $cvv=$request['cvv'];
      $postal_code=$request['postal-code'];

      PaymentsMethods::where('email',$email)->update(array(
         'titular_name'=>$titular_name,
         'card_number'=>$card_number,
         'expiration'=>$expiration,
         'cvv'=>$cvv,
         'postal_code'=>$postal_code
      ));

      return json_encode(array(
         'status'=>200,
         'messenger'=>'Datos de pago almacenados'
      ));
   }

   /**
   * this method makes the response
   */
   private function responseCreate($user, $auth){
      return array(
         'user' => array(
            'client_id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'surname1' => $user->surname1,
            'surname2' => $user->surname2,
            'gender' => $user->gender,
            'phone' => $user->phone,
            'birthday'=>$user->birthday,
            'id_role' => $user->id_role,
            'id_security_question' => $user->id_security_question,
            'security_question_answer' => $user->security_question_answer,
            'active_status' => $user->active_status,
            'pay_status' => $user->pay_status,
            'profile_status' => $user->profile_status
         ),
         'auth' => array(
           'token' => $auth[0]->token,
           'expires' => $auth[0]->expires
         )
      );
   }

   /**
   * This method works to make a query for get the token if exist of the
   * user that want to login
   *
   * @param($user_id) the user id
   * @return token or expire of the session or null if the session does not
   * exists yet
   */
   public function lookingForToken($user_id){
      return DB::table('oauth_access_tokens')
         ->join('oauth_sessions', 'oauth_sessions.id', '=', 'oauth_access_tokens.session_id')
         ->where('owner_id', '=', $user_id)
         ->select('oauth_access_tokens.id AS token', 'oauth_access_tokens.expire_time AS expires')
         ->get();
   }

   /**
   * This method checks if a fields is empty
   *
   * @param($data) contains an array of fields
   *
   * @return true if some field in array is empty or false
   * is all fields in array are not empty
   */
   private function checkEmptyDate($data){
      foreach ($data as $value) {
         if (empty($value)) {
            return true;
         }
      }

      return false;
   }

}

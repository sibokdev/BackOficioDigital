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

class CouriersApiController extends Controller{
    
    /**
   * METHOD POST
   *
   * This method checks if the courier is already registered.
   * If is true return the courier data.
   * If is false return a message saying that the password or email are wrong
   *
   * @param($request) contains the courier's email and password
   *
   * @return If is true returns the courier data, else a message saying that the
   * password or email are wrong both cases in json format
   */
   public function login(Request $request){
      if (!$this->checkEmptyFields(['email' => $request['username'], 'password' => $request['password']])) {

         if (Auth::attempt(['email' => $request['username'], 'password' => $request['password']])) {
            $user = User::where('email', $request['username']);

            if ($user->first()->id_role == 5) {

               $auth = $this->lookingForToken($user->first()->id);

               if (empty($auth)){
                  Authorizer::issueAccessToken();
                  $auth = $this->lookingForToken($user->first()->id);
               }

               return CustomResponsesHandler::response([
                  'code' => 200,
                  'message' => 'Sesión iniciada correctamente',
                  'response' => array(
                        'user' => array(
                            'client_id' => $user->first()->id,
                            'email' => $user->first()->email
                        ), 
                        'auth' => array(
                            'token' => $auth[0]->token,
                            'expires' => $auth[0]->expires
                        ) 
                    )

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
   * METHOD DELETE
   *
   * This method delete the session of a courier 
   *
   * @param($courier_id) the courier's id
   *
   * @return code 200 if a session was delete successfully or code 404 in case an error
   */
   public function logout($courier_id, Request $request){
      $access_token = trim(str_replace('Bearer', '', $request->header('Authorization')));

      if ($access_token == $this->lookingForToken($courier_id)[0]->token) {
         $was_delete = DB::table('oauth_sessions')->where('owner_id', '=', $courier_id)->delete();

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
            "message" => "permisos denegados para el client con id " . $courier_id,
            "response" => null
         ]);
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
    public function recoveryPassword(Request $request) {
		if(empty($request['email'])) {
			return CustomResponsesHandler::response([
				"code" => 404,
				"message" => "El correo proporcionado es nulo",
				"response" => null
			]);
		} else {
			$exists = User::where('email',  $request['email'])->where('id_role', 5);
			
			if(empty($exists->first())) {
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
				
				if($was_updated) {
					$emailHelper = new EmailHandler();
					return $emailHelper->sendEmail([
						'email' => $request['email'],
						'subject' => 'Boveda de documentos: Recuperación de contraseña',
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
   * This method checks if a fields is empty
   *
   * @param($data) contains an array of fields 
   *
   * @return true if some field in array is empty or false 
   * is all fields in array are not empty
   */
   private function checkEmptyFields($data){
      foreach ($data as $value) {
         if (empty($value)) {
            return true;
         }
      }

      return false;
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

}

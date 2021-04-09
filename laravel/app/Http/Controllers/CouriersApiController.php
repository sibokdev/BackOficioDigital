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
use Illuminate\Support\Facades\Storage;


use Dingo\Api\Routing\Helpers;
use Dingo\Api\Auth\Provider\OAuth2;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use App\User;
use App\PersonalDirection;
use App\PersonalRerefence;
use App\WorkReference;
use App\random_code;
use DB;
use File;
use App\Library\EmailHelper\EmailHandler;
use App\Library\CustomResponsesHandler;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

//librerias http call
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;


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
      if (!$this->checkEmptyFields(['email' => $request['username'], 'phone' => $request['username'], 'password' => $request['password']])) {
         
         if (!str_contains($request['username'],'@')) {
            $user = User::where('phone', $request['username']);
            $request['username'] = $user->first()->email;
         }
         
         if (Auth::attempt(['email' => $request['username'],'password' => $request['password']])) {
            
            $user = User::where('email', $request['username']);

            if ($user->first()->status == 12) {

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
			$exists = User::where('email',  $request['email'])->where('status', 11);
			
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
    
   public function registerProveedorServicios(Request $request){
    
         
          $phone = $request->phone;
          $INEfront = $request->INEfront;
          $INEBack = $request->INEBack;
  
       Storage::disk('ftp')->put($phone.'/ineF.jpg', $INEfront);
       Storage::disk('ftp')->put($phone.'/ineB.jpg', $INEBack);
      
     $url = "$phone/ineF.jpg";
     $url1 = "$phone/ineB.jpg";
     
      //$useriD1 = DB::table('users')->insertGetId($data);
     $fotos = array(
          'name' => $request['name'],
          'surname1' =>$request['surname1'],
          'surname2'=>$request['surname2'],
          'birthday'=>$request['birthday'],
          'age'=>$request['age'],
          'password' => bcrypt($request['password']),
          'INEKey'=>$request['INEKey'],
          'office'=>$request['office'],
          'INEfront'=>$url,
          'INEBack'=>$url1,
          'phone'=>$request['phone'],
          'email'=>$request['email'],
          'status'=>11);
      
        
        $useriD = DB::table('users')->insertGetId($fotos);
      //return Storage::disk('ftp')->get($phone.'/ineF.jpg');

      
      $compro = $request->comprodomi;
      Storage::disk('ftp')->put($phone.'/compro_domicilio.jpg', $compro);
      $url3 = "$phone/compro_domicilio.jpg";
      //$was_inserted2 = DB::table('PersonalDirection')->insert($data1);
      $foto = array(
           'calle' => $request['calle'],
           'numero' => $request['numero'],
           'codigopostal'=>$request['codigopostal'],
           'colonia' => $request['colonia'],
           'municipio' => $request['municipio'],
           'estado' => $request['estado'],
           'latitud' => $request['latitud'],
           'longitud'=>$request['longitud'],
           'comprodomi' => $url3,
           'users_id' => $useriD);
       
       $was_inserted2 = DB::table('PersonalDirection')->insert($foto);
       
        
       $data2 = array(

         'pnombre' => $request['pnombre'],
         'papellidos' => $request['papellidos'],
         'ptelefono1' => $request['ptelefono1'],
         'ptelefono2' => $request['ptelefono2'],
         'pnombre2' => $request['pnombre2'],
         'papellidos2' => $request['papellidos2'],
         'ptelefono12' => $request['ptelefono12'],
         'ptelefono22' => $request['ptelefono22'],
         'users_id' => $useriD
         
      );
       
       $was_inserted1 = DB::table('PersonalReferences')->insert($data2);
       
         $data3 = array(

         'wnombre' => $request['wnombre'],
         'wapellidos' => $request['wapellidos'],
         'wtelefono1' => $request['wtelefono1'],
         'wtelefono2' => $request['wtelefono2'],
         'wnombre2' => $request['wnombre2'],
         'wapellidos2' => $request['wapellidos2'],
         'wtelefono12' => $request['wtelefono12'],
         'wtelefono22' => $request['wtelefono22'],
         'users_id' => $useriD
         
      );
      $was_inserted3 = DB::table('WorkReferences')->insert($data3);
     
        
      if ($was_inserted3) {
      
         return ([
         "code"=>$useriD,
         "message" => "El se acaba de registrar los datos",
         "id" =>  $useriD
         
      ]);
    

   } else {
      return CustomResponsesHandler::response([
         "code" => 404,
         "message" => "El email ya esta registrado",
         "response" => null
      ]);
   
    }
    
    return $useriD;
   }
   

   
   public function generateInvitationCode(Request $request){
        $data4 = array(
          'keycode' => rand(100000,900000),
          'phone' => $request['phone'],
          //'users_id' => $useriD
          );
          
          
          $phone = $request ['phone'];
          $keycode = $request->keycode;
          
          $existencia = DB::table('random_codes')
          ->select('keycode')
          ->where('keycode', '=', $keycode)
          ->get();
          
        if (count($existencia) >= 1) {  
           
		}else{
            $was_inserted4 = DB::table('random_codes')->insert($data4);
            
            $phone1 = DB::table('random_codes')
            ->select('keycode')
            ->where('phone',"=",$phone)
            ->get();
            
             if (count($existencia) >= 1) {  
                 
                
             }else{
                 
                 $code = implode(',', array_column($phone1, 'keycode'));
                 
                  $client = new Client([
                'headers' => [ 'Content-Type' => 'application/json' ]
            ]);
             $response = $client->post('https://drber.com.mx/example/send_sms.php',
                ['body' => json_encode(
                    [
                        'to' => "$phone",
                        'message' => "Bienvenido a Oficio Digital tu código de acceso es: $code"
                    ]
                )]
            );
            
            }
            
        }	
       
   }

   
       public function validateCode(Request $request){
           
           $code = $request['code'];
           
           
          $verifi = DB::table('random_codes')
          ->select('keycode')
          ->where('keycode', "=", $code)
          ->get();
           
           if($verifi){
               
               $was_inserted4 = DB::table('random_codes')
               ->select('keycode')
               ->where('keycode', "=",$code)
               ->delete();
               
                 return ([
         "message" => "existe",
         "code" => 200,
         "response"=>$verifi
        
         
      ]);
    
           }else{
               
                
                 return ([
         "message" => "no existe",
         "code" => 404
         
      ]);
    
           }
           
         
          
       }
       
       
       
       public function CodigosPostales(Request $request){
              
              $cp = $request['codigopostal'];
               $url = "http://api-sepomex.hckdrk.mx/query/info_cp/$cp?token=a6425d19-2a37-455f-9914-640c316a37b0";
          
            $client = new Client();
            $response = $client->get($url);
            if ($response->getBody()) {
                $data= json_decode((string) $response->getBody(), true);
                
            }
              return ([
                    "code" => 200,
              "message" => "existe",
              "response" =>$data
              ]);
       }
       
       public function reenviarCode(Request $request){
           
           $datos = array(
               'phone'=>$request['phone'],
               'keycode' => rand(100000,900000),
               );
           
           $phone = $request['phone'];
           $code = $request['keycode'];
           
            $verifi1 = DB::table('random_codes')
          ->select('phone')
          ->where('phone', "=", $phone)
          ->get();
           
           if($verifi1){
               
                $was_inserted6 = DB::table('random_codes')
               ->select('phone')
               ->where('phone', "=",$phone)
               ->delete();
               
               
                   $insert = DB::table('random_codes')->insert($datos);
                   
                     $client = new Client([
                    'headers' => [ 'Content-Type' => 'application/json' ]
                     ]);
                   $response = $client->post('https://drber.com.mx/example/send_sms.php',
                   ['body' => json_encode(
                    [
                        'to' => "$phone",
                        'message' => "Bienvenido a Oficio Digital tu código de acceso es: $code"
                    ]
                )]
            );
                   
               
                 return ([
         "message" => "existe",
         "code" => 200,
         "response"=>$verifi1
         ]);
               
               
           }else{
               
               
                 
                 return ([
         "message" => "no existe",
         "code" => 404
         
      ]);
           }
           
       }

      public function getOficiosCatalog(Request $request){
         return ([ "message" => "Existe","code" => 200]);
      }
   }



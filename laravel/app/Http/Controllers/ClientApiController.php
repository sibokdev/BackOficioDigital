<?php

namespace App\Http\Controllers;

use App\User;

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



class ClientApiController extends Controller{

	use Helpers;

	public function __construct(){
		$this->middleware('api.auth');
	}
   	/*
		validateUser
		Function to validate if the user is able to use the API using the token
   	@return mixed
   	*/
	public function validateUser(){
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
      return response()->json([
        'client_id' => '23123123981023',
        'email' => 'juan@gmail.com',
        'name' => 'Juan Pérez',
        'token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9',
        'expires' => '2016-10-30T20:56:00.000Z',
      ]);
   }

   /*
   * METHOD POST
   *
   * This method is used to register a new user.
   *
   * @param($request) contains the user's email, password, security_question,
   * security_answer, birthday and phone.
   *
   *@return success or in case an error the corresponding data about it
   */
   public function contract(Request $request){
      $data = array(
         $request['email'],
         $request['password'],
         $request['security_question'],
         $request['security_answer'],
         $request['birthday'],
         $request['phone']
      );

      if ($this->checkEmptyDate($data)) {
         return response()->json([
            "code" => 400,
            "success" => false,
            "message" => "Faltan datos para registar un nuevo cliente",
            "user_message" => "Ocurrió un error al registar un nuevo servicio"
         ]);

      }else {
         return response()->json([
            "success" => true
         ]);
      }
   }

   /*
   * METHOD PUT
   *
   * This method is used to complete the registration of a new user.
   *
   * @param($client_id) the user is
   * @param($request) contains the user's first_name, last_name,
   * mothers_last_name, genre, birthday and phone
   *
   * @return success or in case an error the corresponding data about it
   *
   */
   public function completeData($client, Request $request){
      $data = array(
         $request['first_name'],
         $request['last_name'],
         $request['mothers_last_name'],
         $request['genre'],
         $request['birthday'],
         $request['phone']
      );

      if ($this->checkEmptyDate($data)) {
         return response()->json([
            "code" => 400,
            "success" => false,
            "message" => "Faltan datos para completar el registro del cliente",
            "user_message" => "Ocurrió un error al registar un nuevo servicio"
         ]);

      }else {
         return response()->json([
            "success" => true
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

   private function checkEmptyDate($data){
      foreach ($data as $value) {
         if (empty($value)) {
            return true;
         }
      }
      return false;

   }

}

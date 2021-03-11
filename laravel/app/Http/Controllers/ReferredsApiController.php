<?php

namespace App\Http\Controllers;

use App\UsersReferred;
use App\User;
use Illuminate\Support\Facades\Mail;

use Input;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Dingo\Api\Routing\Helpers;

use App\Library\EmailHelper\EmailHandler;
use App\Library\CustomResponsesHandler;
use Carbon\Carbon;


class ReferredsApiController extends Controller {

    use Helpers;

    public function __construct() {
        $this->middleware('api.auth');
    }

    /**
    * METHOD POST
    *
    * This method is used to invite friends
    *
    * @param($emails) string
    *
    *  @return success or in case an error the corresponding data about it
    */
    public function addReferreds(Request $request) {
        $user = $this->auth->user();

        if(!$user) {
            return CustomResponsesHandler::response([
                "code" => 401,
                "message" => "Permisos denegados para el cliente",
                "response" => null
            ]);
        } else {
            $validator = Validator::make($request->all(), $this->getRules("rules"), $this->getRules("errors"));

            if($validator->fails()) {
                return CustomResponsesHandler::response([
                    "code" => 400,
                    "message" => "Error en los parametros: " . implode(", ", $validator->errors()->all()),
                    "response" => null
                ]);
            } else {
                $emails = $request->get("emails");
                $emails_array = explode(",", $emails);
                $referred = [];

                foreach($emails_array as $key => $email) {

                    $data = array(
                        'id_user' => $user->id,
                        'id_referred_user' => 0,
                        'email' => trim($email)
                    );

                    $ref = UsersReferred::where('id_user', $user->id)->where('email', '=', $email)->first();

                    if ($ref == null) {
                        array_push($referred, UsersReferred::create($data));
                        end($referred)->save();
                     }

                    if($referred and isset(end($referred)->id)) {
                        $emailHelper = new EmailHandler();

                        $send = $emailHelper->sendEmail(
							[
							  'email' => trim($email),
							  'subject' => 'Te invitamos a conocer nuestra app Boveda',
							  'message' => 'Hola, te invitamos a uzar nuestra app de Boveda disponible pata iOS y Android http://www.elitechlab.com/es/'
							],
							'invitation'
						);
                    }
                }


                if($referred and isset(end($referred)->id)) {
                    return CustomResponsesHandler::response([
                        "code" => 200,
                        "message" => "Amigos invitados exitosamente",
                        "response" => array("referred" => $referred)
                    ]);
                } else {
                    return CustomResponsesHandler::response([
                        "code" => 400,
                        "message" => "Error al invitar amigos",
                        "response" => null
                    ]);
                }
            }
        }
    }

        /**
    * METHOD GET
    *
    * This method is used to get all referends by client
    *
    *  @return success or in case an error the corresponding data about it
    */
    public function getReferreds() {
        $user = $this->auth->user();

        if(!$user) {
            return CustomResponsesHandler::response([
                "code" => 401,
                "message" => "Permisos denegados para el cliente",
                "response" => null
            ]);
        } else {
            $Referreds = UsersReferred::where('id_user', $user->id)->get(["email"]);

            if($Referreds->count()) {
                return CustomResponsesHandler::response([
                    "code" => 200,
                    "message" => "Listado de correos invitados",
                    "response" => array("emails" => $Referreds)
                ]);
            } else {
                return CustomResponsesHandler::response([
                    "code" => 202,
                    "message" => "No se encontraron correos",
                    "response" => null
                ]);
            }
        }
    }

    /**
    * getRules
    *
    * This method is used to get rules or errors
    *
    *  @return array
    */
    private function getRules($type = "rules") {
        if($type == "rules") {
            return array(
                'emails' => 'required',
            );

        } else {
            return array(
                'emails.required' => "emails es requerido",

            );
        }
    }

}

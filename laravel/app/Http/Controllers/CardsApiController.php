<?php

namespace App\Http\Controllers;

use App\Card;
use App\User;

use Input;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use Dingo\Api\Routing\Helpers;

use App\Library\CustomResponsesHandler;
use Carbon\Carbon;

class CardsApiController extends Controller {

    use Helpers;

    public function __construct() {
        $this->middleware('api.auth');
    }

    /**
    * METHOD POST
    *
    * This method is used to create a Card
    *
    * @param($name) string
    * @param($number) string
    * @param($expiration_month) string
    * @param($expiration_year) string
    * @param($token) string
    * 
    *  @return success or in case an error the corresponding data about it
    */
    public function addCard(Request $request) {
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
                    "message" => "Error en los parametros" . $validator->errors()->all(),
                    "response" => null
                ]);
            } else {  
                  
                $data = array(
                    'client_id' => $user->id,
                    'name' => $request->get("name"),
                    'number' => $request->get("number"),
                    'expiration_month' => $request->get("expiration_month"),
                    'expiration_year' => $request->get("expiration_year"),
                    'token' => $request->get("token"),
                    'idApiCard' => ""
                );
                
                $card = Card::create($data);
                $card->save();
                
                if($card and isset($card->id)) {
                    return CustomResponsesHandler::response([
                        "code" => 200,
                        "message" => "Tarjeta registrada exitosamente",
                        "response" => array("card" => $card)
                    ]);
                } else { 
                    return CustomResponsesHandler::response([
                        "code" => 400,
                        "message" => "Error al registrar la tarjeta",
                        "response" => null
                    ]);
                }
            }
        }
    }

    /**
    * METHOD GET
    *
    * This method is used to get all cards by client
    * 
    *  @return success or in case an error the corresponding data about it
    */
    public function getCards() {
        $user = $this->auth->user();
        
        if(!$user) {
            return CustomResponsesHandler::response([
                "code" => 401,
                "message" => "Permisos denegados para el cliente",
                "response" => null
            ]);
        } else {
            $cards = Card::where('client_id', $user->id)->get();
            
            if($cards->count()) {
                return CustomResponsesHandler::response([
                    "code" => 200,
                    "message" => "Listado de tarjetas registradas",
                    "response" => array("cards" => $cards)
                ]);
            } else { 
                return CustomResponsesHandler::response([
                    "code" => 202,
                    "message" => "No se encontraron tarjetas registradas",
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
                'name' => 'required',
                'number' => 'required',
                'expiration_month' => 'required',
                'expiration_year' => 'required',
                'token' => 'required',
            );
            
        } else {
            return array(
                'name.required' => "name es requerido",
                'number.required' => "number es requerido",
                'expiration_month.required' => "expiration_month es requerido",
                'expiration_year.required' => "expiration_year es requerido",
                'token.required' => "token es requerido",
            );
        }
    }

}

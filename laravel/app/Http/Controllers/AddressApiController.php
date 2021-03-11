<?php

namespace App\Http\Controllers;

use App\ClientAddress;
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

class AddressApiController extends Controller {

    use Helpers;

    public function __construct() {
        $this->middleware('api.auth');
    }

    /**
    * METHOD POST
    *
    * This method is used to create new address
    *
    * @param($address) string
    * @param($alias) string
    * @param($longitude) double
    * @param($latitude) double
    *
    *  @return success or in case an error the corresponding data about it
    */
    public function addAddress(Request $request) {
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
                    "message" => "Error en los parámetros: " . implode(", ", $validator->errors()->all()),
                    "response" => null
                ]);
            } else {
                $data = array(
                    'id_user' => (int)$user->id,
                    'alias' => $request->get("alias"),
                    'address' => $request->get("address"),
                    'latitude' => $request->get("latitude"),
                    'longitude' => $request->get("longitude")
                );
                $address = ClientAddress::create($data);
                $address->save();

                if($address and isset($address->id)) {
                    return CustomResponsesHandler::response([
                        "code" => 200,
                        "message" => "Domicilio agregado exitosamente",
                        "response" => array("address" => $address)
                    ]);
                } else {
                    return CustomResponsesHandler::response([
                        "code" => 400,
                        "message" => "Error al crear el domicilio",
                        "response" => null
                    ]);
                }
            }
        }
    }

    /**
    * METHOD PUT
    *
    * This method is used to update a address
    *
    * @param($address) string
    * @param($alias) string
    * @param($longitude) double
    * @param($latitude) double
    *
    *  @return success or in case an error the corresponding data about it
    */
    public function updateAddress($address_id, Request $request) {
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
                    "message" => "Error en los parámetros: " . implode(", ", $validator->errors()->all()),
                    "response" => null
                ]);
            } else {
                $address = ClientAddress::where("id_user", $user->id)->where("id", $address_id)->first();
                if($address) {
                    $address->alias = $request->get("alias");
                    $address->address = $request->get("address");
                    $address->latitude = $request->get("latitude");
                    $address->longitude = $request->get("longitude");
                    $address->save();
                    return CustomResponsesHandler::response([
                        "code" => 200,
                        "message" => "Domicilio actualizado",
                        "response" => null
                    ]);
                } else {
                    return CustomResponsesHandler::response([
                        "code" => 202,
                        "message" => "No se encontró el domicilio",
                        "response" => null
                    ]);
                }
            }
        }
    }

    /**
    * METHOD GET
    *
    * This method is used to get all address by client
    *
    *  @return success or in case an error the corresponding data about it
    */
    public function getAddress() {
        $user = $this->auth->user();

        if(!$user) {
            return CustomResponsesHandler::response([
                "code" => 401,
                "message" => "Permisos denegados para el cliente",
                "response" => null
            ]);
        } else {
            $addresses = ClientAddress::where('id_user', $user->id)->where('eliminated', 0)->select('id','alias','address','latitude','longitude')->get();
            if($addresses->count()) {
                return CustomResponsesHandler::response([
                    "code" => 200,
                    "message" => "Listado de domicilios",
                    "response" => array("addresses" => $addresses)
                ]);
            } else {
                return CustomResponsesHandler::response([
                    "code" => 202,
                    "message" => "No se encontraron domicilios",
                    "response" => null
                ]);
            }
        }
    }

    /**
    * METHOD DELATE
    *
    * This method is used to eliminate a address
    *
    *  @return success or in case an error the corresponding data about it
    */
    public function deleteAddress($address_id) {
        $user = $this->auth->user();

        if(!$user) {
            return CustomResponsesHandler::response([
                "code" => 401,
                "message" => "Permisos denegados para el cliente",
                "response" => null
            ]);
        } else {
            $address = ClientAddress::where("id_user", $user->id)->where("id", $address_id)->first();
            if($address) {
                $address->eliminated = 1;
                $address->save();
                return CustomResponsesHandler::response([
                    "code" => 200,
                    "message" => "Domicilio eliminado",
                    "response" => null
                ]);
            } else {
                return CustomResponsesHandler::response([
                    "code" => 202,
                    "message" => "No se encontró el domicilio",
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
                'alias' => 'required',
                'address' => 'required',
                'latitude' => 'required',
                'longitude' => 'required'
            );

        } else {
            return array(
                'alias.required' => "alias es requerido",
                'address.required' => "address es requerido",
                'latitude.required' => "latitude es requerido",
                'longitude.required' => "longitude es requerido"
            );
        }
    }

}

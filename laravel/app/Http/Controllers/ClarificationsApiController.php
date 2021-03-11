<?php

namespace App\Http\Controllers;

use App\Aclaraciones;
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

class ClarificationsApiController extends Controller {

    use Helpers;

    public function __construct() {
        $this->middleware('api.auth');
    }

    /**
    * METHOD POST
    *
    * This method is used to create clarification
    *
    * @param($type) int (1:Cobro excesivo, 2:Servicios no reconocidos, 3:Cuentas de usuario)
    * @param($content) string
    *
    *  @return success or in case an error the corresponding data about it
    */
    public function addClarification(Request $request) {
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
                $data = array(
                    'client_id' => $user->id,
                    'clarification_type' => $request->get("type"),
                    'content' => $request->get("content"),
                    'status' => 1
                );

                $clarification = Aclaraciones::create($data);
                $clarification->save();
                if($clarification) {
                    return CustomResponsesHandler::response([
                        "code" => 200,
                        "message" => "Aclaración registrada exitosamente",
                        "response" => array("clarification" => $clarification)
                    ]);
                } else {
                    return CustomResponsesHandler::response([
                        "code" => 400,
                        "message" => "Error al registrar la aclaración",
                        "response" => null
                    ]);
                }
            }
        }
    }

    /**
    * METHOD GET
    *
    * This method is used to get all clarifications by client
    *
    *  @return success or in case an error the corresponding data about it
    */
    public function getClarifications() {
        $user = $this->auth->user();

        if(!$user) {
            return CustomResponsesHandler::response([
                "code" => 401,
                "message" => "Permisos denegados para el cliente",
                "response" => null
            ]);
        } else {
            $clarification = Aclaraciones::select('*',
                DB::raw('(CASE WHEN solution_type = 1 THEN "A favor del cliente(Procedente)" WHEN solution_type = 2 THEN "Inprocedente" WHEN solution_type = 3 THEN "Aclarado(No monetario)" WHEN solution_type = 4 THEN "Solicitud atendida" ELSE "Sin solución" END) as solution_type'),
                DB::raw('(CASE WHEN status = 1 THEN "Pendiente" WHEN status = 2 THEN "Aclarado" WHEN status = 3 THEN "Cancelado" END) as status'))
            ->where('client_id', $user->id)
                ->get();

            if($clarification->count()) {
                return CustomResponsesHandler::response([
                    "code" => 200,
                    "message" => "Listado de aclaraciones",
                    "response" => array("clarifications" => $clarification)
                ]);
            } else {
                return CustomResponsesHandler::response([
                    "code" => 202,
                    "message" => "No se encontraron aclaraciones",
                    "response" => null
                ]);
            }
        }
    }

    /**
    * METHOD PUT
    *
    * This method is used to cancel a clarification
    *
    *  @return success or in case an error the corresponding data about it
    */
    public function cancelClarification($clarification_id) {
        $user = $this->auth->user();

        if(!$user) {
            return CustomResponsesHandler::response([
                "code" => 401,
                "message" => "Permisos denegados para el cliente",
                "response" => null
            ]);
        } else {
            $clarification = Aclaraciones::where("client_id", $user->id)->where("folio", $clarification_id)->first();
            if($clarification->count()) {
                $clarification->status = 3;
                $clarification->save();
                return CustomResponsesHandler::response([
                    "code" => 200,
                    "message" => "Aclaración cancelada",
                    "response" => array("clarification" => $clarification)
                ]);
            } else {
                return CustomResponsesHandler::response([
                    "code" => 202,
                    "message" => "No se encontró la aclaración",
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
                'type' => 'required',
                'content' => 'required',
            );

        } else {
            return array(
                'type.required' => "type es requerido",
                'content.required' => "content es requerido",
            );
        }
    }


}

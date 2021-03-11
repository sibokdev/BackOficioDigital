<?php

namespace App\Http\Controllers;

use App\Audit;
use App\User;
use App\Documents;
use App\AuditDocuments;

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

class AuditsApiController extends Controller {

    use Helpers;

    public function __construct() {
        $this->middleware('api.auth');
    }

    /**
    * METHOD POST
    *
    * This method is used to create audit
    *
    * @param($date) timestamp
    * @param($notes) string
    *
    *  @return success or in case an error the corresponding data about it
    */
    public function addAudit(Request $request) {
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
                $month = date("m",strtotime($request->get("date")));
                $documents = Documents::where('id_user', $user->id)->where('location', 'Boveda')->get();
                if(empty($documents)){
                    return CustomResponsesHandler::response([
                        "code" => 400,
                        "message" => "No puedes solicitar una auditoria si no tienes documentos en boveda",
                        "response" => null
                    ]);
                }
                $audits = Audit::where('client_id', $user->id)->whereMonth('date', '=', $month)->get();

                if($audits->count()) {
                    $paid = 0;
                } else {
                    $paid = 1;
                }
                $data = array(
                    'client_id' => $user->id,
                    'date' => $request->get("date"),
                    'status' => 0,
                    'paid' => $paid,
                    'notes' => $request->get("notes")
                );

                $audit = Audit::create($data);
                $audit->save();

                foreach ($documents as $key => $value) {
                    $data2 = array(
                        'audit_id' => $audit->id,
                        'document_id' => $value->id,
                    );
                    $auditdocuments = AuditDocuments::create($data2);
                    $auditdocuments->save();
                }
                if($audit and isset($audit->id)) {
                    return CustomResponsesHandler::response([
                        "code" => 200,
                        "message" => "Auditoria agregada exitosamente",
                        "response" => array("audit" => $audit)
                    ]);
                } else {
                    return CustomResponsesHandler::response([
                        "code" => 400,
                        "message" => "Error al crear la auditoria",
                        "response" => null
                    ]);
                }
            }
        }
    }

    /**
    * METHOD GET
    *
    * This method is used to get all audits by client
    *
    *  @return success or in case an error the corresponding data about it
    */
    public function getAudits() {
        $user = $this->auth->user();

        if(!$user) {
            return CustomResponsesHandler::response([
                "code" => 401,
                "message" => "Permisos denegados para el cliente",
                "response" => null
            ]);
        } else {

            $audit = Audit::where('client_id', $user->id)->get(['audits.*']);

            foreach ($audit as $key => $value) {
                $documents = AuditDocuments::join('documents', 'documents.id', '=', 'audits_has_documents.document_id')
                                ->where('audit_id',$value->id)
                                ->select('documents.*')
                                ->get();
                $audit[$key]["documents"] = $documents;
            }
            if($audit->count()) {
                return CustomResponsesHandler::response([
                    "code" => 200,
                    "message" => "Listado de auditorias",
                    "response" => array("audits" => $audit)
                ]);
            } else {
                return CustomResponsesHandler::response([
                    "code" => 202,
                    "message" => "No se encontraron auditorias",
                    "response" => null
                ]);
            }
        }
    }

    /**
    * METHOD PUT
    *
    * This method is used to cancel a audit
    *
    *  @return success or in case an error the corresponding data about it
    */
    public function cancelAudit($audit_id) {
        $user = $this->auth->user();

        if(!$user) {
            return CustomResponsesHandler::response([
                "code" => 401,
                "message" => "Permisos denegados para el cliente",
                "response" => null
            ]);
        } else {
            $audit = Audit::where("client_id", $user->id)->where("id", $audit_id)->first();
            if($audit) {
                $audit->status = 2;
                $audit->save();
                return CustomResponsesHandler::response([
                    "code" => 200,
                    "message" => "Auditoria cancelada",
                    "response" => array("audits" => $audit)
                ]);
            } else {
                return CustomResponsesHandler::response([
                    "code" => 202,
                    "message" => "No se encontró la auditoria",
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
                'date' => 'required'
            );

        } else {
            return array(
                'date.required' => "date es requerido"
            );
        }
    }

}

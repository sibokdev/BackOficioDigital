<?php

namespace App\Http\Controllers;

use App\Aclaraciones;
use App\Documents;
use App\ServicesOrder;
use App\ServicesDocuments;
use App\User;
use Input;
use App\DocumentsMovements;
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

class DocumentsApiController extends Controller {

	use Helpers;

    public function __construct() {
        $this->middleware('api.auth');
    }

   /**
	* METHOD GET
	*
	* This method is used to get all documents by client
	*
	* @return success or in case an error the corresponding data about it
	*
	*/
	public function getDocuments() {
		$user = $this->auth->user();

		if(!$user) {
			return CustomResponsesHandler::response([
				"code" => 401,
				"message" => "Permisos denegados para el cliente",
				"response" => null
			]);
		} else {
			$documents = Documents::where('id_user', $user->id)->where('status', '1')->get(['id', 'folio', 'location', 'type', 'alias', 'notes', 'subtype', 'picture_path', 'expedition', 'expiration', 'created_at']);

			if($documents->count()) {
				return CustomResponsesHandler::response([
					"code" => 200,
					"message" => "Listado de documentos",
					"response" => array("documents" => $documents)
				]);
			} else {
				return CustomResponsesHandler::response([
					"code" => 202,
					"message" => "No se encontraron documentos",
					"response" => null
				]);
			}
		}
	}

	/**
	* METHOD GET
	*
	* This method is used to get especific document
	*
	* @return success or in case an error the corresponding data about it
	*
	*/
	public function getDocument($document_id) {
		$user = $this->auth->user();

		if(!$user) {
			return CustomResponsesHandler::response([
				"code" => 401,
				"message" => "Permisos denegados para el cliente",
				"response" => null
			]);
		} else {
			$document = Documents::where('id_user', $user->id)->where('id', '=', $document_id)->where('status', '1')->get(['id', 'folio', 'location', 'type', 'alias', 'notes', 'subtype', 'picture_path', 'expedition', 'expiration', 'created_at'])->first();

			if($document) {
				return CustomResponsesHandler::response([
					"code" => 200,
					"message" => "Detalle de documento",
					"response" => array("document" => $document)
				]);
			} else {
				return CustomResponsesHandler::response([
					"code" => 202,
					"message" => "No se encontraro el documento",
					"response" => null
				]);
			}
		}
	}

	/**
	* METHOD POST
	*
	* This method is used to get create document
	*
	* @param($alias) string
	* @param($type) string
	* @param($subtype) string
	* @param($location) string
	* @param($expedition) timestamp
	* @param($expiration) timestamp
	* @param($picture) image
	* @param($notes) string
	*
	*
	*  @return success or in case an error the corresponding data about it
	*/
	public function addDocument(Request $request) {
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
				$file = Input::file('picture');
				if($file) {
					if(Input::file('picture')->isValid()) {
						$destinationPath = storage_path() . '/uploads/documents/';
						$extension = Input::file('picture')->getClientOriginalExtension();
						$fileName = "file-document-" . $user->id . "-" . Carbon::now()->timestamp . "-" . str_slug(Input::file('picture')->getClientOriginalName()) . ".jpg";
						Input::file('picture')->move($destinationPath, $fileName);
					} else {
						$fileName = "";
					}
				} else {
					$fileName = "";
				}

				$data = array(
					'id_user' => $user->id,
					'location' => $request->get("location"),
					'type' => $request->get("type"),
					'subtype' => $request->get("subtype"),
					'alias' => $request->get("alias"),
					'expedition' => $request->get("expedition"),
					'expiration' => $request->get("expiration"),
					'notes' => $request->get("notes")
				);

				$document = Documents::create($data);
				$document->type = $request->get("type");
				$document->subtype = $request->get("subtype");
				$document->picture_path = $fileName;
				$document->save();


				if($document and isset($document->id)) {
					return CustomResponsesHandler::response([
						"code" => 200,
						"message" => "Documento agregado exitosamente",
						"response" => array("document" => $document)
					]);
				} else {
					return CustomResponsesHandler::response([
						"code" => 400,
						"message" => "Error al crear documento",
						"response" => null
					]);
				}
			}
		}
	}

	/**
	* METHOD PUT
	*
	* This method is used to update document
	*
	* @param($document_id) int
	* @param($alias) string
	* @param($type) string
	* @param($subtype) string
	* @param($location) string
	* @param($expedition) timestamp
	* @param($expiration) timestamp
	* @param($picture) image
	* @param($notes) string
	*
	*
	*  @return success or in case an error the corresponding data about it
	*/
	public function updateDocument($document_id, Request $request) {
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
				$document = Documents::where("id_user", $user->id)->where("id", $document_id)->first();

				if($document) {
					$document->location = $request->get("location");
					$document->alias = $request->get("alias");
					$document->expedition = $request->get("expedition");
					$document->expiration = $request->get("expiration");
					$document->notes = $request->get("notes");
					$document->type = $request->get("type");
					$document->subtype = $request->get("subtype");

					$document->save();

					return CustomResponsesHandler::response([
						"code" => 200,
						"message" => "Documento actualizado exitosamente",
						"response" => array("document" => $document)
					]);
				} else {
					return CustomResponsesHandler::response([
						"code" => 400,
						"message" => "El documento que intenta actualizar no existe",
						"response" => null
					]);
				}
			}
		}
	}

	/**
	* METHOD PUT
	*
	* This method is used to update document folio
	*
	* @param($document_id) int
	* @param($service_id) int
	* @param($folio) string
	*
	*  @return success or in case an error the corresponding data about it
	*/
	public function updateDocumentFolio($document_id, Request $request) {
		$user = $this->auth->user();

		if(!$user) {
			return CustomResponsesHandler::response([
				"code" => 401,
				"message" => "Permisos denegados para el cliente",
				"response" => null
			]);
		} else {
			$validator = Validator::make($request->all(), array('service_id' => 'required','folio' => 'required'), array('service_id.required' => "service_id es requerido", 'folio.required' => "folio es requerido"));

			if($validator->fails()) {
				return CustomResponsesHandler::response([
					"code" => 400,
					"message" => "Error en los parametros: " . implode(", ", $validator->errors()->all()),
					"response" => null
				]);
			} else {
				$service = ServicesOrder::where('id_courier', '=', $user->id)->whereIn('status', array("2","3"))->where('id', '=', $request->get("service_id"))->first();

				if($service) {
					$document = Documents::join('services2documents', 'documents.id', '=', 'services2documents.document_id')->where('documents.id', $document_id)->where('service_id', $request->get("service_id"))->first(['documents.id', 'folio', 'location', 'type', 'alias', 'notes', 'subtype', 'picture_path', 'expedition', 'expiration', 'documents.created_at']);

					if($document) {
						$document->folio = $request->get("folio");
						$document->save();

						return CustomResponsesHandler::response([
							"code" => 200,
							"message" => "Folio de documento actualizado exitosamente",
							"response" => array("document" => $document)
						]);
					} else {
						return CustomResponsesHandler::response([
							"code" => 400,
							"message" => "El documento que intenta actualizar no existe",
							"response" => null
						]);
					}
				} else {
					return CustomResponsesHandler::response([
						"code" => 202,
						"message" => "No se encontró el servicio",
						"response" => null
					]);
				}
			}
		}
	}

	/**
	* METHOD POST
	*
	* This method is used to update picture document
	*
	* @param($document_id) int
	* @param($picture) image
	*
	*
	*  @return success or in case an error the corresponding data about it
	*/
	public function updatePictureDocument($document_id, Request $request) {
		$user = $this->auth->user();

		if(!$user) {
			return CustomResponsesHandler::response([
				"code" => 401,
				"message" => "Permisos denegados para el cliente",
				"response" => null
			]);
		} else {
			$document = Documents::where("id_user", $user->id)->where("id", $document_id)->first();

			if($document) {
				$file = Input::file('picture');

				if($file) {
					if(Input::file('picture')->isValid()) {
						$destinationPath = storage_path() . '/uploads/documents/';
						$extension = Input::file('picture')->getClientOriginalExtension();
						$fileName = "file-document-" . $user->id . "-" . Carbon::now()->timestamp . "-" . str_slug(Input::file('picture')->getClientOriginalName()) . "." . $extension;
						Input::file('picture')->move($destinationPath, $fileName);

						$document->picture_path = $fileName;
						$document->save();

						$return = Documents::where("id", $document_id)->get(['id', 'folio', 'id_user', 'alias', 'picture_path', 'expedition', 'expiration'])->first();

						return CustomResponsesHandler::response([
							"code" => 200,
							"message" => "Imagen actualizada exitosamente",
							"response" => array("document" => $return)
						]);
					} else {
						return CustomResponsesHandler::response([
							"code" => 400,
							"message" => "Error en los parametros, la imagen es inválida",
							"response" => null
						]);
					}
				} else {
					return CustomResponsesHandler::response([
						"code" => 400,
						"message" => "Error en los parametros, la imagen es requerida",
						"response" => null
					]);
				}
			} else {
				return CustomResponsesHandler::response([
					"code" => 400,
					"message" => "El documento que intenta actualizar no existe",
					"response" => null
				]);
			}
		}
	}


	/**
	* METHOD DELETE
	*
	* This method is used to delete document
	*
	* @param($document_id) ID Document
	*
	*  @return success or in case an error the corresponding data about it
	*/
	public function deleteDocument($document_id) {
		$user = $this->auth->user();

		if(!$user) {
			return CustomResponsesHandler::response([
				"code" => 401,
				"message" => "Permisos denegados para el cliente",
				"response" => null
			]);
		} else {
			if(empty($document_id)) {
				return CustomResponsesHandler::response([
					"code" => 400,
					"message" => "Parametros incorrectos, document_id es requerido",
					"response" => null
				]);
			} else {
				$document = Documents::where("id_user", $user->id)->where("id", $document_id)->first();

				if($document) {
					$document->status = 0;
					$document->save();

					$return = Documents::where("id", $document_id)->get(['id'])->first();
					return CustomResponsesHandler::response([
						"code" => 200,
						"message" => "Documento borrado exitosamente",
						"response" => array("document" => $return)
					]);
				} else {
					return CustomResponsesHandler::response([
						"code" => 400,
						"message" => "El documento que intenta borrar no existe",
						"response" => null
					]);
				}
			}
		}
	}

	/**
	* METHOD GET
	*
	* This method is used to get movenets to document
	*
	* @param($document_id) ID Document
	*
	*  @return success or in case an error the corresponding data about it
	*/
	public function getMovements($document_id) {
		$user = $this->auth->user();

		if(!$user) {
			return CustomResponsesHandler::response([
				"code" => 401,
				"message" => "Permisos denegados para el cliente",
				"response" => null
			]);
		} else {
			if(empty($document_id)) {
				return CustomResponsesHandler::response([
					"code" => 400,
					"message" => "Parametros incorrectos, document_id es requerido",
					"response" => null
				]);
			} else {
				$movements = DocumentsMovements::join('documents', 'documents.id', '=', 'documents_movements.document_id')->where("document_id", $document_id)->where("id_user", "=", $user->id)->get();

				if($movements->count()) {
					return CustomResponsesHandler::response([
						"code" => 200,
						"message" => "Movimientos del documento",
						"response" => array("movements" => $movements)
					]);
				} else {
					return CustomResponsesHandler::response([
						"code" => 400,
						"message" => "No existen movimientos para este documento",
						"response" => null
					]);
				}
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
				'subtype' => 'required',
				'location' => 'required'

			);
		} else {
			return array(
				'type.required' => "type es requerido",
				'subtype.required' => "subtype es requerido",
				'location.required' => "location es requerido"
			);
		}
	}
}

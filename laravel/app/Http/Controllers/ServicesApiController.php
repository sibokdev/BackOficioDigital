<?php

namespace App\Http\Controllers;

use App\Cards2openpay;
use App\Users2openpay;
use App\Payments;
use App\CustomServiceCost;
Use Openpay;

use App\ServicesOrder;
use App\ServicesStatus;
use App\ServiceCost;
use App\ServicesDocuments;
use App\Documents;
use App\DocumentsMovements;
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

class ServicesApiController extends Controller {

	use Helpers;

    public function __construct() {
        $this->middleware('api.auth');

        $this->merchantID = "muz0qmla7t86en9avlxk";
        $this->privateKey = "sk_12248197e49e442aacff4370ae1a21ab";

        $this->amount = 50;
        //Openpay::setProductionMode(true);
    }

   /**
	* METHOD GET
	*
	* This method is used to get all services by client
	*
	* @return success or in case an error the corresponding data about it
	*
	*/
	public function getServices() {
		$user = $this->auth->user();

		if(!$user) {
			return CustomResponsesHandler::response([
				"code" => 401,
				"message" => "Permisos denegados para el cliente",
				"response" => null
			]);
		} else {
			$services = ServicesOrder::join('user_addresses', 'user_addresses.id', '=', 'services_orders.address')
				->where('services_orders.id_client', $user->id)
				->where('services_orders.status', '!=', 6)
				->get(['services_orders.*', 'user_addresses.address', 'user_addresses.latitude', 'user_addresses.longitude']);

			if($services->count()) {
				foreach($services as $key =>  $service) {
					$documents = ServicesDocuments::join('documents', 'documents.id', '=', 'services2documents.document_id')->where('service_id', $service->id)->get(['documents.id', 'folio', 'location', 'type', 'alias', 'notes', 'subtype', 'picture_path', 'expedition', 'expiration', 'documents.created_at']);
					$services[$key]->documents = $documents;
				}

				return CustomResponsesHandler::response([
					"code" => 200,
					"message" => "Listado de servicios",
					"response" => array("services" => $services)
				]);
			} else {
				return CustomResponsesHandler::response([
					"code" => 202,
					"message" => "No se encontraron servicios",
					"response" => null
				]);
			}
		}
	}

	/**
	* METHOD GET
	*
	* This method is used to get a service
	*
	* @return success or in case an error the corresponding data about it
	*
	*/
	public function getService($service_id = "") {
		$user = $this->auth->user();

		if(!$user) {
			return CustomResponsesHandler::response([
				"code" => 401,
				"message" => "Permisos denegados para el cliente",
				"response" => null
			]);
		} else {
			if($service_id != "" and $service_id != null) {
				$service = ServicesOrder::join('user_addresses', 'user_addresses.id', '=', 'services_orders.address')
					->where('services_orders.id_client', $user->id)
					->where('services_orders.status', '!=', 6)
					->where('services_orders.id', '=', $service_id)
					->first(['services_orders.*', 'user_addresses.address', 'user_addresses.latitude', 'user_addresses.longitude']);
				$documents = ServicesDocuments::join('documents', 'documents.id', '=', 'services2documents.document_id')->where('service_id', $service_id)->get(['documents.id', 'folio', 'location', 'type', 'alias', 'notes', 'subtype', 'picture_path', 'expedition', 'expiration', 'documents.created_at']);

				if($service) {
					return CustomResponsesHandler::response([
						"code" => 200,
						"message" => "Detalle de servicio",
						"response" => array("service" => $service, "documents" => $documents)
					]);
				} else {
					return CustomResponsesHandler::response([
						"code" => 202,
						"message" => "No se encontró el servicio",
						"response" => null
					]);
				}
			} else {
				return CustomResponsesHandler::response([
					"code" => 400,
					"message" => "Error en los parametros, id_service es requerido",
					"response" => null
				]);
			}
		}
	}

	/**
	* METHOD POST
	*
	* This method is used to get create service
	*
	* @param($service_type) integer (1:entrega, 2:recolección, 3:mixto)
	* @param($urgent) boolean 0|1
	* @param($date) timestamp
	* @param($address) string
	* @param($notes) string
	* @param($documents) string (csv)
	*
	* @return success or in case an error the corresponding data about it
	*/
	public function addService(Request $request) {
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
				$documents = explode(",", $request->get("documents"));
				$validate = ServicesDocuments::join('services_orders', 'services_orders.id', '=', 'services2documents.service_id')->whereIn("status", array("1","2","3"))->whereIn('document_id', $documents)->get();

				if($validate->count()) {
					return CustomResponsesHandler::response([
						"code" => 400,
						"message" => "Estas intentado agregar un documento que actualmente esta en un servicio",
						"response" => null
					]);
				} else {
					if($request->get("urgent") == "1") {

						$openpay = Openpay::getInstance($this->merchantID, $this->privateKey);
						$customer = Users2openpay::where("user_id", $user->id)->first();

						if($customer) {
							$payments = Payments::where("user_id", $user->id)->get();

							if($payments->count()) {
								$nextID = $payments->count()+1;
							} else {
								$nextID = 1;
							}

							#get card
							$card = Cards2openpay::where("client_id", $user->id)->where("main", "1")->first();

							if($card) {
								#create orderID
								$orderTime = Carbon::now();
								$orderID = 'DOX-' . $user->id . '-' . $nextID . '-' . $orderTime->toDateTimeString(); //DOX-CLIENTE-IDSIGUIENTE-timestamp

								#get cost
								$costCustom = CustomServiceCost::where('client_id', $user->id)->where('cost_type', 2)->whereDate('end_promotion', '>=', $orderTime->toDateTimeString())->first();

								if($costCustom) {
									$this->amount = $costCustom->cost;
								} else {
									$cost = ServiceCost::first();

									if($cost) {
										$this->amount = $cost->reception_cost;
									}
								}

								#create charge
								$chargeData = array(
									'source_id' => $card->id_api_card,
									'method' => 'card',
									'amount' => $this->amount,
									'description' => 'Pago de servicio urgente',
									'order_id' => $orderID,
									'device_session_id' => $card->device_session_id
								);

								$customerOpenPay = $openpay->customers->get($customer->customer_id);
								$charge = $customerOpenPay->charges->create($chargeData);

								/*to-do*/
								//cachar los errores con try-catch de openpay y insertar en la tabla de paymetns con status 0 o 2

								if($charge) {
									#save payment db
									$nowTime = Carbon::now();
									$startDate = $nowTime->toDateTimeString();

									$data = array(
										'user_id' => $user->id,
										'date' => $startDate,
										'amount' => $this->amount,
										'payment_method' => 1,
										'transaction_id' => $charge->authorization,
										'description' => 'Pago de servicio urgente',
										'source_id' => $card->id_api_card,
										'order_id' => $orderID,
										'type' => 1,
										'status' => 1,
										'start_date' => $startDate,
										'end_date' => $startDate
									);

									$payment = Payments::create($data);
									$payment->save();
									$data = array(
										'id_client' => $user->id,
										'date' => $request->get("date"),
										'address' => $request->get("address"),
										'service_type' => $request->get("service_type"),
										'urgent' => $request->get("urgent"),
										'latitude' => $request->get("latitude"),
										'longitude' => $request->get("longitude"),
										'status' => 1,
										'notes' => $request->get("notes")
									);

									$service = ServicesOrder::create($data);
									$service->save();

									if($service and isset($service->id)) {
										$insert = array();

										foreach($documents as $document) {
											$insert[] = array('service_id' => $service->id, 'document_id' => $document);
										}

										$result = ServicesDocuments::insert($insert);

										return CustomResponsesHandler::response([
											"code" => 200,
											"message" => "Servicio agregado exitosamente y pago exitoso",
											"response" => array("service" => $service, "payment" => $payment)
										]);
									} else {
										return CustomResponsesHandler::response([
											"code" => 400,
											"message" => "Error al crear servicio",
											"response" => null
										]);
									}
								} else {
									return CustomResponsesHandler::response([
										"code" => 202,
										"message" => "Error al procesar pago",
										"response" => null
									]);
								}
							} else {
								return CustomResponsesHandler::response([
									"code" => 400,
									"message" => "Aún no tiene ninguna tarjeta agregada",
									"response" => null
								]);
							}
						} else {
							return CustomResponsesHandler::response([
								"code" => 400,
								"message" => "Error al obtener el cliente de Openpay",
								"response" => null
							]);
						}
					}

					$data = array(
						'id_client' => $user->id,
						'date' => $request->get("date"),
						'address' => $request->get("address"),
						'service_type' => $request->get("service_type"),
						'urgent' => $request->get("urgent"),
						'latitude' => $request->get("latitude"),
						'longitude' => $request->get("longitude"),
						'status' => 1,
						'notes' => $request->get("notes")
					);

					$service = ServicesOrder::create($data);
					$service->save();

					if($service and isset($service->id)) {
						$insert = array();

						foreach($documents as $document) {
							$insert[] = array('service_id' => $service->id, 'document_id' => $document);
						}

						$result = ServicesDocuments::insert($insert);

						return CustomResponsesHandler::response([
							"code" => 200,
							"message" => "Servicio agregado exitosamente",
							"response" => array("service" => $service)
						]);
					} else {
						return CustomResponsesHandler::response([
							"code" => 400,
							"message" => "Error al crear servicio",
							"response" => null
						]);
					}
				}
			}
		}
	}

	/**
	* METHOD PUT
	*
	* This method is used to update service
	*
	* @param($service_id) int
	* @param($service_type) integer (1:entrega, 2:recolección, 3:mixto)
	* @param($urgent) boolean 0|1
	* @param($date) timestamp
	* @param($address) string
	* @param($notes) string
	* @param($documents) string (csv)
	*
	* @return success or in case an error the corresponding data about it
	*/
	public function updateService($service_id, Request $request) {
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
				$documents = explode(",", $request->get("documents"));
				$validate = ServicesDocuments::join('services_orders', 'services_orders.id', '=', 'services2documents.service_id')->whereIn("status", array("1","2","3"))->where("services_orders.id", "!=", $service_id)->whereIn('document_id', $documents)->get();

				if($validate->count()) {
					return CustomResponsesHandler::response([
						"code" => 400,
						"message" => "Estas intentado agregar un documento que actualmente esta en un servicio",
						"response" => null
					]);
				} else {
					$service = ServicesOrder::where("id_client", $user->id)->where("id", $service_id)->where('status', '!=', 6)->first();

					if($service) {
						$service->date = $request->get("date");
						$service->address = $request->get("address");
						$service->service_type = $request->get("service_type");
						$service->urgent = $request->get("urgent");
						$service->latitude = $request->get("latitude");
						$service->longitude = $request->get("longitude");
						$service->notes = $request->get("notes");

						$service->save();

						ServicesDocuments::where('service_id', $service->id)->delete();
						$insert = array();

						foreach($documents as $document) {
							$insert[] = array('service_id' => $service->id, 'document_id' => $document);
						}
						$result = ServicesDocuments::insert($insert);

						return CustomResponsesHandler::response([
							"code" => 200,
							"message" => "Servicio actualizado exitosamente",
							"response" => array("service" => $service)
						]);
					} else {
						return CustomResponsesHandler::response([
							"code" => 400,
							"message" => "El servicio que intenta actualizar no existe",
							"response" => null
						]);
					}
				}
			}
		}
	}

	/**
	* METHOD DELETE
	*
	* This method is used to delete service
	*
	* @param($service_id) ID Service
	*
	*  @return success or in case an error the corresponding data about it
	*/
	public function deleteService($service_id) {
		$user = $this->auth->user();

		if(!$user) {
			return CustomResponsesHandler::response([
				"code" => 401,
				"message" => "Permisos denegados para el cliente",
				"response" => null
			]);
		} else {
			if(empty($service_id)) {
				return CustomResponsesHandler::response([
					"code" => 400,
					"message" => "Parametros incorrectos, service_id es requerido",
					"response" => null
				]);
			} else {
				$service = ServicesOrder::where("id_client", $user->id)->where("id", $service_id)->first();

				if($service) {
					$service->status = 6;
					$service->save();

					return CustomResponsesHandler::response([
						"code" => 200,
						"message" => "Servicio borrado exitosamente",
						"response" => array("service" => $service)
					]);
				} else {
					return CustomResponsesHandler::response([
						"code" => 400,
						"message" => "El servicio que intenta borrar no existe",
						"response" => null
					]);
				}
			}
		}
	}

	/**
	* METHOD PUT
	*
	* This method is used to cancel service
	*
	* @param($service_id) ID Service
	*
	*  @return success or in case an error the corresponding data about it
	*/
	public function cancelService($service_id) {
		$user = $this->auth->user();

		if(!$user) {
			return CustomResponsesHandler::response([
				"code" => 401,
				"message" => "Permisos denegados para el cliente",
				"response" => null
			]);
		} else {
			if(empty($service_id)) {
				return CustomResponsesHandler::response([
					"code" => 400,
					"message" => "Parametros incorrectos, service_id es requerido",
					"response" => null
				]);
			} else {
				$service = ServicesOrder::where("id_client", $user->id)->where("id", $service_id)->first();

				if($service) {
					$service->status = 5;
					$service->save();

					return CustomResponsesHandler::response([
						"code" => 200,
						"message" => "Servicio cancelado exitosamente",
						"response" => array("service" => $service)
					]);
				} else {
					return CustomResponsesHandler::response([
						"code" => 400,
						"message" => "El servicio que intenta cancelar no existe",
						"response" => null
					]);
				}
			}
		}
	}


	/**
	* METHOD GET
	*
	* This method is used to get all services by courier
	*
	* @return success or in case an error the corresponding data about it
	*
	*/
	public function getServicesCourier() {
		$user = $this->auth->user();

		if(!$user) {
			return CustomResponsesHandler::response([
				"code" => 401,
				"message" => "Permisos denegados para el cliente",
				"response" => null
			]);
		} else {
			$services = ServicesOrder::join('user_addresses', 'user_addresses.id', '=', 'services_orders.address')
				->where('services_orders.id_courier', $user->id)
				->whereIn('services_orders.status', array("2","3"))
				->get(['services_orders.*', 'user_addresses.address', 'user_addresses.latitude', 'user_addresses.longitude']);

			if($services->count()) {
				foreach($services as $key =>  $service) {
					$documents = ServicesDocuments::join('documents', 'documents.id', '=', 'services2documents.document_id')->where('service_id', $service->id)->get(['documents.id', 'folio', 'location', 'type', 'alias', 'notes', 'subtype', 'picture_path', 'expedition', 'expiration', 'documents.created_at']);
					$services[$key]->documents = $documents;
				}

				return CustomResponsesHandler::response([
					"code" => 200,
					"message" => "Listado de servicios",
					"response" => array("services" => $services)
				]);
			} else {
				return CustomResponsesHandler::response([
					"code" => 202,
					"message" => "No se encontraron servicios",
					"response" => null
				]);
			}
		}
	}

	/**
	* METHOD GET
	*
	* This method is used to get a service courier
	*
	* @return success or in case an error the corresponding data about it
	*
	*/
	public function getServiceCourier($service_id = "") {
		$user = $this->auth->user();

		if(!$user) {
			return CustomResponsesHandler::response([
				"code" => 401,
				"message" => "Permisos denegados para el cliente",
				"response" => null
			]);
		} else {
			if($service_id != "" and $service_id != null) {
				$service = ServicesOrder::join('user_addresses', 'user_addresses.id', '=', 'services_orders.address')
					->where('services_orders.id_courier', $user->id)
					->whereIn('services_orders.status', array("2","3"))
					->where('services_orders.id', '=', $service_id)
					->first(['services_orders.*', 'user_addresses.address', 'user_addresses.latitude', 'user_addresses.longitude']);
				$documents = ServicesDocuments::join('documents', 'documents.id', '=', 'services2documents.document_id')->where('service_id', $service_id)->get(['documents.id', 'folio', 'location', 'type', 'alias', 'notes', 'subtype', 'picture_path', 'expedition', 'expiration', 'documents.created_at']);

				if($service) {
					return CustomResponsesHandler::response([
						"code" => 200,
						"message" => "Detalle de servicio",
						"response" => array("service" => $service, "documents" => $documents)
					]);
				} else {
					return CustomResponsesHandler::response([
						"code" => 202,
						"message" => "No se encontró el servicio",
						"response" => null
					]);
				}
			} else {
				return CustomResponsesHandler::response([
					"code" => 400,
					"message" => "Error en los parametros, id_service es requerido",
					"response" => null
				]);
			}
		}
	}

	/**
	* METHOD PUT
	*
	* This method is used to start service
	*
	* @param($service_id) int
	*
	* @return success or in case an error the corresponding data about it
	*/
	public function startService($service_id) {
		$user = $this->auth->user();

		if(!$user) {
			return CustomResponsesHandler::response([
				"code" => 401,
				"message" => "Permisos denegados",
				"response" => null
			]);
		} else {
			if($user->id_role == 5) {
				$service = ServicesOrder::where("id_courier", $user->id)->where("id", $service_id)->where('status', '!=', 6)->first();

				if($service) {
					$service->status = 3;
					$service->save();

					return CustomResponsesHandler::response([
						"code" => 200,
						"message" => "Servicio actualizado exitosamente",
						"response" => array("service" => $service)
					]);
				} else {
					return CustomResponsesHandler::response([
						"code" => 400,
						"message" => "El servicio que intenta actualizar no existe o no esta asignado",
						"response" => null
					]);
				}
			} else {
				return CustomResponsesHandler::response([
					"code" => 401,
					"message" => "Permisos denegados",
					"response" => null
				]);
			}
		}
	}


	/**
	* METHOD PUT
	*
	* This method is used to complete service
	*
	* @param($service_id) int
	*
	* @return success or in case an error the corresponding data about it
	*/
	public function completeService($service_id) {
		$user = $this->auth->user();

		if(!$user) {
			return CustomResponsesHandler::response([
				"code" => 401,
				"message" => "Permisos denegados",
				"response" => null
			]);
		} else {
			if($user->id_role == 5) {
				$service = ServicesOrder::where("id_courier", $user->id)->where("id", $service_id)->where('status', '!=', 6)->first();

				if($service) {
					$service->status = 4;
					$service->save();

					$documents = ServicesDocuments::join('documents', 'documents.id', '=', 'services2documents.document_id')->where('service_id', $service_id)->get(['documents.id', 'folio', 'location', 'type', 'alias', 'notes', 'subtype', 'picture_path', 'expedition', 'expiration', 'documents.created_at']);

					foreach($documents as $document) {
						if($service->service_type == 1) {
							$new_location = "Bóveda";
						} elseif($service->service_type == 2) {
							$new_location = "Cliente";
						} else {
							$doc = DocumentsMovements::where('document_id', $document->id)->orderBy('id', 'desc')->first();

							if($doc) {
								if($doc->new_location == "Cliente") {
									$new_location = "Bóveda";
								} else {
									$new_location = "Cliente";
								}
							} else {
								$new_location = "Bóveda";
							}
						}

						$data = array(
							'document_id' => $document->id,
							'new_location' => $new_location,
							'date' => $service->date
						);

						$movement = DocumentsMovements::create($data);
						$movement->save();

						$documentChange = Documents::where('id', $document->id)->first();
						$documentChange->location = $new_location;
						$documentChange->save();
					}

					return CustomResponsesHandler::response([
						"code" => 200,
						"message" => "Servicio completado exitosamente",
						"response" => array("service" => $service)
					]);
				} else {
					return CustomResponsesHandler::response([
						"code" => 400,
						"message" => "El servicio que intenta actualizar no existe o no esta asignado",
						"response" => null
					]);
				}
			} else {
				return CustomResponsesHandler::response([
					"code" => 401,
					"message" => "Permisos denegados",
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
				'service_type' => 'required',
				'urgent' => 'required',
				'date' => 'required',
				'address' => 'required',
				'documents' => 'required'
			);

		} else {
			return array(
				'service_type.required' => "service_type es requerido",
				'urgent.required' => "urgent es requerido",
				'date.required' => "date es requerido",
				'address.required' => "address es requerido",
				'documents.required' => "documents es requerido"
			);
		}
	}
}

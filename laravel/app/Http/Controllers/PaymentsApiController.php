<?php

namespace App\Http\Controllers;

use App\Cards2openpay;
use App\User;
use App\Users2openpay;
use App\Payments;
use App\CustomServiceCost;
use App\ServiceCost;
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

Use Openpay;

//OpenPay
class PaymentsApiController extends Controller {

	use Helpers;

    public function __construct() {
        $this->middleware('api.auth');
        $this->merchantID = "muz0qmla7t86en9avlxk";
        $this->privateKey = "sk_12248197e49e442aacff4370ae1a21ab";

        $this->amount = 1299;
				$this->amountUrgent = 50;
        //Openpay::setProductionMode(true);
        //aerz48k9uoqsmzph9c8k cliente de prueba
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
    * @param($device_session_id) string
    * @param($main) integer
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
            $validator = Validator::make($request->all(), $this->getCardRules("rules"), $this->getCardRules("errors"));

            if($validator->fails()) {
                return CustomResponsesHandler::response([
                    "code" => 400,
                    "message" => "Error en los parametros: " . implode(", ", $validator->errors()->all()),
                    "response" => null
                ]);
            } else {
				$openpay = Openpay::getInstance($this->merchantID, $this->privateKey);
                $customer = Users2openpay::where("user_id", $user->id)->first();

                if($customer == null) {
					$customerData = array(
						'name' => $user->name,
						'last_name' => $user->surname1 . " " . $user->surname2,
						'email' => $user->email,
						'phone_number' => $user->phone
					);

					$customer = $openpay->customers->add($customerData);

					if($customer) {
						$dataUser = array(
							'user_id' => $user->id,
							'customer_id' => $customer->id,
							'email' => $user->email
						);

						$userOpenPay = Users2openpay::create($dataUser);
						$userOpenPay->save();

					} else {
						return CustomResponsesHandler::response([
							"code" => 400,
							"message" => "Error al registrar la cliente en openpay",
							"response" => null
						]);
					}
				}

				$cardData = array(
					'token_id' => $request->get("token"),
					'device_session_id' => $request->get("device_session_id")
				);
				$customerOpenPay = $openpay->customers->get($customer->customer_id);
				$cardOpenPay = $customerOpenPay->cards->add($cardData);

				if($cardOpenPay) {
					if($request->get("main") == "1") {
						$cardsSearch = Cards2openpay::where("client_id", $user->id)->get();

						if($cardsSearch->count()) {
							foreach($cardsSearch as $value) {
								$value->main = 0;
								$value->save();
							}
						}

						$main = 1;
					} else {
						$cards = Cards2openpay::where("client_id", $user->id)->first();

						if($cards) {
							$main = 0;
						} else {
							$main = 1;
						}
					}

					$data = array(
						'client_id' => $user->id,
						'name' => $request->get("name"),
						'number' => $request->get("number"),
						'expiration_month' => $request->get("expiration_month"),
						'expiration_year' => $request->get("expiration_year"),
						'token' => $request->get("token"),
						'id_api_card' => $cardOpenPay->id,
						'device_session_id' => $request->get("device_session_id"),
						'main' => $main
					);

					$card = Cards2openpay::create($data);
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
				} else {
					return CustomResponsesHandler::response([
                        "code" => 400,
                        "message" => "Error al registrar la tarjeta en OpenPay",
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
            $cards = Cards2openpay::where('client_id', $user->id)->where('status','1')->get(['id', 'name', 'number', 'expiration_month', 'expiration_year', 'main']);

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
    * METHOD PUT
    *
    * This method is used to do main card
    *
    *  @return success or in case an error the corresponding data about it
    */
    public function mainCard(Request $request) {
        $user = $this->auth->user();

        if(!$user) {
            return CustomResponsesHandler::response([
                "code" => 401,
                "message" => "Permisos denegados para el cliente",
                "response" => null
            ]);
        } else {
			$validator = Validator::make($request->all(), array('card_id' => 'required'), array('card_id.required' => "card_id es requerido"));

            if($validator->fails()) {
                return CustomResponsesHandler::response([
                    "code" => 400,
                    "message" => "Error en los parametros: " . implode(", ", $validator->errors()->all()),
                    "response" => null
                ]);
            } else {
				$card = Cards2openpay::where("id", $request->get("card_id"))->first();

				if($card) {
					$cards = Cards2openpay::where("client_id", $user->id)->get();

					foreach($cards as $value) {
						$value->main = 0;
						$value->save();
					}

					$card->main = 1;
					$card->save();

					$payUser = User::where('id', $user->id)->first();
					$payUser->main_method_payment = 1;
					$payUser->save();


					return CustomResponsesHandler::response([
						"code" => 200,
						"message" => "Tarjeta establecida como principal",
						"response" => array("card" => $card)
					]);
				} else {
					return CustomResponsesHandler::response([
						"code" => 202,
						"message" => "No se encontraro la tarjeta a actualizar",
						"response" => null
					]);
				}
			}
        }
    }

	/**
    * METHOD DELETE
    *
    * This method is used to delete card
    *
    *  @return success or in case an error the corresponding data about it
    */
    public function dropCard(Request $request) {
        $user = $this->auth->user();

        if(!$user) {
            return CustomResponsesHandler::response([
                "code" => 401,
                "message" => "Permisos denegados para el cliente",
                "response" => null
            ]);
        } else {
			$validator = Validator::make($request->all(), array('card_id' => 'required'), array('card_id.required' => "card_id es requerido"));

            if($validator->fails()) {
                return CustomResponsesHandler::response([
                    "code" => 400,
                    "message" => "Error en los parametros: " . implode(", ", $validator->errors()->all()),
                    "response" => null
                ]);
            } else {
				$card = Cards2openpay::where("id", $request->get("card_id"))->where('status','1')->first();
				if($card) {
					$cards = Cards2openpay::where("client_id", $user->id)->where('status','1')->get();
					if (count($cards) == 1) {
						return CustomResponsesHandler::response([
							"code" => 202,
							"message" => "No se puede eliminar la unica tarjeta",
							"response" => null
						]);
					}
					if ($card->main) {
						return CustomResponsesHandler::response([
						   "code" => 202,
						   "message" => "No se puede eliminar la tarjeta principal",
						   "response" => null
					   ]);
					}

					$customerOpenPay = Users2openpay::where('user_id', $user->id)->first();
					$openpay = Openpay::getInstance($this->merchantID, $this->privateKey);
					$customer = $openpay->customers->get($customerOpenPay->customer_id);
					$cardOpenPay = $customer->cards->get(trim($card->id_api_card));
					$cardOpenPay->delete();

					$payUser = User::where('id', $user->id)->first();
					$payUser->main_method_payment = 1;
					$payUser->save();

					$card->status = false;
					$card->save();

					return CustomResponsesHandler::response([
						"code" => 200,
						"message" => "Tarjeta eliminada",
						"response" => null
					]);
				} else {
					return CustomResponsesHandler::response([
						"code" => 202,
						"message" => "No se encontró la tarjeta a eliminar",
						"response" => null
					]);
				}
			}
        }
    }

    /**
    * getCardRules
    *
    * This method is used to get rules or errors
    *
    *  @return array
    */
    private function getCardRules($type = "rules") {
        if($type == "rules") {
            return array(
                'name' => 'required',
                'number' => 'required',
                'expiration_month' => 'required',
                'expiration_year' => 'required',
                'token' => 'required',
                'device_session_id' => 'required'
            );

        } else {
            return array(
                'name.required' => "name es requerido",
                'number.required' => "number es requerido",
                'expiration_month.required' => "expiration_month es requerido",
                'expiration_year.required' => "expiration_year es requerido",
                'token.required' => "token es requerido",
                'device_session_id.required' => "device_session_id es requerido"
            );
        }
    }


	/**
	* METHOD POST
	*
	* This method is used to get add Payment
	*
	* @param($device_session_id) string
	*
	* @return success or in case an error the corresponding data about it
	*
	*/
	public function addPayment(Request $request) {
		$user = $this->auth->user();

		if(!$user) {
			return CustomResponsesHandler::response([
				"code" => 401,
				"message" => "Permisos denegados para el cliente",
				"response" => null
			]);
		} else {
			$validator = Validator::make($request->all(), array('device_session_id' => 'required'), array('device_session_id.required' => "device_session_id es requerido"));

            if($validator->fails()) {
                return CustomResponsesHandler::response([
                    "code" => 400,
                    "message" => "Error en los parametros: " . implode(", ", $validator->errors()->all()),
                    "response" => null
                ]);
            } else {
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
						$costCustom = CustomServiceCost::where('client_id', $user->id)->where('cost_type', 1)->whereDate('end_promotion', '>=', $orderTime->toDateTimeString())->first();

						if($costCustom) {
							$this->amount = $costCustom->cost;
						} else {
							$cost = ServiceCost::first();

							if($cost) {
								$this->amount = $cost->annual_cost;
							}
						}

						#create charge
						$chargeData = array(
							'source_id' => $card->id_api_card,
							'method' => 'card',
							'amount' => $this->amount,
							'description' => 'Pago de anualidad',
							'order_id' => $orderID,
							'device_session_id' => $request->get("device_session_id")
						);
						$customerOpenPay = $openpay->customers->get($customer->customer_id);
						$charge = $customerOpenPay->charges->create($chargeData);

						/*to-do*/
						//cachar los errores con try-catch de openpay y insertar en la tabla de paymetns con status 0 o 2

						if($charge) {
							#save payment db
							$nowTime = Carbon::now();
							$startDate = $nowTime->toDateTimeString();
							$endDate = $nowTime->addYear();

							$data = array(
								'user_id' => $user->id,
								'date' => $startDate,
								'amount' => $this->amount,
								'payment_method' => 1,
								'transaction_id' => $charge->authorization,
								'description' => 'Pago de anualidad',
								'source_id' => $card->id_api_card,
								'order_id' => $orderID,
								'type' => 0,
								'status' => 1,
								'start_date' => $startDate,
								'end_date' => $endDate->toDateTimeString()
							);

							$payment = Payments::create($data);
							$payment->save();

							#update pay statys user
							$payUser = User::where('id', $user->id)->first();
							$payUser->pay_status=1;
							$payUser->save();

							return CustomResponsesHandler::response([
								"code" => 200,
								"message" => "Pago exitoso",
								"response" => array("payment" => $payment)
							]);
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
						"message" => "Error al obtener el cliente",
						"response" => null
					]);
				}
			}
		}
	}

	/**
	* METHOD POST
	*
	* This method is used to get add Payment Pyapak
	*
	* @param($device_session_id) string
	*
	* @return success or in case an error the corresponding data about it
	*
	*/
	public function addPaymentPaypal(Request $request) {
		$user = $this->auth->user();

		if(!$user) {
			return CustomResponsesHandler::response([
				"code" => 401,
				"message" => "Permisos denegados para el cliente",
				"response" => null
			]);
		} else {
			$validator = Validator::make($request->all(), array('id' => 'required', 'state' => 'required', 'create_time' => 'required'), array('id.required' => 'id es requerido', 'state.required' => 'state es requerido', 'create_time.required' => 'create_time es requerido'));

            if($validator->fails()) {
                return CustomResponsesHandler::response([
                    "code" => 400,
                    "message" => "Error en los parametros: " . implode(", ", $validator->errors()->all()),
                    "response" => null
                ]);
            } else {
				if($request->get("state") != "approved") {
					return CustomResponsesHandler::response([
						"code" => 202,
						"message" => "Pago no aprobado: " . $request->get("state") ,
						"response" => null
					]);
				} else {
					$payments = Payments::where("user_id", $user->id)->get();

					if($payments->count()) {
						$nextID = $payments->count()+1;
					} else {
						$nextID = 1;
					}

					#Order ID
					$orderTime = Carbon::now();
					$orderID = 'DOX-' . $user->id . '-' . $nextID . '-' . $orderTime->toDateTimeString(); //DOX-CLIENTE-IDSIGUIENTE-timestamp

					#get cost
					$costCustom = CustomServiceCost::where('client_id', $user->id)->where('cost_type', 1)->whereDate('end_promotion', '>=', $orderTime->toDateTimeString())->first();

					if($costCustom) {
						$this->amount = $costCustom->cost;
					} else {
						$cost = ServiceCost::first();

						if($cost) {
							$this->amount = $cost->annual_cost;
						}
					}

					#save payment db
					$nowTime = Carbon::now();
					$startDate = $nowTime->toDateTimeString();
					$endDate = $nowTime->addYear();

					$data = array(
						'user_id' => $user->id,
						'date' => $startDate,
						'amount' => $this->amount,
						'payment_method' => 2,
						'transaction_id' => $request->get("id"),
						'description' => 'Pago de anualidad',
						'source_id' => $request->get("id"),
						'order_id' => $orderID,
						'type' => 0,
						'status' => 1,
						'start_date' => $startDate,
						'end_date' => $endDate->toDateTimeString()
					);

					$payment = Payments::create($data);
					$payment->save();

					#update pay statys user
					$payUser = User::where('id', $user->id)->first();
					$payUser->pay_status=1;
					$payUser->save();

					return CustomResponsesHandler::response([
						"code" => 200,
						"message" => "Pago exitoso",
						"response" => array("payment" => $payment)
					]);
				}
			}
		}
	}

	/**
	* METHOD GET
	*
	* This method is used to get detail of the annual cost by client
	*
	*  @return success or in case an error the corresponding data about it
	*/
	public function getAnnualCost() {
			$user = $this->auth->user();

			if(!$user) {
					return CustomResponsesHandler::response([
							"code" => 401,
							"message" => "Permisos denegados para el cliente",
							"response" => null
					]);
			} else {
					$orderTime = Carbon::now();
					$costCustom = CustomServiceCost::where('client_id', $user->id)->where('cost_type', 1)->whereDate('end_promotion', '>=', $orderTime->toDateTimeString())->first();
					if($costCustom) {
							$this->amount = $costCustom->cost;
					} else {
							$cost = ServiceCost::first();
							if($cost) {
								$this->amount = $cost->annual_cost;
						}
					}
					if($this->amount) {
							return CustomResponsesHandler::response([
									"code" => 200,
									"message" => "Detalle tarifa anual",
									"response" => array("cost" => number_format((float)$this->amount, 2, '.', ''))
							]);
					} else {
							return CustomResponsesHandler::response([
									"code" => 202,
									"message" => "No se pudo obtener la tarifa anual",
									"response" => null
							]);
					}
			}
	}

	/**
	* METHOD GET
	*
	* This method is used to get detail of the urgent cost by client
	*
	*  @return success or in case an error the corresponding data about it
	*/
	public function getUrgentCost() {
		$user = $this->auth->user();

		if(!$user) {
				return CustomResponsesHandler::response([
						"code" => 401,
						"message" => "Permisos denegados para el cliente",
						"response" => null
				]);
		} else {
				$orderTime = Carbon::now();
					$costCustom = CustomServiceCost::where('client_id', $user->id)->where('cost_type', 2)->whereDate('end_promotion', '>=', $orderTime->toDateTimeString())->first();
					if($costCustom) {
							$this->amountUrgent = $costCustom->cost;
					} else {
							$cost = ServiceCost::first();
							if($cost) {
								$this->amountUrgent = $cost->reception_cost;
							}
						}
						if($this->amountUrgent) {
								return CustomResponsesHandler::response([
									"code" => 200,
									"message" => "Detalle tarifa de servicio urgente",
									"response" => array("cost" => number_format((float)$this->amountUrgent, 2, '.', ''))
							]);
					} else {
							return CustomResponsesHandler::response([
									"code" => 202,
									"message" => "No se pudo obtener la tarifa de servicio urgente",
									"response" => null
							]);
					}
			}
	}

	/**
	* METHOD GET
	*
	* This method is used to get account status of the client
	*
	*  @return success or in case an error the corresponding data about it
	*/
	public function getAccountStatus() {
			$user = $this->auth->user();
			if(!$user) {
					return CustomResponsesHandler::response([
							"code" => 401,
							"message" => "Permisos denegados para el cliente",
							"response" => null
					]);
			} else {
					$AccountStatus = Payments::where('user_id', $user->id)
						->select('payments.id','payments.date','payments.amount',
							DB::raw('(CASE WHEN payment_method = 1 THEN "OpenPay" WHEN payment_method = 2 THEN "PayPal" END) as payment_method'),
							DB::raw('(CASE WHEN status = 0 THEN "Declinado" WHEN status = 1 THEN "Pagado" WHEN status = 2 THEN "Error en transacción" END) as status'),
							DB::raw('(CASE WHEN type = 0 THEN "Pago cuota anual" WHEN type = 1 THEN "Pago servicio urgente"  END) as type'))
						->get();
					if($AccountStatus->count()) {
							return CustomResponsesHandler::response([
									"code" => 200,
									"message" => "Estado de cuenta",
									"response" =>  array("transactions" => $AccountStatus)
							]);
					} else {
							return CustomResponsesHandler::response([
									"code" => 202,
									"message" => "No hay registros todavia en el estado de cuenta",
									"response" => null
							]);
					}
			}
	}

	/**
    * getPaymentRules
    *
    * This method is used to get rules or errors
    *
    *  @return array
    */
    private function getPaymentRules($type = "rules") {
        if($type == "rules") {
            return array(
                'date' => 'required',
                'method' => 'required'
            );

        } else {
            return array(
                'date.required' => "date es requerido",
                'method.required' => "method es requerido"
            );
        }
    }

}

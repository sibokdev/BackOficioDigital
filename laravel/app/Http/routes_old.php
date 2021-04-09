<?php

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@loginView');
Route::post('auth/loginForm', 'Auth\AuthController@login');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::get('client/active/{email}',  'UsersApiController@active');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

 //Home Routes(Services)
Route::get('/', 'WelcomeController@index');
Route::get('home', 'HomeController@home');
Route::get('home/ajaxDataTable', 'HomeController@ajaxDataTable');
Route::get('home/asignar/{mensajero_id_valor}/{asignar_id}', 'HomeController@assign');
Route::get('home/cancelar/{id}','HomeController@cancel');
Route::post('home/aggregateService','HomeController@aggregateService');
Route::post('home/createService','HomeController@createService');
Route::post('home/editServiceData','HomeController@editServiceData');
Route::post('home/editService','HomeController@editService');
Route::post('home/clientAddress','HomeController@clientAddress');

// Clients Routes
Route::get('cliente/mostrar', 'ClienteController@show');
Route::get('cliente/mostrar/ajaxClientDataTable', 'ClienteController@ajaxClientDataTable');
Route::get('cliente/usersReferred', 'ClienteController@showUsersReferred');
Route::get('cliente/userReferred/ajaxDataTable', 'ClienteController@ajaxDataTable');
Route::get('client/query', 'ClienteController@query');

//Employee routes
Route::get('empleado/mostrar', 'UsersBackendController@show');
Route::post('empleado/crear','UsersBackendController@create');
Route::get('empleado/suspender/{id}','UsersBackendController@suspender');
Route::get('empleado/activar/{id}','UsersBackendController@activar');
Route::get('empleado/ajaxDataTable', 'UsersBackendController@ajaxDataTable');
//Route::get('songs/{title}/{slug}', ['as' => 'songs.index', 'uses' => 'SomeController@index']);
Route::post('empleado/actualizar','UsersBackendController@postUpdate');

//Costs Routes
Route::get('costos/mostrar','CostosController@show');
Route::get('costos/mostrar/ajaxAnnualDataTable','CostosController@ajaxAnnualDataTable');
Route::get('costos/mostrar/ajaxServicesDataTable','CostosController@ajaxServicesDataTable');
Route::post('costos/mostrar/updateReceptionCost','CostosController@updateReceptionCost');
Route::post('costos/mostrar/updateDeliveryCost','CostosController@updateDeliveryCost');
Route::post('costos/mostrar/updateMixedCost','CostosController@updateMixedCost');
Route::post('costos/mostrar/updateAnnualCost','CostosController@updateAnnualCost');
Route::post('costos/mostrar/personalizedAnnualQuote','CostosController@personalizedAnnualQuote');
Route::post('costos/mostrar/updatePersonalizedAnnualCost','CostosController@updatePersonalizedAnnualCost');
Route::post('costos/mostrar/personalizedAnnualCostModal','CostosController@personalizedAnnualCostModal');
Route::post('costos/mostrar/customizedAnnualCostModal','CostosController@customizedAnnualCostModal');
Route::post('costos/mostrar/customizedServiceCostModal','CostosController@customizedServiceCostModal');
Route::post('costos/mostrar/updatePersonalizedAnnualCost','CostosController@updatePersonalizedAnnualCost');
Route::post('costos/mostrar/updatePersonalizedServiceCost','CostosController@updatePersonalizedServiceCost');
Route::post('costos/mostrar/personalizedServiceCostModal','CostosController@personalizedServiceCostModal');


//Clarifications Routes
Route::get('aclaraciones/aclaraciones','AclaracionesController@index');
Route::put('aclaraciones/aclaraciones/solution','AclaracionesController@solution');
Route::get('aclaraciones/aclaraciones/ajaxMainDataTable','AclaracionesController@ajaxMainDataTable');
Route::get('aclaraciones/aclaraciones/ajaxDataTable','AclaracionesController@ajaxDataTable');

//Audits Routes
Route::get('auditorias/auditorias','AuditoriasController@index');
Route::put('auditorias/auditorias/auditar','AuditoriasController@auditar');
Route::get('auditorias/auditorias/ajaxMainDataTable','AuditoriasController@ajaxMainDataTable');
Route::get('auditorias/auditorias/ajaxDataTable','AuditoriasController@ajaxDataTable');

//Types Routes
Route::get('tipos/tipos','TiposController@index');
Route::get('tipos/tipos/ajaxMainDataTable','TiposController@ajaxMainDataTable');
Route::post('tipos/tipos/agregar','TiposController@agregar');
Route::put('tipos/tipos/editar','TiposController@editar');
Route::delete('tipos/tipos/borrar','TiposController@borrar');

//Sub-Types Routes
Route::get('subtipos/subtipos','SubtiposController@index');
Route::get('subtipos/subtipos/ajaxMainDataTable','SubtiposController@ajaxMainDataTable');
Route::post('subtipos/subtipos/agregar','SubtiposController@agregar');
Route::put('subtipos/subtipos/editar','SubtiposController@editar');
Route::delete('subtipos/subtipos/borrar','SubtiposController@borrar');

//Documents Routes
Route::get('documentos/control','DocumentosController@show');
Route::post('documentos/control','DocumentosController@saveCode');
Route::get('documentos/historico','DocumentosController@historico');
Route::get('documentos/ajaxDataTable', 'DocumentosController@ajaxDataTable');
Route::get('documentos/historicalDayAjaxDataTable', 'DocumentosController@historicalDayAjaxDataTable');

//**Update routes...

//Modals Controller
Route::get('modals/asignar','ModalsController@asignar');
Route::get('modals/historicalCharges/{id}','ModalsController@historical');
Route::get('modals/paymentData/{id}/{service_id}','ModalsController@paymentData');


//Charges and Deposits
//Route::get('charges/chargesAndDeposits','ChargesController@index');
Route::get('charges/showChargesAndDeposits','ChargesController@show');
Route::get('charges/showChargesAndDeposits/ajaxDataTable','ChargesController@ajaxDataTable');
Route::get('charges/payment/{id}','ChargesController@payment');

//Reports And Graphics
Route::get('reportsAndGraphics/chargedVsExpected','ReportsAndGraphicsController@showChargedVsExpected');
Route::get('reportsAndGraphics/clientsReport','ReportsAndGraphicsController@showClientsReport');
Route::get('reportsAndGraphics/statisticServices','ReportsAndGraphicsController@showStatisticServices');
Route::get('reportsAndGraphics/financesReport','ReportsAndGraphicsController@showFinancesReport');
Route::get('download/excel/cobros','DownloadController@cobros');
Route::get('download/excel/clientes','DownloadController@clientes');
Route::get('download/excel/services','DownloadController@services');


//Api urls
/*
 * Definicion de los URL para los API's
 * Primer Segmento: API
 * Segundo Segmento: Version
 * Tercer Segmento: Clase
 * Cuarto Segmento: Metodo
 * Quinta y demas: Argumentos
 * localhost/API/1/usuario/crear
 */

// $api = app('Dingo\Api\Routing\Router');
/** @var \Dingo\Api\Routing\Router $api */
$api = app('api.router');
$api->version('v1', ['namespace' => 'App\Http\Controllers'], function ($api) {

   /**
   * endpoints that do not need authentication
   */
   $api->group(['prefix' => 'v1'], function($api) {
      $api->post('client/login',  'UsersApiController@login');
      $api->post('client/contract',  'UsersApiController@contract');
      $api->put('client/recoveryPassword',  'UsersApiController@recoveryPassword');

		$api->get('images/{filename}', function ($filename) {
			$path = storage_path() . '/uploads/documents/' . $filename;

			if(!File::exists($path)) abort(404);

			$file = File::get($path);
			$type = File::mimeType($path);

			$response = Response::make($file, 200);
			$response->header("Content-Type", $type);

			return $response;
		});
   });

   /**
   * endpoints for clients that need authentication
   *
   */
	$api->group(['prefix' => 'v1','middleware' => 'api.auth'], function($api) {
		$api->delete('client/deleteUser',  'UsersApiController@deleteUser');
		$api->delete('client/{client_id}/logout',  'UsersApiController@logout');
		$api->post('client/changePassword',  'UsersApiController@changePassword');
		$api->put('client/{client_id}/completeData',  'UsersApiController@completeData');

		/* Documents */
		$api->get('client/documents', 'DocumentsApiController@getDocuments');
		$api->get('client/document/{document_id}', 'DocumentsApiController@getDocument');
		$api->get('client/documentMovements/{document_id}', 'DocumentsApiController@getMovements');
		$api->post('client/addDocument', 'DocumentsApiController@addDocument');
		$api->post('client/updatePictureDocument/{document_id}', 'DocumentsApiController@updatePictureDocument');
		$api->put('client/updateDocument/{document_id}', 'DocumentsApiController@updateDocument');
		$api->delete('client/deleteDocument/{document_id}', 'DocumentsApiController@deleteDocument');

		/*Services*/
		$api->get('client/services', 'ServicesApiController@getServices');
		$api->get('client/service/{service_id}', 'ServicesApiController@getService');
		$api->post('client/addService', 'ServicesApiController@addService');
		$api->put('client/updateService/{service_id}', 'ServicesApiController@updateService');
		$api->delete('client/deleteService/{service_id}', 'ServicesApiController@deleteService');
		$api->put('client/cancelService/{service_id}', 'ServicesApiController@cancelService');

		/*Audits*/
		$api->get('client/audits', 'AuditsApiController@getAudits');
		$api->post('client/addAudit', 'AuditsApiController@addAudit');
		$api->put('client/cancelAudit/{audit_id}', 'AuditsApiController@cancelAudit');

        /*Address*/
        $api->get('client/address', 'AddressApiController@getAddress');
        $api->post('client/addAddress', 'AddressApiController@addAddress');
    	$api->put('client/updateAddress/{address_id}', 'AddressApiController@updateAddress');
        $api->delete('client/deleteAddress/{address_id}', 'AddressApiController@deleteAddress');

		/*Clarifications*/
		$api->get('client/getClarifications', 'ClarificationsApiController@getClarifications');
		$api->post('client/addClarification', 'ClarificationsApiController@addClarification');
        $api->put('client/cancelClarification/{clarification_id}', 'ClarificationsApiController@cancelClarification');

		/*Referreds*/
		$api->get('client/getReferreds', 'ReferredsApiController@getReferreds');
		$api->post('client/addReferreds', 'ReferredsApiController@addReferreds');

		/*Types*/
		$api->get('client/types', 'TypesApiController@getTypes');

		/*Payments*/
		$api->get('client/cards', 'PaymentsApiController@getCards');
		$api->post('client/addCard', 'PaymentsApiController@addCard');
		$api->put('client/mainCard', 'PaymentsApiController@mainCard');
        $api->delete('client/dropCard', 'PaymentsApiController@dropCard');

		$api->post('client/addPayment', 'PaymentsApiController@addPayment');
		$api->post('client/addPaymentPaypal', 'PaymentsApiController@addPaymentPaypal');
		$api->get('client/payments', 'PaymentsApiController@getPayments');

        $api->get('client/getUrgentCost', 'PaymentsApiController@getUrgentCost');
        $api->get('client/getAnnualCost', 'PaymentsApiController@getAnnualCost');
        $api->get('client/getAccountStatus', 'PaymentsApiController@getAccountStatus');
	});

   /* COURIERS SECTION */

   /**
   * endpoints for couriers that do not need authentication
   */
   $api->group(['prefix' => 'v1'], function($api) {
      $api->post('courier/login',  'CouriersApiController@login');
	  $api->delete('courier/login',  'CouriersApiController@login');
      $api->put('courier/recoveryPassword',  'CouriersApiController@recoveryPassword');
   });

   /**
   * endpoints for employees that need authentication
   *
   */
	$api->group(['prefix' => 'v1','middleware' => 'api.auth'], function($api) {
		$api->delete('courier/{courier_id}/logout',  'CouriersApiController@logout');

		/*Documents*/
		$api->put('courier/updateDocumentFolio/{document_id}', 'DocumentsApiController@updateDocumentFolio');

		/*Services*/
		$api->get('courier/services', 'ServicesApiController@getServicesCourier');
		$api->get('courier/service/{service_id}', 'ServicesApiController@getServiceCourier');
		$api->put('courier/startService/{service_id}', 'ServicesApiController@startService');
		$api->put('courier/completeService/{service_id}', 'ServicesApiController@completeService');
	});

});
//Test
Route::get('testForm','UsersApiController@form');

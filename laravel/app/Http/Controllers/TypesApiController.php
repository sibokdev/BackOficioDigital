<?php

namespace App\Http\Controllers;

use App\Type;
use App\SubTypes;
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

class TypesApiController extends Controller {
	
	use Helpers;
	
    public function __construct() {
        $this->middleware('api.auth');
    }
    
   /**
	* METHOD GET
	*
	* This method is used to get all documents by types with subtypes
	*
	* @return success or in case an error the corresponding data about it
	*
	*/
	public function getTypes() {
		$user = $this->auth->user();
		
		if(!$user) {
			return CustomResponsesHandler::response([
				"code" => 401,
				"message" => "Permisos denegados para el cliente",
				"response" => null
			]);
		} else {
			$types = Type::get();
			
			if($types->count()) {
				foreach($types as $key => $type) {
					$subtypes = SubTypes::where('type_id', $type->id)->get();
					$types[$key]->subtypes = $subtypes;
				}
				
				//dd($types);
				return CustomResponsesHandler::response([
					"code" => 200,
					"message" => "Listado de tipos de documentos",
					"response" => array("types" => $types)
				]);
			} else { 
				return CustomResponsesHandler::response([
					"code" => 202,
					"message" => "No se encontraron tipos de documentos",
					"response" => null
				]);
			}
		}
	}
}

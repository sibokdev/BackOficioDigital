<?php
namespace App\Library;

class CustomResponsesHandler {

   public static function response(array $data){
      $responseArray = [
         'code' => $data['code'],
         'message' => $data['message'],
         'response' => $data['response']
      ];
      return response()->json($responseArray)->setStatusCode($data['code']);
   }

}

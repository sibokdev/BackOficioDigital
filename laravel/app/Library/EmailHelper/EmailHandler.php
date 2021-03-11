<?php
namespace App\Library\EmailHelper;

class EmailHandler {

   private $email;
   private $subject;
   private $from;

   public function sendEmail(array $data, $from){
	   
      if ($from == 'contract') {
         $this->from = 'Registro éxitoso';
      } elseif($from == 'invitation') {
		 $this->from = 'Invitación enviada exitosamente';
     } elseif($from == 'change') {
		 $this->from = 'Modificación exitosa';
	  } else {
         $this->from = 'Se ha enviado un mensaje al correo que proporcionaste con tu nueva contraseña';
      }

      $this->email = $data['email'];
      $this->subject = $data['subject'];

      \Mail::raw($data['message'], function($message){
         $message->to($this->email)->subject($this->subject);
      });

      if(count(\Mail::failures()) > 0){
         return [
            "code" => 404,
            "message" => "Ocurrió un error al enviar correo ",
            "response" => Mail::failures()
         ];
      }else{
         return [
            "code" => 200,
            "message" => $this->from,
            "response" => null
         ];
      }
   }
}

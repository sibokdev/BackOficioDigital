<?php

require_once __DIR__."/config.php";
require_once dirname(__DIR__)."/EnvayaSMS.php";

$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array

$to = htmlspecialchars($input["to"]);
$body = htmlspecialchars($input["message"]);

if($to == null || $body == null){
    error_log("Usage: php send_sms.php <to> \"<message>\"");
    error_log("Example: ");
    error_log("     php send_sms.php 16504449876 \"hello world\"");
    echo error;
    die;
}

$message = new EnvayaSMS_OutgoingMessage();
$message->id = uniqid("");
$message->to = $to;
$message->message = $body;

file_put_contents("$OUTGOING_DIR_NAME/{$message->id}.json", json_encode($message));
    
echo "Message {$message->id} added to filesystem queue\n";

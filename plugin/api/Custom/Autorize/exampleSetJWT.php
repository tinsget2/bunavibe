<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$root_Dir = "/com";
include_once $path.$root_Dir."/Custom/Database/data_Validate.php";
include_once $path.$root_Dir."/Custom/Variables/constants.php";
include_once $path.$root_Dir."/Custom/JWT/jwt_Caller.php";
include_once $path.$root_Dir."/Custom/Autorize/autorize.php";

header('Content-Type: application/json');

//The array needed to send to jwt
$data = array('a'=>'Tinsae', 'b' => 'Getachew');

//Time the token works for
$time = 24*60*60;

//calling JWT_Data class
$jwt = new JWT_Data();

//Sending the data to create jwt token and store in the coockie 
//get_JWT() returns json data 
$response = json_decode($jwt->set_JWT($data, $time));
$status = $response->Status;
$data = $response->Message;

print_r($response);
?>
<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$root_Dir = "/com";
include_once $path.$root_Dir."/Custom/Database/data_Validate.php";
include_once $path.$root_Dir."/Custom/Variables/constants.php";
include_once $path.$root_Dir."/Custom/JWT/jwt_Caller.php";
include_once $path.$root_Dir."/Custom/Autorize/autorize.php";

header('Content-Type: application/json');

//create JWT_Data objet
$j = new JWT_Data();

//the data that will be encripted
$data = 'Tinsae';

//send data to encript and get the encripted data
//returns array
$d = $j->encript_256($data, true);

print_r($d);
echo '<br>';

//decode the data
$e = $j->decript_256($d, true);
print_r($e);

?>
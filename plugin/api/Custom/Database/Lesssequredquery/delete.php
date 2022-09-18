<?php
    require_once 'less_Secure_Include.php';

    header('Content-Type: application/json');
    // Turn off all error reporting
    error_reporting(0);

    //Get Value
    $input = json_decode(file_get_contents("php://input"));      
    $alies = $input->alies;

    $sql_Query = new Less_Sequre_Query('DELETE', 'Delete');

    $query = "DELETE FROM `company` WHERE `alias` = ?";
    $value = array($alies);
    $type = 's';

    $result = $sql_Query->less_Sequre($query, $value, $type);

    if(!($result == "") || !($result == null)){
        http_response_code(SUCCESS_RESPONSE);
        echo json_encode(array('Status'=>SUCCESS_RESPONSE, 'Message'=>$result));
    }


?>
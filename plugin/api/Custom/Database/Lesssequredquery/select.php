<?php
    require_once 'less_Secure_Include.php';

    header('Content-Type: application/json');
    // Turn off all error reporting
    error_reporting(0);

    //Get value
    $name = $_GET['name'];

    $sql_Query = new Less_Sequre_Query('GET', 'Select');

    $query = "SELECT * FROM `admin` WHERE `admin_Id` = ? LIMIT ?";
    $value = array($name, 1000);
    $type = 'ii';

    $result = $sql_Query->less_Sequre($query, $value, $type);

    if(!($result == "") || !($result == null)){
        http_response_code(SUCCESS_RESPONSE);
        echo json_encode(array('Status'=>SUCCESS_RESPONSE, 'Message'=>$result));
        
    }

?>
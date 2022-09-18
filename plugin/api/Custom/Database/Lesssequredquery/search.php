<?php
    require_once 'less_Secure_Include.php';

    header('Content-Type: application/json');
    // Turn off all error reporting
    error_reporting(0);

    $search = '%'.$_GET['name'].'%';

    if(!($search == '%%')){

        $sql_Query = new Less_Sequre_Query('GET', 'Select');

        $query = "SELECT * FROM `company` WHERE `name` LIKE ?";
        $value = array($search);
        $type = 's';

        $result = $sql_Query->less_Sequre($query, $value, $type);

        if(!($result == "") || !($result == null)){
            http_response_code(SUCCESS_RESPONSE);
            echo json_encode(array('Status'=>SUCCESS_RESPONSE, 'Message'=>$result));
        }
    }else{
        $status = FILE_NOT_FOUND_ERROR;                
        http_response_code($status);
        echo json_encode(array('Status'=>$status, 'Message'=>"File not found"));
    }

?>
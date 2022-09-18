<?php
    require_once 'sequre_Query_Include.php';

    header('Content-Type: application/json');
    // Turn off all error reporting
    error_reporting(0);

    $jwt = new JWT_Data();

    $response = json_decode($jwt->get_JWT());
    //Token response code
    $status = $response->Status;
    //Token message or data
    $jwtToken = $response->Message;
    //issues at time
    $jwtToken_iat = $response->iat;

    //token data check comment out the rest of the code and uncomment print_r
    // print_r($jwtToken);
    //Token datas
    $token = $jwt->decript_256($jwtToken->token, true);
    $name = $jwt->decript_256($jwtToken->name, true);
    $authorization = $jwt->decript_256($jwtToken->authorization, true);
    $email = $jwt->decript_256($jwtToken->email, true);
    $username = $jwt->decript_256($jwtToken->username, true);
    $id = $jwt->decript_256($jwtToken->id, true);
    $iat = $jwtToken->iat;

    //Token create mostly from uniquedatafromjwttoken+iat+secrettokenkey
    $createdToken = $username.URL.$iat.$authorization;

    //Get Value
    $search = '%'.$_GET['name'].'%';

    if(!($search == '%%')){

        $sql_Query = new Data_Validate($token, $createdToken, 'POST', 'Select');

        $query = "SELECT * FROM `company` WHERE `name` LIKE ?";
        $value = array($search);
        $type = 's';

        $result = $sql_Query->data_Validate($query, $value, $type);

        if(!($result == "") || !($result == null)){
            http_response_code(SUCCESS_RESPONSE);
            echo json_encode(array('Status'=>$status, 'Message'=>$result));
        }
    }else{
        $status = FILE_NOT_FOUND_ERROR;                
        http_response_code($status);
        echo json_encode(array('Status'=>$status, 'Message'=>"File not found"));
    }

?>
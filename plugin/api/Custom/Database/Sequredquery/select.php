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
    $name = $_GET['name'];
    

    $sql_Query = new Data_Validate($token, $createdToken, 'GET', 'Select');

    $query = "SELECT * FROM `admin` WHERE `admin_Id` = ? LIMIT ?";
    $value = array($search, 1);
    $type = 'ii';

    $result = $sql_Query->data_Validate($query, $value, $type);

    if(!($result == "") || !($result == null)){
        http_response_code(SUCCESS_RESPONSE);
        echo json_encode(array('Status'=>$status, 'Message'=>$result));
    }

?>
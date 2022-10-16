<?php
//This php is for getting posted vacancies to the poster 
    require_Once "../../plugin/api/Custom/Database/Sequredquery/sequre_Query_Include.php";

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
    $phone = $jwt->decript_256($jwtToken->phone, true);
    $authorization = $jwt->decript_256($jwtToken->authorization, true);
    $email = $jwt->decript_256($jwtToken->email, true);
    $alies = $jwt->decript_256($jwtToken->alies, true);
    $name = $jwt->decript_256($jwtToken->name, true);
    $iat = $jwtToken->iat;

    //Token create mostly from uniquedatafromjwttoken+iat+secrettokenkey
    $createdToken = $email.$phone.URL.$iat.$authorization;

    
    // Get Value
    $friendAlies = $_GET['friendAlies'];
    

    $sql_Query = new Data_Validate($token, $createdToken, 'GET', 'Select');

    $query = "SELECT `p`.`alies`, `p`.`name`, `p`.`path` FROM `posts` `p` RIGHT JOIN `matching` `m` ON `p`.`alies`=`m`.`aliesUserOne` WHERE `p`.`alies`=? AND `p`.`status`=? AND `p`.`privacy`=? AND `m`.`userOneMatchStatus` = ? LIMIT ?";
    $value = array($friendAlies, 1, 1, 1, 10000);
    $type = 'siiii';

    $result = $sql_Query->data_Validate($query, $value, $type);

    if(!($result == "") || !($result == null)){
        http_response_code(SUCCESS_RESPONSE);
        echo json_encode(array('Status'=>$status, 'Message'=>$result));
    }

?>
<?php
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

    //Get Value
    $input = json_decode(file_get_contents("php://input"));
    $companyName = $input->companyName;
    $position = $input->position;
    $startDate = $input->startDate;      
    $endDate = $input->endDate;
    $description = $input->description;

    $time = time();

    $expAlias = substr($companyName, 0, strpos($companyName," ")).$time.rand(100,1000);

    $sql_Query = new Data_Validate($token, $createdToken, 'POST', 'Insert');

    $query = "INSERT INTO `experience`(`alies`, `expAlies`, `companyName`, `position`, `startDate`, `endDate`, `description`) VALUES(?, ?, ?, ?, ?, ?, ?)";
    $value = array($alies, $expAlias, $companyName, $position, $startDate, $endDate, $description);
    $type = 'sssssss';

    $result = $sql_Query->data_Validate($query, $value, $type);

    if(!($result == "") || !($result == null)){
        http_response_code(SUCCESS_RESPONSE);
        echo json_encode(array('Status'=>$status, 'Message'=>$result));
    }


?>
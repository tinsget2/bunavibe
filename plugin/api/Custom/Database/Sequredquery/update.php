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
    $input = json_decode(file_get_contents("php://input"));   
       
    $alies = $input->alies;
    $name = $input->name;
    $user = $input->user;
    $password = $input->password;
    $about = $input->about;      
    $email = $input->email;
    $landline = $input->landline;
    $mobile1 = $input->mobile1;
    $mobile2 = $input->mobile2;
    $country = $input->country;
    $city = $input->city;
    $address = $input->address;  

    $modifiedBy = $input->name;
    $modifiedDate = date("Y-m-d");


    $sql_Query = new Data_Validate($token, $createdToken, 'PUT', 'Update');

    $query = "UPDATE `company` SET `name`=?,`user`=?,`password`=?,`about`=?,`email`=?,`landline`=?,`mobile1`=?,`mobile2`=?,`country`=?,`city`=?,`address`=?,`modifiedDate`=?,`modifiedBy`=? WHERE `alias`=?";
    $value = array($name, $user, $password, $about, $email, $landline, $mobile1, $mobile2, $country, $city, $address, $modifiedDate, $modifiedBy, $alies);
    $type = 'ssssssssssssss';

    $result = $sql_Query->data_Validate($query, $value, $type);

    if(!($result == "") || !($result == null)){
        http_response_code(SUCCESS_RESPONSE);
        echo json_encode(array('Status'=>$status, 'Message'=>$result));
    }


?>
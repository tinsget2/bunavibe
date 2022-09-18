<?php
    require_once 'less_Secure_Include.php';

    header('Content-Type: application/json');
    // Turn off all error reporting
    // error_reporting(0);

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


    $sql_Query = new Less_Sequre_Query('PUT', 'Update');

    $query = "UPDATE `company` SET `name`=?,`user`=?,`password`=?,`about`=?,`email`=?,`landline`=?,`mobile1`=?,`mobile2`=?,`country`=?,`city`=?,`address`=?,`modifiedDate`=?,`modifiedBy`=? WHERE `alias`=?";
    $value = array($name, $user, $password, $about, $email, $landline, $mobile1, $mobile2, $country, $city, $address, $modifiedDate, $modifiedBy, $alies);
    $type = 'ssssssssssssss';

    $result = $sql_Query->less_Sequre($query, $value, $type);

    if(!($result == "") || !($result == null)){
        http_response_code(SUCCESS_RESPONSE);
        echo json_encode(array('Status'=>SUCCESS_RESPONSE, 'Message'=>$result));
    }


?>
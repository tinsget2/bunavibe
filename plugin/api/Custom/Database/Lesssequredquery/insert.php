<?php
    require_once 'less_Secure_Include.php';

    header('Content-Type: application/json');
    // Turn off all error reporting
    error_reporting(0);

    //Get Value
    $input = json_decode(file_get_contents("php://input"));      
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

    $createdBy = $input->name;
    $createdDate = date("Y-m-d");

    $alias = $name.rand(0,10000).rand(0,10000);

    $sql_Query = new Less_Sequre_Query('POST', 'Insert');

    $query = "INSERT INTO `company`(`id`, `alias`, `name`, `user`, `password`, `about`, `email`, `landline`, `mobile1`, `mobile2`, `country`, `city`, `address`, `logo`, `status`, `createdDate`, `createdBy`, `modifiedDate`, `modifiedBy`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $value = array(NULL, $alias, $name, $user, $password, $about, $email, $landline, $mobile1, $mobile2, $country, $city, $address, NULL, 'Approved', $createdDate, $createdBy, NULL, NULL);
    $type = 'issssssssssssssssss';

    $result = $sql_Query->less_Sequre($query, $value, $type);

    if(!($result == "") || !($result == null)){
        http_response_code(SUCCESS_RESPONSE);
        echo json_encode(array('Status'=>SUCCESS_RESPONSE, 'Message'=>$result));
    }


?>
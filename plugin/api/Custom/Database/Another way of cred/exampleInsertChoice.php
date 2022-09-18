<?php
    include_once 'sql_query.php';
    include_once '../Autorize/autorize.php';

    $sql = new SQL_Query();
    $jwt = new JWT_Data();

    //Token decript
    $response = json_decode($jwt->get_JWT());
    //Token response code
    $status = $response->Status;
    //Token message or data
    $data = $response->Message;

    if($status == SUCCESS_RESPONSE){
        $a = $data->a;
        $b = $data->b;
        $c = 'POST';

        try{
            if($_SERVER['REQUEST_METHOD'] === $c){
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

                $query = "INSERT INTO `company`(`id`, `alias`, `name`, `user`, `password`, `about`, `email`, `landline`, `mobile1`, `mobile2`, `country`, `city`, `address`, `logo`, `status`, `createdDate`, `createdBy`, `modifiedDate`, `modifiedBy`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $value = array(NULL, $alias, $name, $user, $password, $about, $email, $landline, $mobile1, $mobile2, $country, $city, $address, NULL, 'Approved', $createdDate, $createdBy, NULL, NULL);
                $type = 'issssssssssssssssss';
                
                $result = $sql->sql_InsertDeleteUpdate($query, $value, $type);
        
                
                http_response_code($status);
                echo json_encode(array('Status'=>$status, 'Message'=>$result));
            }else{
                $status = EXPECTATION_FAILED;
                http_response_code($status);
                echo json_encode(array('Status'=>$status, 'Message'=>'Request method not valid'));
            }
            
        }catch(Exception $e){
            $err = $e->getMessage();
            $conflict = 'Duplicate entry';
            $columnNull = 'cannot be null';
            $columnOtherType1 = 'Data truncated';
            $columnOtherType2 = 'Incorrect';
            if($err == ""){                
                $status = FILE_NOT_FOUND_ERROR;                
                http_response_code($status);
                echo json_encode(array('Status'=>$status, 'Message'=>"File not found"));
            }else if(preg_match("/{$conflict}/i", $err)){
                $status = CONFLICT;                
                http_response_code($status);
                echo json_encode(array('Status'=>$status, 'Message'=>"Duplicate entry"));
            }else if(preg_match("/{$columnNull}/i", $err)){
                $status = PRECONDITION_FAILED;                
                http_response_code($status);
                echo json_encode(array('Status'=>$status, 'Message'=>"Required input is null"));
            }else if(preg_match("/{$columnOtherType1}/i", $err) || preg_match("/{$columnOtherType2}/i", $err)){
                $status = PRECONDITION_FAILED;                
                http_response_code($status);
                echo json_encode(array('Status'=>$status, 'Message'=>"Type mismatch"));
            }else{
                $status = BAD_REQUEST;
                http_response_code($status);
                echo json_encode(array('Status'=>$status, 'Message'=>$err));
            }
        } 
    }else{        
        http_response_code($status);
        echo json_encode(array('Status'=>$status, 'Message'=>$data));
    }
    
?>
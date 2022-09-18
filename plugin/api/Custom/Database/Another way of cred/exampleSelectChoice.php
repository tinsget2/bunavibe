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

        try{
            if($_SERVER['REQUEST_METHOD'] === 'GET'){
                $query = "SELECT * FROM `admin` WHERE `admin_Id` = ? LIMIT ?";
                $value = array(1, 1);
                $type = 'ii';
                
                $result = $sql->sql_Select($query, $value, $type);
                
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
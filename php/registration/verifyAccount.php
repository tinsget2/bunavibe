<?php
    require_Once "../../plugin/api/Custom/Database/Lesssequredquery/less_Secure_Include.php";
    include_once '../../plugin/mail_Sender/send_Mail_Custom.php';

    header('Content-Type: application/json');
    // Turn off all error reporting
    error_reporting(0);

    //Get Value
    $input = json_decode(file_get_contents("php://input"));      
    $email = $input->email;
    $code = $input->code;

    $sql_Query = new Less_Sequre_Query('PUT', 'Select');

    $query = "SELECT `verification`, `status` FROM `userinfo` WHERE `email` = ? LIMIT ?";
    $value = array($email, 1);
    $type = 'si';

    $result = $sql_Query->less_Sequre($query, $value, $type);

    if(!($result == "") || !($result == null)){
        if($result[0]['verification']===$code){            
            if($result[0]['status']===2){
                verifyAccount($email);
            }else{
                http_response_code(BAD_REQUEST);
                echo json_encode(array('Status'=>BAD_REQUEST, 'Message'=>'Your account has been verifed!'));  
            }
        }     
    }

    


    function verifyAccount($email){
        
        $sql_Query = new Less_Sequre_Query('PUT', 'Update');

        $query = "UPDATE `userinfo` SET `status`=? WHERE `email`=?";
        $value = array(1, $email);
        $type = 'ss';

        $result = $sql_Query->less_Sequre($query, $value, $type);

        if(!($result == "") || !($result == null)){
            http_response_code(SUCCESS_RESPONSE);
            echo json_encode(array('Status'=>SUCCESS_RESPONSE, 'Message'=>$result));        
        }
    }


?>
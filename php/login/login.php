<?php
    require_Once "../../plugin/api/Custom/Database/Lesssequredquery/less_Secure_Include.php";

    header('Content-Type: application/json');
    // Turn off all error reporting
    // error_reporting(0);

        
    //Get Value
    $input = json_decode(file_get_contents("php://input"));      
    $username = $input->username;
    $password = $input->password;
    $keepMeStay = $input->keepMeStay;
    
    if($keepMeStay == 'On'){
        $exp = time() + (10 * 365 * 24 * 60 * 60);//10 years
    }else{
        $exp = time() + (24 * 60 * 60);//1 day
    }
    $iat = time();

    $sql_Query = new Less_Sequre_Query('POST', 'Select');

    $query = "SELECT `alies`, `email`, `fullName`, `phone`, `password`, `dateOfBirth`, `accountType` FROM `userinfo` WHERE (`email` = ? OR `phone` = ?) AND `password` = ? AND `status` = ? LIMIT ?";
    $value = array($username, $username, $password, 1, 1);
    $type = 'sssii';

    $result = $sql_Query->less_Sequre($query, $value, $type);
    
    if(!($result == "") || !($result == null)){
        
        
        if(($result[0]['email'] == $username || $result[0]['phone'] == $username) && $result[0]['password'] == $password){
              
                updateOnlineStatus($iat, $exp, $result[0]['alies']);
                
                http_response_code(SUCCESS_RESPONSE);
                

                $jwt = new JWT_Data();
                
                $token = $jwt->encript_256($result[0]['email'].$result[0]['phone'].URL.$iat.$result[0]['accountType'], true);
                

                $alies = $jwt->encript_256($result[0]['alies'], true);
                $email = $jwt->encript_256($result[0]['email'], true);
                $phone = $jwt->encript_256($result[0]['phone'], true);
                $name = $jwt->encript_256($result[0]['fullName'], true);
                $accountType = $jwt->encript_256($result[0]['accountType'], true);
                $authorization = $jwt->encript_256($result[0]['accountType'], true);
                
                $data = array(  'phone'=>$phone,
                                'alies'=>$alies,
                                'email'=>$email,
                                'authorization'=>$authorization,
                                'name'=>$name,
                                'token'=>$token,
                                'iat'=>$iat);

                $response = json_decode($jwt->set_JWT($data, $iat, $exp));

                echo json_encode($response);
            
        }
    }

    function updateOnlineStatus($iat, $exp, $alies){
        $sql_Query_Update = new Less_Sequre_Query('POST', 'Update');

        $queryUpdate = "UPDATE `userinfo` SET `iat`=?, `expiredDate`=? WHERE `alies`=? LIMIT ?";
        $valueUpdate = array($iat, $exp, $alies, 1);
        $typeUpdate = 'sssi';

        $resultUpdate = $sql_Query_Update->less_Sequre($queryUpdate, $valueUpdate, $typeUpdate);
    }

?>
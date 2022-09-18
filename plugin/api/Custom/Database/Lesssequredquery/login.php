<?php
    require_once 'less_Secure_Include.php';

    header('Content-Type: application/json');
    // Turn off all error reporting
    error_reporting(0);

        
    //Get Value
    $input = json_decode(file_get_contents("php://input"));      
    $username = $input->username;
    $password = $input->password;
    $keepMeStay = $input->keepMeStay;
    

    if($keepMeStay == 'true'){
        $time = time() + (10 * 365 * 24 * 60 * 60);//10 years
    }else{
        $time = time() + (24 * 60 * 60);//1 day
    }
    

    $sql_Query = new Less_Sequre_Query('POST', 'Select');

    $query = "SELECT `admin_Id`, `admin_Name`, `admin_Username`, `admin_Email`, `admin_Password`, `admin_Auth` FROM `admin` WHERE `admin_Username` = ? AND `admin_Password` = ? LIMIT ?";
    $value = array($username, $password, 1);
    $type = 'ssi';

    $result = $sql_Query->less_Sequre($query, $value, $type);
    
    if(!($result == "") || !($result == null)){
        
        if($result['0']['admin_Username'] == $username && $result['0']['admin_Password'] == $password){
            http_response_code(SUCCESS_RESPONSE);
            

            $jwt = new JWT_Data();
            $iat = time();
            $token = $jwt->encript_256($result['0']['admin_Username'].URL.$iat.$result['0']['admin_Auth'], true);
            

            $id = $jwt->encript_256($result['0']['admin_Id'], true);
            $username = $jwt->encript_256($result['0']['admin_Username'], true);
            $name = $jwt->encript_256($result['0']['admin_Name'], true);
            $email = $jwt->encript_256($result['0']['admin_Email'], true);
            $authorization = $jwt->encript_256($result['0']['admin_Auth'], true);
            
            $data = array(  'username'=>$username,
                            'id'=>$id,
                            'email'=>$email,
                            'authorization'=>$authorization,
                            'name'=>$name,
                            'token'=>$token,
                            'iat'=>$iat);

            $response = json_decode($jwt->set_JWT($data, $time));

            echo json_encode($response);
        }
    }

?>
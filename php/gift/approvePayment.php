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
    $perchaseAlies = $input->perchaseAlies;

    $sql_Query = new Data_Validate($token, $createdToken, 'POST', 'Select');

    $query = "SELECT * FROM `giftperchase` WHERE `perchaseAlies`=?";
    $value = array($perchaseAlies);
    $type = 's';

    $resultS = $sql_Query->data_Validate($query, $value, $type);

    if(!($resultS == "") || !($resultS == null)){
        if($resultS[0]['approval'] == 1){
            http_response_code(SUCCESS_RESPONSE);
            echo json_encode(array('Status'=>$status, 'Message'=>'Approved Completed'));
        }else{
            $sql_Query = new Data_Validate($token, $createdToken, 'POST', 'Update');

            $query = "UPDATE `giftperchase` SET `approval`=? WHERE `perchaseAlies`=?";
            $value = array(1, $perchaseAlies);
            $type = 'is';

            $result = $sql_Query->data_Validate($query, $value, $type);

            if(!($result == "") || !($result == null)){
                $sql_Query = new Data_Validate($token, $createdToken, 'POST', 'SELECT');

                $query = "SELECT `gt`.`perchaseNumber`, `gt`.`giftAlies`, `gt`.`giftOwner`, `gp`.`numberOfGift` FROM `gifttotal` `gt` LEFT JOIN `giftperchase` `gp` ON `gt`.`perchaseNumber`= `gp`.`perchaseAlies` WHERE `gt`.`perchaseNumber`= ?";
                $value = array($perchaseAlies);
                $type = 's';

                $result1 = $sql_Query->data_Validate($query, $value, $type);

                if(!($result1 == "") || !($result1 == null)){           
                    $sql_Query = new Data_Validate($token, $createdToken, 'POST', 'Insert');

                    $query = "UPDATE `gifttotal` SET `totalGift` = `totalGift`+? WHERE `giftAlies`=? AND `giftOwner`=?";
                    $value = array($result1[0]['numberOfGift'], $result1[0]['giftAlies'], $result1[0]['giftOwner']);
                    $type = 'sss';

                    $result2 = $sql_Query->data_Validate($query, $value, $type);

                    if(!($result2 == "") || !($result2 == null)){
                        http_response_code(SUCCESS_RESPONSE);
                        echo json_encode(array('Status'=>$status, 'Message'=>$result2));
                    }
                    
                }else if($result1 == "" || $result1 == null){
                    $sql_Query = new Data_Validate($token, $createdToken, 'POST', 'Insert');

                    $query = "INSERT INTO `gifttotal`(`perchaseNumber`, `giftAlies`, `giftOwner`, `totalGift`) SELECT `perchaseAlies`, `giftAlies`, `giftOwner`, `numberOfGift` FROM `giftperchase` WHERE `perchaseAlies`=?";
                    $value = array($perchaseAlies);
                    $type = 's';

                    $result2 = $sql_Query->data_Validate($query, $value, $type);

                    if(!($result2 == "") || !($result2 == null)){
                        http_response_code(SUCCESS_RESPONSE);
                        echo json_encode(array('Status'=>$status, 'Message'=>$result2));
                    }
                }                
            }
            }
        }


?>
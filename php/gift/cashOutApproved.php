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
    $perchaseNumber = $input->perchaseNumber;    
    $cashOutAlies = $input->cashOutAlies;

    $time = time();
    $gift = 'CashOut@';

    $cashAlies = substr($gift, 0, strpos($gift,"@")).$time.rand(100,1000);

    $sql_Query = new Data_Validate($token, $createdToken, 'POST', 'Select');

    $query = "SELECT `gt`.`totalGift`, `gp`.`unitPrice`, `co`.`wihdrowalAmount`, `co`.`withdrowalCompleted` FROM `gifttotal` `gt` LEFT JOIN `giftspackage` `gp` ON `gp`.`alias`=`gt`.`giftAlies` LEFT JOIN `chashout` `co` ON `co`.`perchaseNumber`=`gt`.`perchaseNumber` WHERE `gt`.`perchaseNumber`=? AND `gt`.`giftOwner`=?";
    $value = array($perchaseNumber, $alies);
    $type = 'ss';

    $result = $sql_Query->data_Validate($query, $value, $type);

    if(!($result == "") || !($result == null)){
        $cashOutAmount = $result[0]['wihdrowalAmount'];
        if(($result[0]['totalGift']*$result[0]['unitPrice'])>$cashOutAmount && ($result[0]['totalGift']*$result[0]['unitPrice'])>50){
            if($result[0]['withdrowalCompleted']==0){
                $sql_Query = new Data_Validate($token, $createdToken, 'POST', 'Update');

                
                $totalGiftLeft = (($result[0]['totalGift']*$result[0]['unitPrice'])-$cashOutAmount)/$result[0]['unitPrice'];

                $sql_Query = new Data_Validate($token, $createdToken, 'POST', 'Update');

                $query = "UPDATE `gifttotal` SET `totalGift`=?,`checkOutAmount`=`checkOutAmount`+?,`checkOutApproved`=`checkOutApproved`+? WHERE `perchaseNumber`=?";
                $value = array($totalGiftLeft, $cashOutAmount, $cashOutAmount, $perchaseNumber);
                $type = 'diis';

                $resultG = $sql_Query->data_Validate($query, $value, $type);

                if(!($resultG == "") || !($resultG == null)){
                    $query = "UPDATE `chashout` SET `withdrowalCompleted`=? WHERE `alies`=?";
                    $value = array($cashOutAmount, $cashOutAlies);
                    $type = 'ss';

                    $resultC = $sql_Query->data_Validate($query, $value, $type);

                    if(!($resultC == "") || !($resultC == null)){
                        http_response_code(SUCCESS_RESPONSE);
                        echo json_encode(array('Status'=>$status, 'Message'=>$resultG));
                    }
                }
            }else{
                http_response_code(SUCCESS_RESPONSE);
                echo json_encode(array('Status'=>$status, 'Message'=>"Withdrowal completed"));  
            }
            
        }else{
            http_response_code(SUCCESS_RESPONSE);
            echo json_encode(array('Status'=>$status, 'Message'=>"You don't have enough cash"));
        }
    }


?>
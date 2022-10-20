<?php
    require_Once "../../plugin/api/Custom/Database/Sequredquery/sequre_Query_Include.php";

    header('Content-Type: application/json');
    // Turn off all error reporting
    // error_reporting(0);

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
    $purchaseNumber = $input->purchaseNumber;
    $numberOfGiftSend = $input->numberOfGiftSend;
    $giftReciver = $input->giftReciver;

    $sql_Query = new Data_Validate($token, $createdToken, 'POST', 'SELECT');

    $query = "SELECT `perchaseNumber` AS `perchaseAlies`, `giftAlies` , `giftOwner`, `noOfGiftsSend`, `noOfGiftsRecived`, `totalGift` AS `numberOfGift` FROM `gifttotal` WHERE `giftOwner`=? AND `perchaseNumber`=? LIMIT ?";
    $value = array($alies, $purchaseNumber, 1);
    $type = 'ssi';

    $result1 = $sql_Query->data_Validate($query, $value, $type);

    if(!($result1 == "") || !($result1 == null)){           
        if($result1[0]['numberOfGift'] >= $numberOfGiftSend){
            $sql_Query = new Data_Validate($token, $createdToken, 'POST', 'Update');

            $query = "UPDATE `gifttotal` SET `noOfGiftsSend`=`noOfGiftsSend`+?, `totalGift`=`totalGift`-? WHERE `giftOwner`=? AND `perchaseNumber`=?";
            $value = array($numberOfGiftSend, $numberOfGiftSend, $result1[0]['giftOwner'], $result1[0]['perchaseAlies']);
            $type = 'iiss';

            $result = $sql_Query->data_Validate($query, $value, $type);

            if(!($result == "") || !($result == null)){
                // http_response_code(SUCCESS_RESPONSE);
                // echo json_encode(array('Status'=>$status, 'Message'=>$result));
                statment($token, $createdToken, $status, $result1, $giftReciver, $numberOfGiftSend);
            }
        }else{
            http_response_code(SUCCESS_RESPONSE);
            echo json_encode(array('Status'=>$status, 'Message'=>"You only have ".$result1[0]['numberOfGift']." gifts"));
        }
        
    }
    
    
    function statment($token, $createdToken, $status, $result1, $giftReciver, $numberOfGiftSend){
        
        $sql_Query = new Data_Validate($token, $createdToken, 'POST', 'SELECT');

        $query = "SELECT `perchaseNumber` AS `perchaseAlies`, `giftAlies` , `giftOwner`, `noOfGiftsSend`, `noOfGiftsRecived`, `totalGift` AS `numberOfGift` FROM `gifttotal` WHERE `giftOwner`=? AND `giftAlies`=? LIMIT ?";
        $value = array($giftReciver, $result1[0]['giftAlies'], 1);
        $type = 'ssi';

        $result11 = $sql_Query->data_Validate($query, $value, $type);

        if(!($result11 == "") || !($result11 == null)){
            // http_response_code(SUCCESS_RESPONSE);
            // echo json_encode(array('Status'=>$status, 'Message'=>$result11));
            $sql_Query = new Data_Validate($token, $createdToken, 'POST', 'Update');

            $query = "UPDATE `gifttotal` SET `noOfGiftsRecived`=`noOfGiftsRecived`+?, `totalGift`=`totalGift`+? WHERE `giftOwner`=? AND `perchaseNumber`=?";
            $value = array($numberOfGiftSend, $numberOfGiftSend, $result11[0]['giftOwner'], $result11[0]['perchaseAlies']);
            $type = 'iiss';

            $result = $sql_Query->data_Validate($query, $value, $type);

            if(!($result == "") || !($result == null)){
                // http_response_code(SUCCESS_RESPONSE);
                // echo json_encode(array('Status'=>$status, 'Message'=>$result));
                statment_All($token, $createdToken, $status, $result1, $giftReciver, $numberOfGiftSend);
            }
            
        }else{
            $time = time();
            $gift = 'Code@';

            $perchaseAlies = substr($gift, 0, strpos($gift,"@")).$time.rand(100,1000);

            $sql_Query = new Data_Validate($token, $createdToken, 'POST', 'Insert');

            $query = "INSERT INTO `gifttotal`(`perchaseNumber`, `giftAlies`, `giftOwner`, `noOfGiftsRecived`, `totalGift`, `approval`) VALUES (?,?,?,?,?,?)";
            $value = array($perchaseAlies, $result1[0]['giftAlies'], $giftReciver, $numberOfGiftSend, $numberOfGiftSend, 1);
            $type = 'ssssss';

            $result12 = $sql_Query->data_Validate($query, $value, $type);

            if(!($result12 == "") || !($result12 == null)){
                statment_All($token, $createdToken, $status, $result1, $giftReciver, $numberOfGiftSend);
            }
        }

    }

    function statment_All($token, $createdToken, $status, $result1, $giftReciver, $numberOfGiftSend){
        $time = time();
        $gift = 'GiftSR@';

        $gifyAlies = substr($gift, 0, strpos($gift,"@")).$time.rand(100,1000);

        $sql_Query = new Data_Validate($token, $createdToken, 'POST', 'Insert');

        $query = "INSERT INTO `gifts`(`alias`, `giftAlias`, `sender`, `reciver`, `totalGift`) VALUES (?,?,?,?,?)";
        $value = array($gifyAlies, $result1[0]['giftAlies'], $result1[0]['giftOwner'], $giftReciver, $numberOfGiftSend);
        $type = 'sssss';

        $result = $sql_Query->data_Validate($query, $value, $type);

        if(!($result == "") || !($result == null)){
            http_response_code(SUCCESS_RESPONSE);
            echo json_encode(array('Status'=>$status, 'Message'=>$result));
        }
    }
    


?>
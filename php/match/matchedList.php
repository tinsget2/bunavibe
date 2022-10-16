<?php
//This php is for getting posted vacancies to the poster 
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

    
    // Get Value
    // $jobAlies = $_GET['jobAlies'];
    

    $sql_Query = new Data_Validate($token, $createdToken, 'GET', 'Select');

    $query = "SELECT
                `ui`.`alies`,
                `ui`.`email`,
                `ui`.`fullName`,
                `ui`.`phone`,
                `ui`.`gender`,
                `ui`.`InterestedIn`,
                `ui`.`dateOfBirth`,
                `ui`.`about`,
                `a`.`country`,
                `a`.`city`,
                `a`.`location`
            FROM
                `matching` `m1`
            LEFT JOIN `matching` `m2` ON
                `m1`.`aliesUserOne` = `m2`.`aliesUserTwo` AND `m1`.`aliesUserTwo` = `m2`.`aliesUserOne`
            LEFT JOIN `userinfo` `ui` ON
                `m1`.`aliesUserTwo` = `ui`.`alies`
            LEFT JOIN `address` `a` ON `a`.`alies` = `m1`.`aliesUserTwo` AND `a`.`status` = ? AND `a`.`privacy` = ?
            WHERE
                `m1`.`userOneAccept` = `m2`.`userOneAccept` = ? AND `m1`.`privacy` = `m2`.`privacy` = ? AND `m1`.`status` = `m2`.`status` = ? AND `m1`.`userOneMatchStatus` = `m2`.`userOneMatchStatus` = ? AND(
                    `m1`.`aliesUserOne` = ?
                ) AND `ui`.`status` = ? AND `ui`.`privacy` = ? AND(
                    `ui`.`accountType` = ? OR `ui`.`accountType` = ?
                ) AND `m1`.`userOneMatchStatus`=?";
    $value = array(1, 1, 1, 1, 1, 1, $alies, 1, 1, 1, 3, 1);
    $type = 'iiiiiisiiiii';

    $result = $sql_Query->data_Validate($query, $value, $type);

    if(!($result == "") || !($result == null)){
        http_response_code(SUCCESS_RESPONSE);
        echo json_encode(array('Status'=>$status, 'Message'=>$result));
    }

?>
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

    
    // Get Value
    // $limitStart = $_GET['limitStart'];
    // $limitEnd = $_GET['limitEnd'];
    $endDate = date("Y-m-d");
    

    $sql_Query = new Data_Validate($token, $createdToken, 'GET', 'Select');

    $query = "SELECT DISTINCT
                `v`.`alies`, `v`.`jobAlies`, `v`.`companyName`, `v`.`aboutCompany`, `v`.`logo`, `v`.`jobTitle`,             	
                `v`.`jobCatagory`, `v`.`jobType`, `v`.`jobEducation`, `v`.`experience`, `v`.`salary`, `v`.`postedDate`,
                `v`.`endDate`, `v`.`duty`, `v`.`requirement`, `v`.`applyMethod`
            FROM
                `vacancy` `v`
            LEFT JOIN `skills` `s` ON
                `v`.`requirement` LIKE CONCAT('%', `s`.`skill`, '%') OR `jobCatagory` = `s`.`skill` OR `jobTitle` = `s`.`skill` OR `jobType` = `s`.`skill`
            LEFT JOIN `education` `e` ON
                (
                    `v`.`jobEducation` LIKE CONCAT('%', `e`.`graduatedIn`, '%') OR `jobCatagory` = `e`.`graduatedIn` OR `jobTitle` = `e`.`graduatedIn` OR `jobType` = `e`.`graduatedIn`
                )OR
                (
                    `v`.`jobEducation` LIKE CONCAT('%', `e`.`minor`, '%') OR `jobCatagory` = `e`.`minor` OR `jobTitle` = `e`.`minor` OR `jobType` = `e`.`minor`
                )OR
                (
                    `v`.`jobEducation` LIKE CONCAT('%', `e`.`major`, '%') OR `jobCatagory` = `e`.`major` OR `jobTitle` = `e`.`major` OR `jobType` = `e`.`major`
                )
                WHERE `e`.`alies` = ? AND NOT `v`.`alies`=? AND `v`.`endDate`>=? AND `v`.`privacy` = ? AND `v`.`status` = ? LIMIT ?";
    $value = array($alies, $alies, $endDate, 1, 1, 1000);
    $type = 'sssiii';

    $result = $sql_Query->data_Validate($query, $value, $type);

    if(!($result == "") || !($result == null)){
        http_response_code(SUCCESS_RESPONSE);
        echo json_encode(array('Status'=>$status, 'Message'=>$result));
    }

?>
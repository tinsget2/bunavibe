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
    $userAlias = $_GET['userAlias'];

    $sql_Query = new Data_Validate($token, $createdToken, 'GET', 'Select');

    $query = "SELECT
            `u`.`alies`,
            `u`.`email`,
            `u`.`fullName`,
            `u`.`phone`,
            `u`.`gender`,
            `u`.`dateOfBirth`,
            `u`.`password`,
            `u`.`verification`,
            `u`.`about`,
            FLOOR(
                DATEDIFF(CURRENT_DATE, `dateOfBirth`) / 365.25
            ) AS 'age',
            FLOOR(
                1609.344 *(
                    3960.0 * ACOS(
                        (
                            SIN(`a1`.`latitude` /(57.29577951)) * SIN(`a2`.`latitude` /(57.29577951))
                        ) + COS(`a1`.`latitude` /(57.29577951)) * COS(`a2`.`latitude` /(57.29577951)) * COS(
                            (`a2`.`longtiude` /(57.29577951)) -(`a1`.`longtiude` /(57.29577951))
                        )
                    )
                )
            ) AS `distanceInMeter`
        FROM
            `userinfo` `u`
            LEFT JOIN `address` `a2` ON `u`.`alies`=`a2`.`alies`
            LEFT JOIN `address` `a1` ON `a1`.`alies` = ?
        WHERE
            (
                `u`.`accountType` = ? OR `u`.`accountType` = ?
            ) AND `u`.`status` = ? AND `u`.`privacy` = ? AND(
            SELECT
                FLOOR(
                    DATEDIFF(CURRENT_DATE, `dateOfBirth`) / 365.25
                ) AS 'age'
            FROM
                `userinfo` `ui`
            WHERE
                `ui`.`alies` = `u`.`alies`
        ) BETWEEN(
            SELECT
                `selectedAgeRangeMin`
            FROM
                `userinfo`
            WHERE
                `alies` = ?
        ) AND(
            SELECT
                `selectedAgeRangeMax`
            FROM
                `userinfo`
            WHERE
                `alies` = ?
        ) AND NOT `u`.`alies` = ? ORDER BY `distanceInMeter` ASC";
    $value = array($alies, 1, 3, 1, 1, $alies, $alies, $alies);
    $type = 'siiiisss';

    $result = $sql_Query->data_Validate($query, $value, $type);

    if(!($result == "") || !($result == null)){
        http_response_code(SUCCESS_RESPONSE);
        echo json_encode(array('Status'=>$status, 'Message'=>$result));
    }



?>
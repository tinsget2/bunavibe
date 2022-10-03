<?php
    require_Once "../../plugin/api/Custom/Database/Lesssequredquery/less_Secure_Include.php";
    include_once '../../plugin/mail_Sender/send_Mail_Custom.php';

    header('Content-Type: application/json');
    // Turn off all error reporting
    error_reporting(0);

    //Get Value
    $input = json_decode(file_get_contents("php://input"));      
    $phone = $input->phone;

    $verifyPassword = rand(100000,1000000);

    $sql_Query = new Less_Sequre_Query('PUT', 'Update');

    $query = "UPDATE `userinfo` SET `password` = ? WHERE `phone` = ?";
    $value = array($verifyPassword, $phone);
    $type = 'ss';

    $result = $sql_Query->less_Sequre($query, $value, $type);

    if(!($result == "") || !($result == null)){
        http_response_code(SUCCESS_RESPONSE);
        echo json_encode(array('Status'=>SUCCESS_RESPONSE, 'Message'=>$result, 'Phone'=>$phone, 'verificationCode'=>$verifyPassword));        
    }


    function sendEmail($email, $verifyPassword, $result){
        $subject = 'Verify Your Email';
        $to = $email;
    
        $message = "<p style='font-size:18px;'><b>You are almost there!</b></p>";
        $message .= "<p><b>Your verifcation code is<!--Please click on the link to complete the verification process!--></b></p>";
        $message .= "$verifyPassword</p>";
        $message .= "<p>You can ignore this email if you didn't attempt to verify your email address whit Buna vibe. </p>";
        $message .= "<p>Cheers<br></p>";
            
        $mailer = new send_Mail_Custom();
        $send_Mail = $mailer->send_Mail_Now($message, $subject, $to);
        // $send_Mail = $mailer->send_Mail_Now($message, $subject, $to, $name);
        //$send_Mail = $mailer->send_Mail_Now($message, $subject, $to, $name, $attchement);
        //$send_Mail = $mailer->send_Mail_Now($message, $subject, $to, $attchement, $attach_Name);
        //$send_Mail = $mailer->send_Mail_Now($message, $subject, $to, $attchement);
        //$send_Mail = $mailer->send_Mail_Now($message, $subject, $to, $name, $attchement, $attach_Name);
        
        if($send_Mail === 'Success'){
            http_response_code(SUCCESS_RESPONSE);
            echo json_encode(array('Status'=>SUCCESS_RESPONSE, 'Message'=>$result));
        }else{
            http_response_code(BAD_REQUEST);
            echo json_encode(array('Status'=>BAD_REQUEST, 'Message'=>'Verification code faild to send'));
        }
    }


?>
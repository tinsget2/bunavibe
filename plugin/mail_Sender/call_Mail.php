<?php
    include_once 'send_Mail_Custom.php';

    mail_Send_Confirm();

    function mail_Send_Confirm(){
        $subject = 'Verify You Email';
        $to = 'tinsget2@gmail.com';
        $name = 'Tinsae Kebede';
    
        $message = "<p style='font-size:18px;'><b>You are almost there!</b></p>";
        $message .= "<p><b>Please click on the link to complete the verification process!</b></p>";
        $message .= "link.</p>";
        $message .= "<p>You can ignore this email if you didn't attempt to verify your email address whit Buna vibe. </p>";
        $message .= "<p>Cheers<br></p>";
            
        $mailer = new send_Mail_Custom();
        //$send_Mail = $mailer->send_Mail_Now($message, $subject, $to);
        $send_Mail = $mailer->send_Mail_Now($message, $subject, $to, $name);
        //$send_Mail = $mailer->send_Mail_Now($message, $subject, $to, $name, $attchement);
        //$send_Mail = $mailer->send_Mail_Now($message, $subject, $to, $attchement, $attach_Name);
        //$send_Mail = $mailer->send_Mail_Now($message, $subject, $to, $attchement);
        //$send_Mail = $mailer->send_Mail_Now($message, $subject, $to, $name, $attchement, $attach_Name);
            
        if($send_Mail === 'Success'){
            http_response_code(200);
                echo json_encode(
                array('message' => 'You have reserved a room we have send you confirmation email')
            ); 
        }else{
            http_response_code(401);
            echo json_encode(
                array('message' => $send_Mail)
            ); 
        }
                 
               
    }
    
?>
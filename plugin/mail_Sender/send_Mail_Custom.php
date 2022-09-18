<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
class send_Mail_Custom {
  // Properties
  public $response;
  function __construct() {
  }
  // Methods
  public function send_Mail_Now($message, $subject, $to, $name=false, $attachment=false, $attach_Name=false) {
    $this->response = null;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    //Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.yandex.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;  
        //info_Send@251jobs.com                                  //Enable SMTP authentication
        $mail->Username   = 'tinsaegetachew@yandex.com';                     //SMTP username
        //251Jobs.com
        $mail->Password   = 'ofazlqrldntywlrz';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;       //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
        //Recipients
        $mail->setFrom('tinsaegetachew@yandex.com', 'Buna Vibe');
        //$mail->addAddress('email', 'Joe User');     //Add a recipient
        $mail->addAddress($to, $name);          //Name is optional
        // $mail->addReplyTo('email', 'Brana Event');
        // $mail->addCC('email');
        //$mail->addBCC('email');

        //Attachments


        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments

        if($attachment == false){

        }else{
          $mail->addAttachment($attachment, $attach_Name);    //Optional name
        }


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = $message;
        $mail->MsgHTML = $message;

        $mail->send();
        $this->response =  'Success';

    } catch (Exception $e) {
        $this->response = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

    }


    return $this->response;
  }
}
?> 
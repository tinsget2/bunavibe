<?php
$root = $_SERVER['DOCUMENT_ROOT'];
    $path = 'D:/wamp64/www';
    $root_Dir = "/bunavibe/php";
    require_Once $root.$root_Dir."/select2.php";

    // header('Content-Type: application/json');
    // Turn off all error reporting
    // error_reporting(0);

    // $root = $_SERVER['DOCUMENT_ROOT'];
        http_response_code(200);
        echo json_encode(array('Status'=>200, 'Message'=> $a));
        
    // echo '<img src= "'.$root.'/bunavibe/php/office.PNG">';

?>
<?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    $root_Dir = "/bunavibe/plugin/api";
    require_once $path.$root_Dir."/Custom/Database/less_Secure_Query.php";
    require_once $path.$root_Dir."/Custom/Variables/constants.php";
    require_once $path.$root_Dir."/Custom/JWT/jwt_Caller.php";
    require_once $path.$root_Dir."/Custom/Autorize/autorize.php";
?>
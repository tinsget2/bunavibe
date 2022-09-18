<?php
    $path = $_SERVER['DOCUMENT_ROOT'];
    include_once $path."/com/Custom/Variables/constants.php";
    include_once 'variables.php';

    $v = new Variables;
    $v->a;
    echo ROOT_DICTORY;
?>
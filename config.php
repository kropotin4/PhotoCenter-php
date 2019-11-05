<?php

define( 'DEBUG', 1);

session_start();

require_once 'models/ErrorHandler.php';
date_default_timezone_set('Europe/Moscow');

$config =  array(
    "db" => "mysql:host=127.0.0.1;dbname=photo_center",
    "username" => "root",
    "password" => ""
);

try{
    $db = new PDO($config["db"], $config["username"], $config["password"]);
    $GLOBALS['dn_en'] = 1;
}
catch (PDOException $ex){
    $GLOBALS['dn_en'] = 0;
    errorHandler(E_ERROR, $ex->getMessage(), $ex->getFile(), $ex->getLine());
}

?>
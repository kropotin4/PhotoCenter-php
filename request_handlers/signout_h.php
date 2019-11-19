<?php

require_once "../models/tables/UserRepository.php";
require_once "../config.php";

$users = new UserRepository($db);

if ($_SERVER["REQUEST_METHOD"] == 'GET'){

    $users->endSess($_COOKIE["PHPSESSID"]);

    header('Location: ../');
    exit;
}
<?php

require_once "../config.php";


if ($_SERVER["REQUEST_METHOD"] == 'GET'){

    $sql = "UPDATE users_t SET
        user_sessid = 0
        WHERE user_sessid = :sessid";
    $q = $db->prepare($sql);
    $q->bindParam(":sessid", $_COOKIE["PHPSESSID"]);
    $q->execute();
    $rows = $q->fetchAll();

    header('Location: ../');
    exit;
}
<?php

require_once "../config.php";

define('USER_TYPE', 2);

if ($_SERVER["REQUEST_METHOD"] == 'POST'){
    if (isset($_REQUEST["login"]) && isset($_REQUEST["password"])){

        $sql = "SELECT * FROM users_t WHERE user_login = :login";
        $q = $db->prepare($sql);
        $q->bindParam(":login", $_REQUEST["login"]);
        $q->execute();
        $rows = $q->fetchAll();

        if (!count($rows)){
            // Никого с таким login
            $sql = "INSERT INTO users_t (user_login, user_password, user_type)
                VALUES (:login, :password, :type)";
            $q = $db->prepare($sql);
            $q->bindParam(":login", $_REQUEST["login"]);
            $q->bindParam(":password",
                password_hash($_REQUEST["password"], PASSWORD_BCRYPT, ["cost" => 9])
            );
            $q->bindParam(":type", $type=USER_TYPE, PDO::PARAM_INT);
            $q->execute();

            header('Location: ../');
        }
        else {
            trigger_error("Такой логин уже есть", E_USER_ERROR);
            require_once "../public/templates/signup.html";
        }
    }
}
else{
    require_once "../public/templates/signup.html";
}


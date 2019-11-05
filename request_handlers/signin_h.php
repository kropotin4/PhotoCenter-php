<?php

require_once "../config.php";


if ($_SERVER["REQUEST_METHOD"] == 'POST'){
    if (isset($_REQUEST["login"]) && isset($_REQUEST["password"])){
        $sql = "SELECT * FROM users_t WHERE user_login = :login";
        $q = $db->prepare($sql);
        $q->bindParam(":login", $_REQUEST["login"]);
        $q->execute();
        $rows = $q->fetchAll();

        if (count($rows)){
            if (password_verify($_REQUEST["password"], $rows[0]["user_password"])){
                $sql = "UPDATE users_t SET
                    user_sessid = :sessid
                    WHERE user_id = :id";
                $q = $db->prepare($sql);
                $q->bindParam(":sessid", $_COOKIE["PHPSESSID"]);
                $q->bindParam(":id", $rows[0]["user_id"], PDO::PARAM_INT);
                $q->execute();

                header('Location: ../');
                exit;
            }
            else{
                $_SESSION["errors"] = ["text" => "Неверный пароль", "type" => E_USER_ERROR];
                header('Location: ../');
                exit;
            }
        }
        else {
            $_SESSION["errors"] = ["text" => "Несуществующий логин", "type" => E_USER_ERROR];
            header('Location: ../');
            exit;
        }
    }
}


?>
<?php

require_once "../models/tables/UserRepository.php";
require_once "../config.php";

$users = new UserRepository($db);

if ($_SERVER["REQUEST_METHOD"] == 'POST'){
    if (isset($_REQUEST["login"]) && isset($_REQUEST["password"])){
        $user = $users->getByLogin($_REQUEST["login"]);
        if ($user->user_val){
            if (password_verify($_REQUEST["password"], $user->user_password)){
                $users->startSess($user->user_id);

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

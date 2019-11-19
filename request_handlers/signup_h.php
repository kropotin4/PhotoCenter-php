<?php

require_once "../models/tables/UserRepository.php";
require_once "../config.php";

define('USER_TYPE', 2);

$users = new UserRepository($db);

if ($_SERVER["REQUEST_METHOD"] == 'POST'){
    if (isset($_REQUEST["login"]) && isset($_REQUEST["password"])){
        $user = $users->getByLogin($_REQUEST["login"]);
        if (!$user->user_val){
            // Никого с таким login
            $users->insert(
                [   "user_login" => $_REQUEST["login"],
                    "user_type" => USER_TYPE,
                    "user_password" => $_REQUEST["password"]
                ]
            );
            $new_user = $users->getByLogin($_REQUEST["login"]);
            $users->startSess($new_user->user_id);

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


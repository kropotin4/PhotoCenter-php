<?php

require_once "models/utils.php";
require_once "config.php";
require_once "models/Notice.php";

if (isset($_SESSION["errors"])){
    trigger_error($_SESSION["errors"]["text"], $_SESSION["errors"]["type"]);
    unset($_SESSION["errors"]);
}

if (isset($_REQUEST['table'])){
    if (!filter($_REQUEST['table'], TABLE_FILT)){
        trigger_error("Ссылка не прошла фильтрацию: перенаправление на главную страницу", E_USER_ERROR);
        goto exit_gt;
    }

    if ($GLOBALS['dn_en'] == 1){
        try{
            $sql = "SELECT table_id, title FROM page_t WHERE name = :name";
            $q = $db->prepare($sql);
            $q->bindParam(":name", $_REQUEST['table']);
            $q->execute();
            $rows = $q->fetchAll();
        }
        catch(PDOException $Exception){
            trigger_error("PDOException", E_ERROR);
            goto exit_gt;
        }
        catch(Exception $ex){
            trigger_error("Exception", E_ERROR);
            goto exit_gt;
        }
    }
    else{
        errorHandler(E_ERROR, "DB not open", __FILE__, __LINE__);
        goto exit_gt;
    }

    if (!count($rows)){
        trigger_error("Неопределенная ссылка: перенаправление на главную страницу", E_USER_ERROR);
        goto exit_gt;
    }

    $data = "";
    $table_script = $rows[0]['table_id'];
    $table_name = $rows[0]['title'];
    Notice::createAndPushNote($table_script . ': ' .  $table_name);
}
else {
    exit_gt:

    $table_script = -1;
    $table_name = "";
    $mpage_data = file_get_contents("public/templates/main_page.html");
}

require_once "models/tables/UserRepository.php";
$userRep = new UserRepository($db);
$user = $userRep->getBySessId($_COOKIE["PHPSESSID"]);

if ($user->user_val){
    $sign_panel = strtr(
        file_get_contents(
            "public/templates/sign_panel2.html"
        ),
        array('{$user_login}' => $user->user_login)
    );

    require_once "models/AccessTable.php";
    Notice::createAndPushNote("Access: " . AccessTable::checkAccess($db, 0, DELETE));

}
else {
    $sign_panel = file_get_contents("public/templates/sign_panel.html");
}

require_once "public/templates/index2.html";

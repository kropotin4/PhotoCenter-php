<?php

require_once "models/utils.php";
require_once "config.php";

if (isset($_SESSION["errors"])){
    trigger_error($_SESSION["errors"]["text"], $_SESSION["errors"]["type"]);
    reset($_SESSION["errors"]);
}

if (isset($_REQUEST['table'])){
    if (!filter($_REQUEST['table'], TABLE_FILT)){
        trigger_error("Ссылка не прошла фильтрацию: перенаправление на главную страницу", E_USER_ERROR);
        goto exit_gt;
    }

    if ($GLOBALS['dn_en'] == 1){
        try{
            $sql = "SELECT table_id FROM page_t WHERE name = :name";
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
    switch ($table_script) {
        case 0:
            $table_name = "Consultants";
            break;
        case 1:
            $table_name = "Customers";
            break;
        case 2:
            $table_name = "Products";
            break;
        case 3:
            $table_name = "Product Types";
            break;
        case 4:
            $table_name = "Photo Centers";
            break;
        case 5:
            $table_name = "Service";
            break;

        default:
            trigger_error("Какая-то фигня", E_USER_ERROR);
            goto exit_gt;
    }
}
else {
    exit_gt:

    $table_script = -1;
    $table_name = "";
    $mpage_data = file_get_contents("public/templates/main_page.html");
}

require_once "public/templates/index2.html";

?>
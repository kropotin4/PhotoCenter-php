<?php

require_once "../models/tables/UserRepository.php";
require_once "../models/AccessTable.php";
require_once "../models/utils.php";

require_once "../config.php";

$users = new UserRepository($db);

switch($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $filterData["user_login"] = getData($_GET, "user_login", "");
        $filterData["user_type"] = getData($_GET, "user_type", "");

        if (filter($filterData["user_login"], LOGIN_FILT)
            && filter($filterData["user_type"], NUMBER_FILT)
            && AccessTable::checkAccess($db, USERS, READ)
        ){
            $result = $users->getAllFilter(array(
                "user_login" => $filterData["user_login"],
                "user_type" => $filterData["user_type"]
            ));
            http_response_code(intval(FILTER_OK));
        }
        else {
            trigger_error("GET: Не прошел фильтр", E_USER_ERROR);
            $result = array(
                'log_text' => "Не прошел фильтр",
                'log_type' => "warn",
                'log_time' => 10
            );
            http_response_code(intval(FILTER_BAD));
        }

        break;

    case "POST":
        $filterData["user_login"] = $_POST["user_login"];
        $filterData["user_password"] = $_POST["user_password"];
        $filterData["user_type"] = $_POST["user_type"];

        if (filter($filterData["user_login"], LOGIN_FILT)
            && filter($filterData["user_password"], LOGIN_FILT)
            && filter($filterData["user_type"], NUMBER_FILT)
            && AccessTable::checkAccess($db, USERS, INSERT)
        ){
            $result = $users->insert(array(
                "user_login" => $filterData["user_login"],
                "user_password" => $filterData["user_password"],
                "user_type" => $filterData["user_type"]
            ));
            http_response_code(intval(FILTER_OK));
        }
        else {
            trigger_error("POST: Не прошел фильтр", E_USER_ERROR);
            $result = array(
                'log_text' => "Не прошел фильтр",
                'log_type' => "warn",
                'log_time' => 10
            );
            http_response_code(intval(FILTER_BAD));
        }

        break;

    case "PUT":
        parse_str(file_get_contents("php://input"), $_PUT);

        $filterData["user_login"] = $_PUT["user_login"];
        $filterData["user_password"] = $_PUT["user_password"];
        $filterData["user_type"] = $_PUT["user_type"];
        $filterData["user_id"] = $_PUT["user_id"];

        if (filter($filterData["user_login"], LOGIN_FILT)
            && filter($filterData["user_type"], NUMBER_FILT)
            && filter($filterData["user_id"], NUMBER_FILT)
            && AccessTable::checkAccess($db, USERS, EDIT)
        ){
            $result = $users->update(array(
                "user_login" => $filterData["user_login"],
                "user_type" => $filterData["user_type"],
                "user_id" => $filterData["user_id"]
            ));
            http_response_code(intval(FILTER_OK));
        }
        else {
            trigger_error("PUT: Не прошел фильтр", E_USER_ERROR);
            $result = array(
                'log_text' => "Не прошел фильтр",
                'log_type' => "warn",
                'log_time' => 10
            );
            http_response_code(intval(FILTER_BAD));
        }

        break;

    case "DELETE":
        parse_str(file_get_contents("php://input"), $_DELETE);

        $filterData["user_id"] = $_DELETE["user_id"];

        if (filter($filterData["user_id"], NUMBER_FILT)
            && AccessTable::checkAccess($db, USERS, DELETE)){
            $result = $users->remove(intval($filterData["user_id"]));
            http_response_code(intval(FILTER_OK));
        }
        else {
            trigger_error("DELETE: Не прошел фильтр", E_USER_ERROR);
            $result = array(
                'log_text' => "Не прошел фильтр",
                'log_type' => "warn",
                'log_time' => 10
            );
            http_response_code(intval(FILTER_BAD));
        }

        break;
}

header("Content-Type: application/json");
echo json_encode($result);


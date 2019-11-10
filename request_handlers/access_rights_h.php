<?php

require_once "../models/tables/AccessRightRepository.php";
require_once "../models/utils.php";

require_once "../config.php";

$access_rights = new AccessRightRepository($db);


switch($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $right_name = getData($_GET, "right_name", "");

        if (filter($right_name, ACCESS_RIGHT_FILT)){
            $result = $access_rights->getAllFilter(array(
                "right_name" => $right_name
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
        $right_name = $_POST["right_name"];

        if (filter($right_name, ACCESS_RIGHT_FILT)){
            $result = $access_rights->insert(array(
                "right_name" => $right_name
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

        $right_id = $_PUT["right_id"];
        $right_name = $_PUT["right_name"];

        if (filter($right_name, ACCESS_RIGHT_FILT)
            && filter($right_id, NUMBER_FILT)
        ){
            $result = $access_rights->update(array(
                "right_id" => intval($right_id),
                "right_name" => $right_name
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

        $right_id = $_DELETE["right_id"];

        if (filter($right_id, NUMBER_FILT)){
            $result = $access_rights->remove(intval($right_id));
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


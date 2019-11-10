<?php

require_once "../models/tables/ConsultantRepository.php";
require_once "../models/AccessTable.php";
require_once "../models/utils.php";

require_once "../config.php";

$consultants = new ConsultantRepository($db);

switch($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $filterData["full_name"] = getData($_GET, "full_name", "");
        $filterData["passport_data"] = getData($_GET, "passport_data", "");
        $filterData["pc_id"] = getData($_GET, "pc_id", 0);

        if (filter($filterData["full_name"], FULL_NAME_FILT)
            && filter($filterData["passport_data"], PASSPORT_FILT)
            && filter($filterData["pc_id"], NUMBER_FILT)
            && AccessTable::checkAccess($db, CONSULTANTS, READ)
        ){
            $result = $consultants->getAllFilter(array(
                "full_name" => $filterData["full_name"],
                "passport_data" => $filterData["passport_data"],
                "pc_id" => $filterData["pc_id"]
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
        $filterData["full_name"] = $_POST["full_name"];
        $filterData["passport_data"] = $_POST["passport_data"];
        $filterData["phone"] = $_POST["phone"];
        $filterData["sex"] = $_POST["sex"];
        $filterData["birth_date"] = $_POST["birth_date"];
        $filterData["pc_id"] = $_POST["pc_id"];

        if (filter($filterData["full_name"], FULL_NAME_FILT)
            && filter($filterData["passport_data"], PASSPORT_FILT)
            && filter($filterData["phone"], PHONE_NUMBER_FILT)
            && filter($filterData["sex"], CHARS_ONLY_FILT)
            && filter($filterData["birth_date"], BURTH_DAY_FILT)
            && filter($filterData["pc_id"], NUMBER_FILT)
            && AccessTable::checkAccess($db, CONSULTANTS, INSERT)
        ){
            $result = $consultants->insert(array(
                "full_name" => $filterData["full_name"],
                "passport_data" => $filterData["passport_data"],
                "phone" => $filterData["phone"],
                "sex" => $filterData["sex"],
                "birth_date" => $filterData["birth_date"],
                "pc_id" => $filterData["pc_id"]
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

        $filterData["full_name"] = $_PUT["full_name"];
        $filterData["passport_data"] = $_PUT["passport_data"];
        $filterData["phone"] = $_PUT["phone"];
        $filterData["sex"] = $_PUT["sex"];
        $filterData["birth_date"] = $_PUT["birth_date"];
        $filterData["pc_id"] = $_PUT["pc_id"];

        if (filter($filterData["full_name"], FULL_NAME_FILT)
            && filter($filterData["passport_data"], PASSPORT_FILT)
            && filter($filterData["phone"], PHONE_NUMBER_FILT)
            && filter($filterData["sex"], CHARS_ONLY_FILT)
            && filter($filterData["birth_date"], BURTH_DAY_FILT)
            && filter($filterData["pc_id"], NUMBER_FILT)
            && AccessTable::checkAccess($db, CONSULTANTS, EDIT)
        ){
            $result = $consultants->update(array(
                "full_name" => $filterData["full_name"],
                "passport_data" => $filterData["passport_data"],
                "phone" => $filterData["phone"],
                "sex" => $filterData["sex"],
                "birth_date" => $filterData["birth_date"],
                "pc_id" => $filterData["pc_id"]
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

        $filterData["consultant_id"] = $_DELETE["consultant_id"];

        if (filter($filterData["consultant_id"], NUMBER_FILT)
            && AccessTable::checkAccess($db, CONSULTANTS, DELETE)){
            $result = $consultants->remove(intval($filterData["consultant_id"]));
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


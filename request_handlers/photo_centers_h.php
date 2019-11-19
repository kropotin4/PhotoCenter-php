<?php

require_once "../models/tables/PhotoCenterRepository.php";
require_once "../models/AccessTable.php";
require_once "../models/utils.php";

require_once "../config.php";

$photo_centers = new PhotoCenterRepository($db);

switch($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $filterData["address"] = getData($_GET, "address", "");
        $filterData["chains_name"] = getData($_GET, "chains_name", "");
        $filterData["office_hours"] = getData($_GET, "office_hours", "");
        $filterData["phone"] = getData($_GET, "phone", "");

        if (filter($filterData["address"], ADDRESS_FILT)
            && filter($filterData["chains_name"], ADDRESS_FILT)
            && filter($filterData["office_hours"], OFFICE_HOURS_FILT)
            && filter($filterData["phone"], PHONE_NUMBER_FILT)
            && AccessTable::checkAccess($db, PHOTO_CENTERS, READ)
        ){
            $result = $photo_centers->getAllFilter(array(
                "address" => $filterData["address"],
                "chains_name" => $filterData["chains_name"],
                "office_hours" => $filterData["office_hours"],
                "phone" => $filterData["phone"]
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
        $filterData["address"] = $_POST["address"];
        $filterData["chains_name"] = $_POST["chains_name"];
        $filterData["office_hours"] = $_POST["office_hours"];
        $filterData["phone"] = $_POST["phone"];

        if (filter($filterData["address"], ADDRESS_FILT)
            && filter($filterData["chains_name"], ADDRESS_FILT)
            && filter($filterData["office_hours"], OFFICE_HOURS_FILT)
            && filter($filterData["phone"], PHONE_NUMBER_FILT)
            && AccessTable::checkAccess($db, PHOTO_CENTERS, INSERT)
        ){
            $result = $photo_centers->insert(array(
                "address" => $filterData["address"],
                "chains_name" => $filterData["chains_name"],
                "office_hours" => $filterData["office_hours"],
                "phone" => $filterData["phone"]
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

        $filterData["address"] = $_PUT["address"];
        $filterData["chains_name"] = $_PUT["chains_name"];
        $filterData["office_hours"] = $_PUT["office_hours"];
        $filterData["phone"] = $_PUT["phone"];
        $filterData["pc_id"] = $_PUT["pc_id"];

        if (filter($filterData["address"], ADDRESS_FILT)
            && filter($filterData["chains_name"], ADDRESS_FILT)
            && filter($filterData["office_hours"], OFFICE_HOURS_FILT)
            && filter($filterData["phone"], PHONE_NUMBER_FILT)
            && filter($filterData["pc_id"], NUMBER_FILT)
            && AccessTable::checkAccess($db, PHOTO_CENTERS, EDIT)
        ){
            $result = $photo_centers->update(array(
                "address" => $filterData["address"],
                "chains_name" => $filterData["chains_name"],
                "office_hours" => $filterData["office_hours"],
                "phone" => $filterData["phone"],
                "pc_id" => intval($filterData["pc_id"])
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

        $filterData["pc_id"] = $_DELETE["pc_id"];

        if (filter($filterData["pc_id"], NUMBER_FILT)
            && AccessTable::checkAccess($db, PHOTO_CENTERS, DELETE)){
            $result = $photo_centers->remove(intval($filterData["pc_id"]));
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


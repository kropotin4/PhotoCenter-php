<?php

require_once "../models/tables/ServiceRepository.php";
require_once "../models/AccessTable.php";
require_once "../models/utils.php";

require_once "../config.php";

$services = new ServiceRepository($db);


switch($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $filterData["consultant_id"] = getData($_GET,"consultant_id", 0);
        $filterData["product_id"] = getData($_GET, "product_id", 0);
        $filterData["customer_id"] = getData($_GET, "customer_id", 0);
        $filterData["service_date"] = getData($_GET, "service_date", "");
        $filterData["service_time"] = getData($_GET, "service_time", "");

        if (filter($filterData["consultant_id"], NUMBER_FILT)
            && filter($filterData["product_id"], NUMBER_FILT)
            && filter($filterData["customer_id"], NUMBER_FILT)
            && filter($filterData["service_date"], BURTH_DAY_FILT)
            && filter($filterData["service_time"], TIME_FILT)
            && AccessTable::checkAccess($db, SERVICES, READ)
        ){
            $result = $services->getAllFilter(array(
                "consultant_id" => $filterData["consultant_id"],
                "product_id" => $filterData["product_id"],
                "customer_id" => $filterData["customer_id"],
                "service_date" => $filterData["service_date"],
                "service_time" => $filterData["service_time"]
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
        $filterData["consultant_id"] = $_POST["consultant_id"];
        $filterData["product_id"] = $_POST["product_id"];
        $filterData["customer_id"] = $_POST["customer_id"];
        $filterData["service_date"] = $_POST["service_date"];
        $filterData["service_time"] = $_POST["service_time"];

        if (filter($filterData["consultant_id"], NUMBER_FILT)
            && filter($filterData["product_id"], NUMBER_FILT)
            && filter($filterData["customer_id"], NUMBER_FILT)
            && filter($filterData["service_date"], BURTH_DAY_FILT)
            && filter($filterData["service_time"], TIME_FILT)
            && AccessTable::checkAccess($db, SERVICES, INSERT)
        ){
            $result = $services->insert(array(
                "consultant_id" => $filterData["consultant_id"],
                "product_id" => $filterData["product_id"],
                "customer_id" => $filterData["customer_id"],
                "service_date" => $filterData["service_date"],
                "service_time" => $filterData["service_time"]
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

        $filterData["consultant_id"] = $_PUT["consultant_id"];
        $filterData["product_id"] = $_PUT["product_id"];
        $filterData["customer_id"] = $_PUT["customer_id"];
        $filterData["service_date"] = $_PUT["service_date"];
        $filterData["service_time"] = $_PUT["service_time"];
        $filterData["service_id"] = $_PUT["service_id"];

        if (filter($filterData["consultant_id"], NUMBER_FILT)
            && filter($filterData["product_id"], NUMBER_FILT)
            && filter($filterData["customer_id"], NUMBER_FILT)
            && filter($filterData["service_date"], BURTH_DAY_FILT)
            && filter($filterData["service_time"], TIME_FILT)
            && filter($filterData["service_id"], NUMBER_FILT)
            && AccessTable::checkAccess($db, SERVICES, EDIT)
        ){
            $result = $services->update(array(
                "consultant_id" => $filterData["consultant_id"],
                "product_id" => $filterData["product_id"],
                "customer_id" => $filterData["customer_id"],
                "service_date" => $filterData["service_date"],
                "service_time" => $filterData["service_time"],
                "service_id" => $filterData["service_id"]
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

        $filterData["service_id"] = $_DELETE["service_id"];

        if (filter($filterData["service_id"], NUMBER_FILT)
            && AccessTable::checkAccess($db, SERVICES, DELETE)){
            $result = $services->remove(intval($filterData["service_id"]));
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

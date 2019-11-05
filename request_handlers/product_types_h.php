<?php

require_once "../models/tables/ProductTypeRepository.php";
require_once "../models/utils.php";

require_once "../config.php";

$product_types = new ProductTypeRepository($db);


switch($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $filterData["product_types_name"] = getData($_GET, "product_types_name", "");

        if (filter($filterData["product_types_name"], FULL_NAME_FILT)){
            $result = $product_types->getAll(array(
                "product_types_name" => $filterData["product_types_name"]
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
        $filterData["product_types_name"] = $_POST["product_types_name"];

        if (filter($filterData["product_types_name"], FULL_NAME_FILT)){
            $result = $product_types->insert(array(
                "product_types_name" => $filterData["product_types_name"]
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

        $filterData["product_types_id"] = $_PUT["product_types_id"];
        $filterData["product_types_name"] = $_PUT["product_types_name"];

        if (filter($filterData["product_types_name"], FULL_NAME_FILT)
            && filter($filterData["product_types_id"], NUMBER_FILT)
        ){
            $result = $product_types->update(array(
                "product_types_id" => intval($filterData["product_types_id"]),
                "product_types_name" => $filterData["product_types_name"]
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

        $filterData["product_types_id"] = $_DELETE["product_types_id"];

        if (filter($filterData["product_types_id"], NUMBER_FILT)){
            $result = $product_types->remove(intval($_DELETE["product_types_id"]));
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

?>

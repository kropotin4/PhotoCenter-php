<?php

require_once "../models/tables/ProductRepository.php";
require_once "../models/utils.php";

require_once "../config.php";

$products = new ProductRepository($db);


switch($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $filterData["product_name"] = getData($_GET, "product_name", "");
        $filterData["product_price"] = getData($_GET, "product_price", 0);
        $filterData["product_types_id"] = getData($_GET, "product_types_id", 0);

        if (filter($filterData["product_name"], CHARS_ONLY_FILT)
            && filter($filterData["product_price"], NUMBER_FILT, 1)
            && filter($filterData["product_types_id"], NUMBER_FILT, 1)
        ){
            $result = $products->getAllFilter(array(
                "product_name" => $filterData["product_name"],
                "product_price" => $filterData["product_price"],
                "product_types_id" => $filterData["product_types_id"]
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
        $filterData["product_name"] = $_POST["product_name"];
        $filterData["product_price"] = $_POST["product_price"];
        $filterData["product_types_id"] = $_POST["product_types_id"];

        if (filter($filterData["product_name"], CHARS_ONLY_FILT)
            && filter($filterData["product_price"], NUMBER_FILT, 1)
            && filter($filterData["product_types_id"], NUMBER_FILT, 1)
        ) {
            $result = $products->insert(array(
                "product_name" => $filterData["product_name"],
                "product_price" => $filterData["product_price"],
                "product_types_id" => $filterData["product_types_id"]
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

        $filterData["product_name"] = $_PUT["product_name"];
        $filterData["product_price"] = $_PUT["product_price"];
        $filterData["product_types_id"] = $_PUT["product_types_id"];
        $filterData["product_id"] = $_PUT["product_id"];

        if (filter($filterData["product_name"], CHARS_ONLY_FILT)
            && filter($filterData["product_price"], NUMBER_FILT, 1)
            && filter($filterData["product_types_id"], NUMBER_FILT, 1)
            && filter($filterData["product_id"], NUMBER_FILT, 1)
        ) {
            $result = $products->update(array(
                "product_name" => $filterData["product_name"],
                "product_price" => $filterData["product_price"],
                "product_types_id" => $filterData["product_types_id"],
                "product_id" => $filterData["product_id"]
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

        $filterData["product_id"] = $_DELETE["product_id"];

        if (filter($filterData["product_id"], NUMBER_FILT)) {
            $result = $products->remove(intval($filterData["product_id"]));
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

<?php

require_once "../models/tables/CustomerRepository.php";
require_once "../models/utils.php";

require_once "../config.php";


$customers = new CustomerRepository($db);

if ($GLOBALS['dn_en'] == 1)
switch($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $filterData["full_name"] = getData($_GET, "full_name", "");
        $filterData["age"] = getData($_GET, "age", "");

        if (filter($filterData["full_name"], FULL_NAME_FILT)
            && filter($filterData["age"], NUMBER_FILT)
        ){
            $result = $customers->getAll(array(
                "full_name" => $filterData["full_name"],
                "age" => $filterData["age"]
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
        $filterData["age"] = $_POST["age"];

        if (filter($filterData["full_name"], FULL_NAME_FILT)
            && filter($filterData["age"], NUMBER_FILT)
        ){
            $result = $customers->insert(array(
                "full_name" => $filterData["full_name"],
                "age" => intval($filterData["age"])
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

        $filterData["customer_id"] = $_PUT["customer_id"];
        $filterData["full_name"] = $_PUT["full_name"];
        $filterData["age"] = $_PUT["age"];

        if (filter($filterData["full_name"], FULL_NAME_FILT)
            && filter($filterData["age"], NUMBER_FILT)
            && filter($filterData["customer_id"], NUMBER_FILT)
        ){
            $result = $customers->update(array(
                "customer_id" => intval($filterData["customer_id"]),
                "full_name" => $filterData["full_name"],
                "age" => intval($filterData["age"])
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

        $filterData["customer_id"] = $_DELETE["customer_id"];

        if (filter($filterData["customer_id"], NUMBER_FILT)){
            $result = $customers->remove(intval($filterData["customer_id"]));
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

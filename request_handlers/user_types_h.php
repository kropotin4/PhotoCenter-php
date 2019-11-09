<?php

require_once "../models/tables/UserTypeRepository.php";
require_once "../models/utils.php";

require_once "../config.php";

$user_types = new UserTypeRepository($db);

switch($_SERVER["REQUEST_METHOD"]) {
    case "GET":
        $consultants_t = getData($_GET, "consultants_t", "");
        $customers_t = getData($_GET, "customers_t", "");
        $photo_centers_t = getData($_GET, "photo_centers_t", "");
        $products_t = getData($_GET, "products_t", "");
        $product_types_t = getData($_GET, "product_types_t", "");
        $service_t = getData($_GET, "service_t", "");
        $users_t = getData($_GET, "users_t", "");
        $user_types_t = getData($_GET, "user_types_t", "");

        if (filter($consultants_t, NUMBER_FILT)
            && filter($customers_t, NUMBER_FILT)
            && filter($photo_centers_t, NUMBER_FILT)
            && filter($products_t, NUMBER_FILT)
            && filter($product_types_t, NUMBER_FILT)
            && filter($service_t, NUMBER_FILT)
            && filter($users_t, NUMBER_FILT)
            && filter($user_types_t, NUMBER_FILT)
        ){
            $result = $user_types->getAllFilter(array(
                "consultants_t" => $consultants_t,
                "customers_t" => $customers_t,
                "photo_centers_t" => $photo_centers_t,
                "products_t" => $products_t,
                "product_types_t" => $product_types_t,
                "service_t" => $service_t,
                "users_t" => $users_t,
                "user_types_t" => $user_types_t
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

        $consultants_t = $_POST["consultants_t"];
        $customers_t = $_POST["customers_t"];
        $photo_centers_t = $_POST["photo_centers_t"];
        $products_t = $_POST["products_t"];
        $product_types_t = $_POST["product_types_t"];
        $service_t = $_POST["service_t"];
        $users_t = $_POST["users_t"];
        $user_types_t = $_POST["user_types_t"];

        if (filter($consultants_t, NUMBER_FILT)
            && filter($customers_t, NUMBER_FILT)
            && filter($photo_centers_t, NUMBER_FILT)
            && filter($products_t, NUMBER_FILT)
            && filter($product_types_t, NUMBER_FILT)
            && filter($service_t, NUMBER_FILT)
            && filter($users_t, NUMBER_FILT)
            && filter($user_types_t, NUMBER_FILT)
        ){
            $result = $user_types->insert(array(
                "consultants_t" => $consultants_t,
                "customers_t" => $customers_t,
                "photo_centers_t" => $photo_centers_t,
                "products_t" => $products_t,
                "product_types_t" => $product_types_t,
                "service_t" => $service_t,
                "users_t" => $users_t,
                "user_types_t" => $user_types_t,
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

        $user_type_id = $_PUT["user_type_id"];
        $consultants_t = $_PUT["consultants_t"];
        $customers_t = $_PUT["customers_t"];
        $photo_centers_t = $_PUT["photo_centers_t"];
        $products_t = $_PUT["products_t"];
        $product_types_t = $_PUT["product_types_t"];
        $service_t = $_PUT["service_t"];
        $users_t = $_PUT["users_t"];
        $user_types_t = $_PUT["user_types_t"];

        if (filter($consultants_t, NUMBER_FILT)
            && filter($user_type_id, NUMBER_FILT)
            && filter($customers_t, NUMBER_FILT)
            && filter($photo_centers_t, NUMBER_FILT)
            && filter($products_t, NUMBER_FILT)
            && filter($product_types_t, NUMBER_FILT)
            && filter($service_t, NUMBER_FILT)
            && filter($users_t, NUMBER_FILT)
            && filter($user_types_t, NUMBER_FILT)
        ){
            $result = $user_types->update(array(
                "user_type_id" => $user_type_id,
                "consultants_t" => $consultants_t,
                "customers_t" => $customers_t,
                "photo_centers_t" => $photo_centers_t,
                "products_t" => $products_t,
                "product_types_t" => $product_types_t,
                "service_t" => $service_t,
                "users_t" => $users_t,
                "user_types_t" => $user_types_t,
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

        $user_type_id = $_DELETE["user_type_id"];

        if (filter($user_type_id, NUMBER_FILT)){
            $result = $user_types->remove(intval($user_type_id));
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


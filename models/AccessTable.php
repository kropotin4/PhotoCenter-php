<?php

require_once "tables/UserRepository.php";
require_once "tables/UserTypeRepository.php";

define('CONSULTANTS', 0);
define('CUSTOMERS', 1);
define('PRODUCTS', 2);
define('PHOTO_CENTERS', 3);
define('PRODUCT_TYPES', 4);
define('SERVICES', 5);
define('USERS', 6);
define('USER_TYPES', 7);
define('ACCESS_RIGHTS', 8);

define('READ', 0);
define('EDIT', 1);
define('DELETE', 2);
define('INSERT', 3);

class AccessTable
{
    public static function checkAccess($db, $table_id, $access_type){
        $userRep = new UserRepository($db);
        $user = $userRep->getBySessId($_COOKIE["PHPSESSID"]);
        if ($user->user_val){
            $user_type = new UserTypeRepository($db);
            $access_rights = $user_type->getById($user->user_type);
 
            switch ($table_id){
                case CONSULTANTS:
                    return AccessTable::parseAccess($access_type, $access_rights->consultants_t);
                case CUSTOMERS:
                    return AccessTable::parseAccess($access_type, $access_rights->customers_t);
                case PRODUCTS:
                    return AccessTable::parseAccess($access_type, $access_rights->products_t);
                case PHOTO_CENTERS:
                    return AccessTable::parseAccess($access_type, $access_rights->photo_centers_t);
                case PRODUCT_TYPES:
                    return AccessTable::parseAccess($access_type, $access_rights->product_types_t);
                case SERVICES:
                    return AccessTable::parseAccess($access_type, $access_rights->service_t);
                case USERS:
                    return AccessTable::parseAccess($access_type, $access_rights->users_t);
                case USER_TYPES:
                    return AccessTable::parseAccess($access_type, $access_rights->user_types_t);
                case ACCESS_RIGHTS:
                    return 1;
                default:
                    trigger_error("Неизвестный table_id", E_ERROR);
                    break;
            }
        }
        return 0;
    }

    private static function parseAccess($access_type, $id){
        if ($id == 9) return 1;
        switch ($access_type){
            case READ:
                return $id > 1;
            case EDIT:
                return $id == 3 || $id == 6 || $id == 7;
            case DELETE:
                return $id == 4 || $id == 7 || $id == 8;
                break;
            case INSERT:
                return $id == 5 || $id == 6 || $id == 8;
                break;
        }
        return 0;
    }
}
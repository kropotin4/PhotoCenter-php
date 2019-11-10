<?php

function getData($arr, $var, $defualt){
    if (isset($arr[$var]))
        return $arr[$var];
    else
        return $defualt;
}

define('FILTER_OK', 200);
define('FILTER_BAD', 406);

define('FULL_NAME_FILT', 0);
define('PHONE_NUMBER_FILT', 1);
define('NUMBER_FILT', 2);
define('PASSPORT_FILT', 3);
define('CHARS_ONLY_FILT', 4);
define('BURTH_DAY_FILT', 5);
define('ADDRESS_FILT', 6);
define('OFFICE_HOURS_FILT', 7);
define('TIME_FILT', 8);
define('TABLE_FILT', 9);
define('LOGIN_FILT', 10);
define('PASSWORD_FILT', 11);
define('ACCESS_RIGHT_FILT', 12);

function filter($filt_data, $flag){
    switch ($flag) {
        case FULL_NAME_FILT:
            return preg_match("/^[а-я ]*$/ui", $filt_data);
        case PHONE_NUMBER_FILT:
            return preg_match("/^[\-+()0-9]{0,10}$/", $filt_data);
        case NUMBER_FILT:
            return preg_match("/^[0-9]*$/", $filt_data);
        case PASSPORT_FILT:
            //preg_match("/^[0-9]{4}-[0-9]{6}$/", $filt_data)
            return preg_match("/^[0-9\-]{0,11}$/", $filt_data);
        case CHARS_ONLY_FILT:
            return preg_match("/^[а-я]*$/ui", $filt_data);
        case BURTH_DAY_FILT:
            //preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $filt_data)
            return preg_match("/^[0-9\-]{0,10}$/", $filt_data);
        case ADDRESS_FILT:
            return preg_match("/^[а-я .,0-9\-]{0,10}$/ui", $filt_data);
        case OFFICE_HOURS_FILT:
            return preg_match("/^[0-9\-]{0,5}$/ui", $filt_data);
        case TIME_FILT:
            return preg_match("/^[0-9:]{0,8}$/ui", $filt_data);
        case TABLE_FILT:
            return preg_match("/^[a-z_]{1,20}$/u", $filt_data);
        case LOGIN_FILT:
            return preg_match("/^[a-zа-я0-9]{0,30}$/u", $filt_data);
        case PASSWORD_FILT:
            return preg_match("/^[а-я0-9]{0,32}$/ui", $filt_data);
        case ACCESS_RIGHT_FILT:
            return preg_match("/^[a-z+]{0,30}$/ui", $filt_data);
        default:
            return 0;
            break;
    }
}

function file_get_contents_php($path){
    ob_start();
    require_once $path;
    $data = ob_get_contents();//file_get_contents("public/templates/sign_panel.html");
    ob_end_clean();
    return $data;
}

?>
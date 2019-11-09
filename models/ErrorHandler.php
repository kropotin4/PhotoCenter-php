<?php

if (DEBUG) {
    $errorsActive = [
        E_ERROR => TRUE,
        E_WARNING => TRUE,
        E_PARSE => TRUE,
        E_NOTICE => TRUE,
        E_CORE_ERROR => FALSE,
        E_CORE_WARNING => FALSE,
        E_COMPILE_ERROR => FALSE,
        E_COMPILE_WARNING => FALSE,
        E_USER_ERROR => TRUE,
        E_USER_WARNING => TRUE,
        E_USER_NOTICE => TRUE,
        E_STRICT => FALSE,
        E_RECOVERABLE_ERROR => TRUE,
        E_DEPRECATED => FALSE,
        E_USER_DEPRECATED => TRUE,
        E_ALL => FALSE,
    ];
}
else {
    $errorsActive = [
        E_ERROR => FALSE,
        E_WARNING => FALSE,
        E_PARSE => FALSE,
        E_NOTICE => TRUE,
        E_CORE_ERROR => FALSE,
        E_CORE_WARNING => FALSE,
        E_COMPILE_ERROR => FALSE,
        E_COMPILE_WARNING => FALSE,
        E_USER_ERROR => TRUE,
        E_USER_WARNING => TRUE,
        E_USER_NOTICE => TRUE,
        E_STRICT => FALSE,
        E_RECOVERABLE_ERROR => TRUE,
        E_DEPRECATED => FALSE,
        E_USER_DEPRECATED => TRUE,
        E_ALL => FALSE,
    ];
}

error_reporting(
    array_sum(
        array_keys($errorsActive, $search = true)
    )
);

//////////////////////////////////////

function getUserIP(){
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = @$_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
    elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
    else $ip = $remote;

    return $ip;
}

function writeLog($textLog) {
    $file = 'C:/Programs/xampp/htdocs/DoISS/web/logs/log.txt';

    $text = date("[Y-m-d H:i:s]{" . getUserIP() . "}: ");
    $text .= $textLog . PHP_EOL;

    $fOpen = fopen($file,'a');
    fwrite($fOpen, $text);
    fclose($fOpen);
}

////////////////////////////////

require_once "Notice.php";

function errorHandler(
    $errno,     // Уровень ошибки
    $errstr,    // Сообщение об ошибке в виде строки
    $errfile = "",   // Имя файла, в котором произошла ошибка, в виде строки (необезательно)
    $errline =  -1    // Номер строки, в которой произошла ошибка, в виде целого числа (необезательно)
){

    if (!(error_reporting() & $errno)) {
        // Этот код ошибки не включен в error_reporting,
        // так что пусть обрабатываются стандартным обработчиком ошибок PHP
        return false;
    }

    $note = new Notice();

    $logText = "";
    if ($errfile != "")
        $logText .= ' | file: ' . $errfile;
    if ($errline != -1)
        $logText .= ' | line: ' . $errline;

    $note->setEnable(1);
    $note->setText($errstr);
    $note->setType("warn");

    $errname = "";
    switch ($errno) {
        case E_ERROR: // 1 //
            $errname = 'E_ERROR';
            break;
        case E_WARNING: // 2 //
            $errname = 'E_WARNING';
            break;
        case E_PARSE: // 4 //
            $errname =  'E_PARSE';
            break;
        case E_NOTICE: // 8 //
            $errname =  'E_NOTICE';
            break;
        case E_CORE_ERROR: // 16 //
            $errname =  'E_CORE_ERROR';
            break;
        case E_CORE_WARNING: // 32 //
            $errname =  'E_CORE_WARNING';
            break;
        case E_COMPILE_ERROR: // 64 //
            $errname =  'E_COMPILE_ERROR';
            break;
        case E_COMPILE_WARNING: // 128 //
            $errname =  'E_COMPILE_WARNING';
            break;
        case E_USER_ERROR: // 256 //
            $errname =  'E_USER_ERROR';
            break;
        case E_USER_WARNING: // 512 //
            $errname =  'E_USER_WARNING';
            break;
        case E_USER_NOTICE: // 1024 //
            $errname =  'E_USER_NOTICE';
            break;
        case E_STRICT: // 2048 //
            $errname =  'E_STRICT';
            break;
        case E_RECOVERABLE_ERROR: // 4096 //
            $errname =  'E_RECOVERABLE_ERROR';
            break;
        case E_DEPRECATED: // 8192 //
            $errname =  'E_DEPRECATED';
            break;
        case E_USER_DEPRECATED: // 16384 //
            $errname =  'E_USER_DEPRECATED';
        default:

            break;
    }

    writeLog($errname . ' | ' . $errstr . $logText);

    $note->pushNote();
    /* Не запускаем внутренний обработчик ошибок PHP */
    return true;
}

$old_error_handler = set_error_handler("errorHandler");

?>
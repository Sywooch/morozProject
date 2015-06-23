<?php
date_default_timezone_set('Asia/Novosibirsk');
/*ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('xdebug.var_display_max_data', 5000);
ini_set('xdebug.var_display_max_children', 5000);
ini_set('xdebug.var_display_max_depth', 10);*/
require_once 'email.php';

function mylog($txt, $exception = false) {
    $file_log = $_SERVER['DOCUMENT_ROOT'] . '/import/log.txt';
    $msg = "$txt  ---" . date('d.m.Y, H:i') . "\n";
    if ($exception) {
        myprint($exception->getMessage() . ' (line: ' . $exception->getLine() . ')', 'err');
        $msg .= '-----msg: ' . $exception->getMessage() . "\n";
        $msg .= '-----file: ' . $exception->getFile() . ',line:' . $exception->getLine() . "\n";
    }
    file_put_contents($file_log, $msg, FILE_APPEND);
}

function myprint($str, $class) {
    echo "<p class='{$class}'>{$str}</p>";
}

?>
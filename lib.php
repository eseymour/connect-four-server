<?php
namespace EdwardSeymour\ConnectFour\Lib;

define('DATA_DIR', __DIR__.'/Writable/');

$width = 7;
$height = 6;
$strategies = [];

function response($status, $array)
{
    $response = array_merge(['response' => $status], $array);
    echo json_encode($response);
}

function responseError($message)
{
    response(false, ['reason' => $message]);
}

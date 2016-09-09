<?php
$width = 7;
$height = 6;
$strategies = array();

function response($status, $array)
{
    $response = array_merge(array('response' => $status), $array);
    echo json_encode($response);
}

function responseError($message)
{
    response(false, array('reason' => $message));
    exit;
}

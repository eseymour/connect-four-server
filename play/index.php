<?php
$width = 7;

$pid = $_GET['pid']
$move = $_GET['move']

if(is_null($pid)) {
    responseError('PID not specified');
}
if(is_null($move)) {
    responseError('Move not specified');
}
if(!is_numeric($move)) {
    responseError('Non-numeric move');
}
// No games are created yet, so all PIDs are unknown
responseError('Unknown PID');
if($move < 0 || $move >= $width) {
    responseError("Invalid move $move");
}

function responseError($message) {
    $response = array('response' => false, 'reason' => $message);
    echo json_encode($response);
    exit;
}

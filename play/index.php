<?php
$width = 7

if(is_null($_GET['pid'])) {
    $response = array('response' => false, 'reason' => "PID not specified");
    echo json_encode($response);
    exit;
}
$pid = $_GET['pid']

if(is_null($_GET['move'])) {
    $response = array('response' => false, 'reason' => "Move not specified");
    echo json_encode($response);
    exit;
}
$move = $_GET['move']

if($move < 0 || $move >= $width) {
    $response = array('response' => false, 'reason' => "Invalid slot, " . $move);
    echo json_encode($response);
    exit;
}

$response = array('response' => false, 'reason' => "Unknown PID");
echo json_encode($response);

<?php
$width = 7

if($_GET['pid'] === null) {
    $response = array('response' => false, 'reason' => "PID not specified");
    echo json_encode($response);
    exit;
}
$pid = $_GET['pid']

if($_GET['move'] === null) {
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

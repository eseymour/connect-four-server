<?php
$strategies = array();

if ($_GET['strategy'] === null) {
    // No strategy specified
    $response = array('response' => false, 'reason' => "Strategy not specified");
    echo json_encode($response);
    exit;
}

$strategy = $_GET[strategy];
if ($strategies[$strategy] === null) {
    // Strategy not in array of defined strategies
    $response = array('response' => false, 'reason' => "Unknown strategy");
    echo json_encode($response);
    exit;
}

// TODO: Implement game creation
$response = array('response' => false, 'reason' => 'Not implemented yet!');
echo json_encode($response);

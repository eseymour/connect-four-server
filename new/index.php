<?php
$strategies = array();

if (is_null($_GET['strategy'])) {
    // No strategy specified
    $response = array('response' => false, 'reason' => "Strategy not specified");
    echo json_encode($response);
    exit;
}

$strategy = $_GET[strategy];
if (is_null($strategies[$strategy])) {
    // Strategy not in array of defined strategies
    $response = array('response' => false, 'reason' => "Unknown strategy");
    echo json_encode($response);
    exit;
}

// TODO: Implement game creation
$response = array('response' => false, 'reason' => 'Not implemented yet!');
echo json_encode($response);

<?php
$strategies = array();
$strategy = $_GET['strategy']

if (is_null($strategy) {
    responseError('Strategy not specified')
}
if (is_null($strategies[$strategy])) {
    responseError('Unknown Strategy')
}

// TODO: Implement game creation
responseError('Not implemented yet!')

function responseError($message) {
    $response = array('response' => false, 'reason' => $message);
    echo json_encode($response);
    exit;
}

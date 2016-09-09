<?php
define('__ROOT__', dirname(__DIR__).'/');
require(__ROOT__.'lib.php');

$strategy = $_GET['strategy'];

if (is_null($strategy)) {
    responseError('Strategy not specified');
}
if (is_null($strategies[$strategy])) {
    responseError('Unknown Strategy');
}

// TODO: Implement game creation
responseError('Not implemented yet!');

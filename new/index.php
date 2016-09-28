<?php
namespace EdwardSeymour\ConnectFour;
define('__ROOT__', dirname(__DIR__).'/');
require_once(__ROOT__.'lib.php');

$strategy = $_GET['strategy'];

if (is_null($strategy)) {
    Lib\responseError('Strategy not specified');
}
if (is_null($strategies[$strategy])) {
    Lib\responseError('Unknown Strategy');
}

// TODO: Implement game creation
Lib\responseError('Not implemented yet!');

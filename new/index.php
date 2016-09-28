<?php
namespace EdwardSeymour\ConnectFour;

define('ROOT', dirname(__DIR__).'/');
require_once(ROOT.'lib.php');

$strategy = $_GET['strategy'];

if (is_null($strategy)) {
    Lib\responseError('Strategy not specified');
    exit;
}
if (is_null($strategies[$strategy])) {
    Lib\responseError('Unknown Strategy');
    exit;
}

// TODO: Implement game creation
Lib\responseError('Not implemented yet!');

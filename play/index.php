<?php
namespace EdwardSeymour\ConnectFour;

define('ROOT', dirname(__DIR__).'/');
require_once(ROOT.'lib.php');

$pid = $_GET['pid'];
$move = $_GET['move'];

if (is_null($pid)) {
    Lib\responseError('PID not specified');
    exit;
}
if (is_null($move)) {
    Lib\responseError('Move not specified');
    exit;
}
if (!is_numeric($move)) {
    Lib\responseError('Non-numeric move');
    exit;
}
if(!file_exists(DATA_DIR.$pid)) {
    Lib\responseError('Unknown PID');
    exit;
}
if ($move < 0 || $move >= $width) {
    Lib\responseError("Invalid move");
    exit;
}

// TODO: Implement game creation
Lib\responseError('Not implemented yet!');

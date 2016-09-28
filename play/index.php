<?php
namespace EdwardSeymour\ConnectFour;
define('__ROOT__', dirname(__DIR__).'/');
require_once(__ROOT__.'lib.php');

$pid = $_GET['pid'];
$move = $_GET['move'];

if (is_null($pid)) {
    Lib\responseError('PID not specified');
}
if (is_null($move)) {
    Lib\responseError('Move not specified');
}
if (!is_numeric($move)) {
    Lib\responseError('Non-numeric move');
}
// No games are created yet, so all PIDs are unknown
responseError('Unknown PID');
if ($move < 0 || $move >= $width) {
    Lib\responseError("Invalid move $move");
}

<?php
namespace ConnectFour;

define('ROOT', dirname(__DIR__).'/');
require_once(ROOT.'lib.php');
require_once(ROOT.'model/game.php');

$strategy = $_GET['strategy'];

if (is_null($strategy)) {
    Lib\responseError('Strategy not specified');
    exit;
}
if (!in_array($strategy, STRATEGIES, true)) {
    echo $strategy;
    Lib\responseError('Unknown Strategy');
    exit;
}

$pid = Lib\generatePID();
$game = new Model\Game();
$contents = json_encode(['strategy' => $strategy, 'game' => $game]);

file_put_contents(DATA_DIR.$pid, $contents);
Lib\responseSuccess(['pid' => $pid]);

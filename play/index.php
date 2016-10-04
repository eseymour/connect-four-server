<?php
namespace ConnectFour;

if(!defined('ROOT')) define('ROOT', dirname(__DIR__).'/');
require_once(ROOT.'lib.php');
require_once(ROOT.'model/game.php');

$pid = $_GET['pid'];
$move = $_GET['move'];
$gameDir = DATA_DIR.$pid;

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
$move = (int) $move;
if(!file_exists($gameDir)) {
  Lib\responseError('Unknown PID');
  exit;
}

$data = json_decode(file_get_contents($gameDir), true);
$strategy = $data['strategy'];
assert(in_array($strategy, STRATEGIES), "Game data contains unknown strategy.");
$game = new Model\Game($data['game']);

$availableMoves = $game->availableMoves();
if(!in_array($move, $availableMoves)) {
  Lib\responseError("Invalid move, $move");
}

$game->doMove($move, 0);

$ackMove = ['slot'=> $move, 'isWin'=> $game->isWin(), 'isDraw'=> $game->isDraw(), 'row'=> $game->getRow()];
if($game->isGameOver()) {
  Lib\responseSuccess(['ack_move'=> $ackMove]);
  unlink($gameDir);
  exit;
}

$availableMoves = $game->availableMoves();
assert(!empty($availableMoves), "Game is not over, but there are no available moves.");

$computerMove = $availableMoves[rand(0, count($availableMoves)-1)];
$game->doMove($computerMove, 1);

$responseMove = ['slot'=> $computerMove, 'isWin'=> $game->isWin(), 'isDraw'=> $game->isDraw(), 'row'=> $game->getRow()];
if($game->isGameOver()) {
  Lib\responseSuccess(['ack_move'=> $ackMove, 'move'=> $responseMove]);
  unlink($gameDir);
  exit;
}

$contents = json_encode(['strategy'=> $strategy, 'game'=> $game]);
file_put_contents($gameDir, $contents);
Lib\responseSuccess(['ack_move'=> $ackMove, 'move'=> $responseMove]);

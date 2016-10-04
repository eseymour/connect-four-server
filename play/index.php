<?php
namespace ConnectFour;

define('ROOT', dirname(__DIR__).'/');
require_once(ROOT.'lib.php');
require_once(ROOT.'model/game.php');

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
$move = (int) $move;
if(!file_exists(DATA_DIR.$pid)) {
  Lib\responseError('Unknown PID');
  exit;
}

$data = json_decode(file_get_contents(DATA_DIR.$pid), true);
$strategy = $data['strategy'];
assert(in_array($strategy, STRATEGIES), "Game data contains unknown strategy.");
$game = new Model\Game($data['game']);

$availableMoves = $game->availableMoves();
if(!in_array($move, $availableMoves)) {
  Lib\responseError("Invalid move, $move");
}

$game->doMove($move, 0);

if($game->isGameOver()) {
  $winningMove = $game->didLastMoveWin();
  if($winningMove) {
    Lib\response(true, ['ack_move'=> ['slot'=> $move, 'isWin'=> true, 'isDraw'=> false, 'row'=>$winningMove]]);
  } elseif($game->isDraw()) {
    Lib\response(true, ['ack_move'=> ['slot'=> $move, 'isWin'=> false, 'isDraw'=> true, 'row'=> []]]);
  } else {
    Lib\assert(false, "Game without a draw is over but nobody won.");
  }
  unlink(DATA_DIR.$pid);
  exit;
}

$availableMoves = $game->availableMoves();
assert(!empty($availableMoves), "Game is not over, but there are no available moves.");

$computerMove = $availableMoves[rand(0, count($availableMoves)-1)];
$game->doMove($computerMove, 1);

if($game->isGameOver()) {
  $winningMove = $game->didLastMoveWin();
  if($winningMove) {
    Lib\response(true, ['ack_move'=> ['slot'=> $move, 'isWin'=> false, 'isDraw'=> false, 'row'=> []],
                    'move'=> ['slot'=> $computerMove, 'isWin'=> true, 'isDraw'=> false, 'row'=> $winningMove]]);
  } elseif($game->isDraw()) {
    Lib\response(true, ['ack_move'=> ['slot'=> $move, 'isWin'=> false, 'isDraw'=> false, 'row'=> []],
                    'move'=> ['slot'=> $computerMove, 'isWin'=> false, 'isDraw'=> true, 'row'=> []]]);
  } else {
    assert(false, "Game without a draw is over but nobody won.");
  }
  unlink(DATA_DIR.$pid);
  exit;
}

$contents = json_encode(['strategy'=> $strategy, 'game'=> $game]);
file_put_contents(DATA_DIR.$pid, $contents);
Lib\response(true, ['ack_move'=> ['slot'=> $move, 'isWin'=> false, 'isDraw'=> false, 'row'=> []],
                'move'=> ['slot'=> $computerMove, 'isWin'=> false, 'isDraw'=> false, 'row'=> []]]);

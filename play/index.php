<?php
namespace ConnectFour;

if (!defined('ROOT')) define('ROOT', dirname(__DIR__).'/');
require_once ROOT.'lib.php';
require_once ROOT.'model/game.php';

$pid = $_GET['pid'];
$move = $_GET['move'];
$gamePath = DATA_DIR.$pid;

if (is_null($pid)) {
    responseError('PID not specified');
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
if(!file_exists($gamePath)) {
    Lib\responseError('Unknown PID');
    exit;
}

$data = json_decode(file_get_contents($gamePath), true);
$strategyName = $data['strategy'];
switch ($strategyName) {
    case 'Random':
        require_once(ROOT.'strategy/random.php');
        $strategy = new Strategy\Random();
        break;
    case 'Smart':
        require_once(ROOT.'strategy/smart.php');
        $strategy = new Strategy\Smart();
        break;
    default:
        assert(!in_array($strategyName, STRATEGIES),
            'Strategy defined but not implemented');
        Lib\responseError('Game data corrupt');
        exit;
}
$game = new Model\Game($data['game']);

$availableMoves = $game->availableMoves();
if (!in_array($move, $availableMoves)) {
    Lib\responseError("Invalid move, $move");
}

$playerMove = (int) $move;
$game->doMove($playerMove, 0);

$ackMove = [
    'slot'=> $playerMove,
    'isWin'=> $game->isWin(),
    'isDraw'=> $game->isDraw(),
    'row'=> $game->getRow(),
];

if ($game->isGameOver()) {
    unlink($gamePath);
    Lib\responseSuccess(['ack_move'=> $ackMove]);
    exit;
}

$strategyMove = $strategy->nextMove(clone $game);
$game->doMove($strategyMove, 1);

if ($game->isGameOver()) {
    unlink($gamePath);
} else {
    $contents = json_encode(['strategy'=> $strategyName, 'game'=> $game]);
    file_put_contents($gamePath, $contents);
}

$responseMove = [
    'slot'=> $strategyMove,
    'isWin'=> $game->isWin(),
    'isDraw'=> $game->isDraw(),
    'row'=> $game->getRow(),
];
Lib\responseSuccess(['ack_move'=> $ackMove, 'move'=> $responseMove]);

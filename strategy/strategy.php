<?php
namespace ConnectFour\Strategy;

if(!defined('ROOT')) define('ROOT', dirname(__DIR__) . '/');
require_once(ROOT.'lib.php');
require_once(ROOT.'model/game.php');

class Strategy {
  function nextMove($game) {
    assert(!$game->isGameOver(), "No next move for finished game");
    
    $moves = $game->availableMoves();
    assert(!empty($moves), "Game is not over, but there are no available moves");

    shuffle($moves);
    return $moves[0];
  }
}
<?php
namespace ConnectFour\Strategy;

if(!defined('ROOT')) define('ROOT', dirname(__DIR__) . '/');
require_once(ROOT.'lib.php');
require_once(ROOT.'model/game.php');
require_once(ROOT.'strategy/strategy.php');

class Smart extends Strategy {
/*  function nextMove($game) {
    assert(!$game->isGameOver(), "No next move for finished game");

    $bestScore = -1;
    $bestMoves = [];

    $strategyMoves = $game->availableMoves();
    assert(!empty($strategyMoves), "Game is not over, but there are no available moves");
    foreach($strategyMoves as $strategyMove) {
      $game->doMove($strategyMove, 1);

      if($game->isGameOver()) {
        if($bestScore == 1) {
          $bestMoves[] = $strategyMove;
        } else {
          $bestScore = 1;
          $bestMoves = [$strategyMove];
        }
      } else {
        $playerScore = -1;
        
        $playerMoves = $game->availableMoves();
        assert(!empty($playerMoves), "Game is not over, but there are no available moves");
        foreach($playerMoves as $playerMove) {
          $game->doMove($playerMove, 0);

            if(!$game->isGameOver()) {
              $playerScore = 0;
              $game->undoLastMove();
              break;
            }

          $game->undoLastMove();
        }

        if($bestScore == $playerScore) {
          $bestMoves[] = $strategyMove;
        } elseif($bestScore < $playerScore) {
          $bestScore = $playerScore;
          $bestMoves = [$strategyMove];
        }
      }

      $game->undoLastMove();
    }

    shuffle($bestMoves);
    return $bestMoves[0];
  }*/


  function nextMove($game) {
    assert(!$game->isGameOver(), "No next move for finished game");

    $bestScore = -1;
    $bestMoves = [];

    $strategyMoves = $game->availableMoves();
    assert(!empty($strategyMoves), "Game is not over, but there are no available moves");
    foreach($strategyMoves as $strategyMove) {
      $subgame = clone $game;
      $subgame->doMove($strategyMove, 1);

      if($subgame->isGameOver()) {
        $score = 1;
      } else {
        $score = 0;
        
        $playerMoves = $subgame->availableMoves();
        assert(!empty($playerMoves), "Game is not over, but there are no available moves");
        foreach($playerMoves as $playerMove) {
          $subsubgame = clone $subgame;
          $subsubgame->doMove($playerMove, 0);

            if($subsubgame->isGameOver()) {
              $score -= 1;
            }
        }
      }

      if($bestScore == $score) {
        $bestMoves[] = $strategyMove;
      } elseif ($bestScore < $score) {
        $bestScore = $score;
        $bestMoves = [$strategyMove];
        
      }
    }

    shuffle($bestMoves);
    return $bestMoves[0];
  }
}
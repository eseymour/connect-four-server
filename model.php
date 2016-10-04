<?php
namespace ConnectFour\Model;

define('ROOT', __DIR__ . '/');
require_once(ROOT.'lib.php');

class GameBoard {
  private $columns;
  private $columnHeights;
  private $turn;

  public function __construct() {
    $columns = array_fill(0, $width, 0);
    $columnHeights = array_fill(0, $width, 0);
    $turn = 0;
  }

  public function availableMoves() {
    $moves = [];

    for($i = 0; $i < $width; $i++) {
      if($columnHeights[$i] < $height) {
        $moves[] = $i;
      }
    }

    return $moves;
  }

  public function playMove($move, $player) {
    assert(!$isGameOver(), "Game is already over");
    assert($player == 1 + $turn % 2, "Unexpected player, $player.");
    assert($columnHeights[$move] == $height, "Column $move is full.");

    $columns[$move] = (player % 2) << $columnHeights[$move];
    $columnHeights[$move]++;
    $turn++;
  }

  public function isGameOver() {
    return $turn == 42 || playerHasWon(2 - turn % 2);
  }

  public function playerHasWon($player) {
    for($col = 0; $col < $width; $col++) {
      for($row = 0; $row < $columnHeights[$col]; $row++) {
        if($isWinningMove){}
      }
    }
  }

  public function isDraw() {
    return $turn == 42 || !playerHasWon(2 - turn % 2);
  }
}

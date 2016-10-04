<?php
namespace ConnectFour\Model;

define('ROOT', dirname(__DIR__) . '/');
require_once(ROOT.'lib.php');
require_once(ROOT.'model/board.php');

class Game implements \JsonSerializable {
  private $board;
  private $turn;
  private $moves;

  public function __construct($data = null) {
    if(is_null($data)) {
      $this->board = new Board();
      $this->turn = 0;
    } elseif(is_array($data)) {
      $this->board = new Board($data['board']);
      $this->turn = $data['turn'];
    } elseif(is_object($data)) {
      $this->board = new Board($data->board);
      $this->turn = $data->turn;
    }
    $this->moves = [];
  }

  public function __clone() {
    $this->board = clone $this->board;
  }

  public function getBoard() {
    return $this->board;
  }

  public function getTurn() {
    return $this->turn;
  }

  public function availableMoves() {
    return $this->board->availableMoves();
  }

  public function doMove($move, $player) {
    assert(!$this->isGameOver(), "Game is already over");
    assert($this->turn % 2 == $player, "Unexpected player, $player");

    $this->board->doMove($move, $player);
    $this->turn++;
    $this->moves[] = $move;
  }

  public function undoLastMove() {
    assert(!empty($this->moves), "There is no last move.");

    $this->turn--;
    $player = $board->undoLastMove(array_pop($this->moves));
    assert($this->turn % 2 == $player, "Movelist and board desynchronized.");
  }

  public function isGameOver() {
    return $this->turn >= 42 || $this->didLastMoveWin();
  }

  public function didLastMoveWin() {
    if(!empty($this->moves)) {
      return $this->board->isWinningMove(end($this->moves));
    } else {
      return false;
    }
  }

  public function isDraw() {
    return $this->turn >= 42 && !$this->didLastMoveWin();
  }

  public function jsonSerialize() {
    return ['board'=>$this->board, 'turn'=>$this->turn];
  }
}

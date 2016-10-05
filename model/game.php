<?php
namespace ConnectFour\Model;

if(!defined('ROOT')) define('ROOT', dirname(__DIR__) . '/');
require_once(ROOT.'lib.php');
require_once(ROOT.'model/board.php');

class Game implements \JsonSerializable {
  private $board;
  private $turn;
  private $moves;
  private $winningRow;

  public function __construct($data = null) {
    if(is_null($data)) {
      $this->board = new Board();
      $this->turn = 0;
    } elseif(is_array($data)) {
      $this->board = new Board($data['board']);
      $this->turn = $data['turn'];
      $this->winningRow = $data['winningRow'];
    } elseif(is_object($data)) {
      $this->board = new Board($data->board);
      $this->turn = $data->turn;
      $this->winningRow = $data->winningRow;
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

    $this->winningRow = null;
    $this->board->doMove($move, $player);
    $this->turn++;
    $this->moves[] = $move;
  }

  public function undoLastMove() {
    assert(!empty($this->moves), "There is no last move.");

    $this->turn--;
    $player = $this->board->undoMove(array_pop($this->moves));
    assert($this->turn % 2 == $player, "Movelist and board desynchronized.");
  }

  public function isGameOver() {
    return $this->turn >= 42 || $this->isWin();
  }

  public function isWin() {
    return !empty($this->getRow());
  }

  public function getRow() {
    if(is_null($this->winningRow)) {
      if($this->turn < 7) {
        // Impossible for anyone to win before turn 7
        $this->winningRow = [];
      } else {
        $this->winningRow = $this->board->isWinningMove(end($this->moves));
      }
    }
    return $this->winningRow;
  }

  public function isDraw() {
    return $this->turn >= 42 && !$this->isWin();
  }

  public function jsonSerialize() {
    return ['board'=>$this->board, 'turn'=>$this->turn, 'winningRow'=>$this->winningRow];
  }
}

<?php
namespace ConnectFour\Model;

if(!defined('ROOT')) define('ROOT', dirname(__DIR__) . '/');
require_once(ROOT.'lib.php');

class Board implements \JsonSerializable {
  private $columns;
  private $columnHeights;

  public function __construct($data = null) {
    if(is_null($data)) {
      $this->columns = array_fill(0, BOARD_WIDTH, 0);
      $this->columnHeights = array_fill(0, BOARD_WIDTH, 0);
    } elseif(is_array($data)) {
      $this->columns = $data['columns'];
      $this->columnHeights = $data['columnHeights'];
    } elseif(is_object($data)) {
      $this->columns = $data->columns;
      $this->columnHeights = $data->columnHeights;
    }
  }

  public function availableMoves() {
    $moves = [];
    foreach($this->columnHeights as $column => $height) {
      if($height < BOARD_HEIGHT) {
        $moves[] = $column;
      }
    }
    return $moves;
  }

  public function doMove($move, $player) {
    assert($this->columnHeights[$move] < BOARD_HEIGHT, "Column $move is full.");

    $this->columns[$move] |= $player << $this->columnHeights[$move];
    $this->columnHeights[$move]++;
  }

  public function undoMove($move) {
    assert($this->columnHeights[$move] > 0, "Column $move is empty.");

    $this->columnHeights[$move]--;
    $player = $this->columns[$move] >> $this->columnHeights[$move] & 1;
    $this->columns[$move] &= (1 << $this->columnHeights[$move] + 1) - 1;
    return $player;
  }

  public function getDiskOwner($column, $row) {
    assert($column >= 0 && $column < BOARD_WIDTH && $row >= 0 && $row < BOARD_HEIGHT,
           "Invalid board position, ($column, $row).");
    if($this->columnHeights[$column] <= $row) {
      // No disk at position
      return -1;
    }
    return $this->columns[$column] >> $row & 1;
  }

  private function getRestOfGroup($player, $column, $row, $columnDirection, $rowDirection) {
    $group = [];

    for($c = $column + $columnDirection, $r = $row + $rowDirection;
        $c >= 0 && $r >= 0 && $c < BOARD_WIDTH && $r < BOARD_HEIGHT;
        $c += $columnDirection, $r += $rowDirection) {
      if($this->getDiskOwner($c, $r) == $player) {
        array_push($group, $c, $r);
      } else {
        break;
      }
    }

    return $group;
  }

  public function isWinningMove($move) {
    $column = $move;
    $row = $this->columnHeights[$move] - 1;
    $player = $this->getDiskOwner($column, $row);
    $center = [$column, $row];

    //Check vertical
    $group = array_merge($center, $this->getRestOfGroup($player, $column, $row, 0, -1));
    if(count($group) >= 8) {
      return $group;
    }

    //Check Horizontal
    $group = array_merge($center, $this->getRestOfGroup($player, $column, $row, -1, 0),
                         $this->getRestOfGroup($player, $column, $row, 1, 0));
    if(count($group) >= 8) {
      return $group;
    }

    //Check Diagonal 1
    $group = array_merge($center, $this->getRestOfGroup($player, $column, $row, 1, 1),
                         $this->getRestOfGroup($player, $column, $row, -1, -1));
    if(count($group) >= 8) {
      return $group;
    }

    //Check Diagonal 2
    $group = array_merge($center, $this->getRestOfGroup($player, $column, $row, 1, -1),
                         $this->getRestOfGroup($player, $column, $row, -1, 1));
    if(count($group) >= 8) {
      return $group;
    }

    return [];
  }

  public function jsonSerialize() {
    return ['columns'=>$this->columns, 'columnHeights'=>$this->columnHeights];
  }
}

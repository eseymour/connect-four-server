<?php
namespace ConnectFour\Model;

define('ROOT', dirname(__DIR__) . '/');
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
    return $this->columns[$move] >> $this->columnHeights[$move] & 1;
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

  public function isWinningMove($move) {
    $column = $move;
    $row = $this->columnHeights[$move] - 1;
    $player = $this->getDiskOwner($column, $row);
    $vertical = $horizontal = $diagonal1 = $diagonal2 = [$column, $row];

    //Check vertical
    for($r = $row - 1; $r >= 0 && count($vertical) < 8; $r--) {
      if($this->getDiskOwner($column, $r) == $player) {
        array_push($vertical, $column, $r);
      } else {
        break;
      }
    }
    if(count($vertical) == 8) {
      return $vertical;
    }

    //Check Horizontal
    for($c = $column + 1; $c < BOARD_WIDTH && count($horizontal) < 8; $c++) {
      if($this->getDiskOwner($c, $row) == $player) {
        array_push($horizontal, $c, $row);
      } else {
        break;
      }
    }
    for($c = $column - 1; $c >= 0 && count($horizontal) < 8; $c--) {
      if($this->getDiskOwner($c, $row) == $player) {
        array_push($horizontal, $c, $row);
      } else {
        break;
      }
    }
    if(count($horizontal) == 8) {
      return $horizontal;
    }

    //Check Diagonal 1
    for($c = $column + 1, $r = $row + 1; $c < BOARD_WIDTH && $r < BOARD_HEIGHT && count($diagonal1) < 8; $c++, $r++) {
      if($this->getDiskOwner($c, $r) == $player) {
        array_push($diagonal1, $c, $r);
      } else {
        break;
      }
    }
    for($c = $column - 1, $r = $row - 1; $c >= 0 && $r >= 0 && count($diagonal1) < 8; $c--, $r--) {
      if($this->getDiskOwner($c, $r) == $player) {
        array_push($diagonal1, $c, $r);
      } else {
        break;
      }
    }
    if(count($diagonal1) == 8) {
      return $diagonal1;
    }

    //Check Diagonal 2
    for($c = $column + 1, $r = $row - 1; $c < BOARD_WIDTH && $r >= 0 && count($diagonal2) < 8; $c++, $r--) {
      if($this->getDiskOwner($c, $r) == $player) {
        array_push($diagonal2, $c, $r);
      } else {
        break;
      }
    }
    for($c = $column - 1, $r = $row + 1; $c >= 0 && $r < BOARD_WIDTH && count($diagonal2) < 8; $c--, $r++) {
      if($this->getDiskOwner($c, $r) == $player) {
        array_push($diagonal2, $c, $r);
      } else {
        break;
      }
    }
    if(count($diagonal2) == 8) {
      return $diagonal2;
    }

    return false;
  }

  public function jsonSerialize() {
    return ['columns'=>$this->columns, 'columnHeights'=>$this->columnHeights];
  }
}

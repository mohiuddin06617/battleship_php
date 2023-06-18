<?php
class Board
{
    public $ships;
    public $hiddenBoard;
    public $guessBoard;
    /**
     * @var array
     * $shipCoordinates array contains value following two patterns based on orientation:
     * Vertical = [row, endRow, column, 'vertical']
     * Horizontal = [column, endColumn, row, 'horizontal'].
     */
    public $shipCoordinates;
    public $totalShipSunk;
    public $numOfShipsPlaced;
    public $gameOver;
    public $shots;

    public function __construct()
    {
        $this->ships = [];
        $this->hiddenBoard = array_fill(0, 10, array_fill(0, 10, "."));
        $this->guessBoard = array_fill(0, 10, array_fill(0, 10, "."));
        $this->shipCoordinates = [];
        $this->totalShipSunk = 0;
        $this->numOfShipsPlaced = 0;
        $this->gameOver = false;
        $this->shots = 0;
    }


    public function validateShipPlacementGrid($ship, $row, $column, $orientation) {
        if ($orientation === "horizontal") {
            $columnSize = $column + $ship->size;
            if ($columnSize > 10) {
                return false;
            }
            for ($j = $column; $j < $columnSize; $j++) {
                if ($this->hiddenBoard[$row][$j] !== ".") {
                    return false;
                }
            }
        } else {
            $rowSize = $row + $ship->size;
            if ($rowSize > 10) {
                return false;
            }
            for ($i = $row; $i < $rowSize; $i++) {
                if ($this->hiddenBoard[$i][$column] !== ".") {
                    return false;
                }
            }
        }
        return true;
    }

    public function placeShip($ship, $row, $column, $orientation) {
        if ($orientation === "horizontal") {
            $endCol = 0;
            for ($j = $column; $j < $column + $ship->size; $j++) {
                $this->hiddenBoard[$row][$j] = "X";
                $endCol = $j;
            }
            $this->shipCoordinates[] = [$column, $endCol, $row, $orientation];
        } else {
            $endRow = 0;
            for ($i = $row; $i < $row + $ship->size; $i++) {
                $this->hiddenBoard[$i][$column] = "X";
                $endRow = $i;
            }
            $this->shipCoordinates[] = [$row, $endRow, $column, $orientation];
        }

        $this->ships[] = $ship;
        $this->numOfShipsPlaced++;
    }

    public function shipPlacementProcess($ship) {
        while (true) {
            $row = rand(0, 9);
            $column = rand(0, 9);
            $orientation = (rand(0, 1) === 0) ? "horizontal" : "vertical";
            // TODO: Ship place validation in here
            if ($this->validateShipPlacementGrid($ship, $row, $column, $orientation)) {
                // TODO: Ship placement here
                $this->placeShip($ship, $row, $column, $orientation);
                break;
            }
        }
    }

    public function showHiddenBoard() {
        echo "Hidden Board:\n";
        $this->showBoard($this->hiddenBoard);
    }

    public function showGuessBoard() {
        echo "Guess Board:\n";
        $this->showBoard($this->guessBoard);
    }

    public function showBoard($board) {
        echo "  1 2 3 4 5 6 7 8 9 10\n";
        foreach ($board as $i => $row) {
            echo chr(ord('A') + $i) . " " . implode(" ", $row) . "\n";
        }
    }
}
?>
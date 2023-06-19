<?php
require_once "helpers.php";

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


    public function validateShipPlacementGrid($ship, $row, $column, $orientation)
    {
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

    public function checkForShipSunk($row, $col)
    {
        foreach ($this->shipCoordinates as $position) {
            $orientation = $position[3];
            if ($orientation === "horizontal") {
                $startColumn = $position[0];
                $endColumn = $position[1];
                $positionRow = $position[2];
                if ($positionRow === $row) {
                    $hitShipsList = getArrayValuesByRange($this->guessBoard, $positionRow, $startColumn, $positionRow, $endColumn);
                    return count(array_keys($hitShipsList, "X")) === count($hitShipsList);
                }
            } elseif ($orientation === "vertical") {
                $startRow = $position[0];
                $endRow = $position[1];
                $positionColumn = $position[2];
                if ($positionColumn === $col) {
                    $hitShipsList = getArrayValuesByRange($this->guessBoard, $startRow, $positionColumn, $endRow, $positionColumn);
                    return count(array_keys($hitShipsList, "X")) === count($hitShipsList);
                }
            }
        }
        return true;
    }

    public function placeShip($ship, $row, $column, $orientation)
    {
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

    public function shipPlacementProcess($ship)
    {
        while (true) {
            $row = rand(0, 9);
            $column = rand(0, 9);
            $orientation = (rand(0, 1) === 0) ? "horizontal" : "vertical";
            if ($this->validateShipPlacementGrid($ship, $row, $column, $orientation)) {
                $this->placeShip($ship, $row, $column, $orientation);
                break;
            }
        }
    }

    public function shotToShip($row, $column)
    {
        if ($this->guessBoard[$row][$column] === "-" || $this->guessBoard[$row][$column] === "X") {
            echo "Already Guessed\n";
        } elseif ($this->hiddenBoard[$row][$column] === ".") {
            echo "*** Miss ***\n";
            $this->guessBoard[$row][$column] = "-";
        } elseif ($this->hiddenBoard[$row][$column] === "X") {
            $this->guessBoard[$row][$column] = "X";
            if ($this->checkForShipSunk($row, $column)) {
                echo "*** Sunk ***\n";
                $this->totalShipSunk++;
            }
            else{
                echo "*** Hit ***\n";
            }
        }
    }

    public function showHiddenBoard()
    {
        echo "Hidden Board:\n";
        $this->showBoard($this->hiddenBoard);
    }

    public function showGuessBoard()
    {
        echo "Guess Board:\n";
        $this->showBoard($this->guessBoard);
        if(!$this->gameOver){
            echo "Ships Left: " . ($this->numOfShipsPlaced - $this->totalShipSunk) . "\n";
        }
    }

    public function showBoard($board)
    {
        echo "  1 2 3 4 5 6 7 8 9 10\n";
        foreach ($board as $i => $row) {
            echo chr(ord('A') + $i) . " " . implode(" ", $row) . "\n";
        }
    }

    public function checkForGameOver() {
        if ($this->numOfShipsPlaced === $this->totalShipSunk) {
            $this->gameOver = true;
            $this->showGuessBoard();
            echo "Well Done! You completed the game in {$this->shots} shots\n";
        }
    }
}

?>
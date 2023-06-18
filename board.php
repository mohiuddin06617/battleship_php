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
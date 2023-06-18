<!--Battleship Single Player Game Against Computer

Step 1 - Create two 10x10 boards. One board is Hidden and other is visible to the user.
Step 2 - Place the ships on the grid. The hidden board holds the locations of the ships marked with X. Guess board will hold '.' value.
Step 3 - Before placing each ships ensure that it does not overlap with other ships. They can touch but can not overlap. Additionallu, ensure that they are placed within the grid.
Step 5 - Display the guess board to the user.
Step 6 - Prompt the user to enter coordinates in the format "A5" to target a square on the grid. Validate inputted coordiates.
Step 7 - If user entered "show" command then display the hidden board to user alongside with guess board
Step 8 - Update the guess board according to the users inputted value.
Step 8.1 -> If the target square is miss (marked as "-") or hit (marked as "X"), then inform the player that it is already guessed.
Step 8.2 -> If the target square is empty (marked as '.'), update it to a miss marker '-' and inform the player.
Step 8.3 -> If the target square in hidden board contains a ship, update the guess board marker to 'X'. After each hit, check if all the squares of a ship is hit mark. If it is, then mark it as sunk and inform the player accordingly.
Step 9 - Keep count of number of shots. Increase number of shots after each iteration.
Step 10 - Check if game is over. When the total number of ships is equal to sunked ships end the game and notify user that he has won after X number of shots.
-->

<?php
require_once "ship.php";
require_once "board.php";

define('BATTLESHIP', 5);
define('DESTROYER', 4);
define('ROW_SIZE', 10);
define('COLUMN_SIZE', 10);

$board = new Board();

$battleship = new Ship("Battleship", BATTLESHIP);
$destroyerOne = new Ship("Destroyer", DESTROYER);
$destroyerTwo = new Ship("Destroyer", DESTROYER);

$board->shipPlacementProcess($battleship);
$board->shipPlacementProcess($destroyerOne);
$board->shipPlacementProcess($destroyerTwo);

function getCoordinates()
{
    while (true) {
        echo "Enter coordinates (row, col), e.g. A5 = ";
        $inputCoordinates = trim(fgets(STDIN));
        $inputCoordinates = strtoupper($inputCoordinates);

        if ($inputCoordinates === "SHOW") {
            return "SHOW";
        }
        try {
            $rowVal = ord($inputCoordinates[0]) - ord("A");
            $colVal = intval(substr($inputCoordinates, 1)) - 1;

            if ($rowVal >= 0 && $rowVal < ROW_SIZE && $colVal >= 0 && $colVal < COLUMN_SIZE) {
                return [$rowVal, $colVal];
            }
            echo "Invalid Coordinates. Please provide valid coordinates.\n";
        } catch (Exception $e) {
            echo "Invalid Input. Please recheck and try again.\n";
        }
    }
}

while (!$board->gameOver) {
    $board->showGuessBoard();
    $coordinates = getCoordinates();

    if ($coordinates === "SHOW") {
        $board->showHiddenBoard();
        continue;
    }

    [$row, $column] = $coordinates;

    print_r($row, $column);
}
?>
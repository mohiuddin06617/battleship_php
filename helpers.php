<?php
function getArrayValuesByRange($board, $startRow, $startCol, $endRow, $endCol) {
    $arraySlice = [];

    for ($row = $startRow; $row <= $endRow; $row++) {
        $arraySlice = array_merge($arraySlice, array_slice($board[$row], $startCol, $endCol - $startCol + 1));
    }

    return $arraySlice;
}
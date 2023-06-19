<?php
function getArrayValuesByRange($board, $startRow, $startCol, $endRow, $endCol) {
    $arraySlice = [];

    for ($row = $startRow; $row <= $endRow; $row++) {
        for ($col = $startCol; $col <= $endCol; $col++) {
            $arraySlice[] = $board[$row][$col];
        }
    }

    return $arraySlice;
}
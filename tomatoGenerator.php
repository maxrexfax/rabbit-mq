<?php

require "Tomato.php";


function getRandomObjects($countOfObjects, $nameOfColor) {
    $tmpArray = [];
    $tmpColor = '';
    for ($i = 1; $i <= $countOfObjects; $i++) {
        $counter = rand(1, 12);
        if ($counter > 0 && $counter < 4) {
            $tmpColor = 'red';
        } else if ($counter > 3 && $counter < 7) {
            $tmpColor = 'yellow';
        } else if ($counter > 6 && $counter < 10) {
            $tmpColor = 'green';
        } else {
            $tmpColor = 'blue';
        }

        if ($nameOfColor !== null) {
            $tmpColor = $nameOfColor;
        }

        $tmpArray[] = new Tomato($tmpColor);
    }
    return $tmpArray;
}
?>
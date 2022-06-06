<?php
class Tomato {
    public $tomatoColor;
    public $numb;

    function __construct($colorIn) {
        $this->tomatoColor = $colorIn;
    }
}

function getRandomObjects() {
    $tmpArray = [];
    $tmpColor = '';
    for ($i = 0; $i < 15; $i++) {
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

        $tmpArray[] = new Tomato($tmpColor);
    }
    return $tmpArray;
}
?>
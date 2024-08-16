<?php

/**
 * Given the array [B, G, N], where B is the number of boys, G 
 * is the number of gairs and N the number of people you should pair together.
 * 
 * Example, if array [5, 3, 2], means you have to pick 1 girld and 1 boy. 
 * You have 5 options for boy and 3 options for girl, so the function should return 15.
 * 
 * If array [10, 5, 4], you have to pick 2 boys out of 10 and 2 girls out of 5. 
 * Then we have 2 different ways to pair boys and guys, so the function should return 900
 */

function solution($arr): int
{
    list($boys, $girls, $pairs) = $arr;

    $halfPairs = $pairs / 2;
    //echo "halfPairs: $halfPairs" . PHP_EOL;

    $boysCombinations = getCombinations($boys, $halfPairs);
    //echo "boysCombinations: $boysCombinations" . PHP_EOL;

    $girlsCombinations = getCombinations($girls, $halfPairs);
    //echo "girlsCombinations: $girlsCombinations" . PHP_EOL;

    return $boysCombinations * $girlsCombinations * $halfPairs;
}

function getCombinations(int $n, int $k){
    return factorial($n) / (factorial($k) * factorial($n - $k));
}

function factorial(int $n) {
    if ($n === 0 || $n === 1) {
        return 1;
    }

    return $n * factorial($n - 1);
}

// keep this function call here  
echo solution([10, 5, 4]);  

?>

<?php

/**
 * Create a function that takes a single integer parameter, n,
 * and returns the first n elements of the Fibonacci sequence.
 * 
 * g(1) = [ 0 ]
 * g(2) = [ 0, 1 ]
 * g(3) = [ 0, 1, 1 ]
 * g(4) = [ 0, 1, 1, 2 ]
 * g(5) = [ 0, 1, 1, 2, 3 ]
 * g(6) = [ 0, 1, 1, 2, 3, 5 ]
 */

function solution(int $number = 10): array
{
    $result = [];

    for($i = 0; $i < $number; $i++){
        if ($i <= 1){
            $result[] = $i;
            continue;
        }

        $result[] = $result[$i-1] + $result[$i-2];
    }

    return $result;
}

print_r(solution());
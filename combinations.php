<?php
require_once('combination.php');

$combinations=[
    [
        new Combination([0,0]),
        new Combination([0,1]),
        new Combination([0,2]),
        new Combination([0,3]),
    ],
    [
        new Combination([1,0]),
        new Combination([1,1]),
        new Combination([1,2]),
        new Combination([1,3]),
    ],
    [
        new Combination([2,0]),
        new Combination([2,1]),
        new Combination([2,2]),
        new Combination([2,3]),
    ],
    [
        new Combination([2,0]),
        new Combination([1,1]),
        new Combination([1,2]),
        new Combination([2,3]),
    ],
    [
        new Combination([0,0]),
        new Combination([1,1]),
        new Combination([1,2]),
        new Combination([0,3]),
    ],
    [
        new Combination([0,1]),
        new Combination([1,1]),
        new Combination([2,1]),
        new Combination([2,2]),
    ],
];
?>
